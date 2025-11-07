<!-- Πωλήσεις Συνολικά -->
<div class="col-lg-3 col-md-6">
    <div class="panel panel-info">
        <div class="panel-heading">
            Μέσος Χρόνος Εκτέλεσης Tasks (<?= $selected_range ?>)
        </div>
        <div class="panel-body">
            <!-- Dropdown για επιλογή εύρους -->
            <form method="get" action="<?= base_url('admin') ?>">
                <div class="form-group">
                    <label for="range">Εύρος Δεδομένων:</label>
                    <select class="form-control" id="range" name="range" onchange="this.form.submit()">
                        <option value="quarter" <?= $selected_range == 'quarter' ? 'selected' : '' ?>>Τρίμηνο</option>
                        <option value="half" <?= $selected_range == 'half' ? 'selected' : '' ?>>Εξάμηνο</option>
                        <option value="year" <?= $selected_range == 'year' ? 'selected' : '' ?>>Έτος</option>
                    </select>
                </div>
            </form>

            <?php $d = $task_duration; ?>
            <p><strong>Order → Day In:</strong> <?= $d['order_to_dayin'] ?> ημέρες</p>
            <p><strong>Τηλ. Ραντεβού → Παράδοση:</strong> <?= $d['tel_to_dayout'] ?> ημέρες</p>
        </div>
    </div>
</div>

<!-- Εκκρεμότητες -->
<div class="col-lg-3 col-md-6">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3"><i class="fa fa-pause fa-5x"></i></div>
                <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo count($tasks) ?></div>
                    <div>Εκκρεμότητες</div>
                </div>
            </div>
        </div>
        <a href="<?= base_url('admin/customers/get_onhold/' . $selling_point->id) ?>">
            <div class="panel-footer">
                <span class="pull-left">Λεπτομέρειες</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>

<!-- Οφειλέτες -->
<div class="col-lg-3 col-md-6">
    <div class="panel panel-red">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3"><i class="fa fa-bomb fa-5x"></i></div>
                <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo $in_debt_customers ?></div>
                    <div>Οφειλέτες</div>
                </div>
            </div>
        </div>
        <a href="<?= base_url('admin/stocks/on_debt/' . $selling_point->id) ?>">
            <div class="panel-footer">
                <span class="pull-left">Λεπτομέρειες</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>

<!-- Επισκευές σε εκκρεμότητα -->
<div class="col-lg-3 col-md-6">
    <div class="panel panel-green">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3"><i class="fa fa-barcode fa-5x"></i></div>
                <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo count($services) ?></div>
                    <div>Επισκευές σε εκκρεμότητα</div>
                </div>
            </div>
        </div>
        <a href="<?= base_url('admin/services') ?>">
            <div class="panel-footer">
                <span class="pull-left">Λεπτομέρειες</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
