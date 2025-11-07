<div id="page-wrapper">    
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>
                    <?= $title ?>  <?= count($stock_on_test_no) ?> ακουστικά Demo
                </h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->  

    <!-- Table for items with on_test = 0 -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Ακουστικά Demo (Σε Δοκιμή: Όχι)</div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Πελάτης</th>
                                    <th>Ημ/νία </th>
                                    <th>Μοντέλο</th>
                                    <th>Σε Δοκιμή</th>
                                    <th>Σχόλια</th>
                                    <th>Ενεργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($stock_on_test_no)): ?>
                                    <?php foreach ($stock_on_test_no as $item): ?>
                                        <tr class="stock-row" data-id="<?= $item['id'] ?>">
                                            <td><?= $item['serial'] ?></td>

                                            <!-- Customer Dropdown -->
                                            <td>
                                                <input list="customers-list" data-id="<?= $item['id'] ?>" value="<?= $item['customer_name'] ?>">
                                                <datalist id="customers-list">
                                                <?php foreach ($customers as $customer): ?>
                                                    <option value="<?= $customer['name'] ?>" <?= $item['customer_id'] == $customer['id'] ? 'selected' : '' ?>>
                                                <?php endforeach; ?>
                                                </datalist>
                                            </td>
                                            
                                            <!-- Date picker for Day Out -->
                                            <td>
                                                <input type="date" class="day-out-input" data-id="<?= $item['id'] ?>"
                                                    value="<?= ($item['day_out'] != '0000-00-00' && !empty($item['day_out'])) ? $item['day_out'] : '' ?>">
                                            </td>

                                            <!-- Model -->
                                            <td><?= $item['manufacturer_name'] ?> - <?= $item['series_name'] ?> - <?= $item['model_name'] ?></td>

                                            <!-- Checkbox for On Test -->
                                            <td>
                                                <input type="checkbox" class="on-test-checkbox" data-id="<?= $item['id'] ?>" <?= $item['on_test'] ? 'checked' : '' ?>>
                                            </td>
                                            <td><?= $item['comments'] ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/stocks/view/' . $item['id']) ?>" class="btn btn-info">Προβολή</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No data found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>                    
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>

    <!-- Table for items with on_test = 1 -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Ακουστικά Demo (Σε Δοκιμή: Ναι)</div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Πελάτης</th>
                                    <th>Ημ/νία </th>
                                    <th>Μοντέλο</th>
                                    <th>Σε Δοκιμή</th>
                                    <th>Σχόλια</th>
                                    <th>Ενεργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($stock_on_test_yes)): ?>
                                    <?php foreach ($stock_on_test_yes as $item): ?>
                                        <tr class="stock-row" data-id="<?= $item['id'] ?>">
                                            <td><?= $item['serial'] ?></td>

                                            <!-- Customer Dropdown -->
                                            <td>
                                                <input list="customers-list" data-id="<?= $item['id'] ?>" value="<?= $item['customer_name'] ?>">
                                                <datalist id="customers-list">
                                                <?php foreach ($customers as $customer): ?>
                                                    <option value="<?= $customer['name'] ?>" <?= $item['customer_id'] == $customer['id'] ? 'selected' : '' ?>>
                                                <?php endforeach; ?>
                                                </datalist>
                                            </td>

                                            <!-- Date picker for Day Out -->
                                            <td>
                                                <input type="date" class="day-out-input" data-id="<?= $item['id'] ?>"
                                                    value="<?= ($item['day_out'] != '0000-00-00' && !empty($item['day_out'])) ? $item['day_out'] : '' ?>">
                                            </td>

                                            <!-- Model -->
                                            <td><?= $item['manufacturer_name'] ?> - <?= $item['series_name'] ?> - <?= $item['model_name'] ?></td>

                                            <!-- Checkbox for On Test -->
                                            <td>
                                                <input type="checkbox" class="on-test-checkbox" data-id="<?= $item['id'] ?>" <?= $item['on_test'] ? 'checked' : '' ?>>
                                            </td>
                                            <td><?= $item['comments'] ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/stocks/view/' . $item['id']) ?>" class="btn btn-info">Προβολή</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No data found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>                    
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div>

