<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header"><h2>Δελτία Αποστολής</h2></div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="col-lg-8">
        <div class="col-lg-8">
            <div class="panel panel-default col-lg-8">
                <div class="panel-heading " >Προσθήκη Δελτίου Αποστολής</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <form role="form" method="POST" action="<?= base_url('admin/dap_invoices/create/') ?>">                            
                                <div class="form-group">
                                    <label>Από</label>                                    
                                    <input list="companies" name="from" id="from" class="form-control" >
                                      <datalist id="companies">    
                                        <?php if (count($companies)): ?>
                                            <?php foreach ($companies as $key => $list): ?>
                                                <option value="<?= $list['id'] ?> - <?= $list['company_name'] ?>"></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                      </datalist>                                                                                                       
                                </div>    
                                <div class="form-group">
                                    <label>Πρός</label>                                    
                                    <input list="vendors" name="to_customer" id="to_customer" class="form-control" >
                                      <datalist id="vendors">    
                                        <?php if (count($vendors)): ?>
                                            <?php foreach ($vendors as $key => $list): ?>
                                                <option value="<?= $list['id'] ?> - <?= $list['name'] ?>"></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                      </datalist>                                  
                                </div>                            
                                <div class="form-group">
                                    <label>Ημερομηνία</label>
                                    <input class="form-control" type="date" id="date" name="date">
                                </div>                                                       
                        </div>
                        <div class="col-lg-6">                                                      
                                <div class="form-group">
                                    <label>Προσθήκη Ειδών</label>                                    
                                    <input list="stock" name="from" id="from" class="form-control" >
                                      <datalist id="stock">    
                                        <?php if (count($stock)): ?>
                                            <?php foreach ($stock as $key => $list): ?>
                                                <option value="<?= $list['serial'] ?> - <?= $list['ha_model'] ?>"></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                      </datalist>                                                                                                       
                                </div>
                            <button type="submit" class="btn btn-primary">Εισαγωγή</button>                            
                            </form>                            
                        </div>
                    </div><!-- /.row (nested) -->                      
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->            
        </div><!-- /.col-lg-12 --><a  href="<?= base_url('admin/dap_invoices/') . $id ?>" class="btn btn-warning">Πίσω στη λίστα επισκευών</a>
    </div><!-- /.row -->    
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

</div><!-- /#page-wrapper -->
