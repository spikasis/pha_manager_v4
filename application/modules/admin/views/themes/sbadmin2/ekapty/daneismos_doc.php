<div id="page-wrapper" align="justify" lang="el">
    <div class="row">
        <?php 
            $ha_type = $this->ha_type->get($stock->type);
        ?>
        <div class="col-lg-8"><img src="<?= base_url() ?>images/pha_header.png" style="width: 1000px; height: 100px" alt=""/></div><div class="col-lg-4"><?php //echo $company->company_name ?></div> 
    </div>
    <p><br></p>
        <h2 align="center">ΕΝΤΥΠΟ ΔΑΝΕΙΣΜΟΥ - ΕΠΙΣΤΡΟΦΗΣ ΠΡΟΙΟΝΤΟΣ</h2>
    <p><br></p>
    <h3 align="center">ΔΑΝΕΙΣΜΟΣ ΠΡΟΙΟΝΤΟΣ</h3>
<div style="border: 1px solid black; width: 1000px; margin-bottom: 20px">    
    <table width="1000px" id="t01" >
        <tr><td> ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</td><td><strong><?php if (isset($customer->name)) echo $customer->name  ?></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ:</td><td><strong><?php date_default_timezone_set("Europe/Athens"); echo "" . date("d-m-Y");?></strong></td></tr>
        <tr><td> ΥΠΟΓΡΑΦΗ :</td></tr>
        <tr><td> ΚΑΤΑΣΚΕΥΑΣΤΙΚΟΣ ΟΙΚΟΣ:</td><td><strong><?php echo $manufacturer->name ?></strong></td></tr>
        <tr><td> ΤΥΠΟΣ ΑΚΟΥΣΤΙΚΟΥ:</td><td><strong><?php echo $stock->model?>- <?php echo $ha_type->type?></strong></td></tr>
        <tr><td> SERIAL NO:</td><td><strong><?php echo $stock->serial ?></strong></td></tr>
    </table>
    <p><br></p>
</div>
    <p><br></p>
        <h3 align="center">ΕΠΙΣΤΡΟΦΗ ΠΡΟΙΟΝΤΟΣ</h3>
    <p><br></p>
<div style="border: 1px solid black; width: 1000px; margin-bottom: 20px">    
    <table width="1000px" id="t01" >
        <tr><td> ΥΠΕΥΘΥΝΟΣ ΠΑΡΑΛΑΒΗΣ:</td><td><strong></strong></td></tr>
        <tr><td> ΗΜΕΡΟΜΗΝΙΑ:</td></tr>
        <tr><td> ΥΠΟΓΡΑΦΗ  :</td></tr>
    </table>
    <p><br></p>
</div> 
<div style="border: 1px solid black; width: 1000px; height: 200px; margin-bottom: 20px">
        <table>
        <thead>
        <tr>
        <th>ΕΛΕΓΧΟΣ:</th>
        </tr>
        </thead>
        <tr>
            <td>
            <input type="checkbox" name="vehicle1" value="Bike"> Το προϊόν είναι σε πλήρως λειτουργική κατάσταση και είναι προς διάθεση<br>
            <input type="checkbox" name="vehicle1" value="Bike"> Το προϊόν χρήζει επισκευής<br>
            <input type="checkbox" name="vehicle1" value="Bike"> Το προϊόν δεν πληροί τις προδιαγραφές, να συνταχθεί δελτίο καταστροφής<br>
            </td>
            <td></td>
        </tr>
        <tr><p></p></tr>
        <tr>
            <td>
                <strong>ΣΧΟΛΙΑ:</strong>
            </td>
        </tr>
    </table>    
</div>    
    <p style="text-align: right;"><strong>ΥΠΕΥΘΥΝΟΣ ΤΕΧΝΙΚΟΥ ΕΛΕΓΧΟΥ</strong></p>
    <p><br></p><p><br></p><p><br></p>
    <p style="text-align: right;">ΛΙΒΑΔΕΙΑ</p>
    <p style="text-align: right;"></p>
</div> 
    <footer style="text-align: left">
        F03.03_01
    </footer>