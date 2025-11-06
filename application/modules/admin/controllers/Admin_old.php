<?php

class Admin extends Admin_Controller {

    function __construct() {
        parent::__construct();        

        $this->load->model(array('admin/chart'));
        $this->load->model(array('admin/stock'));
        $this->load->model(array('admin/customer'));
        $this->load->model(array('admin/pay'));
        $this->load->model(array('admin/company'));
   }

    public function index() {
        
        $this->db->query("CALL update_balance_full()");

        global $year;
        global $year_now;
        
        //prequestities...............
        $year = 2014;
        $year_now = date('Y');
        
        
        $data = $this->data_stats($year, $year_now);
        $data['statistics_levadia'] = $this->statistics_levadia($year, 1, $year_now);
        $data['statistics_thiva'] = $this->statistics_levadia($year, 2, $year_now);
        
        if ($this->is_admin):
            $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard";            
        else :
            $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "calendar"; 
        endif;
        
        $this->load->view($this->_container, $data);
    }
        
    public function data_stats($year, $year_now){
        
        //  code for chart        
        for ($year; $year <= $year_now; $year++) {
            $statistics_general[] = $this->year_stats_general($year);
        }
        
        $data['statistics_general'] = $statistics_general;
        
        //this year stats
        $data['this_year'] = $this->this_year($year_now);
        $data['this_year_test'] = $this->chart->get_monthly_data($year, 1, 3, 2);
        
        //single numbers.........................
        $data['current_sales'] = $this->year_stats_general($year_now);
        
        $data['current_sales_levadia'] = $this->year_stats($year_now, 1);
        $data['current_sales_thiva'] = $this->year_stats($year_now, 2);
        $data['stock_available'] = $this->stock_av();
        $data['in_debt_customers'] = count($this->customer->get_all('id', 'debt_flag<>0'));
        
        $data['on_hold'] = $this->on_hold();
        $data['stock_ha'] = $this->stock->get_all('id, manufacturer', 'status=1');
        
        $data['stock_debt'] = $this->stock->get_all('id, manufacturer, customer_id, debt, balance', 'debt<>0');

        $data['on_hold_names'] = $this->customer->get_all('id, name, doctor', 'status=5');        

        
        //financial data--------------------------------------------------------
        $data['pays'] = $this->pay->get_all('id, customer, date, pay');
        
        $data['sum_debt'] = $this->debt($year_now);
        
        $data['avg_price'] = $this->avg_price($year_now);
        $data['year_now'] = $year_now;
        //$data['old_debt'] = $this->debt('2014 OR 2015 OR 2016 OR 2017');
        $data['old_debt_2016'] = $this->debt('2016');
        $data['old_debt_2015'] = $this->debt('2015');
        $data['old_debt_2014'] = $this->debt('2014');
        $data['old_debt'] = $data['old_debt_2016'] ;

        // endof code for chart 
        //eopyy
        $eopyy_sum = $this->eopyy_sum();
        $eopyy_pays = $this->eopyy_pays();
        
        $data['sum_eopyy'] = $eopyy_sum;        
        $data['eopyy_pays'] = $eopyy_pays;
                
        $data['eopyy_now'] = array_sum($eopyy_sum)-array_sum($eopyy_pays);       
        //endof_eopyy
        
        
        return $data;
    }
    
    public function statistics_levadia($year, $selling_point, $year_now){

        //$year = 2014;
        //$year_now = date('Y');

        for ($year; $year <= $year_now; $year++) {
            $statistics_levadia[] = $this->year_stats($year, $selling_point);
        }        
    
        return $statistics_levadia;
    }
        
    public function dashboard_levadia(){
        
        $year = 2014;
        $year_now = date('Y');
        
        $data = $this->data_stats($year, $year_now);
        $data['statistics_levadia'] = $this->statistics_levadia($year, 1, $year_now);

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_levadia";            
        $this->load->view($this->_container, $data);        
    }
        
    public function dashboard_thiva(){
        
        $year = 2014;
        $year_now = date('Y');
        
        $data = $this->data_stats($year, $year_now);
        $data['statistics_thiva'] = $this->statistics_levadia($year, 2, $year_now);

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard_thiva";            
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

    public function on_hold() {
        $on_hold = $this->customer->get_all('id', 'status=5');
        $on_hold = count($on_hold);
        return $on_hold;
    }
    
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
                
                $data = $this->chart->clean_column_dash($tmp);
                
                return $data;
    }
    
    public function avg_price($year){
        
        $tmp = $this->chart->get_debt_avg($year);  
        
        $data = number_format($tmp[0]->mprice, 2, '.', '');

        return $data;
        
    }

}
