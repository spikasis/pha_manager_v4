<?php
/**
 * 🚨 ULTIMATE EMERGENCY WARRANTY PDF GENERATOR
 * For servers with complete Composer/dependency breakdown
 * PHP 8.2+ Compatible - Zero external dependencies
 * 
 * Use this when both TCPDF and mPDF fail due to Composer issues
 */

// Prevent direct access without ID
$stock_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($stock_id <= 0) {
    die('❌ Invalid stock ID. Usage: ultimate_emergency_warranty.php?id=STOCK_ID');
}

// Set headers for HTML output initially
header('Content-Type: text/html; charset=UTF-8');

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Emergency Warranty Generator</title>";
echo "<style>body{font-family:Arial;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style></head><body>";

echo "<h1>🚨 Ultimate Emergency Warranty Generator</h1>";
echo "<p><strong>Stock ID:</strong> {$stock_id}</p>";
echo "<p><strong>Status:</strong> Server has Composer dependency issues - using emergency mode</p>";

try {
    // Load database configuration with multiple fallback paths
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
            echo "<div class='success'>✅ Database config loaded from: " . basename($config_file) . "</div>";
            break;
        }
    }
    
    if (!$config_loaded) {
        throw new Exception("Database configuration file not found in any expected location");
    }
    
    // Database connection with enhanced error handling
    $mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }
    $mysqli->set_charset('utf8mb4'); // Enhanced charset for Greek characters
    
    echo "<div class='success'>✅ Database connected successfully</div>";
    
    // Basic warranty data query (using confirmed existing columns only)
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
        throw new Exception("Query preparation failed: " . $mysqli->error);
    }
    
    $stmt->bind_param('i', $stock_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        throw new Exception("Stock ID {$stock_id} not found in database");
    }
    
    echo "<div class='success'>✅ Warranty data retrieved successfully</div>";
    echo "<div class='info'>Customer: " . htmlspecialchars($data['customer_name']) . "</div>";
    echo "<div class='info'>Serial: " . htmlspecialchars($data['serial']) . "</div>";
    
    // Try multiple TCPDF loading methods with comprehensive fallback
    $tcpdf_loaded = false;
    $tcpdf_method = '';
    $pdf_available = false;
    
    // Method 1: Check if TCPDF already available
    if (class_exists('TCPDF')) {
        $tcpdf_loaded = true;
        $tcpdf_method = 'Pre-loaded';
    }
    
    // Method 2: Try Composer autoloader (with extensive error suppression)
    if (!$tcpdf_loaded) {
        $autoloader_paths = [
            __DIR__ . '/vendor/autoload.php',
            dirname(__DIR__) . '/vendor/autoload.php',
            'vendor/autoload.php'
        ];
        
        foreach ($autoloader_paths as $autoloader_path) {
            if (file_exists($autoloader_path)) {
                try {
                    // Maximum error suppression
                    $original_error_reporting = error_reporting(0);
                    $original_display_errors = ini_get('display_errors');
                    ini_set('display_errors', 0);
                    
                    ob_start();
                    include_once $autoloader_path;
                    ob_end_clean();
                    
                    // Restore error settings
                    error_reporting($original_error_reporting);
                    ini_set('display_errors', $original_display_errors);
                    
                    if (class_exists('TCPDF')) {
                        $tcpdf_loaded = true;
                        $tcpdf_method = 'Composer autoloader: ' . basename(dirname($autoloader_path));
                        break;
                    }
                } catch (Throwable $e) {
                    error_reporting($original_error_reporting);
                    ini_set('display_errors', $original_display_errors);
                    ob_end_clean();
                    // Continue to next method
                }
            }
        }
    }
    
    // Method 3: Try direct TCPDF include from various locations
    if (!$tcpdf_loaded) {
        $tcpdf_direct_paths = [
            __DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php',
            dirname(__DIR__) . '/vendor/tecnickcom/tcpdf/tcpdf.php',
            __DIR__ . '/third_party/tcpdf/tcpdf.php',
            __DIR__ . '/libraries/tcpdf/tcpdf.php',
            'vendor/tecnickcom/tcpdf/tcpdf.php',
            'third_party/tcpdf/tcpdf.php'
        ];
        
        foreach ($tcpdf_direct_paths as $tcpdf_path) {
            if (file_exists($tcpdf_path)) {
                try {
                    $original_error_reporting = error_reporting(0);
                    ob_start();
                    include_once $tcpdf_path;
                    ob_end_clean();
                    error_reporting($original_error_reporting);
                    
                    if (class_exists('TCPDF')) {
                        $tcpdf_loaded = true;
                        $tcpdf_method = 'Direct include: ' . basename(dirname($tcpdf_path));
                        break;
                    }
                } catch (Throwable $e) {
                    error_reporting($original_error_reporting);
                    ob_end_clean();
                    // Continue to next path
                }
            }
        }
    }
    
    if ($tcpdf_loaded) {
        echo "<div class='success'>✅ TCPDF loaded successfully via: {$tcpdf_method}</div>";
        $pdf_available = true;
        
        try {
            // Generate PDF with TCPDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            // Enhanced PDF configuration
            $pdf->SetCreator('PHA Manager V4 - Ultimate Emergency Generator');
            $pdf->SetAuthor('Pikasis Hearing Aids');
            $pdf->SetTitle('Εγγύηση Ακουστικού - ' . $data['serial']);
            $pdf->SetSubject('Emergency Warranty Document');
            $pdf->SetKeywords('Warranty, Hearing Aid, ' . $data['serial']);
            
            // Set margins and auto page break
            $pdf->SetMargins(15, 20, 15);
            $pdf->SetAutoPageBreak(TRUE, 20);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // Add page
            $pdf->AddPage();
            
            // Set font with Greek support
            $pdf->SetFont('freeserif', '', 12);
            
            // Generate comprehensive warranty HTML
            $warranty_html = generateUltimateWarrantyHTML($data);
            
            // Write HTML to PDF
            $pdf->writeHTML($warranty_html, true, false, true, false, '');
            
            // Output PDF
            $filename = 'Emergency_Warranty_' . $data['serial'] . '_' . date('Y-m-d') . '.pdf';
            
            if (isset($_GET['download']) && $_GET['download'] == '1') {
                $pdf->Output($filename, 'D'); // Force download
                exit;
            } else {
                // Set proper headers for PDF display
                header('Content-Type: application/pdf');
                $pdf->Output($filename, 'I'); // Display in browser
                exit;
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ PDF generation failed: " . htmlspecialchars($e->getMessage()) . "</div>";
            $pdf_available = false;
        }
    }
    
    // If PDF not available, provide comprehensive HTML warranty
    if (!$pdf_available) {
        echo "<div class='error'>❌ PDF libraries not available - generating HTML warranty</div>";
        
        // Generate HTML warranty
        $html_warranty = generatePrintableWarranty($data);
        
        // Output HTML warranty
        echo "</body></html>"; // Close the status HTML
        
        // Output the warranty HTML
        echo $html_warranty;
        
        // Add JavaScript for auto-print option
        echo "<script>";
        echo "if (confirm('PDF generation unavailable. Print this HTML warranty?')) {";
        echo "  window.print();";
        echo "}";
        echo "</script>";
        exit;
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p><strong>Emergency mode failed.</strong></p>";
    echo "<p>Please contact administrator with error details.</p>";
} catch (Error $e) {
    echo "<div class='error'>❌ PHP ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p><strong>Emergency mode failed.</strong></p>";
} catch (Throwable $e) {
    echo "<div class='error'>❌ CRITICAL ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p><strong>Emergency mode failed.</strong></p>";
}

echo "</body></html>";

/**
 * Generate ultimate warranty HTML with comprehensive details
 */
function generateUltimateWarrantyHTML($data) {
    return '
    <style>
        body { font-family: "freeserif", serif; font-size: 11pt; }
        .header { text-align: center; margin-bottom: 30px; }
        .company-info { text-align: center; margin-bottom: 20px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        td, th { padding: 8px; border: 1px solid #333; }
        .label { background-color: #f0f0f0; font-weight: bold; width: 35%; }
        .warranty-terms { margin: 20px 0; text-align: justify; line-height: 1.5; }
        .signature { text-align: right; margin-top: 40px; }
        .footer { text-align: center; margin-top: 30px; padding: 10px; border: 1px solid #333; background-color: #f8f9fa; }
    </style>
    
    <div class="header">
        <h1 style="color: #2c3e50; font-size: 18pt;">ΕΓΓΥΗΣΗ ΚΑΛΗΣ ΛΕΙΤΟΥΡΓΙΑΣ</h1>
        <h2 style="color: #7f8c8d; font-size: 14pt;">ΙΑΤΡΟΤΕΧΝΟΛΟΓΙΚΟΥ ΠΡΟΙΟΝΤΟΣ</h2>
    </div>
    
    <div class="company-info">
        <p><strong>Πικάσης Ακοοπροθετικά</strong></p>
        <p>Λιβαδειά | Τηλ: 22610-XXXXX</p>
        <hr style="border: 1px solid #bdc3c7; margin: 20px 50px;">
    </div>
    
    <table>
        <tr>
            <td class="label">ΟΝΟΜΑΤΕΠΩΝΥΜΟ ΠΕΛΑΤΗ:</td>
            <td><strong>' . htmlspecialchars($data['customer_name'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">ΑΜΚΑ:</td>
            <td>' . htmlspecialchars($data['customer_amka'] ?? 'N/A') . '</td>
        </tr>

        <tr>
            <td class="label">ΗΜΕΡΟΜΗΝΙΑ ΑΓΟΡΑΣ:</td>
            <td><strong>' . htmlspecialchars($data['day_out'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">ΙΣΧΥΣ ΕΓΓΥΗΣΗΣ ΕΩΣ:</td>
            <td><strong style="color: #d9534f;">' . htmlspecialchars($data['guarantee_end'] ?? 'N/A') . '</strong></td>
        </tr>
    </table>
    
    <table style="margin-top: 20px;">
        <tr>
            <td class="label">ΚΑΤΑΣΚΕΥΑΣΤΙΚΟΣ ΟΙΚΟΣ:</td>
            <td><strong>' . htmlspecialchars($data['manufacturer_name'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">ΣΕΙΡΑ ΠΡΟΙΟΝΤΟΣ:</td>
            <td>' . htmlspecialchars($data['series_name'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td class="label">ΜΟΝΤΕΛΟ:</td>
            <td>' . htmlspecialchars($data['model_name'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td class="label">ΤΥΠΟΣ ΑΚΟΥΣΤΙΚΟΥ:</td>
            <td>' . htmlspecialchars($data['ha_type_name'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td class="label">ΣΕΙΡΙΑΚΟΣ ΑΡΙΘΜΟΣ (SERIAL):</td>
            <td><strong style="color: #0275d8; font-size: 12pt;">' . htmlspecialchars($data['serial'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">BARCODE ΕΟΠΥΥ:</td>
            <td>' . htmlspecialchars($data['ekapty_code'] ?? '-') . '</td>
        </tr>
        <tr>
            <td class="label">ΑΡ. ΕΚΤΕΛΕΣΗΣ ΕΟΠΥΥ:</td>
            <td>' . htmlspecialchars($data['ektelesi_eopyy'] ?? '-') . '</td>
        </tr>
    </table>
    
    <div class="warranty-terms">
        <h3 style="color: #2c3e50; border-bottom: 2px solid #2c3e50; padding-bottom: 5px;">ΟΡΟΙ ΕΓΓΥΗΣΗΣ</h3>
        
        <p><strong>Η συσκευή που προμηθευτήκατε:</strong></p>
        <ul>
            <li>Αποτελεί <strong>ιατροτεχνολογικό προιόν</strong> με πιστοποίηση CE</li>
            <li>Συνοδεύεται από εγγύηση καλής λειτουργίας <strong>δύο (2) ετών</strong></li>
            <li>Καλύπτεται από εξουσιοδοτημένο τμήμα τεχνικής υποστήριξης</li>
        </ul>
        
        <p><strong>Η εγγύηση ΔΕΝ καλύπτει:</strong></p>
        <ul>
            <li>Βλάβες από μη ορθή χρήση ή ελλειπή συντήρηση</li>
            <li>Επισκευές από μη εξουσιοδοτημένα άτομα</li>
            <li>Φυσική φθορά από κανονική χρήση</li>
            <li>Βλάβες από υγρασία, κρούσεις ή πτώσεις</li>
        </ul>
        
        <p><strong>Για τεχνική υποστήριξη:</strong> Επικοινωνήστε με το τμήμα service της εταιρείας μας.</p>
    </div>
    
    <div class="footer">
        <p><strong>Κωδικός Επιχείρησης Μητρώου ΕΚΑΠΤΥ: ' . htmlspecialchars($data['company_ekapty'] ?? '301068') . '</strong></p>
    </div>
    
    <div class="signature">
        <p>Λιβαδειά, ' . date('d-m-Y') . '</p>
        <div style="margin-top: 30px;">
            <p><strong>Σπυρίδων Κ. Πικάσης</strong></p>
            <p style="margin-top: 5px;">Μηχανικός Βιοΐατρικής Τεχνολογίας</p>
            <p style="margin-top: 5px;">Ειδικός Ακοοπροθετιστής</p>
            <p style="margin-top: 15px; font-size: 9pt; color: #666;">Έκδοση: Emergency Generator v1.0</p>
        </div>
    </div>';
}

/**
 * Generate printable HTML warranty when PDF not available
 */
function generatePrintableWarranty($data) {
    $warranty_content = generateUltimateWarrantyHTML($data);
    
    return '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Εγγύηση - ' . htmlspecialchars($data['serial']) . '</title>
    <style>
        @media screen {
            body { max-width: 800px; margin: 20px auto; padding: 20px; border: 2px solid #333; }
            .no-print { display: block; }
        }
        @media print {
            body { margin: 0; padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background: #fff3cd; padding: 15px; margin-bottom: 20px; border: 1px solid #ffc107;">
        <h3 style="color: #856404; margin: 0 0 10px 0;">⚠️ HTML Έκδοση Εγγύησης</h3>
        <p style="margin: 5px 0;"><strong>Λόγος:</strong> Οι βιβλιοθήκες PDF δεν είναι διαθέσιμες στο server</p>
        <p style="margin: 5px 0;"><strong>Για εκτύπωση:</strong> Ctrl+P ή μενού Print του browser</p>
        <p style="margin: 5px 0;"><strong>Εγκυρότητα:</strong> Αυτό το έγγραφο έχει την ίδια νομική ισχύ με την PDF έκδοση</p>
    </div>
    
    ' . $warranty_content . '
    
    <div class="no-print" style="text-align: center; margin-top: 30px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb;">
        <button onclick="window.print()" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;">
            🖨️ Εκτύπωση Εγγύησης
        </button>
        <br><br>
        <small>Σε περίπτωση προβλημάτων, επικοινωνήστε με τον διαχειριστή</small>
    </div>
</body>
</html>';
}
?>