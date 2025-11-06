<!DOCTYPE html>
<html>
<head>
</head>
<body style="font-family: Arial, sans-serif; margin: 20px; line-height: 1.6;">

    <div style="width: 100%; overflow: hidden; margin-bottom: 20px;">
        <div>
            <img src="<?= base_url('images/banner_pikashs.jpg') ?>" style="height: 100px;"/>
        </div>
    </div>
    <div>
        <div>
            <h1 style="margin: 0; font-size: 18px; font-family: Arial;">ΚΑΡΤΕΛΑ ΠΕΛΑΤΗ</h1>
        </div>
    </div>

    <div style="border: 1px solid #ddd; border-radius: 4px; margin-bottom: 20px; padding: 15px;">
        <div style="background-color: #f5f5f5; padding: 10px; border-bottom: 1px solid #ddd;">
            <strong style="font-size: 18px; font-family: Arial;">Στοιχεία Πελάτη - </strong><?= $customer->name ?>
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tbody>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>Διεύθυνση:</strong></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $customer->address ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>Πόλη:</strong></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $customer->city ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>Ημ/νια Γέννησης:</strong></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $customer->birthday ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>Τηλέφωνο:</strong></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $customer->phone_home ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>Κινητό:</strong></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $customer->phone_mobile ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>ΑΜΚΑ:</strong></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $customer->amka ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>Γιατρός:</strong></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $doctor->doc_name ?></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>Πρώτη Επίσκεψη:</strong></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $customer->first_visit ?></td>                    
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>Σημείο Εξυπηρέτησης:</strong></td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $selling_points->city ?></td>
                </tr>                
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><strong>Σχόλια:</strong></td>
                    <td colspan="8" style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="border: 1px solid #ddd; border-radius: 4px; margin-bottom: 20px; padding: 15px;">
        <div style="background-color: #f5f5f5; padding: 10px; border-bottom: 1px solid #ddd;">
            <strong style="font-size: 18px; font-family: Arial;">Στοιχεία Πωλήσεων</strong>
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tbody>
                <tr>
                    <td colspan="5" style="border: 1px solid #ddd; padding: 8px; font-family: Arial;">
                        Serial No: <strong><?= $stock->serial ?></strong>                            
                    </td>
                </tr>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f9f9f9; font-family: Arial;">Κατασκευαστικός Οίκος</th>
                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f9f9f9; font-family: Arial;">Μοντέλο</th>
                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f9f9f9; font-family: Arial;">Τύπος</th>
                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f9f9f9; font-family: Arial;">Ημ/νια Πώλησης</th>
                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f9f9f9; font-family: Arial;">Λήξη Εγγύησης</th>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $manufacturer->name ?></td> <!-- Κατασκευαστικός Οίκος -->
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $series->series ?> <?= $stock_model->model ?></td> <!-- Μοντέλο -->
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $type->type ?></td> <!-- Τύπος -->
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $stock->day_out ?></td> <!-- Ημ/νια Πώλησης -->
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $stock->guarantee_end ?></td> <!-- Λήξη Εγγύησης -->
                </tr>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f9f9f9; font-family: Arial;">Barcode Εκτέλεσης: </th>
                    <td style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $stock->ekapty_code?></td> <!-- barcode εκτελεσης -->
                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f9f9f9; font-family: Arial;">Κωδικός Εκτέλεσης: </th>
                    <td colspan="4" style="border: 1px solid #ddd; padding: 8px; font-family: Arial;"><?= $stock->ektelesi_eopyy?></td> <!-- kwdikos ektelesis -->
                    
                </tr>
                
            </tbody>
        </table>
    </div>

</body>
</html>
