<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Stock extends MY_Model {

    public function __construct() {
        parent::__construct();
    }  
    
    

    
public function getStocksWithDetails($selling_point_id = null, $this_year = null, $status = null, $balance_condition = null, $vendor_id = null, $ekapty_code_not_null = null, $ektelesi_eopyy_not_null = null, $ekapty_code_empty = null) {
    $where_clause = "";
    $params = array();

    // Add condition for selling point
    if ($selling_point_id !== null) {
        $where_clause .= " WHERE s.selling_point = ?";
        $params[] = $selling_point_id;
    }

    // Add condition for this_year
    if ($this_year !== null) {
        $where_clause .= ($where_clause === "" ? " WHERE" : " AND") . " YEAR(s.day_out) = ?";
        $params[] = $this_year;
    }

    // Add condition for status
    if ($status !== null) {
        $where_clause .= ($where_clause === "" ? " WHERE" : " AND") . " s.status = ?";
        $params[] = $status;
    }

    // Add condition for balance condition
    if ($balance_condition === 'non_zero') {
        $where_clause .= ($where_clause === "" ? " WHERE" : " AND") . " s.balance <> 0";
    } elseif ($balance_condition !== null) {
        $where_clause .= ($where_clause === "" ? " WHERE" : " AND") . " s.balance = ?";
        $params[] = $balance_condition;
    }

    // Add condition for vendor
    if ($vendor_id !== null) {
        $where_clause .= ($where_clause === "" ? " WHERE" : " AND") . " s.vendor = ?";
        $params[] = $vendor_id;
    }

    // Add condition for ekapty_code IS NOT NULL, IS NOT empty, AND NOT 0
    if ($ekapty_code_not_null === true) {
        $where_clause .= ($where_clause === "" ? " WHERE" : " AND") . " s.ekapty_code IS NOT NULL AND s.ekapty_code <> '' AND s.ekapty_code <> 0";
    }

    // Add condition for ekapty_code IS empty (either NULL or empty string)
    if ($ekapty_code_empty === true) {
        $where_clause .= ($where_clause === "" ? " WHERE" : " AND") . " (s.ekapty_code IS NULL OR s.ekapty_code = '')";
    }

    // Add condition for ektelesi_eopyy IS NOT NULL, IS NOT empty, AND NOT 0
    if ($ektelesi_eopyy_not_null === true) {
        $where_clause .= ($where_clause === "" ? " WHERE" : " AND") . " s.ektelesi_eopyy IS NOT NULL AND s.ektelesi_eopyy <> '' AND s.ektelesi_eopyy <> 0";
    } elseif ($ektelesi_eopyy_not_null === false) {
        // Add condition for ektelesi_eopyy IS empty (NULL or empty string)
        $where_clause .= ($where_clause === "" ? " WHERE" : " AND") . " (s.ektelesi_eopyy IS NULL OR s.ektelesi_eopyy = '')";
    }

    // Debugging: Print the generated SQL query
    log_message('debug', 'SQL Query: ' . $this->db->last_query());

    // Construct the SQL query
    $query = $this->db->query("
        SELECT 
            s.id, 
            s.doctor_id, 
            s.serial, 
            s.day_in,
            s.day_out,
            s.ekapty_code,
            s.ektelesi_eopyy,
            s.balance, -- Include balance in the select statement if you need it in the result set
            c.name AS customer_name,
            v.name AS vendor_name,
            m.name AS manufacturer_name,
            mo.model AS model_name,
            se.series AS series_name,
            ht.type AS ha_type,
            bt.type AS battery_type,
            sp.city AS selling_point_city,
            ss.status AS stock_status
        FROM 
            stocks s
        LEFT JOIN 
            customers c ON s.customer_id = c.id
        LEFT JOIN 
            vendors v ON s.vendor = v.id
        LEFT JOIN 
            models mo ON s.ha_model = mo.id
        LEFT JOIN 
            series se ON mo.series = se.id
        LEFT JOIN 
            manufacturers m ON se.brand = m.id
        LEFT JOIN 
            ha_types ht ON mo.ha_type = ht.id
        LEFT JOIN 
            battery_types bt ON mo.battery = bt.id
        LEFT JOIN 
            selling_points sp ON s.selling_point = sp.id
        LEFT JOIN 
            stock_statuses ss ON s.status = ss.id
        $where_clause
    ", $params);

    if (!$query) {
        // Handle error
        $error = $this->db->error();
        log_message('error', 'Query error: ' . $error['message']);
        return false;
    }

    return $query->result_array();
}

public function get_stats($year) {
    // Modify your SQL query to filter data based on the year parameter
    $sql = "SELECT model, COUNT(*) AS count FROM stocks WHERE YEAR(day_out) = ? GROUP BY model";
    $result = $this->db->query($sql, array($year));

    // Check if the query was successful
    if ($result) {
        // Fetch the data as an associative array
        $data = $result->result_array();

        /*
        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
         
         */
    } else {
        // Return false if query failed
        return false;
    }
}

public function fetchChartData($year = NULL, $selling_point = NULL) {
    $this->db->select('man.name AS brand, ser.series AS model_series, m.model AS model_name, COUNT(s.ha_model) AS model_count');
    $this->db->from('stocks s');
    $this->db->join('models m', 's.ha_model = m.id');
    $this->db->join('series ser', 'm.series = ser.id', 'left');
    $this->db->join('manufacturers man', 'ser.brand = man.id', 'left');
    $this->db->join('selling_points sp', 's.selling_point = sp.id', 'left');

    if (!is_null($year)) {
        $this->db->where('YEAR(s.day_out)', $year);
    }

    if (!is_null($selling_point)) {
        $this->db->where('sp.id', $selling_point);
    }

    $this->db->group_by('man.name, ser.series, m.model');
    $query = $this->db->get();

    // Debugging: Print out the generated SQL query
    //echo $this->db->last_query();

    return $query->result_array();
}

public function get_by_customer($customer_id) {
    // Αναζήτηση στον πίνακα stocks βάσει του customer_id
    $this->db->where('customer_id', $customer_id);
    $query = $this->db->get('stocks');

    // Επιστροφή των αποτελεσμάτων σε πίνακα
    return $query->result_array();
}
public function get_stock_by_id($id) {
    $this->db->select('stocks.*, 
                       doctors.doc_name as doctor_name,
                       stocks.serial as acoustic_serial,
                       models.model as model_name, 
                       series.series as series_name, 
                       manufacturers.name as manufacturer_name');
    
    $this->db->from('stocks');
    $this->db->join('models', 'stocks.ha_model = models.id', 'left');
    $this->db->join('series', 'models.series = series.id', 'left');
    $this->db->join('manufacturers', 'series.brand = manufacturers.id', 'left');
    $this->db->join('doctors', 'stocks.doctor_id = doctors.id', 'left');
    $this->db->where('stocks.id', $id);
    
    $query = $this->db->get();
    return $query->row_array();  // Επιστροφή του πρώτου αποτελέσματος
}


// Function to get stock data by ha_type with year and selling_point filters

public function getStockByHaType($year = null, $selling_point = null) {
    $this->db->select('ht.type AS ha_type, COUNT(s.id) AS total_stocks')
             ->from('stocks s')
             ->join('models m', 's.ha_model = m.id')
             ->join('ha_types ht', 'm.ha_type = ht.id');
    
    // Applying year filter if provided and not null
    if (!is_null($year)) {
        $this->db->where('YEAR(s.day_out)', $year);
    }

    // Applying selling_point filter if provided and not null
    if (!is_null($selling_point)) {
        $this->db->where('s.selling_point', $selling_point);
    }

    // Group by hearing aid type
    $this->db->group_by('ht.type');
    $this->db->order_by('ht.type', 'ASC');

    // Execute the query and return the results
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->result_array();  // Return the result as an array
    } else {
        return false;  // No data found
    }
}


public function getStocksWithRemainingBalance($selling_point = null) {
    $this->db->select('s.id AS stock_id, s.customer_id, s.ha_price, s.eopyy, 
                       (s.ha_price - s.eopyy - IFNULL(SUM(p.pay), 0)) AS remaining_balance, 
                       c.name AS customer_name, MAX(p.date) AS last_payment_date');
    $this->db->from('stocks s');
    $this->db->join('pays p', 's.id = p.hearing_aid', 'left');  // JOIN με τον πίνακα pays
    $this->db->join('customers c', 's.customer_id = c.id', 'left');  // JOIN με τον πίνακα customers

    if (!is_null($selling_point)) {
        $this->db->where('s.selling_point', $selling_point);
    }

    $this->db->group_by('s.id');
    $this->db->having('remaining_balance !=', 0);  // Φιλτράρισμα για όσους έχουν υπόλοιπο διαφορετικό του μηδενός

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->result_array();  // Επιστροφή αποτελεσμάτων ως πίνακας
    } else {
        return [];  // Επιστροφή κενής λίστας αν δεν υπάρχουν αποτελέσματα
    }
}


    public function get_stocks_with_conditions($status = null, $on_test = null, $selling_point = null) {
    
    // Select required fields for the output
    $this->db->select('
        s.serial, 
        s.id, 
        s.customer_id,
        mo.model AS model_name, 
        se.series AS series_name, 
        ma.name AS manufacturer_name, 
        s.day_out, 
        c.name AS customer_name, 
        s.on_test,
        s.comments
    ');

    // Join the necessary tables
    $this->db->from('stocks s');
    $this->db->join('customers c', 's.customer_id = c.id', 'left'); // Join with customers table
    $this->db->join('models mo', 's.ha_model = mo.id', 'left'); // Join with models table
    $this->db->join('series se', 'mo.series = se.id', 'left'); // Join with series table
    $this->db->join('manufacturers ma', 'se.brand = ma.id', 'left'); // Join with manufacturers table

    // Optional filtering based on the provided parameters
    if ($status !== null) {
        $this->db->where('s.status', $status);
    }
    if ($on_test !== null) {
        // Add condition to handle NULL values as well
        if ($on_test == 'NULL') {
            $this->db->where('s.on_test IS NULL');
        } else {
            $this->db->where('s.on_test', $on_test);
        }
    }
    if ($selling_point !== null) {
        $this->db->where('s.selling_point', $selling_point);
    }

    // Execute the query and return the result
    $query = $this->db->get();
    return $query->result_array(); // Return as an associative array
}

    
   public function update_otf($id, $data)
{
    $this->db->where('id', $id);
    $this->db->update('stocks', $data);
    
    if ($this->db->affected_rows() > 0) {
        return true;
    } else {
        log_message('error', 'Update failed for stock ID: ' . $id);
        return false;
    }
}

public function get_all_acoustics_with_details() {
    $this->db->select('stocks.*, manufacturers.name as manufacturer_name, models.model as model_name, series.series as series_name');
    $this->db->from('stocks');
    $this->db->join('manufacturers', 'stocks.manufacturer = manufacturers.id', 'left');
    $this->db->join('models', 'stocks.model = models.id', 'left');
    $this->db->join('series', 'models.series = series.id', 'left');

    $query = $this->db->get();
    return $query->result_array();
}

// Μέθοδος για την επιστροφή των ακουστικών με τα μοντέλα, σειρές και κατασκευαστές
    public function get_hearing_aids_with_details($status = null) {
        $this->db->select('stocks.*, models.model as model_name, series.series as series_name, manufacturers.name as manufacturer_name');
        $this->db->from('stocks');
        $this->db->join('models', 'stocks.ha_model = models.id', 'left');
        $this->db->join('series', 'models.series = series.id', 'left');
        $this->db->join('manufacturers', 'series.brand = manufacturers.id', 'left');
        
        if ($status !== null) {
            $this->db->where('stocks.status', $status);
        }
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get demo stocks with new categorization system
     * @param string $demo_type 'trial' or 'replacement'
     * @param int $in_use 0=available, 1=in use (has customer_id)
     * @param int $selling_point optional selling point filter
     * @return array
     */
    public function get_demo_stocks($demo_type = null, $in_use = null, $selling_point = null) {
        // Check if demo_type column exists first
        $columns = $this->db->list_fields('stocks');
        $has_demo_type = in_array('demo_type', $columns);
        
        // Build select fields array
        $this->db->select('s.id');
        $this->db->select('s.serial'); 
        $this->db->select('s.customer_id');
        $this->db->select('s.day_out'); 
        $this->db->select('s.day_in');
        $this->db->select('s.on_test');
        $this->db->select('s.comments');
        $this->db->select('s.ha_price');
        $this->db->select('s.selling_point');
        $this->db->select('mo.model AS model_name'); 
        $this->db->select('se.series AS series_name'); 
        $this->db->select('ma.name AS manufacturer_name');
        $this->db->select('c.name AS customer_name');
        
        // Add calculated fields using FALSE to prevent escaping
        $this->db->select('(CASE WHEN s.customer_id IS NOT NULL AND s.customer_id > 0 THEN 1 ELSE 0 END) as in_use', FALSE);
        $this->db->select('(CASE WHEN s.day_out IS NOT NULL AND s.day_out != "0000-00-00" THEN DATEDIFF(CURDATE(), s.day_out) ELSE NULL END) as days_out', FALSE);
        
        // Add demo_type based on availability
        if ($has_demo_type) {
            $this->db->select('s.demo_type');
        } else {
            // Fallback: simulate demo_type based on on_test
            $this->db->select('(CASE WHEN s.on_test = 1 THEN "trial" ELSE "replacement" END) as demo_type', FALSE);
        }

        // Set up table joins
        $this->db->from('stocks s');
        $this->db->join('customers c', 's.customer_id = c.id', 'left');
        $this->db->join('models mo', 's.ha_model = mo.id', 'left');
        $this->db->join('series se', 'mo.series = se.id', 'left');
        $this->db->join('manufacturers ma', 'se.brand = ma.id', 'left');

        // Always filter for demo status (assuming status=5 is demo)
        $this->db->where('s.status', 5);
        
        // Filter by demo_type if specified
        if ($demo_type !== null) {
            if ($has_demo_type) {
                $this->db->where('s.demo_type', $demo_type);
            } else {
                // Fallback logic: trial = on_test 1, replacement = on_test 0 or null
                if ($demo_type === 'trial') {
                    $this->db->where('s.on_test', 1);
                } else {
                    $this->db->group_start();
                    $this->db->where('s.on_test', 0);
                    $this->db->or_where('s.on_test IS NULL');
                    $this->db->group_end();
                }
            }
        }
        
        // Filter by usage status if specified
        if ($in_use !== null) {
            if ($in_use == 1) {
                // In use: has customer assigned
                $this->db->where('s.customer_id IS NOT NULL');
                $this->db->where('s.customer_id >', 0);
            } else {
                // Available: no customer assigned
                $this->db->group_start();
                $this->db->where('s.customer_id IS NULL');
                $this->db->or_where('s.customer_id', 0);
                $this->db->group_end();
            }
        }
        
        // Filter by selling point if specified
        if ($selling_point !== null) {
            $this->db->where('s.selling_point', $selling_point);
        }

        // Order by serial for consistency
        $this->db->order_by('s.serial', 'ASC');

        return $this->db->get()->result_array();
    }
    
    /**
     * Update demo type for a stock item
     * @param int $stock_id
     * @param string $demo_type 'trial' or 'replacement'
     * @return bool
     */
    public function update_demo_type($stock_id, $demo_type) {
        $this->db->where('id', $stock_id);
        return $this->db->update('stocks', ['demo_type' => $demo_type]);
    }

}

