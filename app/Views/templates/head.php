<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="PHA Manager v4 - Professional Hearing Aid Management System">
    <meta name="author" content="Pikas Hearing Aid Center">
    
    <title><?= $title ?? 'PHA Manager v4' ?></title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
    
    <!-- FontAwesome Icons -->
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- SB Admin 2 CSS -->
    <link href="<?= base_url('sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet" type="text/css">
    
    <!-- DataTables CSS (if needed) -->
    <?php if (isset($load_datatables) && $load_datatables): ?>
    <link href="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css">
    <?php endif; ?>

    <!-- Chart.js CSS (if needed) -->
    <?php if (isset($load_charts) && $load_charts): ?>
    <link href="<?= base_url('vendor/chart.js/Chart.min.css') ?>" rel="stylesheet" type="text/css">
    <?php endif; ?>

    <!-- Custom Styles for this page -->
    <?php if (isset($custom_css)): ?>
        <?php foreach ($custom_css as $css): ?>
            <link href="<?= base_url($css) ?>" rel="stylesheet" type="text/css">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Inline Styles (if provided) -->
    <?php if (isset($inline_styles)): ?>
        <style><?= $inline_styles ?></style>
    <?php endif; ?>

    <!-- Favicon -->
    <link href="<?= base_url('favicon.ico') ?>" rel="icon" type="image/x-icon"/>
</head>