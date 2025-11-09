<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chart extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_data($year, $table1, $table2, $field_group, $field_t1, $field_t2, $field_count, $data_name, $count_status, $status) {
        $query = $this->db->query('SELECT COUNT(' . $field_count . ') AS ' . $data_name . ' FROM ' . $table1 . ', ' . $table2 . ' WHERE ' . $field_t2 . ' = ' . $field_t1 . ' AND YEAR(' . $field_group . ')=' . $year . ' AND ' . $count_status . ' = ' . $status . ' GROUP BY MONTH(' . $field_group . ')');
        return $query->result();
    }

    function get_monthly_data($year, $selling_point, $status, $or_status, $ha_type = null, $custom_status = null) {
        $where = "YEAR(stocks.day_out) = $year AND (stocks.status = $status OR stocks.status = $or_status)";

        if ($selling_point !== 'selling_point') {
            $where .= " AND stocks.selling_point = $selling_point";
        }
        if ($ha_type) {
            $where .= " AND stocks.type = " . $this->db->escape($ha_type);
        }
        if ($custom_status) {
            $where .= " AND stocks.status = $custom_status";
        }

        $query = $this->db->query("SELECT IFNULL(COUNT(stocks.id), 0) AS data FROM stocks LEFT JOIN customers ON customers.id = stocks.customer_id WHERE $where GROUP BY MONTH(stocks.day_out)");
        return $query->result();
    }

    function get_monthly_nosale($year, $selling_point, $status, $ha_type = null, $custom_status = null) {
        $where = "YEAR(customers.first_visit) = $year AND customers.status = $status";

        if ($selling_point !== 'selling_point') {
            $where .= " AND customers.selling_point = $selling_point";
        }

        $query = $this->db->query("SELECT COUNT(customers.id) AS data FROM customers WHERE $where GROUP BY MONTH(customers.first_visit)");
        return $query->result();
    }

    function get_doctor_data($year = null, $selling_point = null) {
        $this->db->select('doctors.doc_name AS name, COUNT(customers.id) AS data');
        $this->db->from('doctors');
        $this->db->join('customers', 'customers.doctor = doctors.id', 'left');

        if (!is_null($year)) {
            $this->db->where('YEAR(customers.first_visit)', $year);
        }
        if (!is_null($selling_point) && $selling_point !== 'selling_point') {
            $this->db->where('customers.selling_point', $selling_point);
        }

        $this->db->group_by('doctors.doc_name');
        $query = $this->db->get();
        return $query->result();
    }

    function get_manufacturer_data($year = null, $selling_point = null) {
        $this->db->select('manufacturers.name AS name, COUNT(stocks.serial) AS data');
        $this->db->from('stocks');
        $this->db->join('manufacturers', 'stocks.manufacturer = manufacturers.id');

        if (!is_null($year)) {
            $this->db->where('YEAR(stocks.day_out)', $year);
        }
        if (!is_null($selling_point) && $selling_point !== 'selling_point') {
            $this->db->where('stocks.selling_point', $selling_point);
        }

        $this->db->group_by('manufacturers.name');
        $query = $this->db->get();
        return $query->result();
    }



    function get_vendor_data($year, $selling_point = null) {
        $this->db->select('vendors.name AS name, COUNT(stocks.serial) AS data');
        $this->db->from('stocks');
        $this->db->join('vendors', 'stocks.vendor = vendors.id');

        $this->db->where('YEAR(stocks.day_out)', $year);

        if (!is_null($selling_point) && $selling_point !== 'selling_point') {
            $this->db->where('stocks.selling_point', $selling_point);
        }

        $this->db->group_by('vendors.name');
        return $this->db->get()->result();
    }
   
    
    function get_manufacturer_statistics($year) {
        
        $query = $this->db->query('SELECT manufacturers.name AS brand, '
                . 'COUNT(stocks.serial) AS data FROM stocks, manufacturers '
                . 'WHERE stocks.manufacturer = manufacturers.id '
                . 'AND YEAR(stocks.day_out)=' . $year . ' '
                . 'GROUP BY manufacturers.name '
                . 'ORDER BY `data` desc');
        
        return $query->result_array();
    }
    
    function get_vendor_stats($year, $vendor, $month){
        $query = $this->db->query('SELECT COUNT(stocks.id) AS data '
                . 'FROM stocks '
                . 'WHERE vendor = ' . $vendor . ' '
                . 'AND YEAR(day_in) = ' . $year . ' '
                . 'AND MONTH(day_in) =' . $month );
        
        return $query->result();
    }
    
    function get_vendor_stats_year($vendor, $year){
        $query = $this->db->query('SELECT COUNT(stocks.id) AS data '
                . 'FROM stocks '
                . 'WHERE vendor = ' . $vendor . ' '
                . 'AND status <> 5 ' 
                . 'AND YEAR(day_in) = ' . $year);
        
        return $query->result();
    }
    
    public function get_stocks_by_vendor($vendor_id, $year, $month, $selling_point_id, $status_id) {
        $this->db->select('*');
        $this->db->from('stocks');
        $this->db->where('vendor', $vendor_id);
        $this->db->where('YEAR(day_in)', $year);
        $this->db->where('MONTH(day_in)', $month);
        $this->db->where('selling_point', $selling_point_id);
        $this->db->where('status', $status_id);
        $query = $this->db->get();
        
        return $query->result();  // Επιστρέφει τα αποτελέσματα ως πίνακα αντικειμένων
        //
        
        
    }

    
    function get_doc_stats($year, $doc_id, $status)
    {
        $query = $this->db->query('SELECT * '
                . 'FROM customers '
                . 'WHERE customers.doctor =' .$doc_id . ' '
                . 'AND YEAR(customers.first_visit)=' . $year . ' '
                . 'AND customers.status = ' . $status );
                
        return $query->result();
    }
    
        function get_doc_month_stats($year, $doc_id, $month)
    {
        $query = $this->db->query('SELECT COUNT(customers.id) AS data '
                . 'FROM customers '
                . 'WHERE customers.doctor =' .$doc_id . ' '
                . 'AND YEAR(customers.first_visit)=' . $year . ' '
                . 'AND MONTH(customers.first_visit) = ' . $month );

        return $query->result();
    }
    
    function get_ha_type_stats($year, $selling_point, $type)
    {
        $query = $this->db->query('SELECT COUNT(stocks.id) AS data '
                . 'FROM stocks '
                . 'WHERE YEAR(stocks.day_out) =' .$year . ' '
                . 'AND stocks.selling_point =' . $selling_point . ' '
                . 'AND stocks.type = ' . $type );
        
        return $query->result();
    }

