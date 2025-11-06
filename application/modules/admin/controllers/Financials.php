<?php

class Financials extends Admin_Controller {

    function __construct() {
        parent::__construct();        

        $this->load->model(array('admin/chart'));
        $this->load->model(array('admin/stock'));
        $this->load->model(array('admin/customer'));
        $this->load->model(array('admin/pay'));
        $this->load->model(array('admin/company'));
        $this->load->model(array('admin/selling_point'));
        $this->load->model(array('admin/financial'));
   }

    public function index() {
        
        $this->db->query("CALL update_balance_full()");

        global $year;
        global $year_now;
        
        //prequestities...............
        $year = 2014;
        $year_now = date('Y');
        
        $selling_points = $this->selling_point->get_all();
        
        foreach ($selling_points as $key => $list ):
            for($i = $year; $i <= $year_now; $i++)
            {
                $year_financial_stats[] = $this->year_stats($i, $list['id']);
                
            }
            
            endforeach; 
                 
        $data['year_financial_stats'] = $year_financial_stats;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "financial";            
        $this->load->view($this->_container, $data);
    }
        
    public function year_stats($year, $selling_point) {
        
        $sd_1 = $this->financial->get_year_pcs($year, $selling_point);
        $sd_2 = json_encode($sd_1);      
        $sd_3 = $this->chart->clean_column($sd_2);
        
        $sd_5 = $this->financial->get_year_price_sum($year, $selling_point);
        $sd_6 = json_encode($sd_5);      
        $sd_7 = $this->chart->clean_column($sd_6);
        
        
        $data = array(
            'year' => $year,
            's_p' => $selling_point,
            'pcs' => array_sum(json_decode($sd_3)),
            'sum_price' => array_sum(json_decode($sd_7)),
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
        
        $data = number_format($tmp[0]->mprice, 0, '.', '');

        return $data;
        
    }
    
    public function rebate($price) {
        
     
        
    }

}
