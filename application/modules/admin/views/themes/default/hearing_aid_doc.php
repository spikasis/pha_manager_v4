<div id="page-wrapper" align="justify" lang="el">
    <div class="row" >
        <div class="col-lg-4 " style="display: inline-block; margin:5px; width: 30%; float: left"><img src="<?= base_url() ?>images/logo_pha.png" style="height: 80px" alt=""/></div> 
        
        <div class="col-lg-4 " style="display: inline-block; margin:5px; width: 30%; float: middle"><h3>Serial No: <?php echo $stock->serial ?></h3></div>
        
        <div class="col-lg-4 " style="display: inline-block; margin:5px; width: 30%; float: right"><h2><?php echo $customer->name ?></h2></div>
        
  </div>
    <div class="row" style="display: inline-block; margin:5px; width: 50%"><h2><h2><?php echo $title ?>: </h2></div>
    <div class="row" >
        <h3>            
            <div class="col-lg-4 " style="display: inline-block; width: 60%; float: left"><?php echo $brand->name ?> <?php echo $series->series ?> - <?php echo $ha_model->model ?> <?php echo $type->type ?></div>
            
            <div class="col-lg-4 " style="display: inline-block; width: 40%; float: right">Μπαταρία No: <?php echo $battery->type ?></div>
        </h3>
    </div>    
    <div class="row" >
        <h3>
            <div class="col-lg-4 " style="display: inline-block; margin:5px; width:45%; float: left">Ημερομηνία Πώλησης: <?php echo $stock->day_out ?></div> 
            <div class="col-lg-4 " style="display: inline-block; margin:5px; width: 45%; float: right">Λήξη Εγγύησης: <?php echo $stock->guarantee_end ?></div>
        </h3>
  </div>    
  <div class="row" >
      <h2>
        <div class="col-lg-4 " style="display: inline-block; margin:5px; width: 100%">Barcode ΕΟΠΥΥ: <?php echo $stock->ekapty_code ?></div>   
      </h2>
  </div>    
</div> 