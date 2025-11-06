<?php

class Admin extends Admin_Controller {

    function __construct() {
        parent::__construct();        

        $this->load->model(array('admin/chart'));
        $this->load->model(array('admin/stock'));
        $this->load->model(array('admin/customer'));
        $this->load->model(array('admin/pay'));
        $this->load->model(array('admin/company'));
        $this->load->model(array('admin/selling_point'));
        $this->load->model(array('admin/eopyy_pay'));
        $this->load->model(array('admin/balance_view'));
        $this->load->model(array('admin/debt_view'));
        $this->load->model(array('admin/service'));    
        $this->load->model(array('admin/earlab'));
        $this->load->model(array('admin/task'));
   }

   
   
public function index() {
    global $year;
    global $year_now;
    global $current_user;

    $year = 2014;
    $year_now = date('Y');

    $user = $this->ion_auth->get_user_id();
    $group = $this->ion_auth->get_users_groups($user->id)->result();
    $data['group'] = $group;

    // ====================================
    // ΛΗΨΗ ΦΙΛΤΡΩΝ ΑΠΟ GET
    // ====================================
    $selected_year = $this->input->get('year') ?: $year_now;
    $selected_sp = $this->input->get('sp') ?: 'selling_point';
    $selected_type = $this->input->get('type') ?: null;
    $selected_status = $this->input->get('status') ?: null;

    switch ($group[0]->id) {
        // =================== ADMIN ===================
        case 1:
            $current_user = NULL;

            // === ΝΕΑ data_stats ===
            $data = $this->data_stats($selected_year, $year_now, $selected_sp, $selected_type, $selected_status);

            // === Προσθήκες για panels ===
            $data['stock_bc'] = $this->stock->get_all('id, serial, ha_model, day_in, vendor', 'ekapty_code=0 AND YEAR(day_in)>=2024');
            $data['on_hold'] = $this->task->get_filtered_tasks();
            $data['debt_count'] = $this->stock->getStocksWithRemainingBalance();
            $data['statistics_levadia'] = $this->statistics_levadia($year, 1, $year_now);
            $data['statistics_thiva'] = $this->statistics_levadia($year, 2, $year_now);
            $data['last_pays'] = $this->off_limits();

            $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_tmp";
            $this->load->view($this->_container, $data);
            break;

        // =================== ΛΟΓΙΣΤΗΡΙΟ ===================
        case 6:
            $current_user = NULL;

            // === ΝΕΑ data_stats ===
            $data = $this->data_stats($selected_year, $year_now, $selected_sp, $selected_type, $selected_status);

            // === Προσθήκες για panels ===
            $data['group_id'] = $group[0]->id;
            $data['statistics_levadia'] = $this->statistics_levadia($year, 1, $year_now);
            $data['statistics_thiva'] = $this->statistics_levadia($year, 2, $year_now);
            $data['last_pays'] = $this->off_limits();
            $data['on_hold'] = $this->task->get_filtered_tasks();
            $data['debt_count'] = $this->stock->getStocksWithRemainingBalance();

            $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard";
            $this->load->view($this->_container, $data);
            break;

        // =================== ΥΠΟΛΟΙΠΑ ΟΠΩΣ ΕΙΝΑΙ ===================
        // (Group 4, 5, 7 χωρίς αλλαγές προς το παρόν)
        // ...
    


            // =================== ΛΙΒΑΔΕΙΑ ===================
case 4:
    $current_user = 1;
    $data['current_user'] = $current_user;
    $data['group_id'] = $group[0]->id;

    // === Φίλτρα ===
    $selected_year = $this->input->get('year') ?: $year_now;
    $selected_type = $this->input->get('type') ?: null;
    $selected_status = $this->input->get('status') ?: null;

    // === Νέα data_stats ===
    $data = $this->data_stats($selected_year, $year_now, 1, $selected_type, $selected_status);

    $data['sp_id'] = 1;
    $data['tasks'] = $this->task->get_filtered_tasks(1);
    $data['on_hold'] = $this->task->get_filtered_tasks(1);
    $data['debt_count'] = $this->stock->getStocksWithRemainingBalance(1);
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_sp";
    $this->load->view($this->_container, $data);
    break;

// =================== ΘΗΒΑ ===================
case 5:
    $current_user = 2;
    $data['current_user'] = $current_user;
    $data['group_id'] = $group[0]->id;

    // === Φίλτρα ===
    $selected_year = $this->input->get('year') ?: $year_now;
    $selected_type = $this->input->get('type') ?: null;
    $selected_status = $this->input->get('status') ?: null;

    // === Νέα data_stats ===
    $data = $this->data_stats($selected_year, $year_now, 2, $selected_type, $selected_status);

    $data['sp_id'] = 2;
    $data['tasks'] = $this->task->get_filtered_tasks(2);
    $data['on_hold'] = $this->task->get_filtered_tasks(2);
    $data['debt_count'] = $this->stock->getStocksWithRemainingBalance(2);
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_sp";
    $this->load->view($this->_container, $data);
    break;

// =================== ΕΛΕΓΧΟΣ ΧΩΡΙΣ ΣΥΝΔΕΣΗ (π.χ. ΕΟΠΥΥ) ===================
case 7:
    $data['group_id'] = $group[0]->id;

    // === Φίλτρα ===
    $selected_year = $this->input->get('year') ?: $year_now;
    $selected_type = $this->input->get('type') ?: null;
    $selected_status = $this->input->get('status') ?: null;

    // === Νέα data_stats ===
    $data = $this->data_stats($selected_year, $year_now, 2, $selected_type, $selected_status);

    $data['sp_id'] = 2;
    $data['on_hold'] = $this->task->get_filtered_tasks(2);
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_sp";
    $this->load->view($this->_container, $data);
    break;

        }
                        
    }
        
