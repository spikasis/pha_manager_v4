<?php /* Cleaned panel: dashboard_panel_debts.php */ ?>
<div class="panel panel-default panel-danger">
    <div class="panel-heading">
        <i class="fa fa-bell fa-fw"></i> Εκκρεμότητες Δόσεων
        <span class="pull-right"><strong>€ <?php echo $sum_debt[0]['data'] ?></strong></span>
        <button type="button" class="btn btn-default btn-xs dropdown-toggle" onclick="hideFunction('panel-body-debt')" style="float: right; margin-right: 10px;">Εμφάνιση</button>
    </div>

    <div class="panel-body" id="panel-body-debt" hidden="false">
        <div class="list-group">
            <?php foreach ($stock_debt as $key => $list): ?>
                <?php  
                    $this->load->model(array('admin/customer'));
                    $this->load->model(array('admin/pay'));
                    $this->load->model(array('admin/stock'));
                    $date_now = time();
                    
                    $hearing_aid_id = $this->stock->get($list['id']);
                    $name = $this->customer->get($hearing_aid_id->customer_id);                                
                    $temp_date = $this->pay->get_all('MAX(date) AS last_pay', ' customer=' . $name->id);                                
                    $delay = $date_now - strtotime($temp_date[0]['last_pay']);
                    $days = round($delay / (60 * 60 * 24));
                ?>                        
                <a href="<?= base_url('admin/stocks/pays/' . $list['id']) ?>" class="list-group-item">
                    <i class="fa fa-tasks fa-fw"></i> <?php echo $name->name ?>
                    <?php if ($days > 30 && $days < 10000): ?>
                        <span class="badge bg-warning text-muted small" style="color:white">
                            <?= 'DELAYED ' . $days . ' DAYS!' ?>
                        </span>
                    <?php elseif ($days > 10000): ?>
                        <span class="text-muted small" style="color:red">
                            <?= 'NOT PAYED YET' ?>
                        </span>
                    <?php endif; ?>
                    <span class="pull-right text-muted small"> 
                        <em> € <?php echo $list['balance'] ?> </em>
                    </span>
                </a>
            <?php endforeach; ?>                        
        </div>
        <!-- <a href="<?= base_url('admin/customers/get_all_pays') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a> -->
    </div>
</div>
