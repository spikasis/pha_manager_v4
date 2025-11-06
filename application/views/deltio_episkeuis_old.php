<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Δελτίο Επισκευής Ακουστικού</title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/mpdf_css_custom.css') ?>">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        td {
            border: 1px solid black;
            padding: 8px;
        }
        strong {
            font-weight: bold;
        }
        .title {
            text-align: center;
            font-size: 18px;
        }
        .conditions {
            font-size: 12px;
            text-align: justify;
        }
    </style>
</head>
<body>

    <table>
        <tr>
            <td colspan="12" class="title"><strong>ΔΕΛΤΙΟ ΕΠΙΣΚΕΥΗΣ ΑΚΟΥΣΤΙΚΟΥ</strong></td>
        </tr>
        <tr>
            <td colspan="2"><strong>ΟΝΟΜΑΤΕΠΩΝΥΜΟ:</strong></td>
            <td colspan="6"><?= isset($customer->name) ? $customer->name : '' ?></td>
            <td colspan="2"><strong>ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ:</strong></td>
            <td colspan="2"><?= isset($service->day_in) ? $service->day_in : '' ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>ΕΡΓΑΣΤΗΡΙΟ ΕΠΙΣΚΕΥΗΣ:</strong></td>
            <td colspan="6"><?= isset($lab_sent->name) ? $lab_sent->name : '' ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="12" class="title"><strong>ΣΤΟΙΧΕΙΑ ΑΚΟΥΣΤΙΚΟΥ</strong></td>
        </tr>
        <tr>
            <td colspan="2"><strong>ΕΤΑΙΡΕΙΑ:</strong></td>
            <td colspan="4"><?= $stock_brand->name ?></td>
            <td colspan="2"><strong>ΕΓΓΥΗΣΗ:</strong></td>
            <td colspan="4"><?= $stock->guarantee_end ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>ΜΟΝΤΕΛΟ:</strong></td>
            <td colspan="4"><?= $series->series ?> <?= $stock_model->model ?></td>
            <td colspan="2"><strong>S/N:</strong></td>
            <td colspan="4"><?= $stock->serial ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>ΤΥΠΟΣ:</strong></td>
            <td colspan="10"><?= $stock_type->type ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>ΣΥΜΠΤΩΜΑΤΑ:</strong></td>
            <td colspan="10"><?= $service->malfunction ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>ΣΧΟΛΙΑ ΤΕΧΝΙΚΟΥ:</strong></td>
            <td colspan="10"><?= $service->lab_report ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="12" class="conditions"><strong>Όροι & Προϋποθέσεις</strong> Το παρόν δελτίο παραλαβής είναι απαραίτητο για την παραλαβή του ακουστικού σας από το εργαστήριο μας. Η γραμματεία μας θα επικοινωνήσει μαζί σας για την παραλαβή. Ακουστικά που παραμένουν στην επιχείρησή μας χωρίς ενημέρωση πέραν του τριμήνου θα αποστέλλονται για ανακύκλωση. Η εταιρεία μας δεν έχει υποχρέωση να παραδώσει το ακουστικό χωρίς την προσκόμιση του παρόντος δελτίου.</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="6"><strong>ΑΚΟΥΣΤΙΚΟ ΑΝΤΙΚΑΤΑΣΤΑΣΗΣ</strong></td>
            <td colspan="6"><strong>ΗΜ/ΝΙΑ ΠΑΡΑΛΑΒΗΣ</strong></td>
        </tr>
        <tr>
            <td colspan="4"><strong>BRAND</strong></td>
            <td colspan="2"><strong>MODEL</strong></td>
            <td><strong>TYPE</strong></td>
            <td colspan="5"><strong>SERIAL NO</strong></td>
        </tr>
        <tr>
            <td colspan="4"><?= $ha_temp_brand->name ?></td>
            <td colspan="2"><?= $ha_temp->model ?></td>
            <td><?= $ha_temp_type->type ?></td>
            <td colspan="5"><?= $ha_temp->serial ?></td>
        </tr>
    </table>

    <p><strong>Υπογραφή Πελάτη:</strong> ____________________________________</p>

</body>
</html>
