<div id="page-wrapper" lang="el" align="justify" style="width: 210mm; height: 297mm">
    <div class="row">
        <table style="width: 900px;">
            <tbody>
                <tr>
                    <td style="width: 500px;">
                        <div class="col-sm-5" style="align-content: left;">
                            <img src="<?= base_url() ?>images/logo_pha.png" alt="Pikasis Hearing Aids" width="280" />
                        </div>
                    </td>
                    <td style="width: 400px;">
                        <div class="col-sm-7" style="text-align: right">
                            <strong>Κέντρο Ακοής <?php echo $selling_point->city?></strong>   
                            <strong>Ημ/νια Προσφοράς: <?php echo $offer->offer_date?></strong>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <p><br></p>
    <table style="width: 900px;" style="align-content: center">
        <tr>
            <td style="width: 900px;">
                <div class="col-lg-12" style="text-align: center;">                    
                    <p><h1><strong>ΟΙΚΟΝΟΜΙΚΗ ΠΡΟΣΦΟΡΑ</strong></h1></p>
                <p><h3>Αποκατάστασης Βαρηκοΐας μέσω Ακουστικών</h3></p>
                </div>
            </td>
            
        </tr>
    </table>
    <p><br></p><p><br></p><p><br></p><p><br></p>
<div class=""row">    
    <p>Το κέντρο ακοής <strong>"Πικάσης - Εφαρμογές Ακοής"</strong> προσφέρει στον ασφαλισμένο <strong><?php echo $customer->name?></strong>  πακέτο αποκατάστασης βαρηκοΐας με 
    <?php echo $offer->quantity;?>
        <?php
        if ($offer->quantity > 1): echo "ακουστικά"; 
        else: echo "ακουστικό"; 
        endif;
        ?> 
    βαρηκοΐας της εταιρίας 
        <?php echo $offer->hearing_aid ?> .
    </p>
    <p>
        Στο πακέτο περιλαμβάνεται:
        <ul>
            <li>η συσκευή-ές (ακουστικό βαρηκοΐας),</li>
            <li>η κατασκευή κελύφους ή εκμαγείου για την σωστή εφαρμογή του ακουστικό στον βαρήκοο, </li>
            <li> η απαιτούμενη προσαρμογή μέσω ρυθμίσεων του ακουστικού στον βαρήκοο </li><!-- comment -->
            <li> οι τακτικές συντηρήσεις της συσκευής (καθάρισμα - αλλαγή σωληνάκια κλπ).</li>
        </ul>
         Η προσαρμογή αποτελείται απο 4 διαδοχικές συνεδρίες σταδιακής 
         αύξησης της ενίσχυσης, σύν τη συνεδρία αξιολόγησης της βαρηκοΐας και δοκιμής του ακουστικού.
    </p>
</div>
    <div class=""row" style="margin: 20px">  
        <table>
            <tr>
                <td style="width: 600px; align-content: left"> Κόστος εφαρμογής Ακουστικού(ών) <?php echo $offer->hearing_aid ?></td>
                <td style="width: 200px; align-content: right">€ <?php echo $offer->price ?></td>
            </tr>
            <tr>
                <td style="width: 600px; align-content: left"> Συμμετοχή ασφαλιστικού Φορέα (Ε.Ο.Π.Υ.Υ)</td>
                <td style="width: 200px; align-content: right">€ <?php echo $offer->eopyy ?></td>
            </tr>
            <hr />
            <tr>
                <td style="width: 600px; align-content: left"> Τελικό κόστος για τον Ασφαλισμένο</td>
                <td style="width: 200px; align-content: right"> € <?php echo $offer->final_price ?></td>
            </tr>
        </table>                                                       
    </div>
    <p style="font: 10px;">
        <strong>Όροι & Προϋποθέσεις:</strong>
        Η παρούσα προσφορά ισχύει για 2 μήνες και εφόσον η βαρηκοΐα του ασθενούς 
        δέν έχει μεταβληθεί σημαντικά. Για τον παραγγελία θα πρέπει να καταβάλετε 
        το 30% ως προκαταβολή και η εξώφληση γίνεται με την εφαρμογή του ακουστικού 
        στον ασθενή. Για την αξιοποίηση της επιδότησης του Ε.Ο.Π.Υ.Υ. θα πρέπει να 
        έχουν περάσει τουλάχιστον 4 χρόνια απο την προηγούμενη εφαρμογή ακουστικού 
        βαρηκοΐας, αλλιώς ο ασφαλισμένος δέν δικαιούται της επιδότησης και επιβαρύνεται 
        με το σύνολο του ποσού.
    </p>
</div>