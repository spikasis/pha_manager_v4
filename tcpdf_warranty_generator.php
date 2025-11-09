<?php
/**
 * 🚨 TCPDF Alternative Solution for Warranty PDF Generation
 * PHP 8.2.29 Compatible - Emergency Hotfix
 */

// Get stock ID from URL parameter
$stock_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($stock_id <= 0) {
    die('❌ Invalid stock ID. Usage: tcpdf_warranty_generator.php?id=STOCK_ID');
}

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>TCPDF Warranty Generator</title>";
echo "<style>body{font-family:Arial;margin:20px;} .success{color:green;} .error{color:red;}</style></head><body>";

echo "<h1>🔧 TCPDF Warranty PDF Generator (PHP 8.2 Compatible)</h1>";
echo "<p>Processing Stock ID: <strong>{$stock_id}</strong></p>";

try {
    // Load dependencies
    require_once __DIR__ . '/vendor/autoload.php';
    
    // Database connection
    $config_file = __DIR__ . '/application/config/database.php';
    if (!file_exists($config_file)) {
        throw new Exception("Database config not found: {$config_file}");
    }
    
    define('BASEPATH', '');
    define('ENVIRONMENT', 'production');
    include $config_file;
    
    echo "<div class='success'>✅ Configuration loaded</div>";
    
    // Connect to database
    $mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }
    $mysqli->set_charset('utf8');
    
    echo "<div class='success'>✅ Database connected</div>";
    
    // Get warranty data with joined query
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
    
    // Initialize TCPDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator('PHA Manager V4 - TCPDF');
    $pdf->SetAuthor('Pikasis Hearing Aids');
    $pdf->SetTitle('Εγγύηση Ακουστικού - ' . $data['serial']);
    $pdf->SetSubject('Warranty Document');
    
    // Set margins
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetAutoPageBreak(TRUE, 20);
    
    // Add a page
    $pdf->AddPage();
    
    // Set font for Greek text
    $pdf->SetFont('freeserif', '', 12);
    
    echo "<div class='success'>✅ TCPDF initialized with Greek font support</div>";
    
    // Generate warranty content
    $html = '
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
    
    // Write HTML to PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    
    echo "<div class='success'>✅ PDF content generated successfully</div>";
    
    // Check if download requested
    if (isset($_GET['download'])) {
        $filename = 'Warranty_TCPDF_' . $data['serial'] . '_' . date('Y-m-d') . '.pdf';
        $pdf->Output($filename, 'D'); // Force download
        exit;
    }
    
    // Save to file for testing
    $filename = 'tcpdf_warranty_test_' . date('Y-m-d_H-i-s') . '.pdf';
    $pdf->Output(__DIR__ . '/' . $filename, 'F');
    
    echo "<div class='success'>✅ PDF saved as: {$filename}</div>";
    echo "<div style='margin-top: 20px;'>";
    echo "<p><strong>✅ SUCCESS!</strong> TCPDF warranty generated successfully with PHP 8.2.29</p>";
    echo "<p><a href='tcpdf_warranty_generator.php?id={$stock_id}&download=1' style='background:#007cba;color:white;padding:10px;text-decoration:none;border-radius:5px;'>📄 Download PDF</a></p>";
    echo "<p><a href='javascript:history.back()' style='background:#6c757d;color:white;padding:10px;text-decoration:none;border-radius:5px;'>← Go Back</a></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p><strong>TCPDF Generation Failed</strong></p>";
    echo "<p><a href='javascript:history.back()'>← Go Back</a></p>";
} catch (Error $e) {
    echo "<div class='error'>❌ PHP ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p><strong>TCPDF Generation Failed</strong></p>";
    echo "<p><a href='javascript:history.back()'>← Go Back</a></p>";
}

echo "</body></html>";
?>