    // ================================
// ΝΕΑ ΕΚΔΟΣΗ data_stats με ενοποίηση φίλτρων
// ================================

public function data_stats(
    $year,
    $year_now,
    $selling_point,
    $ha_type = null,
    $status = null
) {
    $data = [];

    // =============== ΣΤΑΤΙΣΤΙΚΑ ΑΝΑ ΕΤΟΣ ===============
    for ($y = 2014; $y <= $year_now; $y++) {
        $sales = $this->chart->get_monthly_data($y, $selling_point, 4, 3, $ha_type, $status);
        $nosales = $this->chart->get_monthly_nosale($y, $selling_point, 3, $ha_type, $status);

        $data['statistics_general'][] = [
            'year' => $y,
            'sales' => array_sum(array_column($sales, 'data')),
            'nosales' => array_sum(array_column($nosales, 'data')),
        ];
    }

    // =============== ΦΙΛΤΡΑ ΓΙΑ DROPDOWNS ===============
    $data['years'] = range(date('Y'), 2014);
    $data['types'] = array('CIC', 'ITC', 'ITE', 'BTE', 'RIC', 'OPEN');
    $data['statuses'] = array(
        1 => 'Διαθέσιμο',
        2 => 'Σε Εκκρεμότητα',
        3 => 'Σε Test',
        4 => 'Πωληθέν'
    );
    $data['selling_points'] = $this->selling_point->get_all();

    // =============== ΜΕΤΑΒΛΗΤΕΣ ΠΡΟΒΟΛΗΣ ===============
    $data['year_now'] = $year_now;
    $data['sp'] = $selling_point;
    $data['ha_type'] = $ha_type;
    $data['status_filter'] = $status;

    // =============== ΠΩΛΗΣΕΙΣ ΤΡΕΧΟΝΤΟΣ ΕΤΟΥΣ ===============
    $data['this_year'] = $this->chart->clean_column_dash(json_encode(
        $this->chart->get_monthly_data($year_now, $selling_point, 4, 3, $ha_type, $status)
    ));

    // =============== PIE CHART BRAND ===============
    $brand_filter = "YEAR(stocks.day_in) = $year_now AND stocks.status IN (1,2,4)";
    if ($selling_point !== 'selling_point') $brand_filter .= " AND stocks.selling_point = $selling_point";
    if ($ha_type) $brand_filter .= " AND stocks.type = " . $this->db->escape($ha_type);
    if ($status) $brand_filter .= " AND stocks.status = $status";

    $data['brand_share'] = $this->db->query("SELECT manufacturers.name AS label, COUNT(stocks.id) AS value
        FROM stocks
        INNER JOIN models ON models.id = stocks.ha_model
        INNER JOIN series ON series.id = models.series
        INNER JOIN manufacturers ON manufacturers.id = series.brand
        WHERE $brand_filter
        GROUP BY manufacturers.name")->result_array();

    // =============== PIE CHART VENDOR ===============
    $vendor_filter = "YEAR(stocks.day_in) = $year_now AND stocks.status IN (1,2,4)";
    if ($selling_point !== 'selling_point') $vendor_filter .= " AND stocks.selling_point = $selling_point";
    if ($ha_type) $vendor_filter .= " AND stocks.type = " . $this->db->escape($ha_type);
    if ($status) $vendor_filter .= " AND stocks.status = $status";

    $data['vendor_share'] = $this->db->query("SELECT vendors.name AS label, COUNT(stocks.id) AS value
        FROM stocks
        INNER JOIN vendors ON vendors.id = stocks.vendor
        WHERE $vendor_filter
        GROUP BY vendors.name")->result_array();

    // =============== ΓΡΑΦΗΜΑ ΓΙΑΤΡΩΝ ===============
    $data['doc_dat'] = $this->chart->get_doctor_data($year_now, $selling_point);

    // =============== KPIs PANEL ===============
    $data['current_sales'] = count($this->stock->get_all('id', 'YEAR(day_out)=' . $year_now .
        ($selling_point !== 'selling_point' ? ' AND selling_point=' . $selling_point : '') .
        ' AND (status=3 OR status=4)'));

    $data['on_hold'] = $this->customer->get_all('id', 'pending=pending' .
        ($selling_point !== 'selling_point' ? ' AND selling_point=' . $selling_point : ''));

    //$data['in_debt_customers'] = count($this->db->query("SELECT id FROM debt_view WHERE balance > 0" .
    //    ($selling_point !== 'selling_point' ? " AND selling_point = $selling_point" : ''))->result());

    $data['stock_available'] = count($this->stock->get_all('id', 'status=1'));

    return $data;
}


/*
// ================================
// ΠΑΛΙΑ ΕΚΔΟΣΗ data_stats()
// ================================
public function data_stats($year, $year_now, $selling_point){
    for ($year; $year <= $year_now; $year++) {
        $statistics_general[] = $this->year_stats_general($year);
    }
    if ($selling_point == 'selling_point') {
        $data['sp'] = 'selling_point';
    } else {
        $sp = $this->selling_point->get($selling_point);
        $data['sp'] = $sp->id;
        $data['selling_point'] = $sp;
    }
    $data['statistics_general'] = $statistics_general;
    // ... υπόλοιπος παλιός κώδικας αφαιρείται για λόγους καθαρότητας ...
    return $data;
}
*/

    
   

    
    public function statistics_levadia($year, $selling_point, $year_now)
    {
        for ($year; $year <= $year_now; $year++) {
            $statistics_levadia[] = $this->year_stats($year, $selling_point);
        }        
    
        return $statistics_levadia;
    }
    
    public function statistics($year, $selling_point, $year_now)
    {
        for ($year; $year <= $year_now; $year++) {
            $this_year = json_encode($year);
            $statistics[] = $this->stock->get_all('COUNT(id) ', 'YEAR(day_out)=' . $year . ' AND selling_point=' . $selling_point);
        } 
        return $statistics;
    }

        public function dashboard_levadia(){
        
        $year = 2014;
        $year_now = date('Y');
        
        $data = $this->data_stats($year, $year_now, 1);
        $data['statistics_levadia'] = $this->statistics_levadia($year, 1, $year_now);

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_levadia";            
        $this->load->view($this->_container, $data);        
    }
        
    public function dashboard_thiva(){
        
        $year = 2014;
        $year_now = date('Y');
        
        $data = $this->data_stats($year, $year_now. 2);
        $data['statistics_thiva'] = $this->statistics_levadia($year, 2, $year_now);

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_thiva";            
        $this->load->view($this->_container, $data);        
    }
    
    public function off_limits()
    {
        $series = $this->stock->get_all('', 'debt<>0');
        foreach ($series as $list):            
            $last_pays[] = $this->pay->get_all('id, customer, date', ' customer=' . $list['customer_id'], '', '', '', 'customer');
            
        endforeach;
        
        return $last_pays;
    }
    
    
    public function dashboard() {
        // Νέα φίλτρα
        $ha_type = $this->input->get('type') ? $this->input->get('type') : null;
        $status = $this->input->get('status') ? $this->input->get('status') : null;
        $year = $this->input->get('year') ? $this->input->get('year') : date('Y');
        $sp = $this->input->get('sp') ? $this->input->get('sp') : null;

        $data['year'] = $year;
        $data['sp'] = $sp;
        $data['ha_type'] = $ha_type;
        $data['status_filter'] = $status;

        // Για dropdowns
        $data['years'] = range(date('Y'), 2014);
        $data['types'] = array('CIC', 'ITC', 'ITE', 'BTE', 'RIC', 'OPEN');
        $data['statuses'] = array(
            1 => 'Διαθέσιμο',
            2 => 'Σε Εκκρεμότητα',
            3 => 'Σε Test',
            4 => 'Πωληθέν'
        );
        $data['selling_points'] = $this->selling_point->get_all();

        // Ετήσιες πωλήσεις (για Morris chart)
        $stats = [];
        for ($y = 2014; $y <= $year; $y++) {
            $sales = $this->chart->get_monthly_data($y, $sp, 4, 3, $ha_type, $status);
            $nosales = $this->chart->get_monthly_nosale($y, $sp, 3, $ha_type, $status);
            $stats[] = [
                'year' => $y,
                'sales' => array_sum(array_column($sales, 'data')),
                'nosales' => array_sum(array_column($nosales, 'data')),
            ];
        }
        $data['statistics_general'] = $stats;

        // Πωλήσεις ανά μήνα τρέχοντος έτους
        $data['this_year'] = $this->chart->clean_column_dash(json_encode(
            $this->chart->get_monthly_data($year, $sp, 4, 3, $ha_type, $status)
        ));

        // Μερίδιο Brand (day_in)
        $brand_filter = "YEAR(stocks.day_in) = $year AND stocks.status IN (1,2,4)";
        if ($sp) $brand_filter .= " AND stocks.selling_point = $sp";
        if ($ha_type) $brand_filter .= " AND stocks.type = '$ha_type'";
        if ($status) $brand_filter .= " AND stocks.status = $status";

        $data['brand_share'] = $this->db->query("SELECT manufacturers.name AS label, COUNT(stocks.id) AS value
            FROM stocks
            INNER JOIN models ON models.id = stocks.ha_model
            INNER JOIN series ON series.id = models.series
            INNER JOIN manufacturers ON manufacturers.id = series.brand
            WHERE $brand_filter
            GROUP BY manufacturers.name")
            ->result_array();

        // Μερίδιο Vendor (day_in)
        $vendor_filter = "YEAR(stocks.day_in) = $year AND stocks.status IN (1,2,4)";
        if ($sp) $vendor_filter .= " AND stocks.selling_point = $sp";
        if ($ha_type) $vendor_filter .= " AND stocks.type = '$ha_type'";
        if ($status) $vendor_filter .= " AND stocks.status = $status";

        $data['vendor_share'] = $this->db->query("SELECT vendors.name AS label, COUNT(stocks.id) AS value
            FROM stocks
            INNER JOIN vendors ON vendors.id = stocks.vendor
            WHERE $vendor_filter
            GROUP BY vendors.name")
            ->result_array();

        // Γιατροί
        $data['doc_dat'] = $this->chart->get_doctor_data($year, $sp);

        // KPIs
        $data['current_sales'] = count($this->stock->get_all('id', 'YEAR(day_out)=' . $year . ($sp ? ' AND selling_point=' . $sp : '') . ' AND (status=3 OR status=4)'));
        $data['on_hold'] = $this->customer->get_all('id', 'pending=pending' . ($sp ? ' AND selling_point=' . $sp : ''));
        $data['in_debt_customers'] = count($this->db->query("SELECT id FROM debt_view WHERE balance > 0" . ($sp ? " AND selling_point = $sp" : ''))->result());
        $data['stock_available'] = count($this->stock->get_all('id', 'status=1'));

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard";
        $this->load->view($this->_container, $data);
    }

    
    public function year_stats($year, $selling_point) {
        
        $series_data1 = $this->chart->get_monthly_data($year, $selling_point, 4, 3);
        $series_data1 = json_encode($series_data1);
        $series_data1 = $this->chart->clean_column($series_data1);
        
        $series_data2 = $this->chart->get_monthly_nosale($year, $selling_point, 3);
        $series_data2 = json_encode($series_data2);
        $series_data2 = $this->chart->clean_column($series_data2);
        
        $data = array(
            'year' => $year,
            'sales' => array_sum(json_decode($series_data1)),
            'nosales' => array_sum(json_decode($series_data2)),
        );

        return $data;
    }
    
    public function year_stats_general($year) {
        
        $series_data1 = $this->chart->get_monthly_data($year, 1, 4, 3);
        $series_data2 = $this->chart->get_monthly_data($year, 2, 4, 3);
        
        $series_data1 = json_encode($series_data1);
        $series_data2 = json_encode($series_data2);
        
        $series_data1 = $this->chart->clean_column($series_data1);
        $series_data2 = $this->chart->clean_column($series_data2);
        
        $series_data3 = $this->chart->get_monthly_nosale($year, 1, 3);
        $series_data4 = $this->chart->get_monthly_nosale($year, 2, 3);
        
        $series_data3 = json_encode($series_data3);
        $series_data4 = json_encode($series_data4);
        
        $series_data3 = $this->chart->clean_column($series_data3);
        $series_data4 = $this->chart->clean_column($series_data4);
        
        $data = array(
                'year' => $year,
                'sales' => array_sum(json_decode($series_data1))+array_sum(json_decode($series_data2)),
                'nosales' => array_sum(json_decode($series_data3))+array_sum(json_decode($series_data4)),
            );

        return $data;
    }
    
    public function stock_av() {
        $stock = $this->stock->get_all('id, manufacturer', 'status=1');
        $stock = count($stock);
        return $stock;
    }

    public function on_hold($selling_point) {
        //$on_hold = $this->customer->get_all('id', 'status=5 AND selling_point = ' . $selling_point);
        $on_hold = $this->customer->get_all('id', 'pending=pending AND selling_point = ' . $selling_point);
        $on_hold = count($on_hold);
        return $on_hold;
        
    }
    
    public function pending_full() {
        //$on_hold = $this->customer->get_all('id', 'status=5 AND selling_point = ' . $selling_point);
        $on_hold = $this->customer->get_all('*', 'pending=pending');
        
        return $on_hold;
    }    
    
    public function eopyy_sum() {
        //$debt_tmp = $this->chart->get_debt_sum();
        $debt1 = $this->chart->get_debt_eopyy();
        $debt2 = json_encode($debt1);
        $debt = $this->chart->clean_column($debt2);
        
        $data = array(            
            'debt' => array_sum(json_decode($debt)),
        );
        
        return $data;
    } 
    
    public function eopyy_pays(){
        $debt1 = $this->chart->get_pays_eopyy();
        $debt2 = json_encode($debt1);
        $debt = $this->chart->clean_column($debt2);
        
        $data = array(            
            'pays' => array_sum(json_decode($debt)),
        );
        
        return $data;        
    }

    public function this_year($year){
                $tmp = json_encode($this->chart->get_monthly_data($year, 1, 4, 3)); 
                //$tmp2 = json_encode($this->chart->get_monthly_data($year, 2, 4, 3)); 
                
                //$tmp = var_dump($tmp1 + $tmp2);
                $data = $this->chart->clean_column_dash($tmp);
                /*for($i=1; $i<=12; $i++)
                {
                    $data = $this->stock->get_all('COUNT(stocks.id) AS pcs', 'MONTH(stocks.day_out) =' . $i . ' AND YEAR(stocks.day_out) =' . $year);
                }
                */
                return $data;
    }
    
    public function avg_price($year, $selling_point){
        
        $tmp = $this->chart->get_debt_avg($year, $selling_point);  
        
        $data = number_format($tmp[0]->mprice, 0, '.', '');

        return $data;        
    }
    
    public function ha_type_stats($year, $selling_point, $type){
        
        $tmp = $this->chart->get_ha_type_stats($year, $selling_point, $type);  
        
        $data = number_format($tmp[0]->mprice, 0, '.', '');

        return $data;
    }

}
