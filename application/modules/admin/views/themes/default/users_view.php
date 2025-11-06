<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Users
                <a  href="<?= base_url('admin/users') ?>" class="btn btn-warning">Πίσω στους Χρηστες</a>
            </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Προφίλ Χρήστη
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?= base_url('admin/users/edit/' . $user->id) ?>">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="table table-striped table-bordered table-hover">
                                        <td>Id </td>
                                        <td>Username </td>
                                        <td>Email </td>
                                        <td>User Group </td>
                                        <td>First Name </td>
                                        <td>Last Name </td>
                                        <td>Phone</td>
                                    </thead>
                                    <tbody>
                                        <tr>                                            
                                            <td><?= $user->id ?> </td>
                                            <td><?= $user->username ?> </td>
                                            <td><?= $user->email ?> </td> 
                                            <td><?= $user->email ?> </td>
                                            <td><?= $user->first_name ?> </td>
                                            <td><?= $user->last_name ?> </td>
                                            <td><?= $user->phone ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
