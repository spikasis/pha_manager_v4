<?php
/**
 * Debug script for eggyisi_doc method
 * Call this to test what's happening: /admin/stocks/debug_eggyisi_doc/2443
 */

// Add this temporary method to Stocks controller for debugging
?>

<!-- Add this method to Stocks.php controller temporarily -->
<?php /*

public function debug_eggyisi_doc($id) {
    echo "<h1>Debug eggyisi_doc for ID: $id</h1>";
    
    try {
        echo "<h2>1. Getting stock data...</h2>";
        $stock = $this->stock->get($id);
        if (!$stock) {
            echo "❌ Stock not found with ID: $id<br>";
            return;
        }
        echo "✅ Stock found: " . print_r($stock, true) . "<br>";
        
        echo "<h2>2. Getting customer data...</h2>";
        $customers = $this->customer->get($stock->customer_id);
        if (!$customers) {
            echo "❌ Customer not found with ID: " . $stock->customer_id . "<br>";
            return;
        }
        echo "✅ Customer found: " . $customers->name . "<br>";
        
        echo "<h2>3. Getting company data...</h2>";
        $companies = $this->company->get(1);
        echo "✅ Company: " . print_r($companies, true) . "<br>";
        
        echo "<h2>4. Getting model data...</h2>";
        $ha_model = $this->model->get($stock->ha_model);
        if (!$ha_model) {
            echo "❌ Model not found with ID: " . $stock->ha_model . "<br>";
            return;
        }
        echo "✅ Model found: " . $ha_model->model . "<br>";
        
        echo "<h2>5. Getting series data...</h2>";
        $ha_series = $this->serie->get($ha_model->series);
        if (!$ha_series) {
            echo "❌ Series not found with ID: " . $ha_model->series . "<br>";
            return;
        }
        echo "✅ Series found: " . $ha_series->series . "<br>";
        
        echo "<h2>6. Getting manufacturer data...</h2>";
        $manufacturers = $this->manufacturer->get($ha_series->brand);
        if (!$manufacturers) {
            echo "❌ Manufacturer not found with ID: " . $ha_series->brand . "<br>";
            return;
        }
        echo "✅ Manufacturer found: " . $manufacturers->name . "<br>";
        
        echo "<h2>7. Getting type data...</h2>";
        $ha_type = $this->ha_type->get($ha_model->ha_type);
        if (!$ha_type) {
            echo "❌ Type not found with ID: " . $ha_model->ha_type . "<br>";
            return;
        }
        echo "✅ Type found: " . $ha_type->type . "<br>";
        
        echo "<h2>8. Preparing data array...</h2>";
        $data['company'] = $companies;
        $data['stock'] = $stock;
        $data['manufacturer'] = $manufacturers;
        $data['customer'] = $customers;
        $data['ha_model'] = $this->model->get($ha_model->id);
        $data['ha_series'] = $ha_series;
        $data['type'] = $ha_type;
        
        echo "✅ Data array prepared<br>";
        
        echo "<h2>9. Testing view loading...</h2>";
        try {
            $html = $this->load->view('eggyisi_doc_final', $data, true);
            echo "✅ View loaded successfully. HTML length: " . strlen($html) . " characters<br>";
            
            if (strlen($html) < 100) {
                echo "⚠️ HTML seems too short. Content:<br><pre>" . htmlspecialchars($html) . "</pre>";
            }
        } catch (Exception $e) {
            echo "❌ View loading failed: " . $e->getMessage() . "<br>";
            return;
        }
        
        echo "<h2>10. Testing Chart model...</h2>";
        if (!$this->chart) {
            echo "❌ Chart model not loaded<br>";
            return;
        }
        echo "✅ Chart model available<br>";
        
        echo "<h2>11. Testing PDF generation...</h2>";
        try {
            $title = 'Εγγύηση Ακουστικού Βαρηκοΐας';
            echo "Calling chart->print_doc with title: $title<br>";
            
            // Don't actually generate PDF, just test the process
            echo "✅ All checks passed! The eggyisi_doc should work.<br>";
            
        } catch (Exception $e) {
            echo "❌ PDF generation failed: " . $e->getMessage() . "<br>";
        }
        
    } catch (Exception $e) {
        echo "❌ General error: " . $e->getMessage() . "<br>";
        echo "Stack trace: " . $e->getTraceAsString() . "<br>";
    }
}

*/ ?>

<!-- Instructions: -->
<!-- 1. Copy the debug_eggyisi_doc method above -->
<!-- 2. Paste it into application/modules/admin/controllers/Stocks.php -->
<!-- 3. Visit: https://manager.pikasishearing.gr/admin/stocks/debug_eggyisi_doc/2443 -->
<!-- 4. Check what exactly is failing -->
<!-- 5. Remove the method after debugging -->

<style>
body { font-family: Arial; margin: 20px; }
h1 { color: #d63384; }
h2 { color: #0d6efd; border-bottom: 1px solid #ccc; }
</style>