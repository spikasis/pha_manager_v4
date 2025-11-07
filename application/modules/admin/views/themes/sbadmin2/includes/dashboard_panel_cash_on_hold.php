<?php /* Cleaned panel: dashboard_panel_cash_on_hold.php */ ?>
<div class="panel panel-default panel-success">
    <div class="panel-heading">
        <i class="fa fa-bell fa-fw"></i> Προς Παράδοση - Είσπραξη
        <span class="pull-right"><strong>€ <?php echo $sum_debt_on_hold[0]['data'] ?></strong></span>
    </div>

    <div class="panel-body">
        <div class="list-group">
            <?php foreach ($on_hold_debt as $key => $list): ?>
                <?php  
                    $this->load->model(array('admin/customer'));
                    $name = $this->customer->get($list['customer_id']);
                ?>
                <a href="<?= base_url('admin/stocks/pays/' . $list['id']) ?>" class="list-group-item">
                    <i class="fa fa-tasks fa-fw"></i> <?php echo $name->name ?>
                    <span class="pull-right text-muted small">
                        <em>€<?php echo $list['balance'] ?></em>
                    </span>
                </a>
            <?php endforeach; ?>                        
        </div>
        <!-- <a href="<?= base_url('admin/customers/get_all_pays') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a> -->
    </div>
</div>
