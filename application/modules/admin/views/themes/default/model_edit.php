<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>
                Μοντέλο

            </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Επεξεργασία Μοντέλου
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?= base_url('admin/models/edit/' . $model->id) ?>">
                                <div class="form-group">
                                    <label>Model ID</label>
                                    <input class="form-control" value="<?= $model->id ?>" placeholder="Auto generated" disabled="1">
                                </div>  
                                <div class="form-group">
                                    <label>Κατασκευαστής - Σειρά</label>
                                    <select class="form-control" id="series" name="series">
                                        <?php if (count($series)): ?>
                                            <?php foreach ($series as $key => $list): ?>
                                            <?php $this_brand = $this->manufacturer->get($list['brand']); ?>
                                                <option value="<?= $list['id'] ?>" <?= ($model->brand == $list['id']) ? 'selected="selected"' : '' ?>> <?= $this_brand->name ?> - <?= $list['series'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                                <div class="form-group">
                                    <label>Μοντέλο</label>
                                    <input class="form-control" value="<?= $model->model ?>" placeholder="Μοντέλο Ακουστικού" id="model" name="model">
                                </div> 
                                <div class="form-group">
                                    <label>Τύπος Ακουστικού</label>
                                    <select class="form-control" id="ha_type" name="ha_type">
                                        <?php if (count($ha_type)): ?>
                                            <?php foreach ($ha_type as $key => $ha_types): ?>
                                                <option value="<?= $ha_types['id'] ?>" <?= ($model->ha_type == $ha_types['id']) ? 'selected="selected"' : '' ?>> <?= $ha_types['type'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>   
                                </div>                                
                                <div class="form-group">
                                    <label>Μπαταρία</label>
                                    <select class="form-control" id="battery" name="battery">
                                        <?php if (count($battery)): ?>
                                            <?php foreach ($battery as $key => $battery_type): ?>
                                                <option value="<?= $battery_type['id'] ?>" <?= ($model->battery == $battery_type['id']) ? 'selected="selected"' : '' ?>> <?= $battery_type['type'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                  </div>
                                <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <a  href="<?= base_url('admin/models') ?>" class="btn btn-warning">Πίσω στη λίστα Μοντέλων</a>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>
</div>
<!-- /#page-wrapper -->
