<?php
class ManufacturerReport_model extends MY_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database(); // ✅ Εξασφαλίζει ότι υπάρχει $this->db
    }

    public function get_sales_yearly($manufacturer_id = null) {
    $where = "WHERE s.day_in IS NOT NULL";
    $params = [];

    if ($manufacturer_id !== null) {
        $where .= " AND mf.id = ?";
        $params[] = $manufacturer_id;
    }

    $sql = "
        SELECT 
            YEAR(s.day_in) AS year,
            COUNT(*) AS manufacturer_total,
            (
                SELECT COUNT(*) 
                FROM stocks s2 
                WHERE YEAR(s2.day_in) = YEAR(s.day_in)
            ) AS total_yearly,
            ROUND(
                (COUNT(*) / 
                (SELECT COUNT(*) FROM stocks s2 WHERE YEAR(s2.day_in) = YEAR(s.day_in))
                ) * 100, 2
            ) AS percent_of_total
        FROM stocks s
        JOIN models m ON m.id = s.ha_model
        JOIN series sr ON sr.id = m.series
        JOIN manufacturers mf ON mf.id = sr.brand
        $where
        GROUP BY YEAR(s.day_in)
        ORDER BY year DESC
    ";

    return $this->db->query($sql, $params)->result_array();
}

    public function get_avg_order_delay($manufacturer_id = null) {
    $where = "
        WHERE YEAR(s.day_in) = YEAR(CURDATE())
        AND s.day_in IS NOT NULL
        AND t.`order` IS NOT NULL
        AND s.day_in >= t.`order`
    ";
    $params = [];

    if ($manufacturer_id !== null) {
        $where .= " AND mf.id = ?";
        $params[] = $manufacturer_id;
    }

    $sql = "
        SELECT 
            ROUND(AVG(DATEDIFF(s.day_in, t.`order`)), 1) AS avg_days_diff
        FROM stocks s
        JOIN tasks t ON t.acoustic_id = s.id
        JOIN models m ON m.id = s.ha_model
        JOIN series sr ON sr.id = m.series
        JOIN manufacturers mf ON mf.id = sr.brand
        $where
    ";

    return $this->db->query($sql, $params)->row_array();
}


public function get_repairs_by_manufacturer($manufacturer_id = null) {
    $where = "WHERE st.status != 5 AND cat.id = 2";
    $params = [];

    if ($manufacturer_id !== null) {
        $where .= " AND man.id = ?";
        $params[] = $manufacturer_id;
    }

    $sql = "
        SELECT 
            man.name AS manufacturer_name, 
            ser.series, 
            m.model AS hearing_aid_model, 
            COUNT(DISTINCT st.id) AS number_of_repairs,
            model_count
        FROM services s
        JOIN service_tickets st_tk ON st_tk.ticket = s.id
        JOIN service_subcategories sc ON sc.id = st_tk.service_sub
        JOIN service_categories cat ON cat.id = sc.category
        JOIN stocks st ON s.ha_service = st.id
        JOIN models m ON st.ha_model = m.id
        JOIN series ser ON m.series = ser.id
        JOIN manufacturers man ON ser.brand = man.id
        JOIN (
            SELECT ha_model, COUNT(*) AS model_count 
            FROM stocks 
            WHERE status != 5 
            GROUP BY ha_model
        ) AS stock_counts ON m.id = stock_counts.ha_model
        $where
        GROUP BY man.name, ser.series, m.model, model_count
        ORDER BY number_of_repairs DESC
    ";

    return $this->db->query($sql, $params)->result_array();
}

public function get_extra_kpis($manufacturer_id = null) {
    $params = [];

    // Κατασκευάζουμε δυναμικά τις συνθήκες φίλτρου
    $brandCondition = "";
    if ($manufacturer_id !== null) {
        $brandCondition = "WHERE se.brand = ?";
        $params[] = $manufacturer_id;
    }

    $brandConditionInJoin = $manufacturer_id !== null ? "se.brand = ?" : "1=1";
    $brandConditionInWhere = $manufacturer_id !== null ? "AND se.brand = ?" : "";

    if ($manufacturer_id !== null) {
        $params[] = $manufacturer_id;
        $params[] = $manufacturer_id;
    }

    $sql = "
        SELECT
            -- 1. Συνολικός αριθμός ακουστικών
            (
                SELECT COUNT(*) 
                FROM stocks s 
                JOIN models m ON m.id = s.ha_model 
                JOIN series se ON se.id = m.series
                " . ($manufacturer_id !== null ? "WHERE se.brand = ?" : "") . "
            ) AS total_stocks,

            -- 2. Μέσος όρος ημερών από πώληση μέχρι 1η επισκευή (από 2019+)
            (
                SELECT ROUND(AVG(DATEDIFF(sv.day_in, s.day_out)), 1)
                FROM services sv
                JOIN stocks s ON s.id = sv.ha_service
                JOIN models m ON m.id = s.ha_model
                JOIN series se ON se.id = m.series
                WHERE 
                    " . $brandConditionInJoin . "
                    AND s.day_out IS NOT NULL
                    AND sv.day_in IS NOT NULL
                    AND sv.day_in >= '2019-01-01'
                    AND sv.day_in >= s.day_out
            ) AS avg_repair_days,

            -- 3. Αριθμός ακουστικών με >1 επισκευές (από 2019)
            (
                SELECT COUNT(*) FROM (
                    SELECT s.id
                    FROM services sv
                    JOIN stocks s ON s.id = sv.ha_service
                    JOIN models m ON m.id = s.ha_model
                    JOIN series se ON se.id = m.series
                    WHERE 
                        YEAR(s.day_out) >= 2019
                        " . $brandConditionInWhere . "
                    GROUP BY s.id
                    HAVING COUNT(*) > 1
                ) AS subquery
            ) AS multi_repair_count
    ";

    return $this->db->query($sql, $params)->row_array();
}

public function get_repairs_by_category($manufacturer_id = null) {
    $params = [];
    $where = "WHERE s.day_in IS NOT NULL";

    if ($manufacturer_id !== null) {
        $where .= " AND stk.manufacturer = ?";
        $params[] = $manufacturer_id;
    }

    $sql = "
        SELECT 
            cat.categories AS category_name,
            sc.subcategory AS subcategory_name,
            COUNT(DISTINCT s.ha_service) AS repair_count
        FROM services s
        JOIN service_tickets st ON st.ticket = s.id
        JOIN service_subcategories sc ON sc.id = st.service_sub
        JOIN service_categories cat ON cat.id = sc.category
        JOIN stocks stk ON stk.id = s.ha_service
        $where
        GROUP BY cat.categories, sc.subcategory
        ORDER BY cat.categories, repair_count DESC
    ";

    return $this->db->query($sql, $params)->result_array();
}

public function get_specific_issue_count($manufacturer_id = null) {
    $params = [];
    $where = "
        WHERE cat.id = 2
        AND sc.id = 9        
        AND DATEDIFF(s.day_in, stk.day_out) BETWEEN 0 AND 730
    ";

    if ($manufacturer_id !== null) {
        $where .= " AND stk.manufacturer = ?";
        $params[] = $manufacturer_id;
    }

    $sql = "
        SELECT COUNT(DISTINCT s.ha_service) AS count
        FROM services s
        JOIN service_tickets st ON st.ticket = s.id
        JOIN service_subcategories sc ON sc.id = st.service_sub
        JOIN service_categories cat ON cat.id = sc.category
        JOIN stocks stk ON stk.id = s.ha_service
        $where
    ";

    $result = $this->db->query($sql, $params)->row_array();
    return $result['count'];
}


}
