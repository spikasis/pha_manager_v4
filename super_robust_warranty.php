<?php
/**
 * 🚨 SUPER ROBUST WARRANTY GENERATOR
 * For servers with completely broken Composer/TCPDF installations
 * Tries every possible method to generate PDFs, falls back to HTML
 */

// Get stock ID
$stock_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($stock_id <= 0) {
    die('❌ Invalid stock ID. Usage: super_robust_warranty.php?id=STOCK_ID');
}

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Super Robust Warranty</title>";
echo "<style>body{font-family:Arial;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style></head><body>";

echo "<h1>🛡️ Super Robust Warranty Generator</h1>";
echo "<p><strong>Stock ID:</strong> {$stock_id}</p>";

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
            echo "<div class='success'>✅ Database config loaded</div>";
            break;
        }
    }
    
    if (!$config_loaded) {
        throw new Exception("Database configuration not found");
    }
    
    // Database connection
    $mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }
    $mysqli->set_charset('utf8mb4');
    
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
        throw new Exception("Stock ID {$stock_id} not found");
    }
    
    echo "<div class='success'>✅ Warranty data retrieved</div>";
    echo "<div class='info'>Customer: " . htmlspecialchars($data['customer_name']) . "</div>";
    echo "<div class='info'>Serial: " . htmlspecialchars($data['serial']) . "</div>";
    
    // SUPER AGGRESSIVE TCPDF LOADING - Try everything possible
    $tcpdf_loaded = false;
    $tcpdf_method = '';
    
    echo "<h3>🔍 Attempting TCPDF Loading (Multiple Methods)</h3>";
    
    // Method 1: Already loaded
    if (class_exists('TCPDF')) {
        $tcpdf_loaded = true;
        $tcpdf_method = 'Pre-loaded in memory';
        echo "<div class='success'>✅ Method 1: TCPDF already available</div>";
    }
    
    // Method 2: Try current directory TCPDF
    if (!$tcpdf_loaded) {
        echo "<div class='info'>🔄 Method 2: Trying current directory...</div>";
        $current_tcpdf_paths = [
            __DIR__ . '/tcpdf/tcpdf.php',
            __DIR__ . '/tcpdf.php',
        ];
        
        foreach ($current_tcpdf_paths as $path) {
            if (file_exists($path)) {
                try {
                    error_reporting(0);
                    ob_start();
                    include_once $path;
                    ob_end_clean();
                    error_reporting(E_ALL);
                    
                    if (class_exists('TCPDF')) {
                        $tcpdf_loaded = true;
                        $tcpdf_method = 'Current directory: ' . basename($path);
                        echo "<div class='success'>✅ Method 2: Loaded from current directory</div>";
                        break;
                    }
                } catch (Throwable $e) {
                    ob_end_clean();
                    error_reporting(E_ALL);
                }
            }
        }
    }
    
    // Method 3: Try vendor paths (multiple attempts)
    if (!$tcpdf_loaded) {
        echo "<div class='info'>🔄 Method 3: Trying vendor directories...</div>";
        $vendor_paths = [
            __DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php',
            dirname(__DIR__) . '/vendor/tecnickcom/tcpdf/tcpdf.php',
            __DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php',
            'vendor/tecnickcom/tcpdf/tcpdf.php',
            '../vendor/tecnickcom/tcpdf/tcpdf.php',
        ];
        
        foreach ($vendor_paths as $path) {
            if (file_exists($path)) {
                try {
                    error_reporting(0);
                    ob_start();
                    include_once $path;
                    ob_end_clean();
                    error_reporting(E_ALL);
                    
                    if (class_exists('TCPDF')) {
                        $tcpdf_loaded = true;
                        $tcpdf_method = 'Vendor path: ' . $path;
                        echo "<div class='success'>✅ Method 3: Loaded from vendor directory</div>";
                        break;
                    }
                } catch (Throwable $e) {
                    ob_end_clean();
                    error_reporting(E_ALL);
                }
            }
        }
    }
    
    // Method 4: Try third_party and libraries
    if (!$tcpdf_loaded) {
        echo "<div class='info'>🔄 Method 4: Trying third_party/libraries...</div>";
        $lib_paths = [
            __DIR__ . '/third_party/tcpdf/tcpdf.php',
            __DIR__ . '/libraries/tcpdf/tcpdf.php',
            __DIR__ . '/application/third_party/tcpdf/tcpdf.php',
            __DIR__ . '/application/libraries/tcpdf/tcpdf.php',
        ];
        
        foreach ($lib_paths as $path) {
            if (file_exists($path)) {
                try {
                    error_reporting(0);
                    ob_start();
                    include_once $path;
                    ob_end_clean();
                    error_reporting(E_ALL);
                    
                    if (class_exists('TCPDF')) {
                        $tcpdf_loaded = true;
                        $tcpdf_method = 'Library path: ' . $path;
                        echo "<div class='success'>✅ Method 4: Loaded from libraries</div>";
                        break;
                    }
                } catch (Throwable $e) {
                    ob_end_clean();
                    error_reporting(E_ALL);
                }
            }
        }
    }
    
    // Method 5: Try Composer autoloader (careful approach)
    if (!$tcpdf_loaded) {
        echo "<div class='info'>🔄 Method 5: Trying Composer (with extreme caution)...</div>";
        $autoloader_paths = [
            __DIR__ . '/vendor/autoload.php',
            dirname(__DIR__) . '/vendor/autoload.php',
            'vendor/autoload.php'
        ];
        
        foreach ($autoloader_paths as $autoloader_path) {
            if (file_exists($autoloader_path)) {
                try {
                    // MAXIMUM error suppression for corrupted Composer
                    $error_level = error_reporting(0);
                    $display_errors = ini_get('display_errors');
                    ini_set('display_errors', 0);
                    
                    ob_start();
                    include_once $autoloader_path;
                    ob_end_clean();
                    
                    // Restore settings
                    error_reporting($error_level);
                    ini_set('display_errors', $display_errors);
                    
                    if (class_exists('TCPDF')) {
                        $tcpdf_loaded = true;
                        $tcpdf_method = 'Composer (careful): ' . basename(dirname($autoloader_path));
                        echo "<div class='success'>✅ Method 5: Composer worked despite issues</div>";
                        break;
                    }
                } catch (Throwable $e) {
                    error_reporting($error_level);
                    ini_set('display_errors', $display_errors);
                    ob_end_clean();
                    echo "<div class='error'>❌ Method 5: Composer failed: " . htmlspecialchars($e->getMessage()) . "</div>";
                }
            }
        }
    }
    
    if ($tcpdf_loaded) {
        echo "<div class='success'>🎉 <strong>SUCCESS!</strong> TCPDF loaded via: {$tcpdf_method}</div>";
        
        try {
            // Generate PDF with TCPDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            $pdf->SetCreator('PHA Manager V4 - Super Robust Generator');
            $pdf->SetAuthor('Pikasis Hearing Aids');
            $pdf->SetTitle('Εγγύηση Ακουστικού - ' . $data['serial']);
            $pdf->SetSubject('Super Robust Warranty Document');
            
            $pdf->SetMargins(15, 20, 15);
            $pdf->SetAutoPageBreak(TRUE, 20);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();
            $pdf->SetFont('freeserif', '', 12);
            
            // Generate warranty HTML
            $warranty_html = generateSuperRobustWarrantyHTML($data);
            $pdf->writeHTML($warranty_html, true, false, true, false, '');
            
            // Output PDF
            $filename = 'SuperRobust_Warranty_' . $data['serial'] . '_' . date('Y-m-d') . '.pdf';
            
            echo "<div class='success'>✅ PDF generated successfully!</div>";
            echo "<p><a href='?id={$stock_id}&download=1' style='background:#007cba;color:white;padding:10px;text-decoration:none;border-radius:5px;'>📄 Download PDF</a></p>";
            
            if (isset($_GET['download'])) {
                $pdf->Output($filename, 'D');
                exit;
            } else {
                // Display in browser
                header('Content-Type: application/pdf');
                $pdf->Output($filename, 'I');
                exit;
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ PDF generation failed: " . htmlspecialchars($e->getMessage()) . "</div>";
            $tcpdf_loaded = false; // Force HTML fallback
        }
    }
    
    // HTML Fallback (when all PDF methods fail)
    if (!$tcpdf_loaded) {
        echo "<div class='error'>❌ All PDF methods failed - generating HTML warranty</div>";
        echo "<div class='info'>📋 This HTML warranty has the same legal validity as PDF</div>";
        
        echo "</body></html>"; // Close status HTML
        
        // Generate and output HTML warranty
        $html_warranty = generatePrintableWarranty($data);
        echo $html_warranty;
        exit;
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ CRITICAL ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p>Please contact administrator</p>";
} catch (Error $e) {
    echo "<div class='error'>❌ PHP ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
} catch (Throwable $e) {
    echo "<div class='error'>❌ SYSTEM ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo "</body></html>";

/**
 * Generate super robust warranty HTML
 */
function generateSuperRobustWarrantyHTML($data) {
    return '
    <style>
        body { font-family: "freeserif", serif; font-size: 12pt; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 25px; }
        .company { text-align: center; margin-bottom: 20px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        td { padding: 10px; border: 1px solid #333; }
        .label { background-color: #f5f5f5; font-weight: bold; width: 40%; }
        .terms { margin: 20px 0; text-align: justify; line-height: 1.6; }
        .signature { text-align: right; margin-top: 35px; }
        .footer { text-align: center; margin-top: 25px; padding: 12px; border: 1px solid #333; background-color: #fafafa; }
    </style>
    
    <div class="header">
        <h1 style="color: #2c3e50; font-size: 20pt; margin-bottom: 10px;">ΕΓΓΥΗΣΗ ΚΑΛΗΣ ΛΕΙΤΟΥΡΓΙΑΣ</h1>
        <h2 style="color: #7f8c8d; font-size: 16pt; margin: 0;">ΙΑΤΡΟΤΕΧΝΟΛΟΓΙΚΟΥ ΠΡΟΙΟΝΤΟΣ</h2>
    </div>
    
    <div class="company">
        <p style="font-size: 14pt; margin: 5px 0;"><strong>Πικάσης Ακοοπροθετικά</strong></p>
        <p style="margin: 5px 0;">Λιβαδειά • Τηλ: 22610-XXXXX</p>
        <hr style="border: 1px solid #ccc; margin: 15px 50px;">
    </div>
    
    <table>
        <tr>
            <td class="label">ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</td>
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
            <td class="label">ΛΗΞΗ ΕΓΓΥΗΣΗΣ:</td>
            <td><strong style="color: #d9534f;">' . htmlspecialchars($data['guarantee_end'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">ΚΑΤΑΣΚΕΥΑΣΤΗΣ:</td>
            <td><strong>' . htmlspecialchars($data['manufacturer_name'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">ΣΕΙΡΑ - ΜΟΝΤΕΛΟ:</td>
            <td>' . htmlspecialchars($data['series_name'] ?? 'N/A') . ' - ' . htmlspecialchars($data['model_name'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td class="label">ΤΥΠΟΣ ΑΚΟΥΣΤΙΚΟΥ:</td>
            <td>' . htmlspecialchars($data['ha_type_name'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td class="label">ΣΕΙΡΙΑΚΟΣ ΑΡΙΘΜΟΣ:</td>
            <td><strong style="color: #0275d8; font-size: 14pt;">' . htmlspecialchars($data['serial'] ?? 'N/A') . '</strong></td>
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
    
    <div class="terms">
        <h3 style="color: #2c3e50; border-bottom: 2px solid #2c3e50; padding-bottom: 8px; margin-bottom: 15px;">ΟΡΟΙ ΕΓΓΥΗΣΗΣ</h3>
        
        <p><strong>Η συσκευή που προμηθευτήκατε:</strong></p>
        <ul style="margin: 10px 0; padding-left: 25px;">
            <li>Αποτελεί <strong>ιατροτεχνολογικό προιόν</strong> με πιστοποίηση CE</li>
            <li>Συνοδεύεται από εγγύηση καλής λειτουργίας <strong>δύο (2) ετών</strong></li>
            <li>Υποστηρίζεται από εξουσιοδοτημένο τεχνικό τμήμα</li>
        </ul>
        
        <p><strong>Η εγγύηση ΔΕΝ καλύπτει:</strong></p>
        <ul style="margin: 10px 0; padding-left: 25px;">
            <li>Βλάβες από λανθασμένη χρήση ή ανεπαρκή συντήρηση</li>
            <li>Επισκευές από μη εξουσιοδοτημένα άτομα ή εργαστήρια</li>
            <li>Φυσική φθορά από την κανονική χρήση του προιόντος</li>
        </ul>
    </div>
    
    <div class="footer">
        <p><strong>Κωδικός Επιχείρησης Μητρώου ΕΚΑΠΤΥ: ' . htmlspecialchars($data['company_ekapty'] ?? '301068') . '</strong></p>
    </div>
    
    <div class="signature">
        <p style="margin-bottom: 25px;">Λιβαδειά, ' . date('d-m-Y') . '</p>
        <div>
            <p style="margin: 8px 0; font-size: 14pt;"><strong>Σπυρίδων Κ. Πικάσης</strong></p>
            <p style="margin: 5px 0;">Μηχανικός Βιοϊατρικής Τεχνολογίας</p>
            <p style="margin: 5px 0;">Ειδικός Ακοοπροθετιστής</p>
            <p style="margin-top: 15px; font-size: 10pt; color: #666;">Έκδοση: Super Robust Generator v1.0</p>
        </div>
    </div>';
}

/**
 * Generate printable HTML warranty
 */
function generatePrintableWarranty($data) {
    $warranty_content = generateSuperRobustWarrantyHTML($data);
    
    return '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Εγγύηση - ' . htmlspecialchars($data['serial']) . '</title>
    <style>
        @media screen {
            body { max-width: 800px; margin: 20px auto; padding: 25px; border: 2px solid #333; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
            .no-print { display: block; }
        }
        @media print {
            body { margin: 0; padding: 15px; }
            .no-print { display: none; }
        }
        .alert { background: #fff3cd; padding: 15px; margin-bottom: 20px; border: 1px solid #ffc107; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="no-print alert">
        <h3 style="color: #856404; margin: 0 0 10px 0;">⚠️ HTML Έκδοση Εγγύησης</h3>
        <p style="margin: 5px 0;"><strong>Λόγος:</strong> PDF βιβλιοθήκες μη διαθέσιμες (Composer corruption)</p>
        <p style="margin: 5px 0;"><strong>Εκτύπωση:</strong> Ctrl+P ή μενού Print του περιηγητή</p>
        <p style="margin: 5px 0;"><strong>Εγκυρότητα:</strong> Ίδια νομική ισχύς με PDF έκδοση</p>
    </div>
    
    ' . $warranty_content . '
    
    <div class="no-print" style="text-align: center; margin-top: 30px; padding: 20px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px;">
        <button onclick="window.print()" style="background: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
            🖨️ Εκτύπωση Εγγύησης
        </button>
        <br><br>
        <small style="color: #155724;">Η εκτύπωση αυτής της σελίδας παράγει νόμιμη εγγύηση ακουστικού</small>
    </div>
</body>
</html>';
}
?>