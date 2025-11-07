<!-- Ανασχεδιασμένο και εργονομικά οργανωμένο Dashboard View -->
<div id="page-wrapper">
<div class="row">
  <div class="col-md-3">
    <form method="get" class="panel panel-default" style="padding: 15px;">
      <h4>Φίλτρα</h4>

      <div class="form-group">
        <label for="year">Έτος</label>
        <select name="year" id="year" class="form-control">
          <?php foreach ($years as $y): ?>
            <option value="<?php echo $y; ?>" <?php echo ($y == $year ? 'selected' : ''); ?>><?php echo $y; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="sp">Υποκατάστημα</label>
        <select name="sp" id="sp" class="form-control">
          <option value="">Όλα</option>
          <?php foreach ($selling_points as $point): ?>
            <option value="<?php echo $point->id; ?>" <?php echo ($point->id == $sp ? 'selected' : ''); ?>><?php echo $point->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="type">Τύπος Ακουστικού</label>
        <select name="type" id="type" class="form-control">
          <option value="">Όλοι</option>
          <?php foreach ($types as $type): ?>
            <option value="<?php echo $type; ?>" <?php echo ($type == $ha_type ? 'selected' : ''); ?>><?php echo $type; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="status">Κατάσταση</label>
        <select name="status" id="status" class="form-control">
          <option value="">Όλες</option>
          <?php foreach ($statuses as $k => $v): ?>
            <option value="<?php echo $k; ?>" <?php echo ($k == $status_filter ? 'selected' : ''); ?>><?php echo $v; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Εφαρμογή</button>
      <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-default btn-block">Καθαρισμός</a>
    </form>
  </div>

  <div class="col-md-9">
    <!-- Dashboard Panels -->
    <div class="row" style="margin-top: 20px;">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">Πωλήσεις τρέχοντος έτους</div>
            <div class="panel-body text-center">
                <h3><?php echo $current_sales ; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading text-center">Εκκρεμότητες</div>
            <div class="panel-body text-center">
                <h3><?php echo is_array($on_hold) ? count($on_hold) : 0; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-danger">
            <div class="panel-heading text-center">Πελάτες με υπόλοιπο</div>
            <div class="panel-body text-center">
                <h3><?php echo $in_debt_customers ; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-success">
            <div class="panel-heading text-center">Διαθέσιμα Ακουστικά</div>
            <div class="panel-body text-center">
                <h3><?php echo $stock_available ; ?></h3>
            </div>
        </div>
    </div>
</div>

    <!-- Εδώ θα εμφανίζονται τα γραφήματα -->
    <div id="year-general" style="height: 180px;"></div>
    <div id="chart-this-year" style="height: 180px;"></div>
    <div class="row">
      <div class="col-sm-6">
        <div id="brand-share-chart" style="height: 180px;"></div>
      </div>
      <div class="col-sm-6">
        <div id="vendor-share-chart" style="height: 180px;"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div id="doctor-chart" style="height: 180px;"></div>
      </div>
    </div>
  </div>
</div>

<script>
new Morris.Bar({
  element: 'year-general',
  data: <?= json_encode($statistics_general) ?>,
  xkey: 'year',
  ykeys: ['sales', 'nosales'],
  labels: ['Πωλήσεις', 'Χαμένες'],
});

new Morris.Bar({
  element: 'chart-this-year',
  data: <?= json_encode($this_year) ?>,
  xkey: 'month',
  ykeys: ['data'],
  labels: ['Πωλήσεις']
});

Morris.Donut({
  element: 'brand-share-chart',
  data: <?= json_encode($brand_share) ?>
});

Morris.Donut({
  element: 'vendor-share-chart',
  data: <?= json_encode($vendor_share) ?>
});

Morris.Donut({
  element: 'doctor-chart',
  data: <?= json_encode($doc_dat) ?>
});
</script>
</div>
