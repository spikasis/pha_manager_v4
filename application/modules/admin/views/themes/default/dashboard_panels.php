<?php
/**
 * Dashboard Panels Partial View
 * Περιλαμβάνει:
 * - Εργασίες με progress bar
 * - Εκκρεμότητες ανά γιατρό
 * - Επισκευές και Κατασκευές
 * - Οφειλές και Χρέη
 * - Εκκρεμή barcodes
 */
?>

<div class="col-lg-3">
    <div class="panel panel-default panel-primary">
        <div class="panel-heading"><i class="fa fa-bell fa-fw"></i> Ανοιχτές Εργασίες</div>
        <div class="panel-body">
            <div class="list-group">
                <?php foreach($tasks as $task): ?>
                    <a href="<?= base_url('admin/customers/view/' . $task['client']) ?>" class="list-group-item">
                        <i class="fa fa-tasks fa-fw"></i> <?= htmlspecialchars($task['customer_name']) ?>
                        <span class="badge pull-right"><?= $task['status_text'] ?></span>
                    </a>
                    <div class="progress">
                        <div class="progress-bar progress-bar-<?= $task['status_class'] ?>" 
                             role="progressbar" 
                             style="width: <?= $task['progress'] ?>%;"
                             aria-valuenow="<?= $task['progress'] ?>" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            <?= round($task['progress']) ?>% 
                            <?php if ($task['progress'] > 0): ?>
                                <small>(<?= $task['progress'] == 100 ? '✓' : round($task['progress'] / 100 * 7) . '/7' ?>)</small>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="<?= base_url('admin/tasks/filtered_tasks/' . $sp_id) ?>" class="btn btn-default btn-block">Όλες οι εργασίες</a>
        </div>
    </div>
</div>

<div class="col-lg-3">
    <div class="panel panel-default panel-primary">
        <div class="panel-heading"><i class="fa fa-bell fa-fw"></i> Σε Εκκρεμότητα</div>
        <div class="panel-body">
            <div class="list-group">
                <?php foreach ($on_hold_names as $list): ?>
                    <?php $doctor = $this->doctor->get($list['doctor']); ?>
                    <a href="<?= base_url('admin/customers/view/' . $list['id']) ?>" class="list-group-item">
                        <i class="fa fa-tasks fa-fw"></i> <?= htmlspecialchars($list['name']) ?>
                        <span class="pull-right text-muted small"><em><?= htmlspecialchars($doctor->doc_name) ?></em></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3">
    <div class="panel panel-default panel-warning">
        <div class="panel-heading"><i class="fa fa-bell fa-fw"></i> Επισκευές Ανοιχτές <span class="pull-right"><strong><?= count($services) ?></strong></span></div>
        <div class="panel-body">
            <div class="list-group">
                <?php foreach ($services as $list): ?>
                    <?php
                    $ha_service = $this->stock->get($list['ha_service']);
                    $customer = $this->customer->get($ha_service->customer_id);
                    if ($ha_service->selling_point != $selling_point->id) continue;
                    $days = round((time() - strtotime($list['day_in'])) / 86400);
                    ?>
                    <a href="<?= base_url('admin/services/edit/' . $list['id']) ?>" class="list-group-item">
                        <i class="fa fa-wrench fa-fw"></i> <?= htmlspecialchars($customer->name) ?>
                        <?php if ($days > 0 && $days < 10000): ?>
                            <span class="pull-center text-muted small" style="color:blue">ON SERVICE FOR <?= $days ?> DAYS!</span>
                        <?php endif; ?>
                        <span class="pull-right text-muted small"><em>από <?= $list['day_in'] ?></em></span>
                    </a>
                <?php endforeach; ?>
            </div>
            <a href="<?= base_url('admin/services/list_open') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
        </div>
    </div>

    <div class="panel panel-default panel-warning">
        <div class="panel-heading"><i class="fa fa-bell fa-fw"></i> Κατασκευές Ανοιχτές <span class="pull-right"><strong><?= count($moulds) ?></strong></span></div>
        <div class="panel-body">
            <div class="list-group">
                <?php foreach ($moulds as $list): ?>
                    <?php
                    $customer = $this->customer->get($list['customer_id']);
                    if ($customer->selling_point != $selling_point->id) continue;
                    $days = round((time() - strtotime($list['date_order'])) / 86400);
                    ?>
                    <a href="<?= base_url('admin/earlabs/edit/' . $list['id']) ?>" class="list-group-item">
                        <i class="fa fa-cogs fa-fw"></i> <?= htmlspecialchars($customer->name) ?>
                        <?php if ($days > 0 && $days < 10000): ?>
                            <span class="pull-center text-muted small" style="color:blue">ON LAB FOR <?= $days ?> DAYS!</span>
                        <?php endif; ?>
                        <span class="pull-right text-muted small"><em>από <?= $list['date_order'] ?></em></span>
                    </a>
                <?php endforeach; ?>
            </div>
            <a href="<?= base_url('admin/earlabs/list_open') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
        </div>
    </div>