<script>
$(document).ready(function () {
    // Δημιουργία αντικειμένου για αντιστοίχιση πελάτη (όνομα -> ID)
    var customerMap = {};
    <?php foreach ($customers as $customer): ?>
        customerMap['<?= $customer['name'] ?>'] = <?= $customer['id'] ?>;
    <?php endforeach; ?>

    // Update the background color for rows based on "On Test" status and "Day Out" date
    function updateRowBackground(row) {
        var onTestCheckbox = $(row).find('.on-test-checkbox');
        var dayOutInput = $(row).find('.day-out-input').val();
        var dayOutDate = new Date(dayOutInput);
        var currentDate = new Date();
        var timeDiff = Math.abs(currentDate - dayOutDate);
        var dayDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)); // Διαφορά σε ημέρες
        
        // Αρχικοποιήστε τα χρώματα
        var green = '#d4edda';
        var yellow = '#fff3cd';
        var red = '#f8d7da';

        if (!onTestCheckbox.is(':checked')) {
            // Πράσινο αν δεν είναι σε δοκιμή
            $(row).css('background-color', green);
        } else if (onTestCheckbox.is(':checked') && dayDiff <= 15) {
            // Κίτρινο αν είναι σε δοκιμή και έχουν περάσει <= 15 μέρες από την day_out
            $(row).css('background-color', yellow);
        } else if (onTestCheckbox.is(':checked') && dayDiff > 15) {
            // Κόκκινο αν είναι σε δοκιμή και έχουν περάσει πάνω από 15 μέρες
            $(row).css('background-color', red);
        } else {
            // Default χρώμα αν δεν ισχύει κάτι από τα παραπάνω
            $(row).css('background-color', '');
        }
    }

    // Update "On Test" checkbox status
    $('.on-test-checkbox').change(function () {
        const stockId = $(this).data('id');    
        const onTest = $(this).is(':checked') ? 1 : 0;

        // AJAX κλήση για ενημέρωση της βάσης δεδομένων
        $.ajax({
            url: '<?= base_url('admin/stocks/update_otf') ?>',
            type: 'POST',
            data: { id: stockId, on_test: onTest },
            success: function (response) {  
                updateRowBackground($(this).closest('tr'));  // Ενημέρωσε το χρώμα της γραμμής
                location.reload();  // Reload the page to update the table
            }.bind(this),
            error: function (xhr, status, error) {
                console.error('Failed to update the on_test status: ' + error);
            }
        });
    });

    // Update background on page load based on "on_test" checkbox status and "day_out"
    $('.stock-row').each(function () {
        updateRowBackground(this);
    });

    // Update customer via datalist input
    $('input[list="customers-list"]').on('change', function () {
        var stockId = $(this).data('id');
        var customerName = $(this).val();

        // Έλεγχος εάν το όνομα πελάτη υπάρχει στον χάρτη
        if (customerMap[customerName]) {
            var customerId = customerMap[customerName];

            // AJAX request to update the customer by ID
            $.ajax({
                url: '<?= base_url('admin/stocks/update_customer') ?>',  // Το υπάρχον endpoint
                type: 'POST',
                data: { id: stockId, customer_id: customerId },
                success: function (response) {
                    alert('Customer updated successfully');
                },
                error: function (xhr, status, error) {
                    alert('Failed to update the customer: ' + error);
                }
            });
        } else {
            alert('Invalid customer name. Please select a valid customer from the list.');
        }
    });

    // Update "day_out" date picker
    $('.day-out-input').on('change', function () {
        var stockId = $(this).data('id');
        var dayOut = $(this).val();

        // AJAX request to update the day_out field
        $.ajax({
            url: '<?= base_url('admin/stocks/update_day_out') ?>',
            type: 'POST',
            data: { id: stockId, day_out: dayOut },
            
            success: function (response) {
                alert('Η ημερομηνία ενημερώθηκε επιτυχώς');
                console.log("Response from server:", response); // Εκτυπώνει την απόκριση του server
            },
            error: function (xhr, status, error) {
                alert('Failed to update the date: ' + error);
            }
        });
    });
});
</script>


