<div id="page-wrapper" align="justify" lang="el">
    <div class="row">
        <div class="col-lg-8"><img src="<?= base_url() ?>images/pha_header.png" style="height: 80px" alt=""/></div><div class="col-lg-4"><?php //echo $company->company_name ?></div> 
    </div>
    <p><br></p>
    <h3 align="center">ΕΝΤΥΠΟ ΚΑΤΑΣΚΕΥΗΣ</h3>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΛΗΨΗΣ ΜΕΤΡΩΝ:</td><td><strong><?php echo $earlab->date_order ?></strong></td></tr>
        <tr><td> ΤΥΠΟΣ ΚΑΤΑΣΚΕΥΗΣ</td><td><strong><?php echo $lab_types->type ?></strong></td></tr>
        <tr><td> VENT (mm)</td><td><strong><?php echo $earlab->vent ?></strong></td></tr>
        <tr><td> ΚΟΣΤΟΣ</td><td><strong><?php echo $earlab->cost ?></strong></td></tr>
    </table>
    <p><br></p>
        <p><br></p>
    <h3 align="center">ΑΠΟΚΟΜΜΑ ΓΡΑΜΜΑΤΕΙΑΣ</h3>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΑΚΟΥΣΤΙΚΟ:</td><td><strong><?php if(isset($stock->serial)) echo $stock->model; echo "-"; if(isset($stock->model)) echo $stock->serial ?></strong></td></tr>
        <tr><td> ΕΠΙΚΟΙΝΩΝΙΑ:</td><td><strong><?php if(isset($customer->phone_home)) echo $customer->phone_home ?> <? if(isset($customer->phone_mobile)) echo $customer->phone_mobile ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΛΗΨΗΣ ΜΕΤΡΩΝ:</td><td><strong><?php echo $earlab->date_order ?></strong></td></tr>
        <tr><td> ΤΥΠΟΣ ΚΑΤΑΣΚΕΥΗΣ</td><td><strong><?php echo $lab_types->type ?></strong></td></tr>
        <tr><td> VENT (mm)</td><td><strong><?php echo $earlab->vent ?></strong></td></tr>
        <tr><td> ΚΟΣΤΟΣ</td><td><strong><?php echo $earlab->cost ?></strong></td></tr>
    </table>
    <p><br></p>
    <p><br></p>
    <h3 align="center">ΔΕΛΤΙΟ ΠΑΡΑΛΑΒΗΣ ΠΕΛΑΤΗ</h3>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΛΗΨΗΣ ΜΕΤΡΩΝ:</td><td><strong><?php echo $earlab->date_order ?></strong></td></tr>
        <tr><td> ΤΥΠΟΣ ΚΑΤΑΣΚΕΥΗΣ</td><td><strong><?php echo $lab_types->type ?></strong></td></tr>
        <tr><td> VENT (mm)</td><td><strong><?php echo $earlab->vent ?></strong></td></tr>
        <tr><td> ΚΟΣΤΟΣ</td><td><strong><?php echo $earlab->cost ?></strong></td></tr>
    </table>
    <p><br></p>

    <p style="text-align: left;">
        Η ΠΑΡΑΛΑΒΗ ΤΟΥ ΕΚΜΑΓΕΙΟΥ ΣΑΣ Η ΤΟΥ ΚΕΛΥΦΟΥΣ ΓΙΝΕΤΑΙ ΑΠΟΚΛΕΙΣΤΙΚΑ ΚΑΙ ΜΟΝΟ 
        ΜΕ ΤΗΝ ΕΠΙΔΕΙΞΗ ΤΟΥ ΠΑΡΟΝΤΟΣ ΑΠΟΔΕΙΚΤΙΚΟΥ ΠΑΡΑΛΑΒΗΣ. ΕΚΜΑΓΕΙΑ ΠΟΥ ΔΕΝ 
        ΑΝΑΖΗΤΟΥΝΤΑΙ ΜΠΑΙΝΟΥΝ ΣΤΟ ΑΡΧΕΙΟ. Η ΕΦΑΡΜΟΓΗ ΝΕΟΥ ΕΚΜΑΓΕΙΟΥ ΠΡΕΠΕΙ ΝΑ 
        ΓΙΝΕΤΑΙ ΠΑΝΩ ΣΤΟΝ ΧΡΗΣΤΗ ΓΙΑ ΝΑ ΣΥΝΟΔΕΥΕΤΑΙ ΑΠΟ ΤΗΝ ΑΝΤΙΣΤΟΙΧΗ ΠΡΟΣΑΡΜΟΓΗ 
        ΤΗΣ ΡΥΘΜΙΣΗΣ. ΑΛΛΑΓΗ ΚΕΛΥΦΟΥΣ ΠΡΟΥΠΟΘΕΤΕΙ ΜΙΑ ΕΡΓΑΣΙΜΗ ΓΙΑ ΤΗ ΜΕΤΑΦΟΡΑ ΤΟΥ 
        ΜΗΧΑΝΙΣΜΟΥ ΣΤΟ ΝΕΟ ΚΕΛΥΦΟΣ. ΚΑΤΑΣΚΕΥΗ ΚΕΛΥΦΟΥΣ-ΕΚΜΑΓΕΙΟΥ ΠΡΟΠΛΗΡΩΝΕΤΑΙ.  
    </p>
    <p></p>
    <p style="text-align: right;"><strong>ΠΙΚΑΣΗΣ - ΕΦΑΡΜΟΓΕΣ ΑΚΟΗΣ</strong></p>
</div> 
