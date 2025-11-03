<?php

namespace App\Controllers;

use App\Controllers\BaseCRUD;
use App\Models\GroupModel;
use App\Models\UserModel;

class Groups extends BaseCRUD
{
    protected $modelName = GroupModel::class;
    protected $viewPath = 'groups';
    protected $pageTitle = 'Διαχείριση Ομάδων';
    protected $entityName = 'Ομάδα';
    protected $entityNamePlural = 'Ομάδες';
    
    public function __construct()
    {
        $this->model = new GroupModel();
    }

    /**
     * Display groups index with DataTables
     */
    public function index()
    {
        $data = [
            'title' => $this->pageTitle,
            'entity_name' => $this->entityNamePlural,
            'ajax_url' => site_url('groups/getData'),
            'create_url' => site_url('groups/create'),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => site_url('dashboard')],
                ['title' => $this->pageTitle, 'url' => '']
            ]
        ];

        return view('groups/index', $data);
    }

    /**
     * Get data for DataTables AJAX
     */
    public function getData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        $searchValue = $this->request->getGet('search')['value'] ?? '';
        $start = (int)($this->request->getGet('start') ?? 0);
        $length = (int)($this->request->getGet('length') ?? 10);
        $orderColumnIndex = (int)($this->request->getGet('order')[0]['column'] ?? 0);
        $orderDirection = $this->request->getGet('order')[0]['dir'] ?? 'asc';

        $columns = ['id', 'name', 'description', 'user_count'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'name';

        // Base query with user count
        $builder = $this->model->builder();
        $builder->select('groups.*, COUNT(users.id) as user_count')
                ->join('users', 'users.group_id = groups.id', 'left')
                ->groupBy('groups.id');

        // Search functionality
        if (!empty($searchValue)) {
            $builder->groupStart()
                   ->like('groups.name', $searchValue)
                   ->orLike('groups.description', $searchValue)
                   ->groupEnd();
        }

        // Get total records (before pagination)
        $totalRecords = $this->model->countAll();
        $filteredQuery = clone $builder;
        $filteredRecords = $filteredQuery->countAllResults(false);

        // Apply ordering and pagination
        $builder->orderBy($orderColumn, $orderDirection)
                ->limit($length, $start);

        $records = $builder->get()->getResultArray();

        // Format data for DataTables
        $data = [];
        foreach ($records as $record) {
            $actions = $this->generateActionButtons($record['id']);
            
            // Format user count with badge
            $userCount = (int)$record['user_count'];
            $userCountBadge = $userCount > 0 
                ? '<span class="badge badge-primary">' . $userCount . ' χρήστες</span>'
                : '<span class="badge badge-secondary">Κενή</span>';

            $data[] = [
                'id' => $record['id'],
                'name' => '<strong>' . esc($record['name']) . '</strong>',
                'description' => esc($record['description']) ?: '<em class="text-muted">Χωρίς περιγραφή</em>',
                'user_count' => $userCountBadge,
                'actions' => $actions
            ];
        }

        return $this->response->setJSON([
            'draw' => (int)($this->request->getGet('draw') ?? 1),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data = [
            'title' => 'Νέα ' . $this->entityName,
            'entity_name' => $this->entityName,
            'action_url' => site_url('groups/store'),
            'back_url' => site_url('groups'),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => site_url('dashboard')],
                ['title' => $this->pageTitle, 'url' => site_url('groups')],
                ['title' => 'Νέα ' . $this->entityName, 'url' => '']
            ]
        ];

        return view('groups/create', $data);
    }

    /**
     * Store new group
     */
    public function store()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back()->with('error', 'Μη έγκυρη μέθοδος αιτήματος.');
        }

        $data = $this->request->getPost();
        
        // Validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|max_length[100]|is_unique[groups.name]',
            'description' => 'permit_empty|max_length[255]'
        ]);

        if (!$validation->run($data)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        try {
            $groupId = $this->model->insert($data);
            
            if ($groupId) {
                return redirect()->to('groups')->with('success', 'Η ομάδα δημιουργήθηκε επιτυχώς!');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Σφάλμα κατά τη δημιουργία της ομάδας.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Group creation error: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Σφάλμα κατά τη δημιουργία της ομάδας: ' . $e->getMessage());
        }
    }

    /**
     * Show group details
     */
    public function show($id)
    {
        $group = $this->model->getGroupWithUsers($id);
        
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Η ομάδα με ID $id δεν βρέθηκε");
        }

        $data = [
            'title' => 'Προβολή ' . $this->entityName . ': ' . $group['name'],
            'entity_name' => $this->entityName,
            'record' => $group,
            'edit_url' => site_url('groups/edit/' . $id),
            'back_url' => site_url('groups'),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => site_url('dashboard')],
                ['title' => $this->pageTitle, 'url' => site_url('groups')],
                ['title' => 'Προβολή: ' . $group['name'], 'url' => '']
            ]
        ];

        return view('groups/show', $data);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $group = $this->model->find($id);
        
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Η ομάδα με ID $id δεν βρέθηκε");
        }

        $data = [
            'title' => 'Επεξεργασία ' . $this->entityName . ': ' . $group['name'],
            'entity_name' => $this->entityName,
            'record' => $group,
            'action_url' => site_url('groups/update/' . $id),
            'back_url' => site_url('groups'),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => site_url('dashboard')],
                ['title' => $this->pageTitle, 'url' => site_url('groups')],
                ['title' => 'Επεξεργασία: ' . $group['name'], 'url' => '']
            ]
        ];

        return view('groups/edit', $data);
    }

    /**
     * Update group
     */
    public function update($id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back()->with('error', 'Μη έγκυρη μέθοδος αιτήματος.');
        }

        $group = $this->model->find($id);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Η ομάδα με ID $id δεν βρέθηκε");
        }

        $data = $this->request->getPost();
        
        // Validation with unique check excluding current record
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => "required|max_length[100]|is_unique[groups.name,id,$id]",
            'description' => 'permit_empty|max_length[255]'
        ]);

        if (!$validation->run($data)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        try {
            $success = $this->model->update($id, $data);
            
            if ($success) {
                return redirect()->to('groups')->with('success', 'Η ομάδα ενημερώθηκε επιτυχώς!');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Σφάλμα κατά την ενημέρωση της ομάδας.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Group update error: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Σφάλμα κατά την ενημέρωση της ομάδας: ' . $e->getMessage());
        }
    }

    /**
     * Delete group
     */
    public function delete($id)
    {
        $group = $this->model->find($id);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Η ομάδα με ID $id δεν βρέθηκε");
        }

        // Check if group has users
        $userModel = new UserModel();
        $userCount = $userModel->where('group_id', $id)->countAllResults();
        
        if ($userCount > 0) {
            return redirect()->to('groups')
                           ->with('error', "Δεν μπορείτε να διαγράψετε την ομάδα '{$group['name']}' γιατί έχει ανατεθεί σε {$userCount} χρήστες.");
        }

        try {
            $success = $this->model->delete($id);
            
            if ($success) {
                return redirect()->to('groups')->with('success', "Η ομάδα '{$group['name']}' διαγράφηκε επιτυχώς!");
            } else {
                return redirect()->to('groups')->with('error', 'Σφάλμα κατά τη διαγραφή της ομάδας.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Group deletion error: ' . $e->getMessage());
            return redirect()->to('groups')
                           ->with('error', 'Σφάλμα κατά τη διαγραφή της ομάδας: ' . $e->getMessage());
        }
    }

    /**
     * Check if field value is unique (AJAX)
     */
    public function checkUnique()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        $field = $this->request->getPost('field');
        $value = $this->request->getPost('value');
        $id = $this->request->getPost('id');

        $builder = $this->model->builder();
        $builder->where($field, $value);
        
        if ($id) {
            $builder->where('id !=', $id);
        }

        $count = $builder->countAllResults();
        
        return $this->response->setJSON(['unique' => $count === 0]);
    }

    /**
     * Get group statistics (AJAX)
     */
    public function getStatistics()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        $stats = [
            'total_groups' => $this->model->countAll(),
            'groups_with_users' => $this->model->getGroupsWithUserCount(),
            'empty_groups' => 0
        ];

        // Count empty groups
        foreach ($stats['groups_with_users'] as $group) {
            if ((int)$group['user_count'] === 0) {
                $stats['empty_groups']++;
            }
        }

        return $this->response->setJSON($stats);
    }

    /**
     * Generate action buttons for DataTable rows
     */
    protected function generateActionButtons($id)
    {
        return '
            <div class="btn-group" role="group">
                <a href="' . site_url('groups/show/' . $id) . '" 
                   class="btn btn-info btn-sm" title="Προβολή">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="' . site_url('groups/edit/' . $id) . '" 
                   class="btn btn-warning btn-sm" title="Επεξεργασία">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="' . site_url('groups/delete/' . $id) . '" 
                   class="btn btn-danger btn-sm" title="Διαγραφή"
                   onclick="return confirm(\'Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή την ομάδα;\')">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        ';
    }
}