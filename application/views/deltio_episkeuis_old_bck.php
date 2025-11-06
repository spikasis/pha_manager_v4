<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Δελτίο Επισκευής Ακουστικού</title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/mpdf_css_custom.css') ?>">
</head>
<body>
    <img src="<?= base_url() ?>images/pha_header.png" style="height: 80px" alt="Header Image">
    <table class="table" style="border: 1px solid black; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td colspan="6" style="border: 1px solid black;"><strong>ΔΕΛΤΙΟ ΕΠΙΣΚΕΥΗΣ ΑΚΟΥΣΤΙΚΟΥ</strong></td>
            <td colspan="6" style="border: 1px solid black;">ΑΠΟΚΟΜΜΑ ΕΡΓΑΣΤΗΡΙΟΥ ΕΠΙΣΚΕΥΗΣ</td>
        </tr>
        <tr>
            <td colspan="2">ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</td>
            <td colspan="6"><?= isset($customer->name) ? $customer->name : '' ?></td>
            <td colspan="4">ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</td>
            <td><?= isset($service->day_in) ? $service->day_in : '' ?></td>
        </tr>
        <tr>
            <td colspan="2">ΠΟΛΗ:</td>
            <td colspan="4"><?= isset($customer->city) ? $customer->city : '' ?></td>
            <td colspan="4">ΕΡΓΑΣΤΗΡΙΟ ΕΠΙΣΚΕΥΗΣ:</td>
            <td colspan="4"><?= isset($lab_sent->name) ? $lab_sent->name : '' ?></td>
        </tr>
        <tr>
            <td colspan="4"><strong>ΣΤΟΙΧΕΙΑ ΑΚΟΥΣΤΙΚΟΥ</strong></td>
        </tr>
        <tr>
            <td colspan="2">ΕΤΑΙΡΕΙΑ:</td>
            <td colspan="2"><?= $stock_brand->name ?></td>
            <td colspan="4">ΛΗΞΗ ΕΓΓΥΗΣΗΣ:</td>
            <td colspan="4"><?= $stock->guarantee_end ?></td>
        </tr>
        <tr>
            <td colspan="2">ΜΟΝΤΕΛΟ:</td>
            <td colspan="6"><?= $stock_brand->name ?> - <?= $series->series ?> <?= $stock_model->model ?></td>
            <td colspan="4"><strong>S/N:</strong> <?= $stock->serial ?></td>
        </tr>
        <tr>
            <td><strong>ΣΥΜΠΤΩΜΑΤΑ:</strong></td>
            <td colspan="11"><?= $service->malfunction ?></td>
        </tr>
        <tr>
            <td>ΕΝΗΜΕΡΩΣΗ ΚΟΣΤΟΥΣ</td>
            <td>NAI</td>
        </tr>
        <tr>
            <td colspan="4">ΣΧΟΛΙΑ ΤΕΧΝΙΚΟΥ:</td>
            <td colspan="11"><?= $service->lab_report ?></td>
        </tr>
    </table>
    <hr>
    <table class="table" style="border: 1px solid black; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td colspan="6" style="border: 1px solid black;"><strong>ΔΕΛΤΙΟ ΕΠΙΣΚΕΥΗΣ ΑΚΟΥΣΤΙΚΟΥ</strong></td>
            <td colspan="5"></td>
            <td colspan="5">ΑΠΟΚΟΜΜΑ ΓΡΑΜΜΑΤΕΙΑΣ</td>
        </tr>
        <tr>
            <td colspan="4">ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</td>
            <td colspan="2"><?= isset($customer->name) ? $customer->name : '' ?></td>
            <td>ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</td>
            <td><?= isset($service->day_in) ? $service->day_in : '' ?></td>
        </tr>
        <tr>
            <td colspan="4">ΔΙΕΥΘΥΝΣΗ:</td>
            <td colspan="2"><?= isset($customer->address) ? $customer->address : '' ?></td>
        </tr>
        <tr>
            <td colspan="4">ΤΗΛΕΦΩΝΑ:</td>
            <td><?= isset($customer->phone_home) ? $customer->phone_home : '' ?></td>
            <td colspan="3"><?= isset($customer->phone_mobile) ? $customer->phone_mobile : '' ?></td>
        </tr>
        <tr>
            <td colspan="4">ΠΟΛΗ:</td>
            <td colspan="2"><?= isset($customer->city) ? $customer->city : '' ?></td>
        </tr>
        <tr>
            <td colspan="4">ΣΤΟΙΧΕΙΑ ΑΚΟΥΣΤΙΚΟΥ</td>
        </tr>
        <tr>
            <td colspan="4">ΕΤΑΙΡΕΙΑ:</td>
            <td colspan="2"><?= $stock_brand->name ?></td>
            <td>S/N:</td>
            <td colspan="8"><?= $stock->serial ?></td>
        </tr>
        <tr>
            <td colspan="4">ΜΟΝΤΕΛΟ:</td>
            <td colspan="2"><?= $series->series ?> <?= $stock_model->model ?></td>
            <td>ΔΙΚΟ ΜΑΣ:</td>
            <td>ΝΑΙ</td>
            <td>ΕΡΓΑΣΤΗΡΙΟ ΕΠΙΣΚΕΥΗΣ:</td>
            <td colspan="2"><?= isset($lab_sent->name) ? $lab_sent->name : '' ?></td>
        </tr>
        <tr>
            <td colspan="4">ΤΥΠΟΣ:</td>
            <td colspan="2"><?= $stock_type->type ?></td>
        </tr>
        <tr>
            <td>ΣΥΜΠΤΩΜΑΤΑ:</td>
            <td colspan="14"><?= $service->malfunction ?></td>
        </tr>        
    </table>
    <hr>
    <table class="table" style="border: 1px solid black; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td colspan="6" style="border: 1px solid black;"><strong>ΔΕΛΤΙΟ ΠΑΡΑΛΑΒΗΣ ΑΚΟΥΣΤΙΚΟΥ</strong></td>
            <td colspan="5">ΗΜ/ΝΙΑ Παραλαβής</td>
            <td colspan="3"><?= $service->day_in ?></td>
        </tr>
        <tr>
            <td colspan="4">BRAND</td>
            <td colspan="2">MODEL</td>
            <td>TYPE</td>
            <td colspan="7">SERIAL NO</td>
        </tr>
        <tr>
            <td colspan="4"><?= $stock_brand->name ?></td>
            <td colspan="2"><?= $series->series ?> <?= $stock_model->model ?></td>
            <td><?= $stock_type->type ?></td>
            <td colspan="7"><?= $stock->serial ?></td>
        </tr>
        <tr>
            <td>Ακουστικό Αντικατάστασης</td>
            <td><?= $ha_temp->id == 893 ? '' : 'X' ?></td>
            <td colspan="2"><?= $ha_temp_brand->name ?></td>
            <td colspan="2"><?= $ha_temp->model ?></td>
            <td><?= $ha_temp_type->type ?></td>
            <td colspan="7"><?= $ha_temp->serial ?></td>
        </tr>
        <tr>
            <td colspan="15"><strong>Όροι & Προϋποθέσεις</strong> Το παρόν δελτίο παραλαβής είναι απαραίτητο για την παραλαβή του ακουστικού σας από το εργαστήριο μας. Η γραμματεία μας θα επικοινωνήσει μαζι σας για την παραλαβή</td>
        </tr>
    </table>
</body>
</html>
