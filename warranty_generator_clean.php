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
 * Generate warranty HTML content for PDF
 */
function generateWarrantyHTML($data) {
    return '
    <style>
        body { 
            font-family: "freeserif", serif; 
            font-size: 12pt; 
            line-height: 1.5; 
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            padding-bottom: 20px;
            border-bottom: 3px solid #2c3e50;
        }
        .company { 
            text-align: center; 
            margin-bottom: 25px; 
            color: #555; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
        }
        td { 
            padding: 12px; 
            border: 1px solid #333; 
            vertical-align: top;
        }
        .label { 
            background-color: #f8f9fa; 
            font-weight: bold; 
            width: 35%; 
        }
        .terms { 
            margin: 25px 0; 
            text-align: justify; 
            line-height: 1.6; 
        }
        .signature { 
            text-align: right; 
            margin-top: 40px; 
        }
        .footer { 
            text-align: center; 
            margin-top: 30px; 
            padding: 15px; 
            border: 2px solid #2c3e50; 
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .warranty-period {
            background-color: #e8f4fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
    
    <div class="header">
        <h1 style="color: #2c3e50; font-size: 22pt; margin-bottom: 10px;">ΕΓΓΥΗΣΗ ΑΚΟΥΣΤΙΚΟΥ ΒΑΡΗΚΟΙΑΣ</h1>
        <h2 style="color: #666; font-size: 14pt; margin: 0;">ΠΙΣΤΟΠΟΙΗΤΙΚΟ ΕΓΓΥΗΣΗΣ</h2>
    </div>
    
    <div class="company">
        <p style="font-size: 16pt; margin: 8px 0; color: #2c3e50;"><strong>Πικάσης Ακοοπροθετικά</strong></p>
        <p style="margin: 5px 0;">Λιβαδειά • Τηλέφωνο: 22610-XXXXX</p>
    </div>
    
    <table>
        <tr>
            <td class="label">ΟΝΟΜΑΤΕΠΩΝΥΜΟ ΠΕΛΑΤΗ:</td>
            <td><strong>' . htmlspecialchars($data['customer_name'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">ΑΡΙΘΜΟΣ ΜΗΤΡΩΟΥ (ΑΜΚΑ):</td>
            <td>' . htmlspecialchars($data['customer_amka'] ?? 'N/A') . '</td>
        </tr>
        <tr>
            <td class="label">ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΔΟΣΗΣ:</td>
            <td><strong>' . htmlspecialchars($data['day_out'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">ΛΗΞΗ ΕΓΓΥΗΣΗΣ:</td>
            <td><strong style="color: #d9534f;">' . htmlspecialchars($data['guarantee_end'] ?? 'N/A') . '</strong></td>
        </tr>
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
            <td class="label">ΣΕΙΡΙΑΚΟΣ ΑΡΙΘΜΟΣ:</td>
            <td><strong style="color: #0275d8; font-size: 14pt;">' . htmlspecialchars($data['serial'] ?? 'N/A') . '</strong></td>
        </tr>
        <tr>
            <td class="label">BARCODE ΕΟΠΥΥ:</td>
            <td>' . htmlspecialchars($data['ekapty_code'] ?? 'Δεν εφαρμόζεται') . '</td>
        </tr>
        <tr>
            <td class="label">ΑΡΙΘΜΟΣ ΕΚΤΕΛΕΣΗΣ ΕΟΠΥΥ:</td>
            <td>' . htmlspecialchars($data['ektelesi_eopyy'] ?? 'Δεν εφαρμόζεται') . '</td>
        </tr>
    </table>
    
    <div class="warranty-period">
        <h3 style="color: #1976d2; margin: 0 0 10px 0;">🛡️ ΠΕΡΙΟΔΟΣ ΕΓΓΥΗΣΗΣ</h3>
        <p style="margin: 5px 0; font-size: 14pt;"><strong>Το ακουστικό βαρηκοΐας καλύπτεται από εγγύηση καλής λειτουργίας για διάστημα δύο (2) πλήρων ετών από την ημερομηνία παράδοσης.</strong></p>
    </div>
    
    <div class="terms">
        <h3 style="color: #2c3e50; border-bottom: 2px solid #2c3e50; padding-bottom: 8px; margin-bottom: 20px;">ΟΡΟΙ ΚΑΙ ΠΡΟΫΠΟΘΕΣΕΙΣ ΕΓΓΥΗΣΗΣ</h3>
        
        <p><strong>Η εγγύηση καλύπτει:</strong></p>
        <ul style="margin: 15px 0; padding-left: 25px; line-height: 1.8;">
            <li>Κατασκευαστικά ελαττώματα και ανωμαλίες</li>
            <li>Δυσλειτουργίες των ηλεκτρονικών μερών</li>
            <li>Προβλήματα ποιότητας ήχου λόγω κατασκευής</li>
            <li>Δωρεάν επισκευή ή αντικατάσταση κατά την κρίση του κατασκευαστή</li>
        </ul>
        
        <p><strong>Η εγγύηση ΔΕΝ καλύπτει:</strong></p>
        <ul style="margin: 15px 0; padding-left: 25px; line-height: 1.8;">
            <li>Βλάβες από λανθασμένη χρήση ή μη τήρηση οδηγιών χρήσης</li>
            <li>Φθορές από υγρασία, κρούσεις, πτώσεις ή εξωτερικές επιδράσεις</li>
            <li>Επισκευές από μη εξουσιοδοτημένα τεχνικά κέντρα</li>
            <li>Φυσική φθορά από την κανονική χρήση (π.χ. φθορά μπαταρίας)</li>
            <li>Βλάβες από τροποποιήσεις ή επεμβάσεις τρίτων</li>
        </ul>
        
        <p style="margin-top: 20px;"><strong>Για την ενεργοποίηση της εγγύησης:</strong> Απαιτείται η επίδειξη αυτού του πιστοποιητικού εγγύησης μαζί με το ακουστικό. Η εταιρεία μας διαθέτει πλήρως εξουσιοδοτημένο τμήμα τεχνικής υποστήριξης και service.</p>
    </div>
    
    <div class="footer">
        <p style="font-size: 13pt;"><strong>Κωδικός Επιχείρησης Μητρώου ΕΚΑΠΤΥ: ' . htmlspecialchars($data['company_ekapty'] ?? '301068') . '</strong></p>
        <p style="margin-top: 8px; color: #666;">Πιστοποιημένο Κέντρο Ακοοπροθετικής</p>
    </div>
    
    <div class="signature">
        <p style="margin-bottom: 30px;">Λιβαδειά, ' . date('d/m/Y') . '</p>
        <div>
            <p style="margin: 10px 0; font-size: 15pt;"><strong>Σπυρίδων Κ. Πικάσης</strong></p>
            <p style="margin: 8px 0;">Μηχανικός Βιοϊατρικής Τεχνολογίας</p>
            <p style="margin: 8px 0;">Ειδικός Ακοοπροθετιστής</p>
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
                max-width: 850px; 
                margin: 20px auto; 
                padding: 30px; 
                border: 2px solid #2c3e50; 
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                background: #fff;
            }
            .no-print { display: block; }
        }
        @media print {
            body { margin: 0; padding: 15px; }
            .no-print { display: none; }
        }
        .alert { 
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            padding: 20px; 
            margin-bottom: 25px; 
            border: 1px solid #2196f3; 
            border-radius: 8px;
            border-left: 5px solid #1976d2;
        }
    </style>
</head>
<body>
    <div class="no-print alert">
        <h3 style="color: #1976d2; margin: 0 0 15px 0;">📄 Εγγύηση Ακουστικού Βαρηκοΐας</h3>
        <p style="margin: 8px 0;"><strong>Πελάτης:</strong> ' . htmlspecialchars($data['customer_name']) . '</p>
        <p style="margin: 8px 0;"><strong>Σειριακός Αριθμός:</strong> ' . htmlspecialchars($data['serial']) . '</p>
        <p style="margin: 8px 0;"><strong>Εκτύπωση:</strong> Χρησιμοποιήστε Ctrl+P ή το μενού εκτύπωσης του περιηγητή</p>
        <p style="margin: 8px 0; color: #1976d2;"><strong>Νομική Ισχύς:</strong> Αυτό το έγγραφο έχει πλήρη νομική ισχύ ως εγγύηση προιόντος</p>
    </div>
    
    ' . $warranty_content . '
    
    <div class="no-print" style="text-align: center; margin-top: 35px; padding: 25px; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border: 1px solid #4caf50; border-radius: 8px;">
        <button onclick="window.print()" style="background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%); color: white; padding: 15px 30px; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            🖨️ Εκτύπωση Εγγύησης
        </button>
        <br><br>
        <small style="color: #2e7d32;">Η εκτυπωμένη έκδοση αυτής της σελίδας αποτελεί επίσημη εγγύηση ακουστικού βαρηκοΐας</small>
    </div>
</body>
</html>';
}
?>