//chart-data-for-earlabs-moulds and shells-------------------------------------

    function get_earlab_data($year) {
        $query = $this->db->query('SELECT lab_types.type AS name, COUNT(earlabs.id) '
                . 'AS data FROM earlabs, lab_types '
                . 'WHERE earlabs.type = lab_types.id '
                . 'AND YEAR(earlabs.date_order)=' . $year . ' '
                . 'GROUP BY lab_types.type');

        return $query->result();
    }

    function get_earlab_data_client($year) {
        $query = $this->db->query('SELECT lab_statuses.status AS name, COUNT(earlabs.id) '
                . 'AS data FROM earlabs, lab_statuses '
                . 'WHERE earlabs.status = lab_statuses.id '
                . 'AND YEAR(earlabs.date_order)=' . $year . ' '
                . 'GROUP BY lab_statuses.status');

        return $query->result();
    }

    function get_earlab_data_pha($year) {
        $query = $this->db->query('SELECT lab_types.type AS name, COUNT(earlabs.id) '
                . 'AS data FROM earlabs, lab_types '
                . 'WHERE earlabs.type = lab_types.id '
                . 'AND YEAR(earlabs.date_order)=' . $year . ' '
                . 'AND earlabs.status = 1 '
                . 'GROUP BY lab_types.type');

        return $query->result();
    }
    
