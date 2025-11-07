<?php /* Cleaned panel: dashboard_panel_barcodes.php */ ?>
<div class="panel panel-default panel-danger">
    <div class="panel-heading">
        <i class="fa fa-barcode fa-fw"></i> Εκκρεμότητες Barcodes
        <span class="pull-right"><strong><?php echo count($stock_bc) ?></strong></span>
    </div>

    <div class="panel-body">
        <div class="list-group">
            <?php foreach ($stock_bc as $key => $list):
                $this->load->model(array('admin/customer'));
                $this->load->model(array('admin/stock'));
                $this->load->model(array('admin/vendor'));
                $this->load->model(array('admin/model'));

                $date_now = time();                                
                $vendor = $this->vendor->get($list['vendor']);
                $model = $this->model->get($list['ha_model']);
                $temp_date = $list['day_in'];                                
                $delay = $date_now - strtotime($temp_date);
                $days = round($delay / (60 * 60 * 24));
            ?>                        
            <a href="<?= base_url('admin/stocks/edit/' . $list['id']) ?>" class="list-group-item">
                <i class="fa fa-tasks fa-fw"></i> 
                <?php echo $model->model ?>-<?php echo $list['serial'] ?> - <?php echo $vendor->name ?>
                <?php if($days > 0 && $days < 10000): ?>
                    <span class="text-muted small" style="color:red">
                        <?= 'delay ' . $days . ' DAYS!' ?>
                    </span>
                <?php endif; ?>
                <span class="pull-right text-muted small">
                    <em> από <?php echo $list['day_in'] ?></em>
                </span>
            </a>
            <?php endforeach; ?>                        
        </div>
        <a href="<?= base_url('admin/earlabs') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
    </div>
</div>
