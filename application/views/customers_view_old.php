<div id="page-wrapper">
    <div class="row" style="width: 100%; overflow: hidden;">
        <div class='col-lg-8' style="width: 300px; float: left;"><img src="<?= base_url('images/logo_pha.png') ?>" style="height: 100px"/></div>        
        <div class='col-lg-4' style="float: right"><h1>ΚΑΡΤΕΛΑ ΠΕΛΑΤΗ</h1></div>
    </div><!-- /.row -->    
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Προβολή Στοιχείων Πελάτη - </strong><?php echo $customer->name ?></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <table class="table table-striped table-bordered table-hover" >                                
                                <tbody>
                                    <tr>
                                        <td><strong>Διεύθυνση: </strong></td>
                                        <td><strong>Πόλη: </strong></td>
                                        <td><strong>Ημ/νια Γέννησης: </strong></td>
                                        <td><strong>Τηλέφωνο: </strong></td>
                                        <td><strong>Κινητό: </strong></td>
                                        <td><strong>Επάγγελμα: </strong></td>
                                
                                    </tr>
                                    <tr>
                                        <td><?php echo $customer->address ?></td>
                                        <td><?php echo $customer->city ?></td>
                                        <td><?php echo $customer->birthday ?></td>
                                        <td><?php echo $customer->phone_home ?></td>
                                        <td><?php echo $customer->phone_mobile ?></td>
                                        <td><?php echo $customer->profession ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Γιατρός: </strong></td>
                                        <td><strong>Παλιός Χρήστης: </strong></td>
                                        <td><strong>Ασφαλιστικός Φορέας: </strong></td>
                                        <td><strong>Σημείο Εξυπηρέτησης: </strong></td>
                                        <td><strong>Κατάσταση πελάτη: </strong></td>
                                        <td><strong>Πρώτη Επίσκεψη: </strong></td>
                                    </tr>
                                    <tr>
                                      <td><?php echo $doctor->doc_name ?></td>
                                      <td><?php echo $customer->old_user ?></td>
                                      <td><?php echo $insurance->name ?></td> 
                                      <td><?php echo $selling_points->city ?></td>
                                      <td><?php echo $customer_status->status ?></td>
                                      <td><?php echo $customer->first_visit ?></td>
                                    </tr>
                                    <tr class="hidden-print">
                                        <td><strong>Σχόλια: </strong></td><td colspan="5"><?php echo $customer->comments ?></td>                                        
                                    </tr>
                                </tbody>
                            </table>
                            <a href="<?= base_url('admin/customers/edit/' . $customer->id) ?>" class="btn btn-info hidden-print" style="float: left">Επεξεργασία</a>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Προβολή Ακουστικών</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-striped table-bordered table-hover" >
                                <?php foreach ($stocks as $key => $list): ?>
                                    <?php
                                    $this->load->model(array('admin/manufacturer'));
                                    $man = $this->manufacturer->get($list['manufacturer']);
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td colspan="6">Serial No: <strong><?php echo $list['serial'] ?></strong></td>
                                            
                                        </tr>
                                        <tr>                                            
                                            <td>Κατασκευαστικός Οίκος</td>
                                            <td>Μοντέλο</td>
                                            <td>Τύπος</td>
                                            <td>Ημ/νια Πώλησης</td>
                                            <td>Λήξη Εγγύησης</td>
                                            <td>Ενέργειες</td>
                                        </tr>
                                        <tr>                                            
                                            <td><?php echo $man->name ?></td>
                                            <td><?php echo $list['model'] ?></td>
                                            <td><?php echo $list['type'] ?></td>
                                            <td><?php echo $list['day_out'] ?></td>
                                            <td><?php echo $list['guarantee_end'] ?></td>
                                            <td>                                                
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ενέργειες
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a href="<?= base_url('admin/stocks/edit/' . $list['id']) ?>" class="btn btn-info hidden-print">Επεξεργασία</a></li>
                                                        <li><a href="<?= base_url('admin/stocks/view/' . $list['id']) ?>" class="btn btn-info hidden-print">Προβολή</a></li>
                                                        <li><a href="<?= base_url('admin/stocks/pays/' . $list['id']) ?>" class="btn btn-info hidden-print">Χρέη</a></li>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="hidden-print">
                                            <td>Σχόλια: </td><td colspan="4"><?php echo $list['comments'] ?></td>
                                            <td></td>                                           

                                        </tr>
                                    </tbody>   
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

    <div class="no-print"><a  href="<?= base_url('admin/customers') ?>" class="btn btn-warning hidden-print">Πίσω στη λίστα πελατών</a></div>
</div>
<!-- /#page-wrapper -->
