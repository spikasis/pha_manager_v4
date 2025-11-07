<?php /* Cleaned panel: dashboard_panel_moulds.php */ ?>
<div class="panel panel-default panel-warning">
    <div class="panel-heading">
        <i class="fa fa-bell fa-fw"></i> Κατασκευές Ανοιχτές
        <span class="pull-right"><strong><?php echo count($moulds) ?></strong></span>
    </div>

    <div class="panel-body">
        <div class="list-group">
            <?php foreach ($moulds as $key => $list):
                $this->load->model(array('admin/customer'));
                $this->load->model(array('admin/stock'));

                $date_now = time();                                
                $customer = $this->customer->get($list['customer_id']);

                if ($customer->selling_point == $selling_point->id):
                    $temp_date = $list['date_order'];                                
                    $delay = $date_now - strtotime($temp_date);
                    $days = round($delay / (60 * 60 * 24));
            ?>                        
            <a href="<?= base_url('admin/earlabs/edit/' . $list['id']) ?>" class="list-group-item">
                <i class="fa fa-tasks fa-fw"></i> <?php echo $customer->name ?>
                <?php if($days > 0 && $days < 10000): ?>
                    <span style="color:blue" class="pull-center text-muted small">
                        <?php echo 'ON LAB FOR ' . $days . ' DAYS!'; ?>
                    </span>
                <?php endif; ?>
                <span class="pull-right text-muted small">
                    <em> από <?php echo $list['date_order'] ?></em>
                </span>
            </a>
            <?php endif; endforeach; ?>                        
        </div>
        <a href="<?= base_url('admin/earlabs/list_open') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
    </div>
</div>