</div>

<div class="col-lg-3">
    <div class="panel panel-default panel-danger">
        <div class="panel-heading">
            <i class="fa fa-bell fa-fw"></i> Εκκρεμότητες Δόσεων <span class="pull-right"><strong>€ <?= $sum_debt[0]['data'] ?></strong></span>
            <button type="button" class="btn btn-default btn-xs float-right" onclick="toggleVisibility('panel-body-debt')">Εμφάνιση</button>
        </div>
        <div class="panel-body" id="panel-body-debt" style="display: none;">
            <div class="list-group">
                <?php foreach ($stock_debt as $list): ?>
                    <?php
                    $ha = $this->stock->get($list['id']);
                    $customer = $this->customer->get($ha->customer_id);
                    $last_pay = $this->pay->get_all('MAX(date) AS last_pay', 'customer=' . $customer->id);
                    $days = round((time() - strtotime($last_pay[0]['last_pay'])) / 86400);
                    ?>
                    <a href="<?= base_url('admin/stocks/pays/' . $list['id']) ?>" class="list-group-item">
                        <i class="fa fa-euro fa-fw"></i> <?= htmlspecialchars($customer->name) ?>
                        <?php if ($days > 30 && $days < 10000): ?>
                            <span class="badge bg-warning">Καθυστέρηση <?= $days ?> ημέρες</span>
                        <?php elseif ($days > 10000): ?>
                            <span class="text-danger">Δεν έχει πληρωθεί</span>
                        <?php endif; ?>
                        <span class="pull-right text-muted small"><em>€ <?= $list['balance'] ?></em></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-danger">
        <div class="panel-heading"><i class="fa fa-bell fa-fw"></i> Εκκρεμότητες Barcodes <span class="pull-right"><strong><?= count($stock_bc) ?></strong></span></div>
        <div class="panel-body">
            <div class="list-group">
                <?php foreach ($stock_bc as $list): ?>
                    <?php
                    $vendor = $this->vendor->get($list['vendor']);
                    $model = $this->model->get($list['ha_model']);
                    $days = round((time() - strtotime($list['day_in'])) / 86400);
                    ?>
                    <a href="<?= base_url('admin/stocks/edit/' . $list['id']) ?>" class="list-group-item">
                        <i class="fa fa-barcode fa-fw"></i> <?= htmlspecialchars($model->model) ?> - <?= htmlspecialchars($list['serial']) ?> - <?= htmlspecialchars($vendor->name) ?>
                        <?php if ($days > 0 && $days < 10000): ?>
                            <span class="pull-center text-muted small" style="color:red">Καθυστέρηση <?= $days ?> ημέρες</span>
                        <?php endif; ?>
                        <span class="pull-right text-muted small"><em>από <?= $list['day_in'] ?></em></span>
                    </a>
                <?php endforeach; ?>
            </div>
            <a href="<?= base_url('admin/earlabs') ?>" class="btn btn-default btn-block">Όλες οι εκκρεμότητες</a>
        </div>
    </div>

    <div class="panel panel-default panel-success">
        <div class="panel-heading"><i class="fa fa-bell fa-fw"></i> Προς Παράδοση - Είσπραξη <span class="pull-right"><strong>€ <?= $sum_debt_on_hold[0]['data'] ?></strong></span></div>
        <div class="panel-body">
            <div class="list-group">
                <?php foreach ($on_hold_debt as $list): ?>
                    <?php $customer = $this->customer->get($list['customer_id']); ?>
                    <a href="<?= base_url('admin/stocks/pays/' . $list['id']) ?>" class="list-group-item">
                        <i class="fa fa-money fa-fw"></i> <?= htmlspecialchars($customer->name) ?>
                        <span class="pull-right text-muted small"><em>€<?= $list['balance'] ?></em></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
