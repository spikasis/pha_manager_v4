<?php

class Admin extends Admin_Controller {

    // Loaded libraries and models properties  
    public $email;
    public $ion_auth;
    public $bcrypt;
    public $ion_auth_model;
    public $chart;
    public $stock;
    public $customer;
    public $pay;
    public $company;
    public $selling_point;
    public $eopyy_pay;
    public $balance_view;
    public $debt_view;
    public $service;
    public $earlab;
    public $task;
    public $doctor;
    public $vendor;
    public $model;

    function __construct() {
        parent::__construct();        
        
        // Load models - optimized single call  
        $this->load->model(array(
            'admin/chart',
            'admin/stock',
            'admin/customer',
            'admin/pay',
            'admin/company',
            'admin/selling_point',
            'admin/eopyy_pay',
            'admin/balance_view',
            'admin/debt_view',
            'admin/service',
            'admin/earlab',
            'admin/task'
        ));
        
   }
   
    /**
     * Common method to prepare dashboard data variables
     */
    private function prepareDashboardData($year, $year_now, $sp_id = null) {
        $data = array();
        $data['year'] = $year;
        $data['year_now'] = $year_now;
        
        if ($sp_id) {
            $data['sp_id'] = $sp_id;
            $data['selling_point'] = $this->selling_point->get($sp_id);
        }
        
        return $data;
    }
   
    public function index() {
    $year = DEFAULT_STATS_YEAR;
    $year_now = CURRENT_YEAR;

    $user_id = $this->ion_auth->get_user_id();
    
    // Check if user ID is valid
    if (!$user_id || !is_numeric($user_id)) {
        redirect('/auth', 'refresh');
        return;
    }
    
    $groups = $this->ion_auth->get_users_groups($user_id)->result();
    
    // Check if user has groups
    if (empty($groups)) {
        show_error('User has no assigned groups. Please contact administrator.');
        return;
    }
    
    $group_id = $groups[0]->id;
    $data['group_id'] = $group_id;

    // Αν είναι admin
    if ($this->ion_auth->is_admin()) {
        // Λήψη επιλεγμένου υποκαταστήματος από GET ή default σε 1
        $sp_id = $this->input->get('sp');
if (!$sp_id || !is_numeric($sp_id)) {
    $sp_id = DEFAULT_SELLING_POINT; // default safe fallback
}

        $sp = $this->selling_point->get($sp_id);

        $data = $this->data_stats($year, $year_now, $sp_id);
        $data = array_merge($data, $this->prepareDashboardData($year, $year_now, $sp_id));
        $data['selling_point'] = $sp;
        $data['selling_points'] = $this->selling_point->get_all();
        $data['group_id'] = 1;

        // Chart-specific στατιστικά για admin
        $data['statistics_levadia'] = $this->statistics_levadia($year, 1, $year_now);
        $data['statistics_thiva'] = $this->statistics_levadia($year, 2, $year_now);
        $data['last_pays'] = $this->off_limits();
        $data['stock_bc'] = $this->stock->get_all('id, serial, ha_model, day_in, vendor, selling_point', 'ekapty_code=0 AND YEAR(day_in)>=2024');

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard";
        $this->load->view($this->_container, $data);
        return;
    }

    // Αν ΔΕΝ είναι admin, πάμε με βάση το group ID
    switch ($group_id) {
        case 4:
        case 5:
        case 7:
            $sp_id = ($group_id == 4) ? 1 : 2;
            $data = $this->data_stats($year, $year_now, $sp_id);
            $data['sp_id'] = $sp_id;
            $data['year'] = $year;
            $data['year_now'] = $year_now;
            $data['selling_point'] = $this->selling_point->get($sp_id);
            $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_sp";
            $this->load->view($this->_container, $data);
            break;

        case 6:
            $data = $this->data_stats($year, $year_now, 'selling_point');
            $data['year'] = $year;
            $data['year_now'] = $year_now;
            $data['statistics_levadia'] = $this->statistics_levadia($year, 1, $year_now);
            $data['statistics_thiva'] = $this->statistics_levadia($year, 2, $year_now);
            $data['last_pays'] = $this->off_limits();
            $data['debt_count'] = $this->stock->getStocksWithRemainingBalance();
            $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard";
            $this->load->view($this->_container, $data);
            break;
    }
}

    
    public function calendar(){
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "calendar"; 
        $this->load->view($this->_container, $data);
    }
        
