<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3><?php echo $customer->name ?></h3>           
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Προβολή Στοιχείων Πελάτη
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-striped table-bordered table-hover" >                                
                                <tbody>
                                    <tr>
                                        <td ><strong>Διεύθυνση: </strong></td><td> <?php echo $customer->address ?></td>
                                        <td><strong>Πόλη: </strong></td><td> <?php echo $customer->city ?></td>
                                        <td><strong>Ημ/νια Γέννησης: </strong></td><td> <?php echo $customer->birthday ?></td>
                                    </tr>
                                    <tr>
                                        <td>Τηλέφωνο: </td><td><?php echo $customer->phone_home ?></td>
                                        <td>Κινητό: </td><td><?php echo $customer->phone_mobile ?></td>
                                        <td>Επάγγελμα: </td><td><?php echo $customer->profession ?></td>

                                    </tr>
                                    <tr>
                                        <td>Γιατρός: </td><td><?php echo $doctor->doc_name ?></td>
                                        <td>Παλιός Χρήστης: </td><td><?php echo $customer->old_user ?></td>
                                        <td>Ασφαλιστικός Φορέας: </td><td><?php echo $insurance->name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Πρώτη Επίσκεψη: </td><td><?php echo $customer->first_visit ?></td>
                                        <td>Πρώτη Εφαρμογή: </td><td><?php echo $customer->first_fit ?></td>
                                        <td>Λήξη Εγγύησης: </td><td><?php echo $customer->guarantee_end ?></td>
                                    </tr>
                                    <tr>
                                        <td>Σημείο Εξυπηρέτησης: </td><td><?php echo $selling_points->city ?></td>
                                        <td>Κατάσταση πελάτη: </td><td><?php echo $customer_status->status ?></td>
                                        <td>Σχόλια: </td><td><?php echo $customer->comments ?></td>
                                        <td>ΑΜΚΑ: </td><td><?php echo $customer->amka ?></td>
                                    </tr>
                                    <?php foreach ($stocks as $key => $list): ?>
                                        <tr>
                                            <td>Serial:</td><td><?php echo $list['serial'] ?></td>
                                            <td>Κατασκευαστικός Οίκος</td><td><?php echo $list['manufacturer'] ?></td>
                                            <td>Μοντέλο</td><td><?php echo $list['model'] ?></td>
                                            <td>Τύπος</td><td><?php echo $list['type'] ?></td>
                                            <td>Ημ/νια Πώλησης</td><td><?php echo $list['day_out'] ?></td>
                                            <td>Λήξη Εγγύησης</td><td><?php echo $list['guarantee_end'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <a  href="<?= base_url('admin/customers') ?>" class="btn btn-warning">Πίσω στη λίστα πελατών</a>
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
