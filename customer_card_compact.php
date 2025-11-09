<?php
/**
 * Γεννήτρια Συμπαγούς Καρτέλας Πελάτη
 * Compact Customer Card Generator - Clean Production Version
 */

// Get stock ID from URL parameter
$stock_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($stock_id <= 0) {
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Σφάλμα</title></head><body>';
    echo '<h2>❌ Λάθος αριθμός προιόντος</h2>';
    echo '<p>Χρήση: customer_card_compact.php?id=ΑΡΙΘΜΟΣ_STOCK</p>';
    echo '</body></html>';
    exit;
}

try {
    // Load database configuration
    $config_paths = [
        __DIR__ . '/application/config/database.php',
        dirname(__DIR__) . '/application/config/database.php',
        'application/config/database.php'
    ];
    
    $config_loaded = false;
    foreach ($config_paths as $config_file) {
        if (file_exists($config_file)) {
            define('BASEPATH', '');
            define('ENVIRONMENT', 'production');
            include $config_file;
            $config_loaded = true;
            break;
        }
    }
    
    if (!$config_loaded) {
        throw new Exception("Αδυναμία φόρτωσης ρυθμίσεων βάσης δεδομένων");
    }
    
    // Database connection
    $mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
    if ($mysqli->connect_error) {
        throw new Exception("Αδυναμία σύνδεσης με βάση δεδομένων: " . $mysqli->connect_error);
    }
    $mysqli->set_charset('utf8mb4');
    
    // Get customer card data with comprehensive joins
    $sql = "
        SELECT 
            s.id as stock_id, s.serial, s.day_out, s.guarantee_end, 
            s.ekapty_code, s.ektelesi_eopyy, s.customer_id,
            c.name as customer_name, c.address, c.city, c.birthday,
            c.phone_home, c.phone_mobile, c.amka, c.first_visit, c.comments,
            d.doc_name as doctor_name,
            sp.city as selling_point_city,
            m.model as model_name,
            ser.series as series_name, 
            man.name as manufacturer_name,
            ht.type as ha_type_name
        FROM stocks s
        LEFT JOIN customers c ON s.customer_id = c.id
        LEFT JOIN doctors d ON c.doctor = d.id
        LEFT JOIN selling_points sp ON c.selling_point = sp.id
        LEFT JOIN models m ON s.ha_model = m.id
        LEFT JOIN series ser ON m.series = ser.id
        LEFT JOIN manufacturers man ON ser.brand = man.id
        LEFT JOIN ha_types ht ON m.ha_type = ht.id
        WHERE s.id = ?
        LIMIT 1
    ";
    
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception("Αδυναμία προετοιμασίας ερώτησης: " . $mysqli->error);
    }
    
    $stmt->bind_param('i', $stock_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        throw new Exception("Δεν βρέθηκε καρτέλα για stock ID: {$stock_id}");
    }
    
    // Try to load TCPDF for PDF generation
    $tcpdf_loaded = false;
    
    // Method 1: Check if already loaded
    if (class_exists('TCPDF')) {
        $tcpdf_loaded = true;
    }
    
    // Method 2: Try vendor autoloader (with error suppression)
    if (!$tcpdf_loaded && file_exists(__DIR__ . '/vendor/autoload.php')) {
        try {
            error_reporting(0);
            ob_start();
            require_once __DIR__ . '/vendor/autoload.php';
            ob_end_clean();
            error_reporting(E_ALL);
            
            if (class_exists('TCPDF')) {
                $tcpdf_loaded = true;
            }
        } catch (Throwable $e) {
            error_reporting(E_ALL);
            ob_end_clean();
        }
    }
    
    // Method 3: Try direct TCPDF include
    if (!$tcpdf_loaded) {
        $tcpdf_paths = [
            __DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php',
            dirname(__DIR__) . '/vendor/tecnickcom/tcpdf/tcpdf.php',
            __DIR__ . '/third_party/tcpdf/tcpdf.php',
            __DIR__ . '/libraries/tcpdf/tcpdf.php'
        ];
        
        foreach ($tcpdf_paths as $path) {
            if (file_exists($path)) {
                try {
                    error_reporting(0);
                    ob_start();
                    require_once $path;
                    ob_end_clean();
                    error_reporting(E_ALL);
                    
                    if (class_exists('TCPDF')) {
                        $tcpdf_loaded = true;
                        break;
                    }
                } catch (Throwable $e) {
                    error_reporting(E_ALL);
                    ob_end_clean();
                }
            }
        }
    }
    
    if ($tcpdf_loaded) {
        // Generate PDF with TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('PHA Manager - Γεννήτρια Καρτέλας');
        $pdf->SetAuthor('Πικάσης Ακοοπροθετικά');
        $pdf->SetTitle('Καρτέλα Πελάτη - ' . $data['customer_name']);
        $pdf->SetSubject('Καρτέλα Πελάτη Ακουστικών');
        
        // Set margins and page settings
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetFont('freeserif', '', 12);
        
        // Generate customer card HTML content
        $card_html = generateCustomerCardHTML($data);
        $pdf->writeHTML($card_html, true, false, true, false, '');
        
        // Output PDF
        $filename = 'Καρτελα_' . str_replace(' ', '_', $data['customer_name']) . '_' . date('Y-m-d') . '.pdf';
        
        if (isset($_GET['download'])) {
            $pdf->Output($filename, 'D'); // Force download
        } else {
            $pdf->Output($filename, 'I'); // Display in browser
        }
        exit;
    }
    
    // HTML fallback when PDF not available
    $html_card = generatePrintableCustomerCard($data);
    echo $html_card;
    
} catch (Exception $e) {
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Σφάλμα</title></head><body>';
    echo '<h2>❌ Σφάλμα στη δημιουργία καρτέλας</h2>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><a href="javascript:history.back()">← Επιστροφή</a></p>';
    echo '</body></html>';
} catch (Error $e) {
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Σφάλμα</title></head><body>';
    echo '<h2>❌ Τεχνικό σφάλμα</h2>';
    echo '<p>Παρακαλώ επικοινωνήστε με τον διαχειριστή</p>';
    echo '</body></html>';
}

