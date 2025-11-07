<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    // Core CodeIgniter properties (to avoid PHP 8.2+ deprecation warnings)
    public $load;
    public $config;
    public $input;
    public $db;
    public $session;
    public $uri;
    public $output;
    public $lang;
    public $router;
    public $security;
    
    // Custom properties  
    var $_container;
    var $_modules;

    function __construct() {
        parent::__construct();
        $this->load->helper('url');

        $this->load->config('ci_my_admin');

        // Set container variable
        $this->_container = $this->config->item('ci_my_admin_template_dir_public') . "layout.php";
        $this->_modules = $this->config->item('modules_locations');

        log_message('debug', 'CI My Admin : MY_Controller class loaded');
    }
}