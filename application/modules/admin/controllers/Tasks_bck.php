<?php

class Tasks extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/task'));   
        $this->load->model(array('admin/customer'));
    }

    public function index() {
        $task = $this->task->get_all();        

        $data['tasks'] = $task;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "tasks_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
    if ($this->input->post('client')) {
        $data['client'] = $this->input->post('client');
        
        // Αυτόματη εισαγωγή της τρέχουσας ημερομηνίας και ώρας
        $data['entry_date'] = date('Y-m-d H:i:s'); 
        
        // Χειρισμός checkbox (αν δεν είναι επιλεγμένο επιστρέφει 0)
        $data['scan'] = $this->input->post('scan') ? 1 : 0;
        $data['order'] = $this->input->post('order');
        $data['gnomateusi'] = $this->input->post('gnomateusi') ? 1 : 0;
        $data['receive'] = $this->input->post('receive') ? 1 : 0;
        $data['tel_rdv'] = $this->input->post('tel_rdv') ? 1 : 0;
        $data['ektelesi'] = $this->input->post('ektelesi') ? 1 : 0;
        $data['paradosi'] = $this->input->post('paradosi') ? 1 : 0;
        $data['signatures'] = $this->input->post('signatures') ? 1 : 0;
        $data['receipt'] = $this->input->post('receipt') ? 1 : 0;
        $data['arxeio'] = $this->input->post('arxeio') ? 1 : 0;
        
        // Εισαγωγή στη βάση δεδομένων
        $this->task->insert($data);

        // Ανακατεύθυνση στη λίστα των tasks
        redirect('/admin/tasks', 'refresh');
    }
    
    $data['clients'] = $this->customer->get_all();

    // Φόρτωση του view
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "tasks_create";
    $this->load->view($this->_container, $data);
}

    

    public function edit($id) {
    // Αν έχει υποβληθεί η φόρμα
    if ($this->input->post('client')) {
        $data['client'] = $this->input->post('client');
        $data['entry_date'] = $this->input->post('entry_date');
        $data['scan'] = $this->input->post('scan');
        $data['order'] = $this->input->post('order');
        $data['gnomateusi'] = $this->input->post('gnomateusi');
        $data['receive'] = $this->input->post('receive');            
        $data['tel_rdv'] = $this->input->post('tel_rdv');
        $data['ektelesi'] = $this->input->post('ektelesi');
        $data['paradosi'] = $this->input->post('paradosi');
        $data['signatures'] = $this->input->post('signatures');
        $data['receipt'] = $this->input->post('receipt');
        $data['arxeio'] = $this->input->post('arxeio');
        
        // Ενημέρωση της εγγραφής
        $this->task->update($data, $id);

        // Ανακατεύθυνση στη λίστα των tasks
        redirect('/admin/tasks', 'refresh');
    }

    // Αν δεν έχει υποβληθεί η φόρμα, ανάκτησε τα δεδομένα της task για το συγκεκριμένο ID
    $data['task'] = $this->task->get($id); // Ανακτάς τα δεδομένα του task
    $data['clients'] = $this->customer->get_all();

    // Φόρτωση της σελίδας επεξεργασίας με τα δεδομένα της task
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "tasks_edit";
    $this->load->view($this->_container, $data);
}

    public function delete($id) {
        $this->task->delete($id);

        redirect('/admin/tasks', 'refresh');
    }

}
