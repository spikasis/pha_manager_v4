<?php
/**
 * 🚨 EMERGENCY WARRANTY PDF HOTFIX 🚨
 * Direct access: https://manager.pikasishearing.gr/warranty_hotfix.php?id=2443
 * NO FRAMEWORK DEPENDENCIES - Pure PHP
 */

// Get stock ID from URL
$stock_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($stock_id <= 0) {
    die('❌ Invalid stock ID. Usage: warranty_hotfix.php?id=STOCK_ID');
}

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Emergency Warranty Generator</title>";
echo "<style>body{font-family:Arial;margin:20px;} .success{color:green;} .error{color:red;}</style></head><body>";

echo "<h1>🔧 Emergency Warranty PDF Generator</h1>";
echo "<p>Processing Stock ID: <strong>{$stock_id}</strong></p>";

try {
    // Database connection - using the same config as CI
    $config_file = __DIR__ . '/application/config/database.php';
    if (!file_exists($config_file)) {
        throw new Exception("Database config file not found: {$config_file}");
    }
    
    // Load CI database config
    include $config_file;
    
    $host = $db['default']['hostname'];
    $user = $db['default']['username'];
    $pass = $db['default']['password'];
    $dbname = $db['default']['database'];
    
    echo "<div class='success'>✅ Database config loaded</div>";
    
    // Connect to database
    $mysqli = new mysqli($host, $user, $pass, $dbname);
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }
    
    $mysqli->set_charset('utf8');
    echo "<div class='success'>✅ Database connected</div>";
    
    // Get all data in one query (join everything)
    $sql = "
        SELECT 
            s.*, 
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
        throw new Exception("Query prepare failed: " . $mysqli->error);
    }
    
    $stmt->bind_param('i', $stock_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        throw new Exception("Stock ID {$stock_id} not found in database");
    }
    
    echo "<div class='success'>✅ All data retrieved successfully</div>";
    
    // Check mPDF availability
    $vendor_path = __DIR__ . '/vendor/autoload.php';
    if (file_exists($vendor_path)) {
        require_once $vendor_path;
        if (class_exists('\\Mpdf\\Mpdf')) {
            echo "<div class='success'>✅ mPDF 8.x available</div>";
            
            // Generate PDF
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10
            ]);
            
            // Simple HTML content for warranty
            $html = '
            <div style="width: 100%; font-family: Arial;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1>ΕΓΓΥΗΣΗ ΚΑΛΗΣ ΛΕΙΤΟΥΡΓΙΑΣ</h1>
                </div>
                
                <table style="width: 100%; border-collapse: collapse;" border="1">
                    <tr><td style="padding: 8px;"><strong>ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</strong></td><td style="padding: 8px;">' . htmlspecialchars($data['customer_name'] ?? 'N/A') . '</td></tr>
                    <tr><td style="padding: 8px;"><strong>ΑΜΚΑ:</strong></td><td style="padding: 8px;">' . htmlspecialchars($data['customer_amka'] ?? 'N/A') . '</td></tr>
                    <tr><td style="padding: 8px;"><strong>ΗΜΕΡΟΜΗΝΙΑ ΑΓΟΡΑΣ:</strong></td><td style="padding: 8px;">' . htmlspecialchars($data['day_out'] ?? 'N/A') . '</td></tr>
                    <tr><td style="padding: 8px;"><strong>ΙΣΧΥΣ ΕΓΓΥΗΣΗΣ:</strong></td><td style="padding: 8px;">' . htmlspecialchars($data['guarantee_end'] ?? 'N/A') . '</td></tr>
                    <tr><td style="padding: 8px;"><strong>ΚΑΤΑΣΚΕΥΑΣΤΙΚΟΣ ΟΙΚΟΣ:</strong></td><td style="padding: 8px;">' . htmlspecialchars($data['manufacturer_name'] ?? 'N/A') . '</td></tr>
                    <tr><td style="padding: 8px;"><strong>ΤΥΠΟΣ ΑΚΟΥΣΤΙΚΟΥ:</strong></td><td style="padding: 8px;">' . htmlspecialchars($data['series_name'] ?? 'N/A') . '-' . htmlspecialchars($data['model_name'] ?? 'N/A') . ' - ' . htmlspecialchars($data['ha_type_name'] ?? 'N/A') . '</td></tr>
                    <tr><td style="padding: 8px;"><strong>SERIAL NO:</strong></td><td style="padding: 8px;">' . htmlspecialchars($data['serial'] ?? 'N/A') . '</td></tr>
                    <tr><td style="padding: 8px;"><strong>BARCODE ΕΟΠΥΥ:</strong></td><td style="padding: 8px;">' . htmlspecialchars($data['ekapty_code'] ?? 'N/A') . '</td></tr>
                    <tr><td style="padding: 8px;"><strong>ΑΡ. ΕΚΤΕΛΕΣΗΣ ΕΟΠΥΥ:</strong></td><td style="padding: 8px;">' . htmlspecialchars($data['ektelesi_eopyy'] ?? 'N/A') . '</td></tr>
                </table>
                
                <div style="margin-top: 30px;">
                    <p>Η συσκευή που προμηθευτήκατε αποτελεί ιατροτεχνολογικό προιόν, φέρει σήμανση <strong>CE</strong> και συνοδεύεται από εγγύηση καλής λειτουργίας δύο (2) ετών.</p>
                    
                    <p>Η επιχείρηση μας διαθέτει εξουσιοδοτημένο τμήμα τεχνικής υποστήριξης.</p>
                    
                    <p><strong>ΟΡΟΙ ΕΓΓΥΗΣΗΣ</strong></p>
                    <p>Η εγγύηση δεν καλύπτει βλάβες που οφείλονται σε μη ορθή χρήση του προιόντος ή ελλειπή συντήρηση όπως αναφέρεται από τον κατασκευαστή στο εγχειρίδιο χρήσης που συνοδεύει το προιόν. Η εγγύηση δεν ισχύει σε περίπτωση επισκευής ή επέμβασης στο προιόν από άτομα που δεν είναι εξουσιοδοτημένα από την επιχείρηση μας ή τον κατασκευαστικό οίκο.</p>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <p>Κωδικός Επιχείρησης Μητρώου ΕΚΑΠΤΥ: ' . htmlspecialchars($data['company_ekapty'] ?? 'N/A') . '</p>
                </div>
                
                <div style="text-align: right; margin-top: 50px;">
                    <p>Λιβαδειά ' . date('d-m-Y') . '</p>
                    <p><strong>Σπυρίδων Κ. Πικάσης</strong></p>
                    <p>Μηχανικός Βιοΐατρικής Τεχνολογίας</p>
                    <p>Ειδικός Ακοοπροθετιστής</p>
                </div>
            </div>';
            
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle('Εγγύηση Ακουστικού - ' . $data['serial']);
            $mpdf->SetAuthor("Pikasis Hearing Aids");
            $mpdf->WriteHTML($html);
            
            // Output PDF directly
            echo "<div class='success'>✅ PDF generated successfully - downloading...</div>";
            echo "<script>setTimeout(function(){ window.location = 'warranty_hotfix.php?id={$stock_id}&download=1'; }, 2000);</script>";
            
            if (isset($_GET['download'])) {
                $mpdf->Output('Warranty_' . $data['serial'] . '_' . date('Y-m-d') . '.pdf', 'D');
                exit;
            }
            
        } else {
            throw new Exception("mPDF class not available after autoloader");
        }
    } else {
        throw new Exception("Composer autoloader not found: {$vendor_path}");
    }
    
    echo "<div style='margin-top: 20px;'>";
    echo "<p><strong>✅ SUCCESS!</strong> Warranty PDF should be downloading.</p>";
    echo "<p><a href='javascript:history.back()'>← Go Back</a> | <a href='warranty_hotfix.php?id={$stock_id}&download=1'>Download Again</a></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p><a href='javascript:history.back()'>← Go Back</a></p>";
} catch (Error $e) {
    echo "<div class='error'>❌ PHP ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p><a href='javascript:history.back()'>← Go Back</a></p>";
}

echo "</body></html>";
?>