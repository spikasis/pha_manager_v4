<?php /* Cleaned panel: dashboard_panel_repairs.php */ ?>
<div class="panel panel-default panel-warning">
    <div class="panel-heading">
        <i class="fa fa-bell fa-fw"></i> Επισκευές Ανοιχτές
        <span class="pull-right"><strong><?php echo count($services) ?></strong></span>
    </div>

    <div class="panel-body">
        <div class="list-group">
            <?php foreach ($services as $key => $list):
                $this->load->model(array('admin/customer'));
                $this->load->model(array('admin/stock'));
                $date_now = time();

                $ha_service = $this->stock->get($list['ha_service']);
                $name = $this->customer->get($ha_service->customer_id); 

                if ($ha_service->selling_point == $selling_point->id):
                    $temp_date = $list['day_in'];                                
                    $delay = $date_now - strtotime($temp_date);
                    $days = round($delay / (60 * 60 * 24));
            ?>
            <a href="<?= base_url('admin/services/edit/' . $list['id']) ?>" class="list-group-item">
                <i class="fa fa-tasks fa-fw"></i> <?php echo $name->name ?>
                <?php if($days > 0 && $days < 10000): ?>
                    <span style="color:blue" class="pull-center text-muted small">
                        <?php echo 'ON SERVICE FOR ' . $days . ' DAYS!'; ?>
                    </span>
                <?php endif; ?>
                <span class="pull-right text-muted small">
                    <em> από <?php echo $list['day_in'] ?></em>
                </span>
            </a>
            <?php endif; endforeach; ?>                        
        </div>
        <a href="<?= base_url('admin/services/list_open') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
    </div>
</div>
