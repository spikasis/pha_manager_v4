<div id="page-wrapper" align="justify" lang="el" >
    <div class="row">
        <?php if (count($brands)): ?>
            <?php foreach ($brands as $key => $list):?>
            <?php //echo json_encode($brands) ?>
        <h2 style="align-content: center">Στατιστικά επισκευων-βλαβων εταιρίας <?php echo $brand->name ?></h2>
        <div class="col-lg-7">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <th>ΣΤΑΤΙΣΤΙΚΑ ΕΠΙΣΚΕΥΩΝ σε σύνολο</th>               
                <th><?php echo json_encode(count($fittings)) ?> εφαρμογών</th> 
                <th>Ποσοστό</th>
                <tr>
                    <td>Μεγάφωνα</td>
                    <td><?php echo json_encode(count($receivers)) ?></td>
                    <td><?php echo round(((count($receivers))/count($fittings))*100, 2) ?>%</td>
                </tr>  
                <tr>
                    <td>Μικρόφωνα</td>
                    <td><?php echo json_encode(count($microphones)) ?></td>
                    <td><?php echo round(((count($microphones))/count($fittings))*100, 2) ?>%</td>
                </tr> 
                <tr>
                    <td>Ενισχυτές</td>
                    <td><?php echo json_encode(count($amplifiers)) ?></td>
                    <td><?php echo round(((count($amplifiers))/count($fittings))*100, 2) ?>%</td>
                </tr> 
                <tr>
                    <td>Επανακατασκευές Εργαστηρίου (Αφορά Αντιπροσωπο)</td>
                    <td><?php echo json_encode(count($earmolds_redesign)) ?></td>
                    <td><?php echo round(((count($earmolds_redesign))/count($fittings))*100, 2) ?>%</td>
                </tr> 
                <tr>
                    <td>Καθαρισμοί Μικρόφωνα/Μεγάφωνα</td>
                    <td><?php echo json_encode(count($cleaning)) ?></td>
                    <td><?php echo round(((count($cleaning))/count($fittings))*100, 2) ?>%</td>
                </tr>
            </table>
        </div>  
        <?php endforeach; ?>
        <?php endif; ?>
        
    </div>  
</div>