/**
 * Generate customer card HTML content for PDF - Compact Single Page Version
 */
function generateCustomerCardHTML($data) {
    return '
    <style>
        body { 
            font-family: "freeserif", serif; 
            font-size: 9pt; 
            line-height: 1.2; 
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header { 
            text-align: center; 
            margin-bottom: 12px; 
            padding-bottom: 8px;
            border-bottom: 2px solid #2c3e50;
        }
        .logo { 
            text-align: center; 
            margin-bottom: 10px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 8px 0; 
        }
        td, th { 
            padding: 4px 6px; 
            border: 1px solid #333; 
            vertical-align: top;
            font-size: 8pt;
        }
        .label { 
            background-color: #f8f9fa; 
            font-weight: bold; 
            width: 20%; 
        }
        .section-header {
            background-color: #e8f4fd;
            border-left: 3px solid #2196f3;
            padding: 6px;
            margin: 8px 0;
            font-size: 10pt;
            font-weight: bold;
        }
        .two-column {
            display: table;
            width: 100%;
        }
        .col-left, .col-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 3px;
        }
        .footer-info {
            text-align: center;
            margin-top: 10px;
            padding: 5px;
            border: 1px solid #2c3e50;
            background-color: #f8f9fa;
            font-size: 8pt;
        }
    </style>
    
    <div class="logo">
        <div style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; padding: 8px; border-radius: 5px;">
            <h2 style="margin: 0; font-size: 14pt;">ΠΙΚΑΣΗΣ ΑΚΟΟΠΡΟΘΕΤΙΚΑ</h2>
            <p style="margin: 0; font-size: 9pt;">Λιβαδειά • Τηλ: 22610-XXXXX</p>
        </div>
    </div>
    
    <div class="header">
        <h1 style="color: #2c3e50; font-size: 14pt; margin: 0;">ΚΑΡΤΕΛΑ ΠΕΛΑΤΗ</h1>
    </div>
    
    <div class="section-header">
        📋 ΣΤΟΙΧΕΙΑ ΠΕΛΑΤΗ - ' . htmlspecialchars($data['customer_name'] ?? 'N/A') . '
    </div>
    
    <div class="two-column">
        <div class="col-left">
            <table>
                <tr>
                    <td class="label">ΟΝΟΜΑ:</td>
                    <td><strong>' . htmlspecialchars($data['customer_name'] ?? 'N/A') . '</strong></td>
                </tr>
                <tr>
                    <td class="label">ΔΙΕΥΘΥΝΣΗ:</td>
                    <td>' . htmlspecialchars($data['address'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td class="label">ΠΟΛΗ:</td>
                    <td>' . htmlspecialchars($data['city'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td class="label">ΑΜΚΑ:</td>
                    <td>' . htmlspecialchars($data['amka'] ?? 'N/A') . '</td>
                </tr>
            </table>
        </div>
        <div class="col-right">
            <table>
                <tr>
                    <td class="label">ΓΕΝΝΗΣΗ:</td>
                    <td>' . htmlspecialchars($data['birthday'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td class="label">ΤΗΛΕΦΩΝΟ:</td>
                    <td>' . htmlspecialchars($data['phone_home'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td class="label">ΚΙΝΗΤΟ:</td>
                    <td>' . htmlspecialchars($data['phone_mobile'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td class="label">ΓΙΑΤΡΟΣ:</td>
                    <td>' . htmlspecialchars($data['doctor_name'] ?? 'N/A') . '</td>
                </tr>
            </table>
        </div>
    </div>
    
    <table style="margin: 8px 0;">
        <tr>
            <td class="label">ΠΡΩΤΗ ΕΠΙΣΚΕΨΗ:</td>
            <td>' . htmlspecialchars($data['first_visit'] ?? 'N/A') . '</td>
            <td class="label">ΣΗΜΕΙΟ ΕΞΥΠΗΡΕΤΗΣΗΣ:</td>
            <td>' . htmlspecialchars($data['selling_point_city'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td class="label">ΣΧΟΛΙΑ:</td>
            <td colspan="3">' . htmlspecialchars($data['comments'] ?? '-') . '</td>
        </tr>
    </table>
    
    <div class="section-header">
        🎧 ΣΤΟΙΧΕΙΑ ΑΚΟΥΣΤΙΚΟΥ - Serial: ' . htmlspecialchars($data['serial'] ?? 'N/A') . '
    </div>
    
    <table>
        <tr>
            <td class="label">ΚΑΤΑΣΚΕΥΑΣΤΗΣ:</td>
            <td><strong>' . htmlspecialchars($data['manufacturer_name'] ?? 'N/A') . '</strong></td>
            <td class="label">ΣΕΙΡΑ:</td>
            <td>' . htmlspecialchars($data['series_name'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td class="label">ΜΟΝΤΕΛΟ:</td>
            <td>' . htmlspecialchars($data['model_name'] ?? 'N/A') . '</td>
            <td class="label">ΤΥΠΟΣ:</td>
            <td>' . htmlspecialchars($data['ha_type_name'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td class="label">ΠΩΛΗΣΗ:</td>
            <td><strong style="color: #2e7d32;">' . htmlspecialchars($data['day_out'] ?? 'N/A') . '</strong></td>
            <td class="label">ΕΓΓΥΗΣΗ:</td>
            <td><strong style="color: #d9534f;">' . htmlspecialchars($data['guarantee_end'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">BARCODE ΕΟΠΥΥ:</td>
            <td>' . htmlspecialchars($data['ekapty_code'] ?? '-') . '</td>
            <td class="label">ΚΩΔ. ΕΚΤΕΛΕΣΗΣ:</td>
            <td>' . htmlspecialchars($data['ektelesi_eopyy'] ?? '-') . '</td>
        </tr>
    </table>
    
    <div class="footer-info">
        <p style="margin: 2px 0;"><strong>Πιστοποιημένο Κέντρο Ακοοπροθετικής • Εκδόθηκε: ' . date('d/m/Y H:i') . '</strong></p>
        <p style="margin: 2px 0; color: #666;">Για τεχνική υποστήριξη επικοινωνήστε με το τμήμα service</p>
    </div>';
}

