<div id="page-wrapper" align="justify" lang="el">
    <div class="row">
        <?php 
            $ha_type = $this->ha_type->get($stock->type);
        ?>
        <div class="col-lg-8"><img src="<?= base_url() ?>images/pha_header.png" style="width: 1000px; height: 100px" alt=""/></div><div class="col-lg-4"><?php //echo $company->company_name ?></div> 
    </div>
    <p><br></p>
    <h2 align="center">ΕΝΤΥΠΟ ΕΠΙΣΚΕΥΗΣ (ΕΠΙΣΤΡΟΦΗΣ ΠΡΟΙΟΝΤΟΣ)</h2>
    <p><br></p>
    <p style="text-align: right;">
        <?php
        date_default_timezone_set("Europe/Athens");
        echo "Ημερομηνία Παραλαβής " . date("d-m-Y");
        //if (isset($stock->day_out)) {echo "Λιβαδειά " . $stock->day_out;}
        $today = date("d-m-Y");       
        ?>
    </p>
  

<div style="border: 1px solid black; width: 1000px; margin-bottom: 20px">    
    <table width="1000px" id="t01" >
        <tr><td> ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</td><td><strong><?php if(isset($customer->name)) echo $customer->name ?></strong></td></tr>
        <tr><td> ΚΑΤΑΣΚΕΥΑΣΤΙΚΟΣ ΟΙΚΟΣ:</td><td><strong><?php echo $manufacturer->name ?></strong></td></tr>
        <tr><td> ΤΥΠΟΣ ΑΚΟΥΣΤΙΚΟΥ:</td><td><strong><?php echo $stock->model?>- <?php echo $ha_type->type?></strong></td></tr>
        <tr><td> SERIAL NO:</td><td><strong><?php echo $stock->serial ?></strong></td></tr>
    </table>
    <p><br></p>
</div>    
<div style="border: 1px solid black; width: 1000px; margin-bottom: 20px">
    <table>
        <tr>
            <td>ΛΗΞΗ ΕΓΓΥΗΣΗΣ:</td>
            <td><strong><?php  echo $stock->guarantee_end; ?></strong></td>
        </tr>
    </table>
</div> 
<div style="border: 1px solid black; width: 1000px; height: 200px; margin-bottom: 20px">
    ΣΥΝΤΟΜΗ ΠΕΡΙΓΡΑΦΗ ΤΟΥ ΠΡΟΒΛΗΜΑΤΟΣ:
</div>
<div style="border: 1px solid black; width: 1000px; height: 200px; margin-bottom: 20px">
    <table>
        <thead>
        <tr>
        <th>ΑΠΟΦΑΣΗ ΔΙΟΡΘΩΤΙΚΗΣ ΕΝΕΡΓΕΙΑΣ:</th>
        <th>ΠΕΡΙΓΡΑΦΗ ΔΙΟΡΘΩΤΙΚΩΝ ΕΝΕΡΓΕΙΩΝ:</th>
        </tr>
        </thead>
        <tr>
            <td>
            <input type="checkbox" name="vehicle1" value="Bike"> ΕΠΙΣΚΕΥΗ<br>
            <input type="checkbox" name="vehicle1" value="Bike"> ΚΑΤΑΣΤΡΟΦΗ<br>
            <input type="checkbox" name="vehicle1" value="Bike"> ΕΠΙΣΤΡΟΦΗ ΣΤΟΝ ΠΡΟΜΗΘΕΥΤΗ ΠΡΟΣ ΑΝΤΙΚΑΤΑΣΤΑΣΗ<br>
            </td>
            <td></td>
        </tr>
    </table>    
</div>
<div style="border: 1px solid black; width: 1000px; height: 200px; margin-bottom: 20px">
ΕΠΙΠΛΕΟΝ ΔΙΟΡΘΩΤΙΚΕΣ ΚΑΙ ΠΡΟΛΗΠΤΙΚΕΣ ΕΝΕΡΓΕΙΕΣ ΠΟΥ ΑΠΟΦΑΣΙΣΤΗΚΑΝ:	 
</div> 		

 							 
 							 
 							 
 	 	 	 	 	 	 	 
							
<div style="text-align:right">				Ο ΥΠΕΥΘΥΝΟΣ ΔΙΑΧΕΙΡΙΣΗΣ ΕΠΙΣΤΡΕΦΟΜΕΝΩΝ>
    
    <p style="text-align: right;"><strong>Σπυρίδων Κ. Πικάσης</strong></p>
    <p><br></p><p><br></p><p><br></p>
    <p style="text-align: right;">Μηχανικός Βιοΐατρικής Τεχνολογίας</p>
    <p style="text-align: right;">Ειδικός Ακοοπροθετιστής</p>
</div> 
    <footer>
        F08.01_01
    </footer>