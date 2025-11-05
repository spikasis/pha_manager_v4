<?php

namespace App\Models;

class InsuranceModel extends BaseCRUDModel
{
    protected $table = 'insurances';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name'];
    
    // Validation rules
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[25]|is_unique[insurances.name,id,{id}]'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Το όνομα του ασφαλιστικού ταμείου είναι υποχρεωτικό',
            'min_length' => 'Το όνομα πρέπει να έχει τουλάχιστον 2 χαρακτήρες',
            'max_length' => 'Το όνομα δεν μπορεί να ξεπερνά τους 25 χαρακτήρες',
            'is_unique' => 'Αυτό το ασφαλιστικό ταμείο υπάρχει ήδη'
        ]
    ];
    
    protected $skipValidation = false;
    
    // Define entity configuration for BaseCRUD
    public function getEntityConfig(): array
    {
        return [
            'name' => 'Insurance',
            'plural_name' => 'Insurances', 
            'display_name' => 'Ασφαλιστικό Ταμείο',
            'plural_display_name' => 'Ασφαλιστικά Ταμεία',
            'icon' => 'fas fa-shield-alt',
            'description' => 'Διαχείριση ασφαλιστικών ταμείων και οργανισμών'
        ];
    }
    
    // Define searchable fields for BaseCRUD
    public function getSearchableFields(): array
    {
        return ['name'];
    }
    
    // Define display columns for DataTable
    public function getDisplayColumns(): array
    {
        return [
            'id' => ['label' => 'ID', 'type' => 'number'],
            'name' => ['label' => 'Όνομα', 'type' => 'text', 'searchable' => true]
        ];
    }
    
    // Define form fields for create/edit
    public function getFormFields(): array
    {
        return [
            'name' => [
                'label' => 'Όνομα Ασφαλιστικού Ταμείου',
                'type' => 'text',
                'required' => true,
                'attributes' => [
                    'placeholder' => 'π.χ. ΙΚΑ, ΟΑΕΕ, ΟΠΑΔ',
                    'maxlength' => '25'
                ],
                'help' => 'Εισάγετε το όνομα του ασφαλιστικού ταμείου ή οργανισμού'
            ]
        ];
    }
    
    /**
     * Get insurance statistics
     */
    public function getInsuranceStats(): array
    {
        $stats = [];
        
        try {
            // Total insurances
            $stats['total'] = $this->countAllResults();
            
            // Most used insurance (from customers table if exists)
            $query = $this->db->query("
                SELECT i.name, COUNT(c.id) as customer_count 
                FROM insurances i 
                LEFT JOIN customers c ON c.insurance_id = i.id 
                GROUP BY i.id, i.name 
                ORDER BY customer_count DESC 
                LIMIT 1
            ");
            
            $mostUsed = $query->getRowArray();
            $stats['most_used'] = $mostUsed ? $mostUsed['name'] : 'Δεν υπάρχουν δεδομένα';
            
        } catch (\Exception $e) {
            log_message('error', 'InsuranceModel::getInsuranceStats - ' . $e->getMessage());
            $stats = [
                'total' => 0,
                'most_used' => 'Σφάλμα'
            ];
        }
        
        return $stats;
    }
    
    /**
     * Get insurances for select dropdown
     */
    public function getForSelect(): array
    {
        try {
            $insurances = $this->select('id, name')
                              ->orderBy('name', 'ASC')
                              ->findAll();
            
            $options = ['' => '-- Επιλέξτε Ασφαλιστικό Ταμείο --'];
            
            foreach ($insurances as $insurance) {
                $options[$insurance['id']] = $insurance['name'];
            }
            
            return $options;
            
        } catch (\Exception $e) {
            log_message('error', 'InsuranceModel::getForSelect - ' . $e->getMessage());
            return ['' => '-- Σφάλμα φόρτωσης --'];
        }
    }
    
    /**
     * Get customers by insurance
     */
    public function getCustomersByInsurance($insuranceId): array
    {
        try {
            $query = $this->db->query("
                SELECT c.id, c.name, c.surname, c.phone, c.email 
                FROM customers c 
                WHERE c.insurance_id = ? 
                ORDER BY c.surname, c.name
            ", [$insuranceId]);
            
            return $query->getResultArray();
            
        } catch (\Exception $e) {
            log_message('error', 'InsuranceModel::getCustomersByInsurance - ' . $e->getMessage());
            return [];
        }
    }
}