/**
 * Generate printable HTML customer card for browser display
 */
function generatePrintableCustomerCard($data) {
    $card_content = generateCustomerCardHTML($data);
    
    return '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Καρτέλα Πελάτη - ' . htmlspecialchars($data['customer_name']) . '</title>
    <style>
        @media screen {
            body { 
                max-width: 750px; 
                margin: 10px auto; 
                padding: 15px; 
                border: 2px solid #2c3e50; 
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                background: #fff;
                font-size: 12px;
            }
            .no-print { display: block; }
        }
        @media print {
            body { margin: 0; padding: 10px; font-size: 10px; }
            .no-print { display: none; }
        }
        .alert { 
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #ff9800; 
            border-radius: 5px;
            border-left: 3px solid #f57c00;
        }
    </style>
</head>
<body>
    <div class="no-print alert">
        <h4 style="color: #e65100; margin: 0 0 8px 0;">📄 Καρτέλα Πελάτη - ' . htmlspecialchars($data['customer_name']) . ' (Serial: ' . htmlspecialchars($data['serial']) . ')</h4>
        <p style="margin: 3px 0; font-size: 11px;"><strong>Εκτύπωση:</strong> Ctrl+P • <strong>Αποθήκευση:</strong> PDF εξαγωγή από browser</p>
    </div>
    
    ' . $card_content . '
    
    <div class="no-print" style="text-align: center; margin-top: 20px; padding: 12px; background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); border: 1px solid #ff9800; border-radius: 5px;">
        <button onclick="window.print()" style="background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); color: white; padding: 8px 16px; border: none; border-radius: 4px; font-size: 12px; cursor: pointer;">
            🖨️ Εκτύπωση Καρτέλας
        </button>
        <br>
        <small style="color: #e65100; font-size: 10px; margin-top: 5px; display: block;">Επίσημη καρτέλα πελάτη ακουστικών βαρηκοΐας</small>
    </div>
</body>
</html>';
}
?>