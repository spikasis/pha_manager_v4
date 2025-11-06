<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; font-size: 10px; margin: 0; padding: 0;">

    <!-- Εικόνα Header -->
    <img src="<?= base_url() ?>images/banner_pikashs.jpg" alt="Header Image" style="width: 100%; height: auto; margin-bottom: 10px;">

    <!-- Πίνακας 1: Δελτίο Επισκευής Ακουστικού -->
    <table width="100%" style="border-collapse: collapse; margin-bottom: 20px; background-color: #e3f2fd;">
        <tr>
            <td colspan="6" style="text-align: center; font-size: 11px; font-weight: bold; border: 1px solid black;">ΔΕΛΤΙΟ ΕΠΙΣΚΕΥΗΣ ΑΚΟΥΣΤΙΚΟΥ</td>
            <td colspan="6" style="text-align: center; font-size: 11px; border: 1px solid black;">ΑΠΟΚΟΜΜΑ ΕΡΓΑΣΤΗΡΙΟΥ ΕΠΙΣΚΕΥΗΣ</td>
        </tr>
        <tr>
    <td colspan="3" style="border: 1px solid black; font-weight: bold;">
        ΛΙΒΑΔΕΙΑ 
        <span style="display: inline-block; width: 12px; height: 12px; border: 1px solid black; text-align: center; 
            font-weight: bold; line-height: 12px; <?php echo ($stock->selling_point == 1) ? 'background-color: black; color: white;' : ''; ?>">
            <?php echo ($stock->selling_point == 1) ? '&#10003;' : ''; ?>
        </span>
    </td>
    <td colspan="3" style="border: 1px solid black; font-weight: bold;">
        ΘΗΒΑ 
        <span style="display: inline-block; width: 12px; height: 12px; border: 1px solid black; text-align: center; 
            font-weight: bold; line-height: 12px; <?php echo ($stock->selling_point == 2) ? 'background-color: black; color: white;' : ''; ?>">
            <?php echo ($stock->selling_point == 2) ? '&#10003;' : ''; ?>
        </span>
    </td>
    <td colspan="6" rowspan="2" style="border: 1px solid black; text-align: center;">
        <strong>R 
            <span style="display: inline-block; width: 12px; height: 12px; border: 1px solid black; text-align: center; 
                font-weight: bold; line-height: 12px;">
            </span>
        </strong> &nbsp;&nbsp;&nbsp;
        <strong>L 
            <span style="display: inline-block; width: 12px; height: 12px; border: 1px solid black; text-align: center; 
                font-weight: bold; line-height: 12px;">
            </span>
        </strong>
    </td>
