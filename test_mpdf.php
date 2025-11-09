<?php
/**
 * Test script για δοκιμή mPDF 8.x integration
 */

// Load Composer autoloader
require_once 'vendor/autoload.php';

try {
    // Δημιουργία νέας instance του mPDF 8.x
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'default_font_size' => 12,
        'default_font' => 'Arial',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'margin_header' => 6,
        'margin_footer' => 3,
        'orientation' => 'P'
    ]);

    // HTML περιεχόμενο
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Δοκιμή mPDF 8.x</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .header { text-align: center; color: #2e74b5; }
            .customer-info { margin: 20px 0; }
            .info-row { margin: 10px 0; }
            .label { font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>PHA MANAGER V4 - PDF Export Test</h1>
            <h2>mPDF Version 8.x Integration</h2>
        </div>
        
        <div class="customer-info">
            <div class="info-row">
                <span class="label">Ημερομηνία:</span> ' . date('d/m/Y H:i:s') . '
            </div>
            <div class="info-row">
                <span class="label">mPDF Version:</span> ' . \Mpdf\Mpdf::VERSION . '
            </div>
            <div class="info-row">
                <span class="label">Status:</span> ✅ Integration Successful
            </div>
        </div>
        
        <h3>Test Features</h3>
        <ul>
            <li>✅ Greek character support (Ελληνικά χαρακτήρες)</li>
            <li>✅ UTF-8 encoding</li>
            <li>✅ CSS styling</li>
            <li>✅ Modern mPDF 8.x compatibility</li>
            <li>✅ Composer autoloading</li>
        </ul>
        
        <div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-left: 4px solid #28a745;">
            <strong>Success!</strong> Το mPDF 8.x έχει εγκατασταθεί και λειτουργεί σωστά με τo PHA Manager V4.
        </div>
    </body>
    </html>';

    // Προσθήκη HTML στο PDF
    $mpdf->WriteHTML($html);

    // Output PDF
    $filename = 'mpdf_test_' . date('Y-m-d_H-i-s') . '.pdf';
    $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);

    echo "PDF generated successfully: " . $filename;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "\nStack trace: " . $e->getTraceAsString();
}
?>