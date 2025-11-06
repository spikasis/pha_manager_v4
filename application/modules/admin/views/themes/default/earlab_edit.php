<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header"><h2>Κατασκευές Εργαστηρίου (επεξεργασία)</h2></div>            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default panel-danger">
                <div class="panel-heading">Προσθήκη Κατασκευής</div>
                <div class="panel-body">
                    <div class="row">                        
                        <form role="form" method="POST" action="<?= base_url('admin/earlabs/edit/'. $earlab->id) ?>">                            
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Πελάτης</label>
                                    <input list="customer_idS" name="customer_id" id="customer_id" class="form-control" value="<?= isset($earlab->customer_id) ? $earlab->customer_id : '' ?>">
                                    <datalist class="form-group" id="customer_idS">
                                       <?php if (count($customers)): ?>
                                            <?php foreach ($customers as $key => $customer): ?>
                                        <option value="<?= $customer['id'] ?>" <?= ($earlab->customer_id == $customer['id']) ? 'selected="selected"' : '' ?>> <?= $customer['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </datalist> 
                                </div>
                                <div class="form-group">
                                    <label>Ημ/νια Λήψης Μέτρων</label>
                                    <input class="form-control " type="date" value="<?=$earlab->date_order?>" id="date_order" name="date_order">
                                </div>
                                <div class="form-group">
                                    <label>Ημ/νια Παραλαβής (απο εργαστήριο)</label>
                                    <input class="form-control" type="date" value="<?=$earlab->date_delivery?>" id="date_delivery" name="date_delivery">
                                </div>
                                <div class="form-group">
                                    <label>Ημ/νια Παράδοσης (στον πελάτη)</label>
                                    <input class="form-control" type="date" value="<?=$earlab->date_fit?>" id="date_fit" name="date_fit">
                                </div>                                
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Ακουστικό</label>
                                    <input class="form-control" value="<?=$earlab->hearing_aid?>" placeholder="Εισαγάγετε Ακουστικό" id="hearing_aid" name="hearing_aid">
                                </div>
                                <div class="form-group ">
                                    <label>Κόστος</label>
                                    <input class="form-control" value="<?=$earlab->cost?>" placeholder="Εισαγάγετε Κόστος" id="cost" name="cost">
                                </div>  
                                <div class="form-group">
                                    <label>Εργαστήριο</label>
                                    <input list="vendor_idS" name="vendor_id" id="vendor_id" class="form-control" value="<?=$earlab->vendor_id ?>" >
                                    <datalist class="form-group" id="vendor_idS">
                                       <?php if (count($vendors)): ?>
                                            <?php foreach ($vendors as $key => $vendor): ?>
                                        <option value="<?= $vendor['id'] ?>" <?= ($earlab->vendor_id == $vendor['id']) ? 'selected="selected"' : '' ?>> <?= $vendor['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </datalist>                                    
                                </div>
                                <div class="form-group ">
                                    <label>Κατάσταση</label>
                                    <select class="form-control" id="status" name="status">
                                        <?php if (count($lab_statuses)): ?>
                                            <?php foreach ($lab_statuses as $key => $status): ?>
                                        <option value="<?= $status['id'] ?>" <?= ($earlab->status == $status['id']) ? 'selected="selected"' : '' ?>> <?= $status['status'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>                    
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Vent</label>
                                    <input class="form-control" value="<?=$earlab->vent?>" placeholder="Vent" id="vent" name="vent">
                                </div>                                
                                <div class="form-group ">
                                    <label>Μεγάφωνο</label>
                                    <input class="form-control" value="<?=$earlab->receiver?>" placeholder="receiver" id="receiver" name="receiver">
                                </div>
                                <div class="form-group ">
                                    <label>Φίλτρο</label>
                                    <input class="form-control" value="<?=$earlab->filter?>" placeholder="Εισαγάγετε Φίλτρο" id="filter" name="filter">
                                </div>
                                <div class="form-group"><!-- comment -->
                                        <label>Τύπος</label>
                                        <select class="form-control" id="type" name="type"  value="<?= $type['type'] ?>">
                                        <?php if (count($lab_types)): ?>
                                            <?php foreach ($lab_types as $key => $type): ?>
                                            <option value="<?= $type['id'] ?>"> <?= $type['type'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </select>
                                </div>                                                                
                            </div>
                            <div class="col-lg-2">
                                <table class="table">
                                    <tr>
                                        <th>Πλευρά</th>
                                        <td>
                                            <fieldset>
                                                <input type="radio" id="right" name="side" value="Right" <?php if ($earlab->side == 'Right') echo ' checked'; ?> />
                                                <label for="right">Right</label>
                                            </fieldset>
                                        </td>
                                        <td>
                                            <fieldset>
                                                <input type="radio" id="left" name="side" value="Left" <?php if ($earlab->side == 'Left') echo ' checked'; ?> />
                                                <label for="left">Left</label>
                                            </fieldset>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Υλικό</th>
                                        <td>
                                            <fieldset>
                                                <input type="radio" id="hard" name="material" value="Σκληρό" <?php if ($earlab->material  == 'Σκληρό') echo ' checked'; ?> />
                                                <label for="hard">Σκληρό</label>
                                            </fieldset>
                                        </td>
                                        <td>
                                            <fieldset>
                                                <input type="radio" id="soft" name="material" value="Μαλακό" <?php if ($earlab->material == 'Μαλακό') echo ' checked'; ?> />
                                                <label for="soft">Μαλακό</label>
                                            </fieldset>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Remake</th>
                                        <td>
                                            <fieldset>
                                                <input type="checkbox" id="remake" name="remake" value="Επανακατασκευή"  <?php if ($earlab->remake == 'Επανακατασκευή') echo ' checked'; ?>/>
                                                <label for="remake">Επανακατασκευή</label>
                                            </fieldset>
                                        </td>
                                    </tr>
                                </table>
                                <div class="form-group">
                                    <label>Σχόλια</label>
                                    <input class="form-control" value="<?=$earlab->comments?>" placeholder="Εισαγάγετε Σχόλια" id="comments" name="comments">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                                <button type="reset" class="btn btn-default">Επαναφορά</button>                                
                            </div>
                        </form>                           
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->    
    <a  href="<?= base_url('admin/earlabs') ?>" class="btn btn-warning">Πίσω στη λίστα κατασκευών</a>
</div><!-- /#page-wrapper -->
