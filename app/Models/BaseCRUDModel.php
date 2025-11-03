<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Base CRUD Model
 * 
 * This class provides standard database operations that can be extended by specific models.
 * It includes search functionality, soft deletes support, and consistent timestamp handling.
 */
class BaseCRUDModel extends Model
{
    // Common model configuration
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
    
    // Common validation rules (can be extended by child models)
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Search functionality for DataTables
     * 
     * @param string $search Search term
     * @return $this
     */
    public function search($search)
    {
        if (empty($search)) {
            return $this;
        }
        
        // Get searchable fields (all text fields by default)
        $searchableFields = $this->getSearchableFields();
        
        if (empty($searchableFields)) {
            return $this;
        }
        
        $this->groupStart();
        foreach ($searchableFields as $field) {
            $this->orLike($field, $search);
        }
        $this->groupEnd();
        
        return $this;
    }
    
    /**
     * Get searchable fields for the model
     * Should be overridden in child models to specify which fields are searchable
     * 
     * @return array
     */
    protected function getSearchableFields()
    {
        // Get all fields from the table
        $fields = $this->db->getFieldNames($this->table);
        
        // Filter out non-searchable field types
        $searchableFields = [];
        foreach ($fields as $field) {
            $fieldData = $this->db->getFieldData($this->table);
            foreach ($fieldData as $data) {
                if ($data->name === $field) {
                    // Include varchar, text, and similar string fields
                    if (in_array($data->type, ['varchar', 'text', 'char', 'mediumtext', 'longtext'])) {
                        $searchableFields[] = $field;
                    }
                    break;
                }
            }
        }
        
        return $searchableFields;
    }
    
    /**
     * Get records with relationships
     * 
     * @param array $with Relationships to load
     * @return array
     */
    public function getWithRelations($with = [])
    {
        $query = $this->select($this->table . '.*');
        
        foreach ($with as $relation => $config) {
            if (is_string($config)) {
                // Simple relation: 'table' => 'foreign_key'
                $query->join($relation, $this->table . '.' . $config . ' = ' . $relation . '.id', 'left');
            } elseif (is_array($config)) {
                // Complex relation with custom join conditions
                $table = $config['table'] ?? $relation;
                $localKey = $config['local_key'] ?? 'id';
                $foreignKey = $config['foreign_key'] ?? $relation . '_id';
                $joinType = $config['type'] ?? 'left';
                
                $query->join($table, $this->table . '.' . $localKey . ' = ' . $table . '.' . $foreignKey, $joinType);
            }
        }
        
        return $query->findAll();
    }
    
    /**
     * Get paginated results
     * 
     * @param int $perPage Records per page
     * @param int $page Current page
     * @return array
     */
    public function getPaginated($perPage = 20, $page = 1)
    {
        $offset = ($page - 1) * $perPage;
        
        return [
            'data' => $this->findAll($perPage, $offset),
            'total' => $this->countAllResults(false),
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($this->countAllResults(false) / $perPage)
        ];
    }
    
    /**
     * Get records for dropdown/select options
     * 
     * @param string $valueField Field to use as option value
     * @param string $textField Field to use as option text
     * @param array $where Additional where conditions
     * @return array
     */
    public function getForDropdown($valueField = 'id', $textField = 'name', $where = [])
    {
        $query = $this->select($valueField . ', ' . $textField);
        
        if (!empty($where)) {
            $query->where($where);
        }
        
        $results = $query->findAll();
        $options = [];
        
        foreach ($results as $row) {
            $options[$row[$valueField]] = $row[$textField];
        }
        
        return $options;
    }
    
    /**
     * Soft delete record (if soft deletes are enabled)
     * 
     * @param mixed $id
     * @return bool
     */
    public function softDelete($id)
    {
        if (!$this->useSoftDeletes) {
            return $this->delete($id);
        }
        
        return $this->update($id, [$this->deletedField => date('Y-m-d H:i:s')]);
    }
    
    /**
     * Restore soft deleted record
     * 
     * @param mixed $id
     * @return bool
     */
    public function restore($id)
    {
        if (!$this->useSoftDeletes) {
            return false;
        }
        
        return $this->update($id, [$this->deletedField => null]);
    }
    
    /**
     * Get only soft deleted records
     * 
     * @return array
     */
    public function onlyDeleted()
    {
        if (!$this->useSoftDeletes) {
            return [];
        }
        
        return $this->where($this->deletedField . ' IS NOT NULL')->findAll();
    }
    
    /**
     * Validate data before insert/update
     * 
     * @param array $data
     * @return bool
     */
    public function validateData($data)
    {
        if (empty($this->validationRules)) {
            return true;
        }
        
        $validation = \Config\Services::validation();
        $validation->setRules($this->validationRules, $this->validationMessages);
        
        return $validation->run($data);
    }
    
    /**
     * Get validation errors
     * 
     * @return array
     */
    public function getValidationErrors()
    {
        $validation = \Config\Services::validation();
        return $validation->getErrors();
    }
    
    /**
     * Batch insert with validation
     * 
     * @param array|null $set
     * @param bool|null $escape
     * @param int $batchSize
     * @param bool $testing
     * @return bool|int
     */
    public function insertBatch(array $set = null, bool $escape = null, int $batchSize = 100, bool $testing = false)
    {
        if (empty($set)) {
            return false;
        }
        
        // Validate each record if validation rules are set
        if (!empty($this->validationRules)) {
            foreach ($set as $row) {
                if (!$this->validateData($row)) {
                    return false;
                }
            }
        }
        
        return parent::insertBatch($set, $escape, $batchSize, $testing);
    }
    
    /**
     * Count records with conditions
     * 
     * @param array $where
     * @return int
     */
    public function countWhere($where = [])
    {
        if (!empty($where)) {
            $this->where($where);
        }
        
        return $this->countAllResults(false);
    }
    
    /**
     * Check if record exists
     * 
     * @param mixed $id
     * @return bool
     */
    public function exists($id)
    {
        return $this->find($id) !== null;
    }
    
    /**
     * Get the next auto-increment value
     * 
     * @return int
     */
    public function getNextId()
    {
        $query = $this->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '{$this->table}'");
        $result = $query->getRow();
        
        return $result ? (int)$result->AUTO_INCREMENT : 1;
    }
}