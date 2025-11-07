<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Εταιρία
                <a  href="<?= base_url('admin/companies') ?>" class="btn btn-warning">Πίσω στη λίστα εταιριών</a>
            </h2>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Εισαγωγή Στοιχείων Επιχείρησης
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if ($this->session->flashdata('message')): ?>
                        <div class="col-lg-12 col-md-12">
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?=$this->session->flashdata('message')?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?=base_url('admin/companies/edit/'. $company->id)?>">
                                <div class="form-group">
                                    <label>Brand Id Input</label>
                                    <input class="form-control" value="<?=$company->id?>" placeholder="Auto generated" disabled="1">
                                </div>
                                <div class="form-group">
                                    <label>Επωνυμία</label>
                                    <input class="form-control" value="<?=$company->company_name?>" placeholder="Enter company name" id="company_name" name="company_name">
                                </div>
                                <div class="form-group">
                                    <label>Διεύθυνση</label>
                                    <input class="form-control" value="<?=$company->address?>" placeholder="Enter company country" id="address" name="address">
                                </div>
                                <div class="form-group">
                                    <label>Τηλέφωνο</label>
                                    <input class="form-control" value="<?=$company->phone?>" placeholder="Enter company ce mark" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label>Φαξ</label>
                                    <input class="form-control" value="<?=$company->fax?>" placeholder="Enter company url" id="fax" name="fax">
                                </div>
                                <div class="form-group">
                                    <label>e-mail</label>
                                    <input class="form-control" value="<?=$company->email?>" placeholder="Enter company url" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Πόλη</label>
                                    <input class="form-control" value="<?=$company->city?>" placeholder="Enter company url" id="city" name="city">
                                </div>
                                <div class="form-group">
                                    <label>Τ.Κ.</label>
                                    <input class="form-control" value="<?=$company->postal?>" placeholder="Enter company url" id="postal" name="postal">
                                </div>
                                <div class="form-group">
                                    <label>Α.Φ.Μ.</label>
                                    <input class="form-control" value="<?=$company->vat?>" placeholder="Enter company url" id="vat" name="vat">
                                </div>
                                <div class="form-group">
                                    <label>Λογότυπο</label>
                                    <input class="form-control" value="<?=$company->logo?>" placeholder="Enter company url" id="logo" name="logo">
                                </div>
                                <div class="form-group">
                                    <label>ΕΚΑΠΤΥ</label>
                                    <input class="form-control" value="<?=$company->ekapty?>" placeholder="Enter company url" id="ekapty" name="ekapty">
                                </div>
                                <div class="form-group">
                                    <label>Διαχειριστής</label>
                                    <select class="form-control" id="administrator" name="administrator">
                                        <?php if (count($users)): ?>
                                            <?php foreach ($users as $key => $user): ?>
                                                <option value="<?= $user['id'] ?>" <?= ($company->administrator == $user['id']) ? 'selected="selected"' : '' ?>> <?= $user['last_name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </form>
                        </div>
                    </div><!-- /.row (nested) -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /#page-wrapper -->
