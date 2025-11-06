<!-- jQuery 
<script src="<?= base_url() ?>assets/admin/js/jquery.min.js"></script>-->

<!-- Bootstrap Core JavaScript 
<script src="<?= base_url() ?>assets/admin/js/bootstrap.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript-->
<script src="<?= base_url() ?>assets/admin/js/metisMenu.min.js"></script> 
<!--<script src="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.js"></script>-->

 
 
<!-- DataTables JavaScript -->
<script src="<?= base_url() ?>assets/admin/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/admin/js/dataTables.bootstrap.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?= base_url() ?>assets/admin/js/sb-admin-2.js"></script>

<!-- Morris Charts JavaScript 
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.2.7/morris.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.2.7/morris.js"></script>-->  

<script>
// Προσθήκη ενός φίλτρου για να αγνοεί τους μη έγκυρους χαρακτήρες
document.querySelectorAll = (function(original) {
    return function(selectors) {
        try {
            return original.apply(this, arguments);
        } catch (e) {
            console.warn('Invalid selector encountered: ', selectors);
            return [];
        }
    };
})(document.querySelectorAll);


    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true  
        });
    });

function hideFunction($id) {
  var x = document.getElementById($id);
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
</body>

</html>
