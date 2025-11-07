<?php /* Cleaned panel: dashboard_panel_on_hold.php */ ?>
<div class="panel panel-default panel-primary">
    <div class="panel-heading">
        <i class="fa fa-bell fa-fw"></i> Σε Εκκρεμότητα
    </div>

    <div class="panel-body" id="panel-body">
        <div class="list-group">
            <?php foreach ($on_hold_names as $key => $list): ?>
                <?php  
                    $this->load->model(array('admin/doctor'));
                    $doc_id = $this->doctor->get($list['doctor']);
                ?>
                <a href="<?= base_url('admin/customers/view/' . $list['id']) ?>" class="list-group-item">
                    <i class="fa fa-tasks fa-fw"></i> <?php echo $list['name'] ?>
                    <span class="pull-right text-muted small"><em><?php echo $doc_id->doc_name ?></em></span>
                </a>
            <?php endforeach; ?>                        
        </div>
        <!-- <a href="<?= base_url('admin/customers/get_onhold') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a> -->
    </div>
</div>
