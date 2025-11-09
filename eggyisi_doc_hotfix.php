<?php
/**
 * EMERGENCY HOTFIX - Upload this file as eggyisi_doc_hotfix.php
 * Then change the URL call to use this instead
 */

// Emergency hotfix for eggyisi_doc crashes
// Call this via: /admin/stocks/eggyisi_doc_hotfix/2443

if (!defined('BASEPATH')) {
    // Quick CI integration
    require_once '../../../index.php';
}

class Emergency_PDF_Fix {
    
    public function generate_eggyisi_pdf($stock_id) {
        
        echo "<h1>🔧 Emergency PDF Fix - Stock ID: {$stock_id}</h1>";
        echo "<p>Bypassing broken eggyisi_doc method...</p>";
        
        try {
            // Direct database connection (bypass models if needed)
            $CI = &get_instance();
            
            // Test database connection
            $query = $CI->db->query("SELECT 1 as test");
            if (!$query) {
                throw new Exception("Database connection failed");
            }
            echo "✅ Database connection OK<br>";
            
            // Get stock data directly
            $stock_query = $CI->db->query("SELECT * FROM stocks WHERE id = ?", array($stock_id));
            $stock = $stock_query->row();
            
            if (!$stock) {
                echo "❌ <strong>Σφάλμα:</strong> Δεν βρέθηκε ακουστικό με ID: {$stock_id}<br>";
                echo "<p><a href='javascript:history.back()'>← Επιστροφή</a></p>";
                return;
            }
            
            echo "✅ Stock found: Serial = {$stock->serial}<br>";
            
            // Get customer data
            if (empty($stock->customer_id)) {
                echo "❌ <strong>Σφάλμα:</strong> Το ακουστικό δεν έχει συνδεδεμένο πελάτη<br>";
                echo "<p><a href='javascript:history.back()'>← Επιστροφή</a></p>";
                return;
            }
            
            $customer_query = $CI->db->query("SELECT * FROM customers WHERE id = ?", array($stock->customer_id));
            $customer = $customer_query->row();
            
            if (!$customer) {
                echo "❌ <strong>Σφάλμα:</strong> Δεν βρέθηκε πελάτης με ID: {$stock->customer_id}<br>";
                echo "<p><a href='javascript:history.back()'>← Επιστροφή</a></p>";
                return;
            }
            
            echo "✅ Customer found: {$customer->name}<br>";
            
            // Check if we have minimum required data for PDF
            $required_fields = array('serial', 'day_out');
            $missing_fields = array();
            
            foreach ($required_fields as $field) {
                if (empty($stock->$field)) {
                    $missing_fields[] = $field;
                }
            }
            
            if (!empty($missing_fields)) {
                echo "❌ <strong>Σφάλμα:</strong> Λείπουν απαραίτητα στοιχεία: " . implode(', ', $missing_fields) . "<br>";
                echo "<p><a href='javascript:history.back()'>← Επιστροφή</a></p>";
                return;
            }
            
            // Try to get related data (non-critical)
            $ha_model = null;
            $ha_series = null;
            $manufacturer = null;
            $ha_type = null;
            
            if (!empty($stock->ha_model)) {
                $model_query = $CI->db->query("SELECT * FROM models WHERE id = ?", array($stock->ha_model));
                $ha_model = $model_query->row();
                
                if ($ha_model && !empty($ha_model->series)) {
                    $series_query = $CI->db->query("SELECT * FROM series WHERE id = ?", array($ha_model->series));
                    $ha_series = $series_query->row();
                    
                    if ($ha_series && !empty($ha_series->brand)) {
                        $manufacturer_query = $CI->db->query("SELECT * FROM manufacturers WHERE id = ?", array($ha_series->brand));
                        $manufacturer = $manufacturer_query->row();
                    }
                }
                
                if ($ha_model && !empty($ha_model->ha_type)) {
                    $type_query = $CI->db->query("SELECT * FROM ha_types WHERE id = ?", array($ha_model->ha_type));
                    $ha_type = $type_query->row();
                }
            }
            
            // Get company data
            $company_query = $CI->db->query("SELECT * FROM companies WHERE id = 1");
            $company = $company_query->row();
            
            echo "<h2>📄 Generating Simple PDF...</h2>";
            
            // Generate simple HTML for PDF (no complex template)
            $html = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>Εγγύηση Ακουστικού</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; }
                    .content { margin: 30px 0; }
                    .field { margin: 10px 0; }
                    .label { font-weight: bold; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <h1>ΕΓΓΥΗΣΗ ΚΑΛΗΣ ΛΕΙΤΟΥΡΓΙΑΣ</h1>
                    <p>ΠΙΚΑΣΗΣ ΑΚΟΥΣΤΙΚΑ ΒΑΡΗΚΟΙΑΣ</p>
                </div>
                
                <div class='content'>
                    <div class='field'>
                        <span class='label'>ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</span> {$customer->name}
                    </div>
                    <div class='field'>
                        <span class='label'>ΑΜΚΑ:</span> " . (isset($customer->amka) ? $customer->amka : 'Δεν έχει καταχωρηθεί') . "
                    </div>
                    <div class='field'>
                        <span class='label'>ΗΜΕΡΟΜΗΝΙΑ ΑΓΟΡΑΣ:</span> {$stock->day_out}
                    </div>
                    <div class='field'>
                        <span class='label'>ΙΣΧΥΣ ΕΓΓΥΗΣΗΣ:</span> " . (isset($stock->guarantee_end) ? $stock->guarantee_end : 'Δύο (2) έτη από την ημερομηνία αγοράς') . "
                    </div>
                    <div class='field'>
                        <span class='label'>ΚΑΤΑΣΚΕΥΑΣΤΙΚΟΣ ΟΙΚΟΣ:</span> " . ($manufacturer ? $manufacturer->name : 'Δεν έχει καταχωρηθεί') . "
                    </div>
                    <div class='field'>
                        <span class='label'>ΤΥΠΟΣ ΑΚΟΥΣΤΙΚΟΥ:</span> " . 
                        ($ha_series ? $ha_series->series : '') . 
                        ($ha_model ? ' - ' . $ha_model->model : '') . 
                        ($ha_type ? ' - ' . $ha_type->type : '') . "
                    </div>
                    <div class='field'>
                        <span class='label'>SERIAL NO:</span> {$stock->serial}
                    </div>
                    <div class='field'>
                        <span class='label'>BARCODE ΕΟΠΥΥ:</span> " . (isset($stock->ekapty_code) ? $stock->ekapty_code : 'Δεν έχει καταχωρηθεί') . "
                    </div>
                </div>
                
                <div class='content'>
                    <h3>ΟΡΟΙ ΕΓΓΥΗΣΗΣ</h3>
                    <p>Η συσκευή που προμηθευτήκατε αποτελεί ιατροτεχνολογικό προιόν και 
                    συνοδεύεται από εγγύηση καλής λειτουργίας δύο (2) ετών.</p>
                    
                    <p>Η εγγύηση δεν καλύπτει βλάβες που οφείλονται σε μη ορθή χρήση του προιόντος 
                    ή ελλειπή συντήρηση.</p>
                    
                    <p style='text-align: center; margin-top: 50px;'>
                        <strong>ΠΙΚΑΣΗΣ ΑΚΟΥΣΤΙΚΑ ΒΑΡΗΚΟΙΑΣ</strong><br>
                        Λιβαδειά, " . date('d/m/Y') . "
                    </p>
                </div>
            </body>
            </html>";
            
            // Try to generate PDF
            try {
                // Check if mPDF is available
                if (file_exists('../../../vendor/autoload.php')) {
                    require_once '../../../vendor/autoload.php';
                    if (class_exists('\\Mpdf\\Mpdf')) {
                        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
                        $mpdf->WriteHTML($html);
                        $mpdf->Output('Εγγύηση_' . $stock->serial . '.pdf', 'D');
                        exit;
                    }
                }
                
                // Fallback: Show HTML version
                echo "⚠️ PDF library not available. Showing HTML version:<br><br>";
                echo "<div style='border: 1px solid #ccc; padding: 20px; background: white;'>";
                echo $html;
                echo "</div>";
                echo "<p><strong>Οδηγίες:</strong> Μπορείτε να αποθηκεύσετε αυτή τη σελίδα ως PDF από τον browser (Ctrl+P → Save as PDF)</p>";
                
            } catch (Exception $e) {
                echo "❌ PDF generation failed: " . $e->getMessage() . "<br>";
                echo "📄 Showing HTML version instead:<br><br>";
                echo $html;
            }
            
        } catch (Exception $e) {
            echo "❌ <strong>Σφάλμα:</strong> " . $e->getMessage() . "<br>";
            echo "<p>Παρακαλώ επικοινωνήστε με τον διαχειριστή του συστήματος.</p>";
            echo "<p><a href='javascript:history.back()'>← Επιστροφή</a></p>";
        }
    }
}

// Auto-execute if called directly
if (isset($_GET['id']) || (isset($GLOBALS['argv']) && count($GLOBALS['argv']) > 1)) {
    $stock_id = isset($_GET['id']) ? $_GET['id'] : (isset($GLOBALS['argv'][1]) ? $GLOBALS['argv'][1] : null);
    
    if ($stock_id) {
        $fix = new Emergency_PDF_Fix();
        $fix->generate_eggyisi_pdf($stock_id);
    } else {
        echo "Usage: eggyisi_doc_hotfix.php?id=STOCK_ID";
    }
}
?>