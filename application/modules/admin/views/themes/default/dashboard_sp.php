<?php
// Dashboard με dropdown υποκαταστήματος και γραφήματα για admin
?>
<div id="page-wrapper" id="header">

    <div class="row">

<?php if (isset($selling_points) && is_array($selling_points) && count($selling_points) > 1): ?>
<div class="row">
    <div class="col-lg-3 col-md-4">
        <label for="selling_point">Υποκατάστημα:</label>
        <select id="selling_point" name="selling_point" class="form-control" onchange="changeSellingPoint(this.value)">
            <option value="">-- Επιλέξτε --</option>
            <?php foreach ($selling_points as $sp): ?>
                <option value="<?= $sp['id'] ?>" <?= ($sp['id'] == $selected_selling_point ? 'selected' : '') ?>>
                    <?= $sp['city'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<script>
   function changeSellingPoint(id) {
    if (!id || isNaN(id)) return; // αποτρέπουμε λάθη
    const year = <?= json_encode($year_now) ?>;
    window.location.href = "<?= base_url('admin/dashboard/index') ?>?sp=" + id;
}

</script>
<?php endif; ?>

        <div class="col-lg-12">
            <h1 class="page-header">
                Στοιχεία <?php echo $year_now ?> - <?php echo $selling_point->city ?>
                <button type="button" class="btn btn-success hidden-print" onclick="hideFunction('hidden_div')" style="float: right">Εμφάνιση</button>
            </h1>
        </div>
    </div>
    <div class="row" id="hidden_div">
        <?php if ($this->session->flashdata('message')): ?>
            <div class="col-lg-12 col-md-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $this->session->flashdata('message') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Πίνακες -->
    <div class="row">
        <div class="col-lg-12"><?php $this->load->view('admin/themes/default/includes/dashboard_panels_blocks'); ?></div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12"><?php $this->load->view('admin/themes/default/includes/dashboard_panel_tasks'); ?></div>
        <div class="col-lg-3 col-md-4 col-sm-12"><?php $this->load->view('admin/themes/default/includes/dashboard_panel_on_hold'); ?></div>
        <div class="col-lg-3 col-md-4 col-sm-12"><?php $this->load->view('admin/themes/default/includes/dashboard_panel_repairs'); ?></div>
        <div class="col-lg-3 col-md-4 col-sm-12"><?php $this->load->view('admin/themes/default/includes/dashboard_panel_moulds'); ?></div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12"><?php $this->load->view('admin/themes/default/includes/dashboard_panel_debts'); ?></div>
        <div class="col-lg-4 col-md-4 col-sm-12"><?php $this->load->view('admin/themes/default/includes/dashboard_panel_barcodes'); ?></div>
        <div class="col-lg-4 col-md-4 col-sm-12"><?php $this->load->view('admin/themes/default/includes/dashboard_panel_cash_on_hold'); ?></div>
    </div>

    <!-- Γραφήματα μόνο για admin -->
    <?php if ($this->ion_auth->is_admin()): ?>
        <div class="row">
            <div class="col-lg-6"><?php $this->load->view('admin/themes/default/includes/chart_sales_per_year'); ?></div>
            <div class="col-lg-6"><?php $this->load->view('admin/themes/default/includes/chart_debt_vs_sales'); ?></div>
        </div>
    <?php endif; ?>

</div>