    public function data_stats($year, $year_now, $selling_point)
{
    $data = [];

    // Γενικά στατιστικά ανά έτος
    $statistics_general = [];
    for ($y = $year; $y <= $year_now; $y++) {
        $statistics_general[] = $this->year_stats_general($y);
    }
    $data['statistics_general'] = $statistics_general;

    // Στοιχεία υποκαταστήματος
    if ($selling_point === 'selling_point') {
        $data['sp'] = 'selling_point';
    } else {
        $sp = $this->selling_point->get($selling_point);
        $data['sp'] = $sp->id;
        $data['selling_point'] = $sp;
    }

    // Στατιστικά για το τρέχον έτος
    $data['this_year'] = $this->this_year($year_now);
    $data['this_year_test'] = $this->chart->get_monthly_data($year, 1, 3, 2);

    // Μεμονωμένα KPIs
    $current_sales_result = $this->stock->get_all('id', 'YEAR(day_out)=' . $year_now . ' AND selling_point=' . $selling_point . ' AND (status=4 OR status=3)');
    $data['current_sales'] = is_array($current_sales_result) ? count($current_sales_result) : 0;
    $data['stock_available'] = $this->stock_av();
    $in_debt_result = $this->debt_view->get_all('id', 'balance<>0 AND selling_point=' . $selling_point);
    $data['in_debt_customers'] = is_array($in_debt_result) ? count($in_debt_result) : 0;
    $data['on_hold'] = $this->on_hold($selling_point);
    $data['stock_ha'] = $this->stock->get_all('id, manufacturer', 'status=1');

    // Εκκρεμότητες & υπόλοιπα
    $data['stock_debt'] = $this->debt_view->get_all('', 'balance<>0 AND day_out<>0 AND selling_point=' . $selling_point);
    $data['on_hold_debt'] = $this->debt_view->get_all('', 'balance<>0 AND day_out=0 AND selling_point=' . $selling_point);
    $data['on_hold_names'] = $this->customer->get_all('id, name, doctor, status, selling_point', 'pending=pending AND selling_point=' . $selling_point);

    // Οικονομικά
    $data['pays'] = $this->pay->get_all('id, customer, date, pay');
    $data['sum_debt'] = $this->debt_view->get_all('SUM(balance) AS data', 'YEAR(day_out)=' . $year_now . ' AND selling_point=' . $selling_point);
    $data['sum_debt_on_hold'] = $this->debt_view->get_all('SUM(balance) AS data', 'day_out=0 AND selling_point=' . $selling_point);
    $data['avg_price'] = $this->stock->get_all('ROUND(AVG(ha_price),0) AS data', 'YEAR(day_out)=' . $year_now . ' AND (status=4 OR status=3)');

    // Παλιό χρέος
    $old_debt = $this->debt_view->get_all('SUM(balance) AS data', 'YEAR(day_out)<' . $year_now . ' AND YEAR(day_out)<>0');
    $data['old_debt'] = $old_debt[0];

    // ΕΟΠΥΥ
    $data['eopyy_sum'] = $this->stock->get_all('SUM(eopyy) AS data', 'day_out<>0');
    $data['eopyy_pays'] = $this->eopyy_pay->get_all('SUM(price) AS data');
    $data['eopyy_now'] = array_sum($data['eopyy_sum'][0]) - array_sum($data['eopyy_pays'][0]);

    // Τεχνικά / Εργαστήριο
    $data['services'] = $this->service->get_all('id, ha_service, day_in', 'status=2');
    $data['moulds'] = $this->earlab->get_all('id, customer_id, date_order', 'date_delivery=0');
    $data['stock_bc'] = $this->stock->get_all('id, serial, ha_model, day_in, vendor, selling_point', 'ekapty_code=0 AND YEAR(day_in)>=2024 AND selling_point=' . $selling_point);

    // Ετήσιο χρέος ανά υποκατάστημα
    $data['year_debt_sp'] = $this->stock->get_all('SUM(debt)', 'YEAR(day_out)=' . $year . ' AND selling_point=' . $selling_point);

    // Εκκρεμείς εργασίες
    $data['tasks'] = $this->task->get_filtered_tasks($selling_point);

    // Τρέχον έτος
    $data['year_now'] = $year_now;
    
    $range_input = $this->input->get('range') ? $this->input->get('range') : 'quarter';

switch ($range_input) {
    case 'half':
        $range_sql = '6m';
        break;
    case 'year':
        $range_sql = '12m';
        break;
    case 'quarter':
    default:
        $range_sql = '3m';
        break;
}

$durations = $this->task->get_average_task_durations($selling_point, $range_sql);
$data['task_duration'] = [
    'order_to_dayin' => round($durations['avg_order_diff']),
    'tel_to_dayout'  => round($durations['avg_tel_diff']),
];
$data['selected_range'] = $range_input;
    
    return $data;
}

    
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
        
