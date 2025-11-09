<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Task extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    // Create new task
    public function create_task($data) {
        return $this->db->insert('tasks', $data);
    }

    // Delete task
    public function delete_task($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tasks');
    }

    // Get all tasks with associated customer and selected acoustic details
    public function get_all_tasks() {
        $this->db->select('
            tasks.*, 
            customers.name as customer_name, 
            customers.phone_mobile, 
            customers.phone_home, 
            customers.address, 
            customers.amka,
            customers.doctor,
            stocks.serial as acoustic_serial, 
            stocks.ekapty_code,
            stocks_2.serial as acoustic_serial_2,            
            stocks.ha_model, 
            stocks_2.ha_model as ha_model_2,
            stocks.manufacturer, 
            stocks.day_in as receive,     
            stocks.day_out as paradosi,  
            models.model as model_name, 
            models.ha_type as model_type,
            series.series as series_name, 
            series.brand as series_brand, 
            manufacturers.name as manufacturer_name,
            doctors.doc_name as doctor_name' // Προσθήκη του ονόματος του γιατρού'
        );
        
        // Join tasks with related tables (customers, stocks, models, etc.)
        $this->db->from('tasks');
        $this->db->join('customers', 'tasks.client = customers.id', 'left');
        $this->db->join('stocks', 'tasks.acoustic_id = stocks.id', 'left');
        $this->db->join('stocks as stocks_2', 'tasks.acoustic_id_2 = stocks_2.id', 'left');
        $this->db->join('models', 'stocks.ha_model = models.id', 'left');
        $this->db->join('series', 'models.series = series.id', 'left');
        $this->db->join('manufacturers', 'series.brand = manufacturers.id', 'left');
        //$this->db->join('doctors', 'stocks.doctor_id = doctors.id', 'left'); // Προσθήκη του JOIN για τον πίνακα doctors
        $this->db->join('doctors', 'customers.doctor = doctors.id', 'left'); // Προσθήκη του JOIN για τον πίνακα doctors

        $query = $this->db->get();        
        $tasks = $query->result_array(); // Αποθήκευση των tasks

    
        // Υπολογισμός της πρόοδου για κάθε task
        foreach ($tasks as &$task) {
            $totalSteps = 7; // Συνολικός αριθμός βημάτων
            $completedSteps = 0;

            // Ελέγχουμε ποια βήματα έχουν ολοκληρωθεί
            if ($task['scan']) $completedSteps++;
            if ($task['order']) $completedSteps++;
            if ($task['tel_rdv']) $completedSteps++;
            if ($task['ektelesi']) $completedSteps++;
            if ($task['signatures']) $completedSteps++;
            if ($task['receipt']) $completedSteps++;
            if ($task['arxeio']) $completedSteps++;            
            
            // Υπολογισμός ποσοστού πρόοδου
            $task['progress'] = round(($completedSteps / $totalSteps) * 100, 2); // Πρόοδος σε %
    }
        
        return $tasks; // Επιστρέφει τη λίστα με τα tasks
    }

    // Get task by ID with related customer and specific acoustics
    public function get_task_by_id($id) {
        $this->db->select('
            tasks.*, 
            customers.name as customer_name, 
            customers.phone_mobile, 
            customers.phone_home, 
            customers.address, 
            stocks.serial as acoustic_serial, 
            stocks_2.serial as acoustic_serial_2, 
            stocks.ha_model, 
            stocks_2.ha_model as ha_model_2,
            stocks.manufacturer, 
            stocks.day_in as receive,     
            stocks.day_out as paradosi,  
            models.model as model_name, 
            models.ha_type as model_type'
        );

        $this->db->from('tasks');
        $this->db->join('customers', 'tasks.client = customers.id', 'left');
        $this->db->join('stocks', 'tasks.acoustic_id = stocks.id', 'left');
        $this->db->join('stocks as stocks_2', 'tasks.acoustic_id_2 = stocks_2.id', 'left');
        $this->db->join('models', 'stocks.ha_model = models.id', 'left');

        $this->db->where('tasks.id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }

    // Get the task by ID for editing with acoustic details
    public function get_task_by_id_edit($id) {
        $this->db->select('
            tasks.*, 
            customers.name as customer_name, 
            stocks.serial as acoustic_serial, 
            stocks_2.serial as acoustic_serial_2'
        );

        $this->db->from('tasks');
        $this->db->join('customers', 'tasks.client = customers.id', 'left');
        $this->db->join('stocks', 'tasks.acoustic_id = stocks.id', 'left');
        $this->db->join('stocks as stocks_2', 'tasks.acoustic_id_2 = stocks_2.id', 'left');
        $this->db->where('tasks.id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }

    // Update task record
    public function update_task($id, $data) {
        log_message('debug', "Updating task ID: $id with data: " . print_r($data, true));
        $this->db->where('id', $id);
        $result = $this->db->update('tasks', $data);

        if (!$result) {
            log_message('error', 'Error updating task: ' . $this->db->last_query());
        }

        return $result;
    }

    // Update specific field of task in database
    public function update_field_in_db($taskId, $field, $value) {
        // Log the input parameters
        log_message('debug', "Updating Task ID: $taskId, field: $field, value: $value");
        
        // Validate input parameters
        if (empty($taskId) || empty($field)) {
            log_message('error', "Invalid parameters: taskId=$taskId, field=$field");
            return false;
        }
        
        // Check if task exists
        $this->db->where('id', $taskId);
        $existing_task = $this->db->get('tasks');
        if ($existing_task->num_rows() == 0) {
            log_message('error', "Task ID: $taskId not found in database");
            return false;
        }
        
        // Prepare data for update
        if ($field === 'tel_rdv' && $value == 1) {
            $data = [
                $field => $value,
                'tel_rdv_timestamp' => date('Y-m-d H:i:s')
            ];
        } else {
            $data = [$field => $value];
        }
        
        log_message('debug', "Update data: " . json_encode($data));
        
        // Perform the update
        $this->db->where('id', $taskId);
        $result = $this->db->update('tasks', $data);
        
        // Log the result
        if ($result) {
            $affected_rows = $this->db->affected_rows();
            log_message('debug', "Task ID: $taskId updated successfully. Affected rows: $affected_rows");
            
            // Double check the update by fetching the updated record
            $this->db->where('id', $taskId);
            $updated_task = $this->db->get('tasks')->row();
            log_message('debug', "Updated task field value: " . $updated_task->$field);
            
            return true;
        } else {
            $db_error = $this->db->error();
            log_message('error', "Failed to update Task ID: $taskId. Database error: " . json_encode($db_error));
            return false;
        }
    }

    // Insert task into the database
    public function insert($data) {
        return $this->db->insert('tasks', $data);
    }

    // Get acoustics for a customer (used in dropdown logic)
    public function get_acoustics_by_customer($customerId) {
        $this->db->select('id, serial, ha_model');
        $this->db->from('stocks');
        $this->db->where('customer_id', $customerId);

        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_filtered_tasks($selling_point = null) {
    $this->db->select('
        tasks.*, 
        customers.name as customer_name, 
        customers.phone_mobile, 
        customers.phone_home, 
        customers.address, 
        customers.doctor,
        stocks.serial as acoustic_serial, 
        stocks_2.serial as acoustic_serial_2, 
        stocks.ha_model, 
        stocks_2.ha_model as ha_model_2,
        stocks.manufacturer, 
        stocks.day_in as receive,     
        stocks.day_out as paradosi,  
        models.model as model_name, 
        models.ha_type as model_type,
        series.series as series_name, 
        series.brand as series_brand, 
        manufacturers.name as manufacturer_name,
        doctors.doc_name as doctor_name' // Προσθήκη του ονόματος του γιατρού
    );

    // Join tasks with related tables (customers, stocks, models, etc.)
    $this->db->from('tasks');
    $this->db->join('customers', 'tasks.client = customers.id', 'left');
    $this->db->join('stocks', 'tasks.acoustic_id = stocks.id', 'left');
    $this->db->join('stocks as stocks_2', 'tasks.acoustic_id_2 = stocks_2.id', 'left');
    $this->db->join('models', 'stocks.ha_model = models.id', 'left');
    $this->db->join('series', 'models.series = series.id', 'left');
    $this->db->join('manufacturers', 'series.brand = manufacturers.id', 'left');
    //$this->db->join('doctors', 'stocks.doctor_id = doctors.id', 'left'); // Προσθήκη του JOIN για τον πίνακα doctors
    $this->db->join('doctors', 'customers.doctor = doctors.id', 'left'); // Προσθήκη του JOIN για τον πίνακα doctors

    // Φιλτράρισμα με βάση το selling_point αν δίνεται
    if ($selling_point) {
        $this->db->where('customers.selling_point', $selling_point);
    }

    // Συνθήκες για να βρεις τα tasks με τουλάχιστον ένα checkbox null
    $this->db->group_start(); // Ξεκινάμε μια ομάδα συνθηκών
    $this->db->where('tasks.scan', 0);
    $this->db->or_where('tasks.gnomateusi', 0);
    $this->db->or_where('tasks.tel_rdv', 0);
    $this->db->or_where('tasks.ektelesi', 0);
    $this->db->or_where('tasks.signatures', 0);
    $this->db->or_where('tasks.receipt', 0);
    $this->db->or_where('tasks.arxeio', 0);
    $this->db->or_where('stocks.day_out', 0);
    $this->db->or_where('stocks.day_in', 0);
    $this->db->group_end(); // Κλείνουμε την ομάδα συνθηκών

    $query = $this->db->get();
    $tasks = $query->result_array(); // Αποθήκευση των tasks

    
    // Υπολογισμός της πρόοδου για κάθε task
    foreach ($tasks as &$task) {
        $totalSteps = 7; // Συνολικός αριθμός βημάτων
        $completedSteps = 0;

        // Ελέγχουμε ποια βήματα έχουν ολοκληρωθεί
        if ($task['scan']) $completedSteps++;
        if ($task['order']) $completedSteps++;
        if ($task['tel_rdv']) $completedSteps++;
        if ($task['ektelesi']) $completedSteps++;
        if ($task['signatures']) $completedSteps++;
        if ($task['receipt']) $completedSteps++;
        if ($task['arxeio']) $completedSteps++;

        // Υπολογισμός ποσοστού πρόοδου
        $task['progress'] = ($completedSteps / $totalSteps) * 100; // Πρόοδος σε %
    }

    return $tasks; // Επιστροφή των tasks με την πρόοδο
}

public function get_vendors_delivery_stats()
    {    
        $sql = "
            SELECT 
                vendors.name AS vendor_name,
                ROUND(
                    AVG(
                        CASE 
                            WHEN stocks.day_in IS NOT NULL 
                             AND tasks.order IS NOT NULL 
                             AND DATE(stocks.day_in) >= DATE(tasks.order)
                            THEN DATEDIFF(DATE(stocks.day_in), DATE(tasks.order))
                            ELSE NULL
                        END
                    ), 1) AS avg_order_to_receive_days,
                ROUND(
                    AVG(
                        CASE 
                            WHEN stocks.day_out IS NOT NULL 
                             AND stocks.day_in IS NOT NULL 
                             AND DATE(stocks.day_out) >= DATE(stocks.day_in)
                            THEN DATEDIFF(DATE(stocks.day_out), DATE(stocks.day_in))
                            ELSE NULL
                        END
                    ), 1) AS avg_receive_to_delivery_days
            FROM 
                vendors
            LEFT JOIN stocks ON stocks.vendor = vendors.id
            LEFT JOIN tasks ON tasks.acoustic_id = stocks.id
                AND YEAR(tasks.entry_date) = YEAR(CURDATE())
                AND tasks.acoustic_id IS NOT NULL
            GROUP BY 
                vendors.id
            HAVING 
                AVG(
                    CASE 
                        WHEN stocks.day_in IS NOT NULL 
                         AND tasks.order IS NOT NULL 
                         AND DATE(stocks.day_in) >= DATE(tasks.order)
                        THEN DATEDIFF(DATE(stocks.day_in), DATE(tasks.order))
                        ELSE NULL
                    END
                ) > 0 
                AND AVG(
                    CASE 
                        WHEN stocks.day_out IS NOT NULL 
                         AND stocks.day_in IS NOT NULL 
                         AND DATE(stocks.day_out) >= DATE(stocks.day_in)
                        THEN DATEDIFF(DATE(stocks.day_out), DATE(stocks.day_in))
                        ELSE NULL
                    END
                ) > 0
            ORDER BY 
                avg_order_to_receive_days ASC
        ";

        // Εκτέλεση του query
        $query = $this->db->query($sql);

        // Επιστροφή των αποτελεσμάτων
        return $query->result();
    }
    
    public function get_average_task_durations($selling_point = null, $range = '3m')
{
    // Μετατροπή της χρονικής περιόδου
    switch ($range) {
        case '6m':
            $interval = '6 MONTH';
            break;
        case '12m':
        case '1y':
            $interval = '12 MONTH';
            break;
        default:
            $interval = '3 MONTH';
    }

    // Δημιουργία του WHERE clause για selling_point
    $selling_point_condition = '';
    $params = [];
    
    if ($selling_point !== null) {
        $selling_point_condition = 'c.selling_point = ? AND';
        $params = [$selling_point, $selling_point];
    }

    $sql = "
        SELECT 
            (
                SELECT AVG(DATEDIFF(s.day_in, t.`order`))
                FROM tasks t
                JOIN stocks s ON s.id = t.acoustic_id
                JOIN customers c ON c.id = t.client
                WHERE 
                    $selling_point_condition
                    t.`order` IS NOT NULL
                    AND s.day_in IS NOT NULL
                    AND s.day_in > t.`order`
                    AND t.`order` >= DATE_SUB(CURDATE(), INTERVAL $interval)
            ) AS avg_order_diff,
            
            (
                SELECT AVG(DATEDIFF(s.day_out, t.tel_rdv_timestamp))
                FROM tasks t
                JOIN stocks s ON s.id = t.acoustic_id
                JOIN customers c ON c.id = t.client
                WHERE 
                    $selling_point_condition
                    t.tel_rdv_timestamp IS NOT NULL
                    AND s.day_out IS NOT NULL
                    AND s.day_out > t.tel_rdv_timestamp
                    AND t.tel_rdv_timestamp >= DATE_SUB(CURDATE(), INTERVAL $interval)
            ) AS avg_tel_diff
    ";

    $query = $this->db->query($sql, $params);
    return $query->row_array();
}


}



