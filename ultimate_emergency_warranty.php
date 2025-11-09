<?php
/**
 * Γεννήτρια Εγγύησης Ακουστικού Βαρηκοΐας
 * Emergency Warranty Generator - Clean Production Version
 */

// Get stock ID from URL parameter
$stock_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($stock_id <= 0) {
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Σφάλμα</title></head><body>';
    echo '<h2>❌ Λάθος αριθμός ακουστικού</h2>';
    echo '<p>Χρήση: warranty_generator.php?id=ΑΡΙΘΜΟΣ_ΑΚΟΥΣΤΙΚΟΥ</p>';
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
    
    // Get warranty data
    $sql = "
        SELECT 
            s.serial, s.day_out, s.guarantee_end, s.ekapty_code, s.ektelesi_eopyy,
            c.name as customer_name, c.amka as customer_amka,
            co.ekapty as company_ekapty,
            m.model as model_name,
            ser.series as series_name, 
            man.name as manufacturer_name,
            ht.type as ha_type_name
        FROM stocks s
        LEFT JOIN customers c ON s.customer_id = c.id
        LEFT JOIN companies co ON co.id = 1
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
        throw new Exception("Δεν βρέθηκε ακουστικό με αριθμό: {$stock_id}");
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
        $pdf->SetCreator('PHA Manager - Γεννήτρια Εγγύησης');
        $pdf->SetAuthor('Πικάσης Ακοοπροθετικά');
        $pdf->SetTitle('Εγγύηση Ακουστικού - ' . $data['serial']);
        $pdf->SetSubject('Εγγύηση Ακουστικού Βαρηκοΐας');
        
        // Set margins and page settings
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetFont('freeserif', '', 12);
        
        // Generate warranty HTML content
        $warranty_html = generateWarrantyHTML($data);
        $pdf->writeHTML($warranty_html, true, false, true, false, '');
        
        // Output PDF
        $filename = 'Εγγυηση_' . $data['serial'] . '_' . date('Y-m-d') . '.pdf';
        
        if (isset($_GET['download'])) {
            $pdf->Output($filename, 'D'); // Force download
        } else {
            $pdf->Output($filename, 'I'); // Display in browser
        }
        exit;
    }
    
    // HTML fallback when PDF not available
    $html_warranty = generatePrintableWarranty($data);
    echo $html_warranty;
    
} catch (Exception $e) {
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Σφάλμα</title></head><body>';
    echo '<h2>❌ Σφάλμα στη δημιουργία εγγύησης</h2>';
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
 * Generate warranty HTML content for PDF - Compact Single Page Version
 */
function generateWarrantyHTML($data) {
    return '
    <style>
        body { 
            font-family: "freeserif", serif; 
            font-size: 10pt; 
            line-height: 1.3; 
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header { 
            text-align: center; 
            margin-bottom: 15px; 
            padding-bottom: 10px;
            border-bottom: 2px solid #2c3e50;
        }
        .company { 
            text-align: center; 
            margin-bottom: 15px; 
            color: #555; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 10px 0; 
        }
        td { 
            padding: 6px 8px; 
            border: 1px solid #333; 
            vertical-align: top;
            font-size: 9pt;
        }
        .label { 
            background-color: #f8f9fa; 
            font-weight: bold; 
            width: 35%; 
        }
        .terms { 
            margin: 15px 0; 
            text-align: justify; 
            line-height: 1.4; 
            font-size: 9pt;
        }
        .signature { 
            text-align: right; 
            margin-top: 20px; 
        }
        .footer { 
            text-align: center; 
            margin-top: 15px; 
            padding: 8px; 
            border: 1px solid #2c3e50; 
            background-color: #f8f9fa;
            font-size: 9pt;
        }
        .warranty-period {
            background-color: #e8f4fd;
            border-left: 3px solid #2196f3;
            padding: 8px;
            margin: 10px 0;
            font-size: 10pt;
        }
        .two-column {
            display: table;
            width: 100%;
        }
        .col-left, .col-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 5px;
        }
    </style>
    
    <div class="header">
        <h1 style="color: #2c3e50; font-size: 16pt; margin: 5px 0;">ΕΓΓΥΗΣΗ ΑΚΟΥΣΤΙΚΟΥ ΒΑΡΗΚΟΙΑΣ</h1>
        <p style="color: #666; font-size: 11pt; margin: 0;">ΠΙΣΤΟΠΟΙΗΤΙΚΟ ΕΓΓΥΗΣΗΣ - Πικάσης Ακοοπροθετικά, Λιβαδειά</p>
    </div>
    
    <div class="two-column">
        <div class="col-left">
            <table>
                <tr>
                    <td class="label">ΠΕΛΑΤΗΣ:</td>
                    <td><strong>' . htmlspecialchars($data['customer_name'] ?? 'N/A') . '</strong></td>
                </tr>
                <tr>
                    <td class="label">ΑΜΚΑ:</td>
                    <td>' . htmlspecialchars($data['customer_amka'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td class="label">ΠΑΡΑΔΟΣΗ:</td>
                    <td><strong>' . htmlspecialchars($data['day_out'] ?? 'N/A') . '</strong></td>
                </tr>
                <tr>
                    <td class="label">ΛΗΞΗ ΕΓΓΥΗΣΗΣ:</td>
                    <td><strong style="color: #d9534f;">' . htmlspecialchars($data['guarantee_end'] ?? 'N/A') . '</strong></td>
                </tr>
                <tr>
                    <td class="label">SERIAL:</td>
                    <td><strong style="color: #0275d8; font-size: 11pt;">' . htmlspecialchars($data['serial'] ?? 'N/A') . '</strong></td>
                </tr>
            </table>
        </div>
        <div class="col-right">
            <table>
                <tr>
                    <td class="label">ΚΑΤΑΣΚΕΥΑΣΤΗΣ:</td>
                    <td><strong>' . htmlspecialchars($data['manufacturer_name'] ?? 'N/A') . '</strong></td>
                </tr>
                <tr>
                    <td class="label">ΣΕΙΡΑ:</td>
                    <td>' . htmlspecialchars($data['series_name'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td class="label">ΜΟΝΤΕΛΟ:</td>
                    <td>' . htmlspecialchars($data['model_name'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td class="label">ΤΥΠΟΣ:</td>
                    <td>' . htmlspecialchars($data['ha_type_name'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td class="label">ΕΟΠΥΥ:</td>
                    <td>' . htmlspecialchars($data['ekapty_code'] ?? '-') . '</td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="warranty-period">
        <h4 style="color: #1976d2; margin: 0 0 5px 0; font-size: 11pt;">🛡️ ΕΓΓΥΗΣΗ ΔΥΟ (2) ΕΤΩΝ</h4>
        <p style="margin: 0; font-size: 10pt;"><strong>Εγγύηση καλής λειτουργίας για 2 πλήρη έτη από την παράδοση.</strong></p>
    </div>
    
    <div class="terms">
        <h4 style="color: #2c3e50; border-bottom: 1px solid #2c3e50; padding-bottom: 3px; margin: 10px 0 8px 0; font-size: 11pt;">ΟΡΟΙ ΕΓΓΥΗΣΗΣ</h4>
        
        <div class="two-column">
            <div class="col-left">
                <p><strong>Καλύπτει:</strong></p>
                <ul style="margin: 5px 0; padding-left: 15px; font-size: 8pt;">
                    <li>Κατασκευαστικά ελαττώματα</li>
                    <li>Δυσλειτουργίες ηλεκτρονικών</li>
                    <li>Προβλήματα ποιότητας ήχου</li>
                    <li>Δωρεάν επισκευή/αντικατάσταση</li>
                </ul>
            </div>
            <div class="col-right">
                <p><strong>ΔΕΝ καλύπτει:</strong></p>
                <ul style="margin: 5px 0; padding-left: 15px; font-size: 8pt;">
                    <li>Λάθος χρήση/συντήρηση</li>
                    <li>Μη εξουσιοδοτημένες επισκευές</li>
                    <li>Φυσική φθορά</li>
                    <li>Υγρασία, κρούσεις, πτώσεις</li>
                </ul>
            </div>
        </div>
        
        <p style="margin: 8px 0 0 0; font-size: 8pt;"><strong>Ενεργοποίηση:</strong> Επίδειξη πιστοποιητικού + ακουστικό. Εξουσιοδοτημένο service διαθέσιμο.</p>
    </div>
    
    <div class="two-column" style="margin-top: 15px;">
        <div class="col-left">
            <div class="footer">
                <p style="font-size: 8pt; margin: 2px 0;"><strong>ΕΚΑΠΤΥ: ' . htmlspecialchars($data['company_ekapty'] ?? '301068') . '</strong></p>
                <p style="font-size: 8pt; margin: 2px 0;">Πιστοποιημένο Κέντρο Ακοοπροθετικής</p>
            </div>
        </div>
        <div class="col-right">
            <div class="signature">
                <p style="margin: 0; font-size: 8pt;">Λιβαδειά, ' . date('d/m/Y') . '</p>
                <p style="margin: 5px 0 2px 0; font-size: 10pt;"><strong>Σπυρίδων Κ. Πικάσης</strong></p>
                <p style="margin: 0; font-size: 8pt;">Μηχανικός Βιοϊατρικής Τεχνολογίας</p>
                <p style="margin: 0; font-size: 8pt;">Ειδικός Ακοοπροθετιστής</p>
            </div>
        </div>
    </div>';
}

/**
 * Generate printable HTML warranty for browser display
 */
function generatePrintableWarranty($data) {
    $warranty_content = generateWarrantyHTML($data);
    
    return '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Εγγύηση Ακουστικού - ' . htmlspecialchars($data['serial']) . '</title>
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
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #2196f3; 
            border-radius: 5px;
            border-left: 3px solid #1976d2;
        }
    </style>
</head>
<body>
    <div class="no-print alert">
        <h4 style="color: #1976d2; margin: 0 0 8px 0;">📄 Εγγύηση Ακουστικού - ' . htmlspecialchars($data['customer_name']) . ' (Serial: ' . htmlspecialchars($data['serial']) . ')</h4>
        <p style="margin: 3px 0; font-size: 11px;"><strong>Εκτύπωση:</strong> Ctrl+P • <strong>Νομική Ισχύς:</strong> Επίσημη εγγύηση ακουστικού βαρηκοΐας</p>
    </div>
    
    ' . $warranty_content . '
    
    <div class="no-print" style="text-align: center; margin-top: 20px; padding: 12px; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border: 1px solid #4caf50; border-radius: 5px;">
        <button onclick="window.print()" style="background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%); color: white; padding: 8px 16px; border: none; border-radius: 4px; font-size: 12px; cursor: pointer;">
            🖨️ Εκτύπωση
        </button>
        <br>
        <small style="color: #2e7d32; font-size: 10px; margin-top: 5px; display: block;">Επίσημη εγγύηση ακουστικού βαρηκοΐας</small>
    </div>
</body>
</html>';
}
?>