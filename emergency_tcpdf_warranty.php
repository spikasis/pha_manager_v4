<?php
/**
 * 🚨 EMERGENCY STANDALONE TCPDF WARRANTY GENERATOR
 * For servers with Composer dependency issues
 * PHP 8.2+ Compatible - No external dependencies
 */

// Configuration
define('EMERGENCY_MODE', true);

// Get stock ID from URL
$stock_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($stock_id <= 0) {
    die('❌ Invalid stock ID. Usage: emergency_tcpdf_warranty.php?id=STOCK_ID');
}

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Emergency TCPDF Warranty</title>";
echo "<style>body{font-family:Arial;margin:20px;} .success{color:green;} .error{color:red;}</style></head><body>";

echo "<h1>🚨 Emergency TCPDF Warranty Generator</h1>";
echo "<p>Processing Stock ID: <strong>{$stock_id}</strong></p>";

try {
    // Load database configuration
    $config_file = __DIR__ . '/application/config/database.php';
    if (!file_exists($config_file)) {
        throw new Exception("Database config not found: {$config_file}");
    }
    
    define('BASEPATH', '');
    define('ENVIRONMENT', 'production');
    include $config_file;
    
    echo "<div class='success'>✅ Database config loaded</div>";
    
    // Database connection
    $mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }
    $mysqli->set_charset('utf8');
    
    echo "<div class='success'>✅ Database connected</div>";
    
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
    ";
    
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception("Query preparation failed: " . $mysqli->error);
    }
    
    $stmt->bind_param('i', $stock_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        throw new Exception("Stock ID {$stock_id} not found in database");
    }
    
    echo "<div class='success'>✅ Warranty data retrieved</div>";
    
    // Try TCPDF with multiple loading methods
    $tcpdf_loaded = false;
    $tcpdf_method = '';
    
    // Method 1: Check if already available
    if (class_exists('TCPDF')) {
        $tcpdf_loaded = true;
        $tcpdf_method = 'Already loaded';
    }
    
    // Method 2: Try vendor autoloader (suppressed)
    if (!$tcpdf_loaded && file_exists(__DIR__ . '/vendor/autoload.php')) {
        try {
            error_reporting(0); // Suppress all errors
            ob_start();
            require_once __DIR__ . '/vendor/autoload.php';
            ob_end_clean();
            error_reporting(E_ALL);
            
            if (class_exists('TCPDF')) {
                $tcpdf_loaded = true;
                $tcpdf_method = 'Composer autoloader (suppressed)';
            }
        } catch (Throwable $e) {
            ob_end_clean();
            error_reporting(E_ALL);
            // Continue to next method
        }
    }
    
    // Method 3: Try direct TCPDF include
    if (!$tcpdf_loaded) {
        $tcpdf_paths = [
            __DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php',
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
                        $tcpdf_method = 'Direct include: ' . basename(dirname($path));
                        break;
                    }
                } catch (Throwable $e) {
                    ob_end_clean();
                    error_reporting(E_ALL);
                    continue;
                }
            }
        }
    }
    
    if (!$tcpdf_loaded) {
        // Fallback to HTML output
        echo "<div class='error'>❌ TCPDF not available - generating HTML warranty</div>";
        
        // Generate HTML warranty as fallback
        $html_warranty = generateHTMLWarranty($data);
        echo $html_warranty;
        
        echo "<div style='margin-top: 20px; padding: 10px; border: 1px solid #orange; background: #fff3cd;'>";
        echo "<strong>⚠️ Note:</strong> PDF generation unavailable. This is the HTML version of the warranty.<br>";
        echo "For PDF version, please contact administrator to fix TCPDF dependencies.";
        echo "</div>";
        
    } else {
        echo "<div class='success'>✅ TCPDF loaded via: {$tcpdf_method}</div>";
        
        // Generate PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        $pdf->SetCreator('PHA Manager V4 - Emergency TCPDF');
        $pdf->SetAuthor('Pikasis Hearing Aids');
        $pdf->SetTitle('Εγγύηση Ακουστικού - ' . $data['serial']);
        $pdf->SetSubject('Emergency Warranty Document');
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->AddPage();
        $pdf->SetFont('freeserif', '', 12);
        
        $html_content = generateWarrantyHTML($data);
        $pdf->writeHTML($html_content, true, false, true, false, '');
        
        // Output PDF
        $filename = 'Emergency_Warranty_' . $data['serial'] . '_' . date('Y-m-d') . '.pdf';
        
        if (isset($_GET['download'])) {
            $pdf->Output($filename, 'D'); // Force download
            exit;
        } else {
            $pdf->Output($filename, 'I'); // Display in browser
            exit;
        }
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
} catch (Error $e) {
    echo "<div class='error'>❌ PHP ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo "</body></html>";

/**
 * Generate warranty HTML content
 */
function generateWarrantyHTML($data) {
    return '
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #2c3e50;">ΕΓΓΥΗΣΗ ΚΑΛΗΣ ΛΕΙΤΟΥΡΓΙΑΣ</h1>
        <p style="color: #7f8c8d;"><strong>Πικάσης Ακοοπροθετικά</strong></p>
        <hr style="border: 1px solid #bdc3c7;">
    </div>
    
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr style="background-color: #ecf0f1;">
            <td style="width: 35%; font-weight: bold;">ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</td>
            <td style="width: 65%;">' . htmlspecialchars($data['customer_name'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">ΑΜΚΑ:</td>
            <td>' . htmlspecialchars($data['customer_amka'] ?? 'N/A') . '</td>
        </tr>
        <tr style="background-color: #ecf0f1;">
            <td style="font-weight: bold;">ΗΜΕΡΟΜΗΝΙΑ ΑΓΟΡΑΣ:</td>
            <td>' . htmlspecialchars($data['day_out'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">ΙΣΧΥΣ ΕΓΓΥΗΣΗΣ:</td>
            <td>' . htmlspecialchars($data['guarantee_end'] ?? 'N/A') . '</td>
        </tr>
        <tr style="background-color: #ecf0f1;">
            <td style="font-weight: bold;">ΚΑΤΑΣΚΕΥΑΣΤΙΚΟΣ ΟΙΚΟΣ:</td>
            <td>' . htmlspecialchars($data['manufacturer_name'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">ΤΥΠΟΣ ΑΚΟΥΣΤΙΚΟΥ:</td>
            <td>' . htmlspecialchars($data['series_name'] ?? '') . '-' . htmlspecialchars($data['model_name'] ?? '') . ' - ' . htmlspecialchars($data['ha_type_name'] ?? 'N/A') . '</td>
        </tr>
        <tr style="background-color: #ecf0f1;">
            <td style="font-weight: bold;">SERIAL NO:</td>
            <td><strong>' . htmlspecialchars($data['serial'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">BARCODE ΕΟΠΥΥ:</td>
            <td>' . htmlspecialchars($data['ekapty_code'] ?? '-') . '</td>
        </tr>
        <tr style="background-color: #ecf0f1;">
            <td style="font-weight: bold;">ΑΡ. ΕΚΤΕΛΕΣΗΣ ΕΟΠΥΥ:</td>
            <td>' . htmlspecialchars($data['ektelesi_eopyy'] ?? '-') . '</td>
        </tr>
    </table>
    
    <div style="margin-top: 25px; text-align: justify; line-height: 1.6;">
        <p>Η συσκευή που προμηθευτήκατε αποτελεί ιατροτεχνολογικό προιόν, φέρει σήμανση <strong>CE</strong> και συνοδεύεται από εγγύηση καλής λειτουργίας <strong>δύο (2) ετών</strong>.</p>
        
        <p>Η επιχείρηση μας διαθέτει εξουσιοδοτημένο τμήμα τεχνικής υποστήριξης.</p>
        
        <h3 style="color: #2c3e50; margin-top: 20px;">ΟΡΟΙ ΕΓΓΥΗΣΗΣ</h3>
        
        <p>Η εγγύηση δεν καλύπτει βλάβες που οφείλονται σε μη ορθή χρήση του προιόντος ή ελλειπή συντήρηση όπως αναφέρεται από τον κατασκευαστή στο εγχειρίδιο χρήσης που συνοδεύει το προιόν.</p>
        
        <p>Η εγγύηση δεν ισχύει σε περίπτωση επισκευής ή επέμβασης στο προιόν από άτομα που δεν είναι εξουσιοδοτημένα από την επιχείρηση μας ή τον κατασκευαστικό οίκο.</p>
    </div>
    
    <div style="text-align: center; margin-top: 25px; padding: 15px; border: 1px solid #bdc3c7; background-color: #f8f9fa;">
        <p><strong>Κωδικός Επιχείρησης Μητρώου ΕΚΑΠΤΥ: ' . htmlspecialchars($data['company_ekapty'] ?? '301068') . '</strong></p>
    </div>
    
    <div style="text-align: right; margin-top: 40px;">
        <p>Λιβαδειά, ' . date('d-m-Y') . '</p>
        <div style="margin-top: 30px;">
            <p><strong>Σπυρίδων Κ. Πικάσης</strong></p>
            <p style="margin-top: 5px;">Μηχανικός Βιοΐατρικής Τεχνολογίας</p>
            <p style="margin-top: 5px;">Ειδικός Ακοοπροθετιστής</p>
        </div>
    </div>';
}

/**
 * Generate HTML warranty for browser display when PDF not available
 */
function generateHTMLWarranty($data) {
    $html_content = generateWarrantyHTML($data);
    
    return '
    <div style="max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; background: white;">
        ' . $html_content . '
        
        <div style="text-align: center; margin-top: 30px; padding: 10px; border-top: 2px solid #ccc;">
            <p><strong>📄 HTML ΕΚΔΟΣΗ ΕΓΓΥΗΣΗΣ</strong></p>
            <p>Για εκτύπωση: Ctrl+P ή Right Click → Print</p>
        </div>
    </div>';
}
?>