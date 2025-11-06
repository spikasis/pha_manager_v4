<div id="page-wrapper" align="justify" lang="el">
    <div class="row">
        <table style="width: 100%">
            <td style="float: left"><div class="col-lg-8"><img src="<?= base_url() ?>images/logo_pha.png" style="height: 80px" alt="logo"/></div></td>
            <td style="float: ">www.pikasishearing.gr</td>
            <td style="float: right">
                <div class=""><strong>      <?php echo $company->company_name   ?></strong></div>
                <div class="">Διεύθυνση:    <?php echo $company->address        ?></div>
                <div class="">Τηλέφωνο:     <?php echo $company->phone          ?></div>
            </td>
        </table>       
    </div>
    <p><br></p><p><br></p>
    <h2 style="align-content: center">ΤΡΑΠΕΖΙΚΟΙ ΛΟΓΑΡΙΑΣΜΟΙ</h2>
    <p><br></p>
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <th> ΤΡΑΠΕΖΑ</th>
        <th> ΙΒΑΝ</th>
        <th> ΤΥΠΟΣ</th>
        <th> ΔΙΚΑΙΟΥΧΟΣ</th>
        <?php if (count($banks)): ?>
            <?php foreach ($banks as $key => $list): ?>  
                <tr>
                    <td><?php echo $list['name'] ?></td>
                    <td><?php echo $list['iban'] ?></td>
                    <td><?php echo $list['type'] ?></td>
                    <td><?php echo $list['owner'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <p><br></p>
    <p style="text-align: left;">
        Παρακαλούμε όπως καταθέτετε στους ανωτέρω τραπεζικούς λογαριασμούς το ακριβές ποσό της απόδειξης αγοράς ακουστικού 
        βαρηκοΐας που προμηθευτήκατε απο την επιχείρηση μας. Μετά την κατάθεση παρακαλήσθε όπως επικοινωνήσετε μαζί μας 
        προς ενημέρωση της εξώφλησης σας. Το καταθετήριο αποτελεί και αποδεικτικό εξώφλησης της οφειλής σας.
    </p>
    <p><?php
        date_default_timezone_set("Europe/Athens");
        echo "Λιβαδειά " . date("d-m-Y");
        /*if (isset($customer->first_fit))
            echo "Λιβαδειά " . $customer->first_fit
        */    ?>
    </p>
    <p style="text-align: right;"><strong>Σπυρίδων Κ. Πικάσης</strong></p>
    <p><br></p><p><br></p><p><br></p>
    <p style="text-align: right;">Μηχανικός Βιοΐατρικής Τεχνολογίας</p>
    <p style="text-align: right;">Ειδικός Ακοοπροθετιστής</p>
    <p style="text-align: right;">Υπεύθυνος Κέντρου Ακοής Λιβαδειάς</p>
</div>