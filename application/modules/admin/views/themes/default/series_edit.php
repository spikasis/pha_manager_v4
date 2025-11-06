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
                            <form role="form" method="POST" action="<?= base_url('admin/series/edit/' . $series->id) ?>">
                                <div class="form-group">
                                    <label>Series ID</label>
                                    <input class="form-control" value="<?= $model->id ?>" placeholder="Auto generated" disabled="1">
                                </div>  
                                <div class="form-group">
                                    <label>Κατασκευαστικός Οίκος</label>
                                    <select class="form-control" id="brand" name="brand">
                                        <?php if (count($brand)): ?>
                                            <?php foreach ($brand as $key => $brand): ?>
                                                <option value="<?= $brand['id'] ?>" <?= ($model->brand == $brand['id']) ? 'selected="selected"' : '' ?>> <?= $brand['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                                <div class="form-group">
                                    <label>Μοντέλο</label>
                                    <input class="form-control" value="<?= $series->series ?>" placeholder="Σειρά Ακουστικών" id="series" name="series">
                                </div> 
                                
                                <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                            </form>                            
                            <a  href="<?= base_url('admin/series') ?>" class="btn btn-warning">Πίσω στη λίστα Σειρών</a>
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
