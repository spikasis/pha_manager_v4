<div id="page-wrapper" align="justify" lang="el">
    <div class="row">
        <div class="col-lg-8"><img src="<?= base_url() ?>images/pha_header.png" style="height: 80px" alt=""/></div><div class="col-lg-4"><?php echo $company->company_name ?></div> 
    </div>
    <p><br></p>
    <h2 align="center">ΠΑΡΑΛΑΒΗ ΑΚΟΥΣΤΙΚΟΥ ΒΑΡΗΚΟΪΑΣ </h2>
    <h3 align="center">ΠΡΟΣ ΕΛΕΓΧΟ ΚΑΙ ΕΠΙΣΚΕΥΗ</h3>
    <p><br></p>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</td><td><strong><?php if(isset($service->day_in)) echo $service->day_in ?></strong></td></tr>
        <tr><td> ΣΤΟΙΧΕΙΑ ΑΚΟΥΣΤΙΚΟΥ:</td><td><strong><?php echo $stock->model ?>-<?php echo $stock->serial?></strong></td></tr>
        <tr><td> ΣΥΜΠΤΩΜΑΤΑ:</td><td><strong><?php echo $service->malfunction ?></strong></td></tr>
        <tr><td> ΕΝΕΡΓΕΙΕΣ:</td><td><strong><?php echo $service->lab_report ?></strong></td></tr>
        <tr><td> ΚΟΣΤΟΣ ΕΠΙΣΚΕΥΗΣ: </td><td><strong> <?php echo $service->price ?></strong></td></tr>
        <tr><td> ΑΚΟΥΣΤΙΚΟ ΑΝΤΙΚΑΤΑΣΤΑΣΗΣ:</td><td><strong><?php echo $ha_temp->model ?> - <?php echo $ha_temp->serial ?></strong></td></tr>
    </table>
    <p><br></p>
    <p style="text-align: left;">
        Το παρόν δελτίο παραλαβής αποτελεί αποδεικτικό παράδοσης αλλα καί παραλαβής του ακουστικού σας. 
        Υποχρεωτικά για την αναζήτηση και παραλαβή του ακουστικού σας θα πρέπει να προσκομίσετε το παρόν δελτίο.
        Η επιχείρηση δέν οφείλει να παραδόσει ακουστικό χωρίς την επίδειξη του δελτίου.
    </p><p>
    <p><strong>ΟΡΟΙ ΕΠΙΣΚΕΥΗΣ</strong></p>	
    <p style="text-align: left;">Ο έλεγχος και η εκτίμηση επισκευής του ακουστικού βαρηκοΐας που προσκομίζετε στην επιχείρηση μας, 
        χρεώνεται 15,00€. Η χρέωση προκαταβάλεται και αφαιρείται απο το τελικό κόστος επισκευής του ακουστικού εφόσον είναι 
        επισκευάσιμο. Η χρέωση δέν αφορά ακουστικά που έχουν εφαρμοστεί απο την επιχείρηση μας και είναι εντός εγγύησης.</p>
    <p></p>
    <p style="text-align: left;"><strong style="float: left">Παράδοση</strong> <strong style="float: right">Παραλαβή</strong></p><br>
    <p><br></p>
    <p><br></p>     
    <p>---------------------------------------------------------------------------------------------------------------------------------------------------</p>
    <h3 align="center">ΕΝΤΥΠΟ ΕΠΙΣΚΕΥΗΣ - ΑΠΟΚΟΜΜΑ ΓΡΑΜΜΑΤΕΙΑΣ</h3>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</td><td><strong><?php echo $service->day_in ?></strong></td></tr>
        <tr><td> ΑΚΟΥΣΤΙΚΟ ΕΠΙΣΚΕΥΗΣ:</td><td><strong><?php echo $stock->model?>-<?php echo $stock->serial?></strong></td></tr>
        <tr><td> ΑΚΟΥΣΤΙΚΟ ΑΝΤΙΚΑΤΑΣΤΑΣΗΣ:</td><td><strong><?php echo $ha_temp->model ?> - <?php echo $ha_temp->serial ?></strong></td></tr> 
    </table>      
    <p>---------------------------------------------------------------------------------------------------------------------------------------------------</p>
    <h3 align="center">ΕΝΤΥΠΟ ΕΠΙΣΚΕΥΗΣ - ΑΠΟΚΟΜΜΑ ΠΕΛΑΤΗ</h3>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</td><td><strong><?php echo $service->day_in ?></strong></td></tr>
        <tr><td> ΑΚΟΥΣΤΙΚΟ ΕΠΙΣΚΕΥΗΣ:</td><td><strong><?php echo $stock->model?>-<?php echo $stock->serial?></strong></td></tr>
        <tr><td> ΑΚΟΥΣΤΙΚΟ ΑΝΤΙΚΑΤΑΣΤΑΣΗΣ:</td><td><strong><?php echo $ha_temp->model ?> - <?php echo $ha_temp->serial ?></strong></td></tr> 
    </table>    
</div> 