        $year = DEFAULT_STATS_YEAR;
        $year_now = CURRENT_YEAR;
        
        $data = $this->data_stats($year, $year_now, 1);
        $data['statistics_levadia'] = $this->statistics_levadia($year, 1, $year_now);

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_levadia";            
        $this->load->view($this->_container, $data);        
    }
        
    public function dashboard_thiva(){
        
        $year = DEFAULT_STATS_YEAR;
        $year_now = CURRENT_YEAR;
        
        $data = $this->data_stats($year, $year_now, 2);
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
    
    
    public function dashboard($selling_point = null, $year = null)
{
    // Προεπιλογή για το τρέχον έτος
    $current_year = date('Y');
    $data['year'] = $year ? $year : 'all';  // Αν δεν υπάρχει έτος, επιλέγουμε "all" για συνολικά στοιχεία
    $data['selling_point'] = $selling_point;

    // Δημιουργία των συνθηκών για το query για τον πίνακα `stocks`
    $conditions = array();

    // Αν έχει επιλεγεί selling_point
    if (!is_null($selling_point)) {
        $conditions[] = 'selling_point = ' . $selling_point;
    }

    // Αν έχει επιλεγεί έτος, προσθέτουμε τη συνθήκη στο query
    if (!is_null($year) && $year != "all") {
        $conditions[] = 'YEAR(day_out) = ' . $year;
    }

    // Δημιουργία του where condition αν υπάρχουν συνθήκες για τον πίνακα `stocks`
    $where = !empty($conditions) ? implode(' AND ', $conditions) : null;

    // Δημιουργία των συνθηκών για το query για τον πίνακα `customers`
    $customer_conditions = array();

    // Έλεγχος για το έτος για τον πίνακα `customers`
    if (!is_null($year) && $year != "all") {
        $customer_conditions[] = 'YEAR(first_visit) = ' . $year;
    }

    // Έλεγχος για το selling_point για τον πίνακα `customers`
    if (!is_null($selling_point)) {
        $customer_conditions[] = 'selling_point = ' . $selling_point;
    }

    // Δημιουργία του where condition αν υπάρχουν συνθήκες για τον πίνακα `customers`
    $customer_where = !empty($customer_conditions) ? implode(' AND ', $customer_conditions) : null;

    // Κλήση του μοντέλου με τις παραμέτρους για τις πωλήσεις
    $data['sales'] = $this->stock->get_all('COUNT(id) AS data', $where);

    // Κλήση του μοντέλου για τα συνολικά χρέη
    $data['debt'] = $this->stock->get_all('SUM(debt) AS data', $where);

    // Κλήση του μοντέλου για τις μη πωλήσεις
    $no_sales_conditions = $customer_where ? $customer_where . ' AND status = 3' : 'status = 3';
    $data['no_sales'] = $this->customer->get_all('COUNT(id) AS data', $no_sales_conditions);

    // Κλήση του μοντέλου για τη μέση τιμή
    $avg_price_conditions = $where ? $where . ' AND stocks.status = 4' : 'stocks.status = 4';
    $data['avg_price'] = $this->stock->get_all('ROUND(AVG(ha_price), 0) AS data', $avg_price_conditions);

    // Στατιστικά τύπων ακουστικών
    $data['stock_type_stats'] = $this->stock->getStockByHaType($year, $selling_point);

    // Γραφήματα για κάθε μήνα
    for($i = 1; $i <= 12; $i++) {
        $monthly_conditions = $where ? $where . ' AND MONTH(day_out) = ' . $i : 'MONTH(day_out) = ' . $i;
        $sales_graph[] = $this->stock->get_all('COUNT(id) AS data', $monthly_conditions);

        $monthly_no_sales_conditions = $no_sales_conditions . ' AND MONTH(first_visit) = ' . $i;
        $nosales_graph[] = $this->customer->get_all('COUNT(id) AS data', $monthly_no_sales_conditions);

        $visits_conditions = $customer_where ? $customer_where . ' AND MONTH(first_visit) = ' . $i : 'MONTH(first_visit) = ' . $i;
        $visits[] = $this->customer->get_all('COUNT(id) AS data', $visits_conditions);
    }

    // Προετοιμασία δεδομένων για τα γραφήματα
    $data['sales_graph'] = $this->chart->clean_column(json_encode($sales_graph));
    $data['nosales_graph'] = $this->chart->clean_column(json_encode($nosales_graph));
    $data['visits'] = $this->chart->clean_column(json_encode($visits));

    // Δεδομένα για τα γραφήματα κατασκευαστών και γιατρών
    $data['brands_graph'] = $this->chart->clean_pie(json_encode($this->chart->get_manufacturer_data($year, $selling_point)));
    $data['doc_dat'] = $this->chart->clean_pie(json_encode($this->chart->get_doctor_data($year, $selling_point)));

    // Χρέη που δεν έχουν πληρωθεί
    $debt_conditions = $where ? $where . ' AND balance <> 0' : 'balance <> 0';
    $data['debt_new'] = $this->stock->get_all('SUM(debt) as data', $debt_conditions);

    // Υπολογισμός χρέους για το έτος
    $ha_total_conditions = $where ? $where : '';
    $ha_total = $this->stock->get_all('SUM(ha_price) AS total', $ha_total_conditions);
    $eopyy_total = $this->stock->get_all('SUM(eopyy) AS eopyy', $ha_total_conditions);
    $ha = $this->stock->get_all('id', $ha_total_conditions);

    // OPTIMIZED: Single query instead of N+1 queries
    $ha_ids = array_column($ha, 'id');
    $total_all = 0;
    
    if (!empty($ha_ids)) {
        $ha_ids_string = implode(',', array_map('intval', $ha_ids));
        $total_pays_result = $this->pay->get_all(
            'SUM(pay) AS total_payments', 
            'hearing_aid IN (' . $ha_ids_string . ')'
        );
        $total_all = !empty($total_pays_result) && isset($total_pays_result[0]['total_payments']) 
            ? (int)$total_pays_result[0]['total_payments'] 
            : 0;
    }

    $data['total_pays'] = $ha_total[0]['total'] - $eopyy_total[0]['eopyy'] - $total_all;
    $data['total_all'] = $total_all;

    // Δεδομένα για τα γραφήματα
    $data['chart_data'] = $this->stock->fetchChartData($year, $selling_point);
    $data['sp'] = $this->selling_point->get($selling_point);

    // Ορισμός του τίτλου ανάλογα με την επιλογή έτους ή "συνολικά"
    if ($year === null || $year == 'all') {
        $data['title'] = 'Συνολικά Στατιστικά';
    } else {
        $data['title'] = 'Στατιστικά Έτους ' . $year;
    }

    // Φόρτωση του view
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_year";
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
        $stock = is_array($stock) ? count($stock) : 0;
        return $stock;
    }

    public function on_hold($selling_point) {
        //$on_hold = $this->customer->get_all('id', 'status=5 AND selling_point = ' . $selling_point);
        $on_hold = $this->customer->get_all('id', 'pending=pending AND selling_point = ' . $selling_point);
        $on_hold = is_array($on_hold) ? count($on_hold) : 0;
        return $on_hold;
        
    }
    
    public function pending_full() {
        //$on_hold = $this->customer->get_all('id', 'status=5 AND selling_point = ' . $selling_point);
        $on_hold = $this->customer->get_all('*', 'pending=pending');
        
        return $on_hold;
    }
    
    /*
    public function debt($year) {
        //$debt_tmp = $this->chart->get_debt_sum();
        $debt1 = $this->chart->get_debt_sum($year);
        $debt2 = json_encode($debt1);
        $debt = $this->chart->clean_column($debt2);
        
        $data = array(            
            'debt' => array_sum(json_decode($debt)),
        );
        
        return $data;
    }
    */
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
