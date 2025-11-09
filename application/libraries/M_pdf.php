<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Composer autoloader for new mPDF 8.x
require_once FCPATH . 'vendor/autoload.php';

class M_pdf {
 
    public $param;
    public $pdf;
 
    public function __construct($param = [])
    {
        // Convert old parameters to new mPDF 8.x format
        if (is_string($param)) {
            // Old format was string, convert to array for mPDF 8.x
            $config = [
                'mode' => 'utf-8',
                'format' => 'A4',
                'default_font_size' => 0,
                'default_font' => '',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_header' => 6,
                'margin_footer' => 3,
                'orientation' => 'P'
            ];
        } else {
            // New format is already array
            $config = is_array($param) ? $param : [];
        }
        
        $this->param = $config;
        
        // Use new mPDF 8.x constructor
        $this->pdf = new \Mpdf\Mpdf($config);
    }
}