</tr>



        </tr>
        <tr>
            <td colspan="6" style="border: 1px solid black; font-weight: bold;">ΟΝΟΜΑΤΕΠΩΝΥΜΟ: <?= isset($customer->name) ? $customer->name : '' ?></td>
        </tr>
        <tr>
            <td colspan="6" style="border: 1px solid black;">ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ: <?= isset($service->day_in) ? $service->day_in : '' ?></td>
            <td colspan="6" style="border: 1px solid black;">ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΔΟΣΗΣ: <?= isset($service->day_out) ? $service->day_out : '' ?></td>
        </tr>
        <!-- 
        <tr>
            <td colspan="6" style="border: 1px solid black;">ΠΟΛΗ: <?= isset($customer->city) ? $customer->city : '' ?></td>
            <td colspan="6" style="border: 1px solid black;">ΔΙΕΥΘΥΝΣΗ: <?= isset($customer->address) ? $customer->address : '' ?></td>
        </tr>
       <tr>
            <td colspan="6" style="border: 1px solid black;">ΤΗΛΕΦΩΝΑ: <?= isset($customer->phone_home) ? $customer->phone_home : '' ?> / <?= isset($customer->phone_mobile) ? $customer->phone_mobile : '' ?></td>
            <td colspan="6" style="border: 1px solid black;">EMAIL: <?= isset($customer->email) ? $customer->email : '' ?></td>
        </tr>
        -->
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; background-color: #bbdefb; border: 1px solid black;">ΣΤΟΙΧΕΙΑ ΑΚΟΥΣΤΙΚΟΥ</td>
            <td colspan="6" style="border: 1px solid black; font-weight: bold;">ΕΝΗΜΕΡΩΣΗ ΚΟΣΤΟΥΣ <input type="checkbox"></td>
        </tr>
        <tr>
            <td colspan="3" style="border: 1px solid black; font-weight: bold;">ΕΤΑΙΡΕΙΑ: <?= $stock_brand->name ?></td>
            <td colspan="3" style="border: 1px solid black; font-weight: bold;">ΤΥΠΟΣ: <?= $stock_type->type ?></td>
            <td colspan="6" style="border: 1px solid black; font-weight: bold;">ΛΗΞΗ ΕΓΓΥΗΣΗΣ: <?= $stock->guarantee_end ?></td>
        </tr>
        <tr>
            <td colspan="3" style="border: 1px solid black;">ΜΟΝΤΕΛΟ: <?= $series->series ?> <?= $stock_model->model ?></td>
            <td colspan="3" style="border: 1px solid black;">ΕΡΓΑΣΤΗΡΙΟ: <?= $vendor->name ?></td>
            <td colspan="6" style="border: 1px solid black;">S/N: <?= $stock->serial ?></td>
        </tr>
        <tr>
            <td colspan="12" style="border: 1px solid black; font-weight: bold;">ΣΥΜΠΤΩΜΑΤΑ:</td>
        </tr>
        <tr>
            <td colspan="12" style="border: 1px solid black;"><?= $service->malfunction ?></td>
        </tr>
        <tr>
            <td colspan="12" style="border: 1px solid black; font-weight: bold;">ΣΧΟΛΙΑ ΤΕΧΝΙΚΟΥ:</td>
        </tr>
        <tr>
            <td colspan="12" style="border: 1px solid black;  padding: 20px 0;"><?= $service->lab_report ?></td>
        </tr>
    </table>

    <!-- Διακεκομμένη γραμμή -->
    <div style="border-top: 1px dashed black; height: 2px; margin: 20px 0;"></div>

    <!-- Πίνακας 2: Απόκομμα Γραμματείας -->
    <table width="100%" style="border-collapse: collapse; margin-bottom: 20px; background-color: #fff9c4;">
        <tr>
            <td colspan="6" style="text-align: center; font-size: 11px; font-weight: bold; border: 1px solid black;">ΔΕΛΤΙΟ ΕΠΙΣΚΕΥΗΣ ΑΚΟΥΣΤΙΚΟΥ</td>
            <td colspan="6" style="text-align: center; font-size: 11px; border: 1px solid black;">ΑΠΟΚΟΜΜΑ ΓΡΑΜΜΑΤΕΙΑΣ</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; font-weight: bold;">ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</td>
            <td colspan="4" style="border: 1px solid black;"><?= isset($customer->name) ? $customer->name : '' ?></td>
            <td colspan="2" style="border: 1px solid black; font-weight: bold;">ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</td>
            <td colspan="4" style="border: 1px solid black;"><?= isset($service->day_in) ? $service->day_in : '' ?></td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; font-weight: bold;">ΔΙΕΥΘΥΝΣΗ:</td>
            <td colspan="10" style="border: 1px solid black;"><?= isset($customer->address) ? $customer->address : '' ?></td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; font-weight: bold;">ΤΗΛΕΦΩΝΑ:</td>
            <td colspan="10" style="border: 1px solid black;"><?= isset($customer->phone_home) ? $customer->phone_home : '' ?> - <?= isset($customer->phone_mobile) ? $customer->phone_mobile : '' ?></td>
            
            </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; font-weight: bold;">ΠΟΛΗ:</td>
            <td colspan="4" style="border: 1px solid black;"><?= isset($customer->city) ? $customer->city : '' ?></td>
            <td colspan="8" style="border: 1px solid black;">ΕΡΓΑΣΤΗΡΙΟ: <?= $vendor->name ?></td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: center; font-size: 11px; font-weight: bold; background-color: #fff59d; border: 1px solid black;">ΣΤΟΙΧΕΙΑ ΑΚΟΥΣΤΙΚΟΥ</td>
        </tr>
        <tr>
            
            <td colspan="2" style="border: 1px solid black; font-weight: bold;">ΕΤΑΙΡΕΙΑ:</td>
            <td colspan="4" style="border: 1px solid black;"><?= $stock_brand->name ?></td>            
            <td colspan="4" style="border: 1px solid black; font-weight: bold;">S/N: <?= $stock->serial ?></td>
           
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; font-weight: bold;">ΜΟΝΤΕΛΟ:</td>
            <td colspan="4" style="border: 1px solid black;"><?= $series->series ?> <?= $stock_model->model ?></td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; font-weight: bold;">ΤΥΠΟΣ:</td>
            <td colspan="4" style="border: 1px solid black;"><?= $stock_type->type ?></td>
        </tr>
        <tr>
            <td colspan="12" style="border: 1px solid black; font-weight: bold;">ΣΥΜΠΤΩΜΑΤΑ:</td>
        </tr>
        <tr>
            <td colspan="12" style="border: 1px solid black;"><?= $service->malfunction ?></td>
        </tr>

        <!-- Όροι και πεδίο υπογραφής -->
        <tr>
            <td colspan="12" style="border: 1px solid black; font-size: 9px; padding: 5px;">
                <strong>Όροι & Προϋποθέσεις:</strong> Το παρόν δελτίο παραλαβής είναι απαραίτητο για την παραλαβή του ακουστικού σας από το εργαστήριο μας. Η γραμματεία μας θα επικοινωνήσει μαζί σας για την παραλαβή του ακουστικού. Ακουστικά που παραμένουν στην επιχείρηση μας χωρίς ενημέρωση πέραν του τριμήνου θα αποστέλλονται για ανακύκλωση.
            </td>
        </tr>
        <tr>
            <td colspan="12" style="border: 1px solid black; font-size: 10px; padding: 5px;">
                <strong>Παρέλαβα ακουστικό αντικατάστασης:</strong> 
                <div style="float: right;">S/N:<?= $ha_temp->serial  ?> - <?= $ha_temp_brand->name ?> - <?= $ha_temp_series->series ?> - <?= $ha_temp_model->model ?> - <?= $ha_temp_type->type ?>.<br><br>
                <strong>Υπογραφή πελάτη:</strong> ...............................................
                </div>
            </td>
        </tr>
    </table>

    <!-- Διακεκομμένη γραμμή -->
    <div style="border-top: 1px dashed black; height: 2px; margin: 20px 0;"></div>

    <!-- Πίνακας 3: Δελτίο Παραλαβής -->
    <table width="100%" style="border-collapse: collapse; margin-bottom: 20px; background-color: #c8e6c9;">
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; border: 1px solid black;">ΔΕΛΤΙΟ ΠΑΡΑΛΑΒΗΣ ΑΚΟΥΣΤΙΚΟΥ</td>
            <td colspan="4" style="font-weight: bold; border: 1px solid black; width: 25%;">ΗΜ/ΝΙΑ Παραλαβής:</td>
            <td colspan="2" style="border: 1px solid black;"><?= $service->day_in ?></td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold; border: 1px solid black;">BRAND:</td>
            <td colspan="4" style="border: 1px solid black;"><?= $stock_brand->name ?></td>
            <td colspan="2" style="font-weight: bold; border: 1px solid black;">MODEL:</td>
            <td colspan="4" style="border: 1px solid black;"><?= $series->series ?> <?= $stock_model->model ?></td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold; border: 1px solid black;">TYPE:</td>
            <td colspan="4" style="border: 1px solid black;"><?= $stock_type->type ?></td>
            <td colspan="2" style="font-weight: bold; border: 1px solid black;">SERIAL NO:</td>
            <td colspan="4" style="border: 1px solid black;"><?= $stock->serial ?></td>
        </tr>
        <tr>
            <td colspan="12" style="font-weight: bold; border: 1px solid black;">ΑΚΟΥΣΤΙΚΟ ΑΝΤΙΚΑΤΑΣΤΑΣΗΣ:</td>
        </tr>
        <tr>
            <td colspan="12" style="border: 1px solid black;">S/N:<?= $ha_temp->serial  ?> - <?= $ha_temp_brand->name ?> - <?= $ha_temp_series->series ?> - <?= $ha_temp_model->model ?> - <?= $ha_temp_type->type ?></td>
        </tr>
        <tr>
            <td colspan="12" style="border: 1px solid black; font-size: 9px;">
                <strong>Όροι & Προϋποθέσεις:</strong> Το παρόν δελτίο παραλαβής είναι απαραίτητο για την παραλαβή του ακουστικού σας από το εργαστήριο μας. Η γραμματεία μας θα επικοινωνήσει μαζί σας για την παραλαβή του ακουστικού. Ακουστικά που παραμένουν στην επιχείρηση μας χωρίς ενημέρωση πέραν του τριμήνου θα αποστέλλονται για ανακύκλωση.
            </td>
        </tr>
    </table>

</body>
</html>