//endof chart data for earlabs mould and shells---------------------------------
//chart data for debt-----------------------------------------------------------

    public function get_debt_data($year, $status, $selling_point) {

            $query = $this->db->query('SELECT '
                    . 'IFNULL(SUM(stocks.debt),0) AS data '
                    . 'FROM stocks, customers '
                    . 'WHERE YEAR(stocks.day_out)=' . $year . ' '
                    . 'AND stocks.`status` =' . $status . ' '
                    . 'AND customers.selling_point=' . $selling_point . ' '
                    . 'GROUP BY MONTH(stocks.day_out)');        
   
        return $query->result();
    }
    
    public function get_debt_sum($year){
        
        $query = $this->db->query('SELECT '
                . 'IFNULL(SUM(stocks.debt),0) AS data '
                . 'FROM stocks '
                . 'WHERE YEAR(stocks.day_out) = '. $year); 
        
        return $query->result();        
    }
    
    public function get_debt_avg($year, $selling_point){
        
    $query = $this->db->query('SELECT avg(stocks.ha_price) AS mprice '
                . 'FROM stocks '
                . 'WHERE YEAR(stocks.day_out)=' . $year . ' '
                . 'AND stocks.selling_point=' . $selling_point . ' '
                . 'AND stocks.status = 4 '
                . 'OR stocks.status = 3'); 
 
 
    return $query->result();        
    }
    
    public function get_debt_eopyy(){
        
        $query = $this->db->query('SELECT IFNULL(SUM(stocks.eopyy),0) AS data FROM stocks WHERE stocks.status = 4 '); 

        return $query->result();        
    }    

    public function get_pays_eopyy(){
        
        $query = $this->db->query('SELECT IFNULL(SUM(eopyy_pays.price),0) AS data FROM eopyy_pays'); 
        
        return $query->result();        
    }
    
    public function get_pays_data($year, $status, $selling_point) {
        $query = $this->db->query('SELECT COUNT(stocks.id) AS name, '
                . 'ROUND(SUM(stocks.balance),2) AS data '
                . 'FROM stocks, customers '
                . 'WHERE stocks.balance IS NOT NULL '
                . 'AND YEAR(stocks.day_out)=' . $year . ' '
                . 'AND stocks.status=' . $status . ' '
                . 'AND customers.selling_point =' . $selling_point . ' '
                . 'GROUP BY MONTH(stocks.day_out)');        
        return $query->result();
    }
    
    public function get_pays_monthly_stats($month)
    {
        $query = $this->db->query('SELECT SUM(pays.pay) AS data '
                . 'FROM pays '
                . 'WHERE MONTH(pays.date) = ' . $month);
        
        return $query->result();
    }
        
    public function get_eopyy_data($year, $status, $eopyy_pay) {
        $query = $this->db->query('SELECT COUNT(stocks.id) AS name, '
                . 'ROUND(SUM(stocks.eopyy),2) AS data '
                . 'FROM stocks, customers '
                . 'WHERE stocks.eopyy IS NOT NULL '
                . 'AND YEAR(stocks.day_out)=' . $year . ' '
                . 'AND stocks.status=' . $status . ' '
                . 'AND customers.selling_point = 1 '
                . 'AND stocks.eopyy_pay = ' . $eopyy_pay . ' '
                . 'GROUP BY MONTH(stocks.day_out)');
        
        return $query->result();        
    }
    
    public function get_old_debt(){
        $query = $this->db->query('SELECT SUM(stocks.debt) AS debt '
                . 'FROM stocks '
                . 'WHERE YEAR(stocks.day_out) = 2016 '
                . 'OR YEAR(stocks.day_out) = 2015 '
                . 'OR YEAR(stocks.day_out)=2014');
        
        return $query->result();
    }
