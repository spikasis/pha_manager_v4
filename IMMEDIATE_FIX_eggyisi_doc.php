<?php
/**
 * IMMEDIATE FIX - Replace this in Stocks controller
 * Copy this method over the existing eggyisi_doc method
 */

public function eggyisi_doc($id) {
    try {
        // Enhanced error handling with detailed logging
        log_message('info', 'eggyisi_doc called for ID: ' . $id);
        
        // Get stock with error checking
        $stock = $this->stock->get($id);
        if (!$stock) {
            log_message('error', 'Stock not found for ID: ' . $id);
            show_error('Δεν βρέθηκε το ακουστικό με ID: ' . $id);
            return;
        }
        
        // Get customer with error checking  
        if (empty($stock->customer_id)) {
            log_message('error', 'Stock has no customer_id: ' . $id);
            show_error('Το ακουστικό δεν έχει συνδεδεμένο πελάτη.');
            return;
        }
        
        $customers = $this->customer->get($stock->customer_id);
        if (!$customers) {
            log_message('error', 'Customer not found for ID: ' . $stock->customer_id);
            show_error('Δεν βρέθηκε ο πελάτης με ID: ' . $stock->customer_id);
            return;
        }
        
        // Get company
        $companies = $this->company->get(1);
        if (!$companies) {
            log_message('error', 'Company not found with ID: 1');
            show_error('Δεν βρέθηκαν στοιχεία εταιρείας.');
            return;
        }
        
        // Get model with error checking
        if (empty($stock->ha_model)) {
            log_message('error', 'Stock has no ha_model: ' . $id);
            show_error('Το ακουστικό δεν έχει συνδεδεμένο μοντέλο.');
            return;
        }
        
        $ha_model = $this->model->get($stock->ha_model);
        if (!$ha_model) {
            log_message('error', 'Model not found for ID: ' . $stock->ha_model);
            show_error('Δεν βρέθηκε το μοντέλο με ID: ' . $stock->ha_model);
            return;
        }
        
        // Get series with error checking
        if (empty($ha_model->series)) {
            log_message('error', 'Model has no series: ' . $stock->ha_model);
            show_error('Το μοντέλο δεν έχει συνδεδεμένη σειρά.');
            return;
        }
        
        $ha_series = $this->serie->get($ha_model->series);
        if (!$ha_series) {
            log_message('error', 'Series not found for ID: ' . $ha_model->series);
            show_error('Δεν βρέθηκε η σειρά με ID: ' . $ha_model->series);
            return;
        }
        
        // Get manufacturer with error checking
        if (empty($ha_series->brand)) {
            log_message('error', 'Series has no brand: ' . $ha_model->series);
            show_error('Η σειρά δεν έχει συνδεδεμένο κατασκευαστή.');
            return;
        }
        
        $manufacturers = $this->manufacturer->get($ha_series->brand);
        if (!$manufacturers) {
            log_message('error', 'Manufacturer not found for ID: ' . $ha_series->brand);
            show_error('Δεν βρέθηκε ο κατασκευαστής με ID: ' . $ha_series->brand);
            return;
        }
        
        // Get type with error checking
        if (empty($ha_model->ha_type)) {
            log_message('error', 'Model has no ha_type: ' . $stock->ha_model);
            show_error('Το μοντέλο δεν έχει συνδεδεμένο τύπο.');
            return;
        }
        
        $ha_type = $this->ha_type->get($ha_model->ha_type);
        if (!$ha_type) {
            log_message('error', 'Type not found for ID: ' . $ha_model->ha_type);
            show_error('Δεν βρέθηκε ο τύπος με ID: ' . $ha_model->ha_type);
            return;
        }
        
        // Prepare data array
        $data = array(
            'company' => $companies,
            'stock' => $stock,
            'manufacturer' => $manufacturers,
            'customer' => $customers,
            'ha_model' => $ha_model,
            'ha_series' => $ha_series,
            'type' => $ha_type
        );
        
        log_message('info', 'All data prepared successfully for eggyisi_doc ID: ' . $id);
        
        // Load view with error handling
        try {
            $html = $this->load->view('eggyisi_doc_final', $data, true);
            
            if (empty($html)) {
                log_message('error', 'View returned empty HTML for eggyisi_doc ID: ' . $id);
                show_error('Η φόρτωση του template εγγύησης απέτυχε.');
                return;
            }
            
            log_message('info', 'View loaded successfully, HTML length: ' . strlen($html));
            
        } catch (Exception $e) {
            log_message('error', 'View loading failed for eggyisi_doc: ' . $e->getMessage());
            show_error('Σφάλμα στη φόρτωση του template: ' . $e->getMessage());
            return;
        }
        
        // Generate PDF with error handling
        try {
            $title = 'Εγγύηση Ακουστικού Βαρηκοΐας - ' . $stock->serial;
            
            // Check if chart model is available
            if (!isset($this->chart)) {
                log_message('error', 'Chart model not loaded in eggyisi_doc');
                show_error('Η βιβλιοθήκη PDF δεν είναι διαθέσιμη. Επικοινωνήστε με τον διαχειριστή.');
                return;
            }
            
            log_message('info', 'Calling print_doc for eggyisi_doc ID: ' . $id);
            $this->chart->print_doc($html, $title);
            
        } catch (Exception $e) {
            log_message('error', 'PDF generation failed for eggyisi_doc: ' . $e->getMessage());
            show_error('Η δημιουργία του PDF απέτυχε: ' . $e->getMessage() . '<br>Παρακαλώ επικοινωνήστε με τον διαχειριστή.');
        } catch (Error $e) {
            log_message('error', 'PDF generation PHP error for eggyisi_doc: ' . $e->getMessage());
            show_error('Σφάλμα στη δημιουργία PDF. Παρακαλώ επικοινωνήστε με τον διαχειριστή.');
        }
        
    } catch (Exception $e) {
        log_message('error', 'General error in eggyisi_doc: ' . $e->getMessage());
        show_error('Γενικό σφάλμα: ' . $e->getMessage() . '<br>Παρακαλώ επικοινωνήστε με τον διαχειριστή.');
    } catch (Error $e) {
        log_message('error', 'PHP Error in eggyisi_doc: ' . $e->getMessage());
        show_error('Σφάλμα PHP. Παρακαλώ επικοινωνήστε με τον διαχειριστή.');
    }
}
?>