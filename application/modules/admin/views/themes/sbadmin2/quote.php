<div id="page-wrapper" align="justify" lang="el">
    <div class="row">
        <div class="col-lg-8"><img src="<?= base_url() ?>images/pha_header.png" style="height: 80px" alt=""/></div><div class="col-lg-4"><?php //echo $company->company_name ?></div> 
    </div>
    <p><br></p>
    <h2 align="center">ΠΡΟΣΦΟΡΑ ΑΚΟΥΣΤΙΚΩΝ ΒΑΡΗΚΟΙΑΣ</h2>
    <p><br></p>
    <table width="100%" id="t01">
        <tr><td> ΟΝΟΜΑ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΑΓΟΡΑΣ:</td><td><strong><?php if(isset($stock->day_out)) echo $stock->day_out ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ ΛΗΞΗΣ ΕΓΓΥΗΣΗΣ:</td><td><strong><?php if(isset($stock->guarantee_end)) echo $stock->guarantee_end ?></strong></td></tr>
        <tr><td> ΚΑΤΑΣΚΕΥΑΣΤΙΚΟΣ ΟΙΚΟΣ:</td><td><strong><?php echo $manufacturer->name ?></strong></td></tr>
        <tr><td> ΜΟΝΤΕΛΟ:</td><td><strong><?php echo $stock->model?>-<?php echo $stock->type?></strong></td></tr>
        <tr><td> SERIAL NO:</td><td><strong><?php echo $stock->serial ?></strong></td></tr>
    </table>
    <p><br></p>
    <p style="text-align: left;">
        Η συσκευή που προμηθευτήκατε αποτελεί ιατροτεχνολογικό προιόν, φέρει σήμανση <strong>CE <?php echo $manufacturer->ce_mark ?></strong> και 							
        συνοδεύεται από εγγύηση καλής λειτουργίας δύο (2) ετών.	Η επιχείρηση μας διαθέτει εξουσιοδοτημένο τμήμα τεχνικής υποστήριξης.
    </p><p>
    <p><strong>ΟΡΟΙ ΕΓΓΥΗΣΗΣ</strong></p>	
    <p style="text-align: left;">Η εγγύηση δεν καλύπτει βλάβες που οφείλονται σε μη ορθή χρήση του προιόντος ή ελλειπή							
        συντήρηση όπως αναφέρεται από τον κατασκευαστή.	
        Η εγγύηση δεν ισχύει σε περίπτωση επισκευής ή επέμβασης στο προιόν από άτομα που δεν είναι							
        εξουσιοδοτημένα από την επιχείρηση μας ή τον κατασκευαστικό οίκο.</p>
    <p></p>
    <p style="text-align: center;">Κωδικός Επιχείρησης Μητρώου ΕΚΑΠΤΥ: <?php echo $company->ekapty ?></p>
    <p style="text-align: center;">Κωδικός Προϊόντος Μητρώου ΕΚΑΠΤΥ: <?php echo $stock->ekapty_code ?></p>
    <p style="text-align: center;">----------------------------------------------------------------------------------------------</p>
    <p style="text-align: right;">
        <?php
        date_default_timezone_set("Europe/Athens");
        //echo "Λιβαδειά " . date("d-m-Y");
        if (isset($stock->day_out)) {echo "Λιβαδειά " . $stock->day_out;}        
        ?>
    <p style="text-align: right;"><strong>Σπυρίδων Κ. Πικάσης</strong></p>
    <p><br></p><p><br></p><p><br></p>
    <p style="text-align: right;">Μηχανικός Βιοΐατρικής Τεχνολογίας</p>
    <p style="text-align: right;">Ειδικός Ακοοπροθετιστής</p>
</div> 
