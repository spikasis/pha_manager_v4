<div id="page-wrapper" lang="el" style="width: 210mm; height: 297mm">  
  <head>
    <meta charset="UTF-8">
    <style type="text/css">
      @page {
        size: A4;
        margin: 20mm 15mm 20mm 15mm;
      }
      body {
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 11pt;
        line-height: 1.5;
        margin: 20mm 15mm 20mm 15mm;
      }
      h1, h2, h3 {
        font-weight: bold;
      }
      h2 {
        margin-top: 20px;
        font-size: 14pt;
      }
      p {
        margin: 10px 0;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        page-break-after: auto;
      }
      th, td {
        padding: 5px;
        text-align: left;
        vertical-align: top;
      }
      th {
        font-weight: bold;
        background-color: #f4f4f4;
      }
      td {
        border: 1px solid #ddd;
      }
      .no-border {
        border: none;
      }
      .highlight {
        font-weight: bold;
        background-color: #e0e0e0;
      }
      .page-break {
        page-break-before: always;
      }
    </style>
  </head>
  <body>
    <table>
      <tr>
        <td class="no-border">
          <img src="<?= base_url() ?>images/pha_header.png" alt="Λογότυπο" style="height: 80px;">
        </td>
        <td class="no-border" style="text-align: right;">
          <?php echo $company->company_name ?>
        </td>
      </tr>
    </table>

    <h2>ΔΕΛΤΙΟ ΕΠΙΣΚΕΥΗΣ ΑΚΟΥΣΤΙΚΟΥ</h2>

    <table>
      <tr>
        <th colspan="4">ΟΝΟΜΑΤΕΠΩΝΥΜΟ</th>
        <td colspan="4"><?php if (isset($customer->name)) echo $customer->name; ?></td>
        <th colspan="2">ΕΡΓΑΣΤΗΡΙΟ ΕΠΙΣΚΕΥΗΣ</th>
        <td colspan="2"><?php if (isset($lab_sent->name)) echo $lab_sent->name; ?></td>
      </tr>
      <tr>
        <th>ΠΟΛΗ</th>
        <td><?php if (isset($customer->city)) echo $customer->city; ?></td>
        <th>ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΛΑΒΗΣ</th>
        <td><?php if (isset($service->day_in)) echo $service->day_in; ?></td>
      </tr>
      <!-- Προσθέστε όσα πεδία χρειάζονται -->
    </table>

    <h2>ΣΤΟΙΧΕΙΑ ΑΚΟΥΣΤΙΚΟΥ</h2>

    <table>
      <tr>
        <th>ΕΤΑΙΡΕΙΑ</th>
        <td><?php echo $stock_brand->name ?></td>
        <th>ΜΟΝΤΕΛΟ</th>
        <td><?php echo $model->model ?> - S/N: <?php echo $stock->serial ?></td>
      </tr>
      <!-- Άλλα πεδία -->
    </table>

    <h2>ΣΥΜΠΤΩΜΑΤΑ</h2>
    <p><?php echo $service->malfunction; ?></p>

    <!-- Διάφορα άλλα τμήματα πληροφοριών -->

    <!-- Παράδειγμα διάσπασης σελίδας -->
    <div class="page-break"></div>

    <h2>ΔΕΛΤΙΟ ΠΑΡΑΛΑΒΗΣ ΑΚΟΥΣΤΙΚΟΥ</h2>

    <!-- Πίνακας ή τμήματα για άλλες πληροφορίες -->
  </body>
</div>
