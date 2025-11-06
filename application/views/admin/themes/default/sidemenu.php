<?php
$CI =& get_instance();
$user_id = $CI->ion_auth->get_user_id();
$group = $CI->ion_auth->get_users_groups($user_id)->row();
$group_id = $group->id;
?>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Αναζήτηση...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </li>

            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard fa-fw"></i> Αρχική</a></li>

            <?php if ($group_id == 1): // Admin ?>
                <li><a href="<?= base_url('admin/customers') ?>"><i class="fa fa-users fa-fw"></i> Πελάτες</a></li>
                <li><a href="<?= base_url('admin/sales') ?>"><i class="fa fa-shopping-cart fa-fw"></i> Πωλήσεις</a></li>
                <li><a href="<?= base_url('admin/repairs') ?>"><i class="fa fa-wrench fa-fw"></i> Επισκευές</a></li>
                <li><a href="<?= base_url('admin/reports') ?>"><i class="fa fa-chart-bar fa-fw"></i> Αναφορές</a></li>
                <li><a href="<?= base_url('admin/settings') ?>"><i class="fa fa-cogs fa-fw"></i> Ρυθμίσεις</a></li>

            <?php elseif ($group_id == 2): // Υποκατάστημα ?>
                <li><a href="<?= base_url('admin/customers') ?>"><i class="fa fa-users fa-fw"></i> Πελάτες</a></li>
                <li><a href="<?= base_url('admin/sales') ?>"><i class="fa fa-shopping-cart fa-fw"></i> Πωλήσεις</a></li>

            <?php elseif ($group_id == 3): // Εργαστήριο ?>
                <li><a href="<?= base_url('admin/repairs') ?>"><i class="fa fa-wrench fa-fw"></i> Επισκευές</a></li>
                <li><a href="<?= base_url('admin/tasks') ?>"><i class="fa fa-tasks fa-fw"></i> Εργασίες</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
