<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * System Settings Model
 * Διαχείριση ρυθμίσεων συστήματος για notifications και άλλες παραμέτρους
 */
class System_setting extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Λήψη ρύθμισης από τη βάση
     */
    public function get_setting($key, $default_value = null) {
        $this->db->where('setting_key', $key);
        $query = $this->db->get('system_settings');
        
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->setting_value;
        }
        
        return $default_value;
    }

    /**
     * Ενημέρωση ή δημιουργία ρύθμισης
     */
    public function set_setting($key, $value) {
        $this->db->where('setting_key', $key);
        $query = $this->db->get('system_settings');
        
        $data = array(
            'setting_key' => $key,
            'setting_value' => $value,
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        if ($query->num_rows() > 0) {
            // Update existing
            $this->db->where('setting_key', $key);
            return $this->db->update('system_settings', $data);
        } else {
            // Insert new
            $data['created_at'] = date('Y-m-d H:i:s');
            return $this->db->insert('system_settings', $data);
        }
    }

    /**
     * Λήψη όλων των ρυθμίσεων
     */
    public function get_all_settings() {
        $query = $this->db->get('system_settings');
        $settings = array();
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    /**
     * Δημιουργία πίνακα system_settings αν δεν υπάρχει
     */
    public function create_table_if_not_exists() {
        if (!$this->db->table_exists('system_settings')) {
            $this->load->dbforge();
            
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'setting_key' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'unique' => TRUE
                ),
                'setting_value' => array(
                    'type' => 'TEXT'
                ),
                'description' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'null' => TRUE
                ),
                'created_at' => array(
                    'type' => 'DATETIME'
                ),
                'updated_at' => array(
                    'type' => 'DATETIME'
                )
            );
            
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('setting_key');
            $this->dbforge->create_table('system_settings');
            
            // Insert default settings
            $this->insert_default_settings();
        }
    }

    /**
     * Εισαγωγή προεπιλεγμένων ρυθμίσεων
     */
    private function insert_default_settings() {
        $default_settings = array(
            array(
                'setting_key' => 'service_delay_notification_days',
                'setting_value' => '7',
                'description' => 'Αριθμός ημερών μετά τον οποίο μια επισκευή θεωρείται καθυστερημένη',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ),
            array(
                'setting_key' => 'service_critical_delay_days',
                'setting_value' => '14',
                'description' => 'Αριθμός ημερών μετά τον οποίο μια επισκευή θεωρείται κρίσιμα καθυστερημένη',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ),
            array(
                'setting_key' => 'notification_refresh_interval',
                'setting_value' => '300000',
                'description' => 'Διάστημα ανανέωσης notifications σε milliseconds (5 λεπτά)',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ),
            array(
                'setting_key' => 'enable_service_notifications',
                'setting_value' => '1',
                'description' => 'Ενεργοποίηση notifications για καθυστερημένες επισκευές',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            )
        );
        
        $this->db->insert_batch('system_settings', $default_settings);
    }
}