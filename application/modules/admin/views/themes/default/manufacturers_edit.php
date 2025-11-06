<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Brands
                <a  href="<?= base_url('admin/manufacturers') ?>" class="btn btn-warning">Go back to manufacturers listing</a>
            </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Update manufacturer
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
                            <form role="form" method="POST" action="<?=base_url('admin/manufacturers/edit/'.$manufacturer->id)?>">
                                <div class="form-group">
                                    <label>Brand Id Input</label>
                                    <input class="form-control" value="<?=$manufacturer->id?>" placeholder="Auto generated" disabled="1">
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" value="<?=$manufacturer->name?>" placeholder="Enter manufacturer Name" id="name" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Country</label>
                                    <input class="form-control" value="<?=$manufacturer->country?>" placeholder="Enter manufacturer country" id="country" name="country">
                                </div>
                                <div class="form-group">
                                    <label>CE Mark</label>
                                    <input class="form-control" value="<?=$manufacturer->ce_mark?>" placeholder="Enter manufacturer ce" id="ce_mark" name="ce_mark">
                                </div>
                                <div class="form-group">
                                    <label>URL</label>
                                    <input class="form-control" value="<?=$manufacturer->url?>" placeholder="Enter manufacturer url" id="url" name="url">
                                </div>

                                <button type="submit" class="btn btn-primary">Submit Button</button>
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
