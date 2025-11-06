<?php

class Statistics extends Statistics {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/manufacturer'));
        $this->load->model(array('admin/chart'));
        $this->load->model(array('admin/stock'));
    }

    public function index() {
        
    }
}