//endof chart data for debt-----------------------------------------------------    

    function clean_column($series_data) {

        $series_data = str_replace('"', '', $series_data);
        $series_data = str_replace('{', '', $series_data);
        $series_data = str_replace('}', '', $series_data);
        $series_data = str_replace('data', '', $series_data);
        $series_data = str_replace('month', '', $series_data);
        $series_data = str_replace('name', '', $series_data);
        $series_data = str_replace('manufacturer', '', $series_data);
        $series_data = str_replace('.', '.', $series_data);
        $series_data = str_replace(':', '', $series_data);
        $series_data = str_replace('[[', '[', $series_data);
        $series_data = str_replace(']]', ']', $series_data);
        $series_data = str_replace(',', ', ', $series_data);
        $series_data = str_replace('.00', '', $series_data);
        $series_data = str_replace('], [', ', ', $series_data);         

        return $series_data;
    }

    function clean_column_dash($series_data) {

        $series_data = str_replace("\ ", '', $series_data);
        $series_data = str_replace('"', '', $series_data);
        $series_data = str_replace('{', '{"', $series_data);
        $series_data = str_replace(':', '":', $series_data);
/*        $series_data = str_replace('month', '', $series_data);
        $series_data = str_replace('name', '', $series_data);
        $series_data = str_replace('manufacturer', '', $series_data);
        $series_data = str_replace('.', '.', $series_data);
        $series_data = str_replace(':', '', $series_data);
        $series_data = str_replace('[[', '[', $series_data);
        $series_data = str_replace(']]', ']', $series_data);
        $series_data = str_replace(',', ', ', $series_data);
        $series_data = str_replace('.00', '', $series_data);
*/
        return $series_data;
    }

    function clean_pie($series_data) {
        // PHP 8.2+ compatibility: utf8_encode() is deprecated
        $series_data = str_replace('{"name":"', "{name: '", $series_data);
        $series_data = str_replace('","data":"', "', data: ", $series_data);
        $series_data = str_replace('"}', "}", $series_data);
        $series_data = str_replace('data', 'y', $series_data);

        return $series_data;
    }
    
    function clean_debt($series_data) {
        // PHP 8.2+ compatibility: utf8_encode() is deprecated
        $series_data = str_replace('"', "'", $series_data);
        //$series_data = str_replace('{', "", $series_data);
        //$series_data = str_replace('}', "", $series_data);
        $series_data = str_replace('"', '', $series_data);

        return $series_data;
    }    

    function clean_chart($series_data) {
        /*
          $series_data = str_replace('"', '', $series_data);
          $series_data = str_replace('sales', 'sales :' , $series_data);
          $series_data = str_replace('nosales', 'nosales :', $series_data);
          $series_data = str_replace('manufacturer', '', $series_data);
          $series_data = str_replace('.', '', $series_data);
          $series_data = str_replace(':', '', $series_data);
          $series_data = str_replace('[[', '[', $series_data);
          $series_data = str_replace(']]', ']', $series_data);
          $series_data = str_replace(',', ', ', $series_data);


          //$series_data = str_replace('{', '', $series_data);
          //$series_data = str_replace('}', '', $series_data);
          $series_data = str_replace('"', '', $series_data);
          $series_data = str_replace('\"', '', $series_data);
          $series_data = str_replace(':sales:', ' sales:' , $series_data);
          $series_data = str_replace(':year:', ' year:' , $series_data);
          $series_data = str_replace(':{', ':', $series_data);
          $series_data = str_replace('},', ',', $series_data);
          $series_data = str_replace('{', '[', $series_data);
          $series_data = str_replace('}}', ']', $series_data);
         */
        $series_data = str_replace("\"year\"", '{year', $series_data);
        $series_data = str_replace("\"sales\"", 'sales', $series_data);
        $series_data = str_replace("\"nosales\"", 'nosales', $series_data);
        $series_data = str_replace("{{", '{', $series_data);
        $series_data = str_replace('"', '', $series_data);
        

        return $series_data;
    }
    
    function print_doc($html, $title)
    {       
        // Try to load Composer autoloader for mPDF 8.x with enhanced error handling
        $composerLoaded = false;
        if (file_exists(FCPATH . 'vendor/autoload.php')) {
            try {
                // Suppress all warnings and errors during autoloader include
                $oldErrorReporting = error_reporting(0);
                
                ob_start(); // Capture any output
                include_once FCPATH . 'vendor/autoload.php';
                ob_end_clean(); // Discard captured output
                
                error_reporting($oldErrorReporting);
                
                // Test if mPDF class is actually available
                if (class_exists('\\Mpdf\\Mpdf')) {
                    $composerLoaded = true;
                } else {
                    $composerLoaded = false;
                }
                
            } catch (Exception $e) {
                // Log error but continue with fallback
                log_message('error', 'Composer autoloader failed: ' . $e->getMessage());
                $composerLoaded = false;
            } catch (Error $e) {
                // Handle PHP 7+ errors
                log_message('error', 'Composer autoloader error: ' . $e->getMessage());
                $composerLoaded = false;
            } catch (Throwable $e) {
                // Handle PHP 8+ throwables
                log_message('error', 'Composer autoloader throwable: ' . $e->getMessage());
                $composerLoaded = false;
            } finally {
                // Always restore error reporting
                if (isset($oldErrorReporting)) {
                    error_reporting($oldErrorReporting);
                }
            }
        }
        
        // Check which mPDF version is available
        if ($composerLoaded && class_exists('\\Mpdf\\Mpdf')) {
            // mPDF 8.x (new version from vendor)
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10
            ]);
        } else {
            // mPDF 6.0 (old version from third_party)
            $legacy_mpdf_path = APPPATH . '/third_party/mpdf/mpdf.php';
            
            if (file_exists($legacy_mpdf_path)) {
                try {
                    // Suppress errors for PHP 8.2+ compatibility issues
                    $oldErrorReporting = error_reporting(0);
                    ob_start();
                    
                    include_once $legacy_mpdf_path;
                    
                    ob_end_clean();
                    error_reporting($oldErrorReporting);
                    
                    if (class_exists('mPDF')) {
                        $mpdf = new mPDF('utf-8', 'A4', '', '', 10, 10, 10, 10, 6, 3);
                    } else {
                        // Last resort: show error message
                        show_error('PDF export is not available. mPDF class not found. Please contact administrator.');
                        return;
                    }
                } catch (Throwable $e) {
                    error_reporting($oldErrorReporting);
                    log_message('error', 'Legacy mPDF failed (PHP compatibility issue): ' . $e->getMessage());
                    show_error('PDF export is not available. Legacy mPDF is incompatible with current PHP version. Please upgrade to mPDF 8.x.');
                    return;
                }
            } else {
                // No PDF library available
                show_error('PDF export is not available. No mPDF library found. Please contact administrator.');
                return;
            }
        }
        
        // Verify $mpdf object was created successfully
        if (!isset($mpdf) || !is_object($mpdf)) {
            show_error('PDF generation failed. Please contact administrator.');
            return;
        }
        
        try {
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle($title);
            $mpdf->SetAuthor("Pikasis Hearing Aids.");
            $mpdf->SetWatermarkText("Pikasis Hearing");
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');
            
            $mpdf->WriteHTML($html, 2);
            
            $mpdf->Output();
            
        } catch (Exception $e) {
            log_message('error', 'PDF generation error: ' . $e->getMessage());
            show_error('PDF generation failed: ' . $e->getMessage());
        } catch (Error $e) {
            log_message('error', 'PDF generation PHP error: ' . $e->getMessage());
            show_error('PDF generation failed. Please contact administrator.');
        }
    }

//end_of Model
}
