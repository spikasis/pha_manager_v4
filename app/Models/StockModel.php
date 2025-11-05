<?php

namespace App\Models;

class StockModel extends BaseCRUDModel
{
    protected $table = 'stocks';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name', 'description', 'category', 'manufacturer', 'supplier_id', 
        'sku', 'barcode', 'unit_price', 'cost_price', 'quantity', 
        'min_quantity', 'max_quantity', 'location', 'is_active', 'notes'
    ];
    
    // Validation rules
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'description' => 'permit_empty|max_length[500]',
        'category' => 'permit_empty|max_length[50]',
        'manufacturer' => 'permit_empty|max_length[100]',
        'supplier_id' => 'permit_empty|integer',
        'sku' => 'permit_empty|max_length[50]|is_unique[stocks.sku,id,{id}]',
        'barcode' => 'permit_empty|max_length[50]|is_unique[stocks.barcode,id,{id}]',
        'unit_price' => 'permit_empty|decimal',
        'cost_price' => 'permit_empty|decimal',
        'quantity' => 'required|integer|greater_than_equal_to[0]',
        'min_quantity' => 'permit_empty|integer|greater_than_equal_to[0]',
        'max_quantity' => 'permit_empty|integer|greater_than_equal_to[0]',
        'location' => 'permit_empty|max_length[100]',
        'is_active' => 'in_list[0,1]',
        'notes' => 'permit_empty|max_length[1000]'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Το όνομα του προϊόντος είναι υποχρεωτικό',
            'min_length' => 'Το όνομα πρέπει να έχει τουλάχιστον 2 χαρακτήρες',
            'max_length' => 'Το όνομα δεν μπορεί να ξεπερνά τους 100 χαρακτήρες'
        ],
        'description' => [
            'max_length' => 'Η περιγραφή δεν μπορεί να ξεπερνά τους 500 χαρακτήρες'
        ],
        'category' => [
            'max_length' => 'Η κατηγορία δεν μπορεί να ξεπερνά τους 50 χαρακτήρες'
        ],
        'manufacturer' => [
            'max_length' => 'Ο κατασκευαστής δεν μπορεί να ξεπερνά τους 100 χαρακτήρες'
        ],
        'supplier_id' => [
            'integer' => 'Ο προμηθευτής πρέπει να είναι έγκυρος'
        ],
        'sku' => [
            'max_length' => 'Ο κωδικός SKU δεν μπορεί να ξεπερνά τους 50 χαρακτήρες',
            'is_unique' => 'Αυτός ο κωδικός SKU υπάρχει ήδη'
        ],
        'barcode' => [
            'max_length' => 'Το barcode δεν μπορεί να ξεπερνά τους 50 χαρακτήρες',
            'is_unique' => 'Αυτό το barcode υπάρχει ήδη'
        ],
        'unit_price' => [
            'decimal' => 'Η τιμή πώλησης πρέπει να είναι αριθμός'
        ],
        'cost_price' => [
            'decimal' => 'Η τιμή κόστους πρέπει να είναι αριθμός'
        ],
        'quantity' => [
            'required' => 'Η ποσότητα είναι υποχρεωτική',
            'integer' => 'Η ποσότητα πρέπει να είναι ακέραιος αριθμός',
            'greater_than_equal_to' => 'Η ποσότητα δεν μπορεί να είναι αρνητική'
        ],
        'min_quantity' => [
            'integer' => 'Η ελάχιστη ποσότητα πρέπει να είναι ακέραιος αριθμός',
            'greater_than_equal_to' => 'Η ελάχιστη ποσότητα δεν μπορεί να είναι αρνητική'
        ],
        'max_quantity' => [
            'integer' => 'Η μέγιστη ποσότητα πρέπει να είναι ακέραιος αριθμός',
            'greater_than_equal_to' => 'Η μέγιστη ποσότητα δεν μπορεί να είναι αρνητική'
        ],
        'location' => [
            'max_length' => 'Η τοποθεσία δεν μπορεί να ξεπερνά τους 100 χαρακτήρες'
        ],
        'is_active' => [
            'in_list' => 'Η κατάσταση ενεργοποίησης πρέπει να είναι 0 ή 1'
        ],
        'notes' => [
            'max_length' => 'Οι σημειώσεις δεν μπορούν να ξεπερνούν τους 1000 χαρακτήρες'
        ]
    ];
    
    protected $skipValidation = false;
    
    // Define entity configuration for BaseCRUD
    public function getEntityConfig(): array
    {
        return [
            'name' => 'Stock',
            'plural_name' => 'Stocks', 
            'display_name' => 'Προϊόν Αποθήκης',
            'plural_display_name' => 'Αποθέματα',
            'icon' => 'fas fa-boxes',
            'description' => 'Διαχείριση αποθεμάτων και προϊόντων'
        ];
    }
    
    // Define searchable fields for BaseCRUD
    public function getSearchableFields(): array
    {
        return ['name', 'description', 'sku', 'barcode', 'category', 'manufacturer', 'location'];
    }
    
    // Define display columns for DataTable
    public function getDisplayColumns(): array
    {
        return [
            'id' => ['label' => 'ID', 'type' => 'number'],
            'name' => ['label' => 'Όνομα', 'type' => 'text', 'searchable' => true],
            'sku' => ['label' => 'SKU', 'type' => 'text', 'searchable' => true],
            'category' => ['label' => 'Κατηγορία', 'type' => 'text', 'searchable' => true],
            'manufacturer' => ['label' => 'Κατασκευαστής', 'type' => 'text', 'searchable' => true],
            'quantity' => ['label' => 'Ποσότητα', 'type' => 'number'],
            'unit_price' => ['label' => 'Τιμή', 'type' => 'currency'],
            'location' => ['label' => 'Τοποθεσία', 'type' => 'text', 'searchable' => true],
            'is_active' => ['label' => 'Ενεργό', 'type' => 'boolean']
        ];
    }
    
    // Define form fields for create/edit
    public function getFormFields(): array
    {
        return [
            'name' => [
                'label' => 'Όνομα Προϊόντος',
                'type' => 'text',
                'required' => true,
                'attributes' => [
                    'placeholder' => 'π.χ. Ακουστικό βαρηκοΐας Siemens',
                    'maxlength' => '100'
                ],
                'help' => 'Εισάγετε το όνομα του προϊόντος'
            ],
            'description' => [
                'label' => 'Περιγραφή',
                'type' => 'textarea',
                'required' => false,
                'attributes' => [
                    'placeholder' => 'Λεπτομερής περιγραφή του προϊόντος...',
                    'maxlength' => '500',
                    'rows' => '3'
                ],
                'help' => 'Προαιρετική περιγραφή του προϊόντος'
            ],
            'category' => [
                'label' => 'Κατηγορία',
                'type' => 'select',
                'required' => false,
                'options' => [
                    '' => '-- Επιλέξτε Κατηγορία --',
                    'Ακουστικά Βαρηκοΐας' => 'Ακουστικά Βαρηκοΐας',
                    'Αξεσουάρ Ακουστικών' => 'Αξεσουάρ Ακουστικών',
                    'Μπαταρίες' => 'Μπαταρίες',
                    'Εργαλεία' => 'Εργαλεία',
                    'Υλικά Επισκευής' => 'Υλικά Επισκευής',
                    'Καλούδια' => 'Καλούδια',
                    'Φίλτρα' => 'Φίλτρα',
                    'Άλλο' => 'Άλλο'
                ],
                'help' => 'Κατηγορία του προϊόντος'
            ],
            'manufacturer' => [
                'label' => 'Κατασκευαστής',
                'type' => 'text',
                'required' => false,
                'attributes' => [
                    'placeholder' => 'π.χ. Siemens, Phonak, Widex',
                    'maxlength' => '100'
                ],
                'help' => 'Εταιρία κατασκευής του προϊόντος'
            ],
            'sku' => [
                'label' => 'Κωδικός SKU',
                'type' => 'text',
                'required' => false,
                'attributes' => [
                    'placeholder' => 'π.χ. SIE-001-BTE',
                    'maxlength' => '50'
                ],
                'help' => 'Μοναδικός κωδικός προϊόντος (Stock Keeping Unit)'
            ],
            'barcode' => [
                'label' => 'Barcode',
                'type' => 'text',
                'required' => false,
                'attributes' => [
                    'placeholder' => 'π.χ. 1234567890123',
                    'maxlength' => '50'
                ],
                'help' => 'Barcode του προϊόντος (αν υπάρχει)'
            ],
            'cost_price' => [
                'label' => 'Τιμή Κόστους (€)',
                'type' => 'number',
                'required' => false,
                'attributes' => [
                    'placeholder' => '0.00',
                    'step' => '0.01',
                    'min' => '0'
                ],
                'help' => 'Τιμή αγοράς/κόστους του προϊόντος'
            ],
            'unit_price' => [
                'label' => 'Τιμή Πώλησης (€)',
                'type' => 'number',
                'required' => false,
                'attributes' => [
                    'placeholder' => '0.00',
                    'step' => '0.01',
                    'min' => '0'
                ],
                'help' => 'Τιμή πώλησης του προϊόντος'
            ],
            'quantity' => [
                'label' => 'Τρέχουσα Ποσότητα',
                'type' => 'number',
                'required' => true,
                'attributes' => [
                    'placeholder' => '0',
                    'min' => '0',
                    'step' => '1'
                ],
                'help' => 'Διαθέσιμη ποσότητα στην αποθήκη'
            ],
            'min_quantity' => [
                'label' => 'Ελάχιστη Ποσότητα',
                'type' => 'number',
                'required' => false,
                'attributes' => [
                    'placeholder' => '0',
                    'min' => '0',
                    'step' => '1'
                ],
                'help' => 'Ελάχιστη ποσότητα για ειδοποίηση αναπλήρωσης'
            ],
            'max_quantity' => [
                'label' => 'Μέγιστη Ποσότητα',
                'type' => 'number',
                'required' => false,
                'attributes' => [
                    'placeholder' => '0',
                    'min' => '0',
                    'step' => '1'
                ],
                'help' => 'Μέγιστη ποσότητα αποθήκης'
            ],
            'location' => [
                'label' => 'Τοποθεσία Αποθήκης',
                'type' => 'text',
                'required' => false,
                'attributes' => [
                    'placeholder' => 'π.χ. Ράφι A1, Συρτάρι B3',
                    'maxlength' => '100'
                ],
                'help' => 'Θέση του προϊόντος στην αποθήκη'
            ],
            'is_active' => [
                'label' => 'Ενεργό Προϊόν',
                'type' => 'select',
                'required' => true,
                'options' => [
                    '1' => 'Ναι',
                    '0' => 'Όχι'
                ],
                'attributes' => [
                    'value' => '1'
                ],
                'help' => 'Ορίστε αν το προϊόν είναι διαθέσιμο για χρήση'
            ],
            'notes' => [
                'label' => 'Σημειώσεις',
                'type' => 'textarea',
                'required' => false,
                'attributes' => [
                    'placeholder' => 'Επιπλέον σημειώσεις για το προϊόν...',
                    'maxlength' => '1000',
                    'rows' => '4'
                ],
                'help' => 'Προαιρετικές σημειώσεις και παρατηρήσεις'
            ]
        ];
    }
    
    /**
     * Get inventory statistics
     */
    public function getInventoryStats(): array
    {
        $stats = [];
        
        try {
            // Total products
            $stats['total_products'] = $this->countAllResults();
            
            // Active products
            $stats['active_products'] = $this->where('is_active', 1)->countAllResults(false);
            
            // Low stock items (quantity <= min_quantity)
            $stats['low_stock'] = $this->db->query("
                SELECT COUNT(*) as count 
                FROM stocks 
                WHERE quantity <= min_quantity 
                AND min_quantity > 0 
                AND is_active = 1
            ")->getRowArray()['count'];
            
            // Out of stock items
            $stats['out_of_stock'] = $this->where(['quantity' => 0, 'is_active' => 1])->countAllResults(false);
            
            // Total inventory value (cost price * quantity)
            $totalValue = $this->db->query("
                SELECT SUM(cost_price * quantity) as total_value 
                FROM stocks 
                WHERE is_active = 1
            ")->getRowArray();
            
            $stats['inventory_value'] = $totalValue['total_value'] ? round($totalValue['total_value'], 2) : 0;
            
            // Average price
            $avgPrice = $this->db->query("
                SELECT AVG(unit_price) as avg_price 
                FROM stocks 
                WHERE unit_price > 0 AND is_active = 1
            ")->getRowArray();
            
            $stats['avg_price'] = $avgPrice['avg_price'] ? round($avgPrice['avg_price'], 2) : 0;
            
        } catch (\Exception $e) {
            log_message('error', 'StockModel::getInventoryStats - ' . $e->getMessage());
            $stats = [
                'total_products' => 0,
                'active_products' => 0,
                'low_stock' => 0,
                'out_of_stock' => 0,
                'inventory_value' => 0,
                'avg_price' => 0
            ];
        }
        
        return $stats;
    }
    
    /**
     * Get low stock items
     */
    public function getLowStockItems(): array
    {
        try {
            return $this->db->query("
                SELECT id, name, quantity, min_quantity, location
                FROM stocks 
                WHERE quantity <= min_quantity 
                AND min_quantity > 0 
                AND is_active = 1
                ORDER BY (quantity - min_quantity) ASC, name ASC
            ")->getResultArray();
            
        } catch (\Exception $e) {
            log_message('error', 'StockModel::getLowStockItems - ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get products by category
     */
    public function getProductsByCategory(): array
    {
        try {
            return $this->db->query("
                SELECT 
                    COALESCE(category, 'Χωρίς Κατηγορία') as category,
                    COUNT(*) as count,
                    SUM(quantity) as total_quantity
                FROM stocks 
                WHERE is_active = 1 
                GROUP BY category 
                ORDER BY count DESC
            ")->getResultArray();
            
        } catch (\Exception $e) {
            log_message('error', 'StockModel::getProductsByCategory - ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Update stock quantity
     */
    public function updateQuantity(int $id, int $newQuantity, string $reason = ''): bool
    {
        try {
            $stock = $this->find($id);
            if (!$stock) {
                return false;
            }
            
            // Update quantity
            $result = $this->update($id, ['quantity' => $newQuantity]);
            
            // Log the change (optional - could create stock_movements table)
            if ($result && !empty($reason)) {
                log_message('info', "Stock quantity updated - ID: {$id}, Old: {$stock['quantity']}, New: {$newQuantity}, Reason: {$reason}");
            }
            
            return $result;
            
        } catch (\Exception $e) {
            log_message('error', 'StockModel::updateQuantity - ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if product needs restocking
     */
    public function needsRestocking(int $id): bool
    {
        try {
            $stock = $this->find($id);
            
            if (!$stock || !$stock['is_active']) {
                return false;
            }
            
            return $stock['min_quantity'] > 0 && $stock['quantity'] <= $stock['min_quantity'];
            
        } catch (\Exception $e) {
            log_message('error', 'StockModel::needsRestocking - ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get products for select dropdown
     */
    public function getForSelect(): array
    {
        try {
            $products = $this->select('id, name, sku, quantity')
                            ->where('is_active', 1)
                            ->orderBy('name', 'ASC')
                            ->findAll();
            
            $options = ['' => '-- Επιλέξτε Προϊόν --'];
            
            foreach ($products as $product) {
                $displayName = $product['name'];
                if (!empty($product['sku'])) {
                    $displayName .= ' (' . $product['sku'] . ')';
                }
                $displayName .= ' - Διαθέσιμα: ' . $product['quantity'];
                
                $options[$product['id']] = $displayName;
            }
            
            return $options;
            
        } catch (\Exception $e) {
            log_message('error', 'StockModel::getForSelect - ' . $e->getMessage());
            return ['' => '-- Σφάλμα φόρτωσης --'];
        }
    }
}