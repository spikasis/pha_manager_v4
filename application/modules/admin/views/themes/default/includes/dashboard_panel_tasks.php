<?php /* Panel: Ανοιχτές Εργασίες */ ?>
<div class="panel panel-default panel-primary">
    <div class="panel-heading">
        <i class="fa fa-bell fa-fw"></i> Ανοιχτές Εργασίες
    </div>
    <div class="panel-body" id="panel-body">
        <div class="list-group">
            <?php foreach($tasks as $task): ?> 
            <a href="<?= base_url('admin/customers/view/' . $task['client']) ?>" class="list-group-item">
                <i class="fa fa-tasks fa-fw"></i> <?= $task['customer_name']; ?>
            </a>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: <?= $task['progress']; ?>%;" aria-valuenow="<?= $task['progress']; ?>" aria-valuemin="0" aria-valuemax="100">
                    <?= round($task['progress']) ?>% 
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <a href="<?= base_url('admin/tasks/filtered_tasks/' . $sp_id) ?>" class="btn btn-default btn-block">Όλες οι εργασίες</a>
    </div>
</div>
