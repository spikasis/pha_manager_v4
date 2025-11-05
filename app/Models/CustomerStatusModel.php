<?php

namespace App\Models;

class CustomerStatusModel extends BaseCRUDModel
{
    protected $table = 'customer_statuses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'description', 'color', 'is_active'];
    
    // Validation rules
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[50]|is_unique[customer_statuses.name,id,{id}]',
        'description' => 'permit_empty|max_length[255]',
        'color' => 'permit_empty|max_length[7]|regex_match[/^#[0-9A-Fa-f]{6}$/]',
        'is_active' => 'in_list[0,1]'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Το όνομα της κατάστασης είναι υποχρεωτικό',
            'min_length' => 'Το όνομα πρέπει να έχει τουλάχιστον 2 χαρακτήρες',
            'max_length' => 'Το όνομα δεν μπορεί να ξεπερνά τους 50 χαρακτήρες',
            'is_unique' => 'Αυτή η κατάσταση υπάρχει ήδη'
        ],
        'description' => [
            'max_length' => 'Η περιγραφή δεν μπορεί να ξεπερνά τους 255 χαρακτήρες'
        ],
        'color' => [
            'max_length' => 'Το χρώμα πρέπει να είναι έγκυρος κωδικός HEX',
            'regex_match' => 'Το χρώμα πρέπει να είναι έγκυρος κωδικός HEX (π.χ. #FF0000)'
        ],
        'is_active' => [
            'in_list' => 'Η κατάσταση ενεργοποίησης πρέπει να είναι 0 ή 1'
        ]
    ];
    
    protected $skipValidation = false;
    
    // Define entity configuration for BaseCRUD
    public function getEntityConfig(): array
    {
        return [
            'name' => 'CustomerStatus',
            'plural_name' => 'CustomerStatuses', 
            'display_name' => 'Κατάσταση Πελάτη',
            'plural_display_name' => 'Καταστάσεις Πελατών',
            'icon' => 'fas fa-tags',
            'description' => 'Διαχείριση καταστάσεων και κατηγοριοποίησης πελατών'
        ];
    }
    
    // Define searchable fields for BaseCRUD
    public function getSearchableFields(): array
    {
        return ['name', 'description'];
    }
    
    // Define display columns for DataTable
    public function getDisplayColumns(): array
    {
        return [
            'id' => ['label' => 'ID', 'type' => 'number'],
            'name' => ['label' => 'Όνομα', 'type' => 'text', 'searchable' => true],
            'description' => ['label' => 'Περιγραφή', 'type' => 'text', 'searchable' => true],
            'color' => ['label' => 'Χρώμα', 'type' => 'color'],
            'is_active' => ['label' => 'Ενεργή', 'type' => 'boolean']
        ];
    }
    
    // Define form fields for create/edit
    public function getFormFields(): array
    {
        return [
            'name' => [
                'label' => 'Όνομα Κατάστασης',
                'type' => 'text',
                'required' => true,
                'attributes' => [
                    'placeholder' => 'π.χ. Ενεργός, Ανενεργός, Υποψήφιος',
                    'maxlength' => '50'
                ],
                'help' => 'Εισάγετε το όνομα της κατάστασης πελάτη'
            ],
            'description' => [
                'label' => 'Περιγραφή',
                'type' => 'textarea',
                'required' => false,
                'attributes' => [
                    'placeholder' => 'Προαιρετική περιγραφή της κατάστασης...',
                    'maxlength' => '255',
                    'rows' => '3'
                ],
                'help' => 'Προαιρετική περιγραφή για τη χρήση της κατάστασης'
            ],
            'color' => [
                'label' => 'Χρώμα',
                'type' => 'color',
                'required' => false,
                'attributes' => [
                    'value' => '#007bff'
                ],
                'help' => 'Επιλέξτε χρώμα για την οπτική αναπαράσταση της κατάστασης'
            ],
            'is_active' => [
                'label' => 'Ενεργή Κατάσταση',
                'type' => 'select',
                'required' => true,
                'options' => [
                    '1' => 'Ναι',
                    '0' => 'Όχι'
                ],
                'attributes' => [
                    'value' => '1'
                ],
                'help' => 'Ορίστε αν η κατάσταση είναι διαθέσιμη για χρήση'
            ]
        ];
    }
    
    /**
     * Get customer status statistics
     */
    public function getStatusStats(): array
    {
        $stats = [];
        
        try {
            // Total statuses
            $stats['total'] = $this->countAllResults();
            
            // Active statuses
            $stats['active'] = $this->where('is_active', 1)->countAllResults(false);
            
            // Most used status (from customers table if exists)
            $query = $this->db->query("
                SELECT cs.name, COUNT(c.id) as customer_count 
                FROM customer_statuses cs 
                LEFT JOIN customers c ON c.status_id = cs.id 
                GROUP BY cs.id, cs.name 
                ORDER BY customer_count DESC 
                LIMIT 1
            ");
            
            $mostUsed = $query->getRowArray();
            $stats['most_used'] = $mostUsed ? $mostUsed['name'] : 'Δεν υπάρχουν δεδομένα';
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatusModel::getStatusStats - ' . $e->getMessage());
            $stats = [
                'total' => 0,
                'active' => 0,
                'most_used' => 'Σφάλμα'
            ];
        }
        
        return $stats;
    }
    
    /**
     * Get active statuses for select dropdown
     */
    public function getForSelect(): array
    {
        try {
            $statuses = $this->select('id, name, color')
                            ->where('is_active', 1)
                            ->orderBy('name', 'ASC')
                            ->findAll();
            
            $options = ['' => '-- Επιλέξτε Κατάσταση --'];
            
            foreach ($statuses as $status) {
                $options[$status['id']] = $status['name'];
            }
            
            return $options;
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatusModel::getForSelect - ' . $e->getMessage());
            return ['' => '-- Σφάλμα φόρτωσης --'];
        }
    }
    
    /**
     * Get customers by status
     */
    public function getCustomersByStatus($statusId): array
    {
        try {
            $query = $this->db->query("
                SELECT c.id, c.name, c.surname, c.phone, c.email 
                FROM customers c 
                WHERE c.status_id = ? 
                ORDER BY c.surname, c.name
            ", [$statusId]);
            
            return $query->getResultArray();
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatusModel::getCustomersByStatus - ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get status with customer count
     */
    public function getStatusesWithCount(): array
    {
        try {
            $query = $this->db->query("
                SELECT 
                    cs.*,
                    COUNT(c.id) as customer_count
                FROM customer_statuses cs 
                LEFT JOIN customers c ON c.status_id = cs.id 
                GROUP BY cs.id 
                ORDER BY cs.name ASC
            ");
            
            return $query->getResultArray();
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatusModel::getStatusesWithCount - ' . $e->getMessage());
            return [];
        }
    }
}