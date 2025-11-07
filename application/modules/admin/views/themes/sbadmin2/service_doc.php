<div id="page-wrapper" align="justify" lang="el">
    <div class="row">
        <div class="col-lg-8"><img src="<?= base_url() ?>images/pha_header.png" style="height: 80px" alt=""/></div><div class="col-lg-4"><?php //echo $company->company_name ?></div> 
    </div>
    <p><br></p>
    <h3 align="center">ΕΝΤΥΠΟ ΕΠΙΣΚΕΥΗΣ</h3>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</td><td><strong><?php $service->day_in ?></strong></td></tr>
        <tr><td> ΜΟΝΤΕΛΟ:</td><td><strong><?php echo $model->model?>-<?php echo $stock->type?></strong></td></tr>
        <tr><td> SERIAL NO:</td><td><strong><?php echo $stock->serial ?></strong></td></tr>
        <tr><td> ΣΥΜΠΤΩΜΑΤΑ</td><td><strong><?php echo $service->job ?></strong></td></tr>
        <tr><td> ΚΟΣΤΟΣ</td><td><strong></strong></td></tr>
    </table>
    <p><br></p>
        <p><br></p>
    <h3 align="center">ΑΠΟΚΟΜΜΑ ΓΡΑΜΜΑΤΕΙΑΣ</h3>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</td><td><strong><?php $service->day_in ?></strong></td></tr>
        <tr><td> ΜΟΝΤΕΛΟ:</td><td><strong><?php echo $stock->model?>-<?php echo $stock->type?></strong></td></tr>
        <tr><td> SERIAL NO:</td><td><strong><?php echo $stock->serial ?></strong></td></tr>
        <tr><td> ΣΥΜΠΤΩΜΑΤΑ</td><td><strong><?php echo $service->job ?></strong></td></tr>
        <tr><td> ΚΟΣΤΟΣ</td><td><strong></strong></td></tr>
    </table>
    <p><br></p>
    <p><br></p>
    <h3 align="center">ΔΕΛΤΙΟ ΠΑΡΑΛΑΒΗΣ ΠΕΛΑΤΗ</h3>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</td><td><strong><?php $service->day_in ?></strong></td></tr>
        <tr><td> ΜΟΝΤΕΛΟ:</td><td><strong><?php echo $stock->model?>-<?php echo $stock->type?></strong></td></tr>
        <tr><td> SERIAL NO:</td><td><strong><?php echo $stock->serial ?></strong></td></tr>
        <tr><td> ΣΥΜΠΤΩΜΑΤΑ</td><td><strong><?php echo $service->job ?></strong></td></tr>
        <tr><td> ΚΟΣΤΟΣ</td><td><strong></strong></td></tr>
    </table>
    <p><br></p>

    <p style="text-align: left;">
        Η ΠΑΡΑΛΑΒΗ ΤΟΥ ΑΚΟΥΣΤΙΚΟΥ ΣΑΣ (ΕΠΙΣΚΕΥΑΣΜΕΝΟ Η ΟΧΙ) 
        ΓΙΝΕΤΑΙ ΑΠΟΚΛΕΙΣΤΙΚΑ ΚΑΙ ΜΟΝΟ ΜΕ ΤΗΝ ΕΠΙΔΕΙΞΗ ΤΟΥ ΠΑΡΟΝΤΟΣ ΑΠΟΔΕΙΚΤΙΚΟΥ ΠΑΡΑΛΑΒΗΣ. 
        ΑΚΟΥΣΤΙΚΑ ΠΟΥ ΔΕΝ ΑΝΑΖΗΤΟΥΝΤΑΙ ΓΙΑ ΔΙΑΣΤΗΜΑ ΜΕΓΑΛΥΤΕΡΟ ΤΩΝ ΤΡΙΩΝ (3) ΜΗΝΩΝ ΣΤΕΛΝΟΝΤΑΙ 
        ΓΙΑ ΑΝΑΚΥΚΛΩΣΗ. Ο ΕΛΕΓΧΟΣ ΚΑΙ Η ΕΠΙΣΚΕΥΗ ΤΟΥ ΚΑΘΕ ΑΚΟΥΣΤΙΚΟΥ ΚΟΣΤΟΛΟΓΕΙΤΑΙ 25 ΕΥΡΩ ΣΥΝ 
        ΤΟ ΚΟΣΤΟΣ ΤΟΥ ΑΝΤΑΛΛΑΚΤΙΚΟΥ ΕΦ' ΟΣΟΝ ΑΠΑΙΤΕΙΤΑΙ. ΚΑΜΙΑ ΕΡΓΑΣΙΑ ΔΕΝ ΠΡΑΓΜΑΤΟΠΟΙEIΤΑΙ 
        ΧΩΡΙΣ ΣΥΝΕΝΝΟΗΣΗ ΜΑΖΙ ΣΑΣ.  
    </p>
    <p></p>
    <p style="text-align: right;"><strong>ΠΙΚΑΣΗΣ - ΕΦΑΡΜΟΓΕΣ ΑΚΟΗΣ</strong></p>
</div> 
