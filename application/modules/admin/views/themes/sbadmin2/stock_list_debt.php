<div id="page-wrapper">    
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2> Υπόλοιπα Χρεών Ακουστικών </h2>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Λίστα Ακουστικών με Υπόλοιπα</div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID Ακουστικού</th>
                                    <th>Πελάτης</th>
                                    <th>Συνολική Τιμή</th>
                                    <th>Συμμετοχή Ασφαλιστικού Φορέα</th>
                                    <th>Υπόλοιπο</th>
                                    <th>Τελευταία Πληρωμή</th>
                                </tr>
                            </thead>
                            <tbody> 
        <?php if (count($stock)): ?>
            <?php foreach ($stock as $list): 
                // Υπολογισμός διαφορών ημερομηνιών
                $lastPaymentDate = $list['last_payment_date'];
                $today = new DateTime();
                $paymentDate = $lastPaymentDate ? new DateTime($lastPaymentDate) : null;
                $daysDiff = $paymentDate ? $paymentDate->diff($today)->days : null;

                // Ορισμός κλάσεων βάσει των ημερομηνιών πληρωμής
                if (!$lastPaymentDate) {
                    $rowClass = 'bg-warning'; // Καμία πληρωμή
                } elseif ($daysDiff > 30) {
                    $rowClass = 'bg-danger';    // Πάνω από 30 μέρες
                } else {
                    $rowClass = 'bg-success';  // Κάτω από 30 μέρες
                }
            ?>
                                <tr class="<?= $rowClass ?>">
                                    <td><?= $list['stock_id'] ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/customers/view/'. $list['customer_id']) ?>">
                                            <?= $list['customer_name']  ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="view-payments" data-stock-id="<?= $list['stock_id'] ?>"><?= number_format($list['ha_price'], 2) ?> €</a>
                                    </td>
                                    <td><?= number_format($list['eopyy'], 2) ?> €</td>
                                    <td><?= number_format($list['remaining_balance'], 2) ?> €</td>
                                    <td><?= $lastPaymentDate ? date('d/m/Y', strtotime($lastPaymentDate)) : 'Καμία Πληρωμή' ?></td>
                                </tr>
            <?php endforeach; ?>
        <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Δεν βρέθηκαν δεδομένα</td>
                                </tr>
        <?php endif; ?>
                            </tbody>
                        </table>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal για την εμφάνιση των πληρωμών -->
<div class="modal fade" id="paymentsModal" tabindex="-1" role="dialog" aria-labelledby="paymentsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentsModalLabel">Πληρωμές για Ακουστικό</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ημερομηνία Πληρωμής</th>
                            <th>Ποσό</th>
                        </tr>
                    </thead>
                    <tbody id="paymentsTableBody">
                        <!-- Εδώ θα φορτώνονται δυναμικά οι πληρωμές μέσω AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    // Όταν γίνεται κλικ στη συνολική τιμή
    $('.view-payments').on('click', function(e) {
        e.preventDefault();
        
        var stockId = $(this).data('stock-id');

        // AJAX αίτημα για να πάρουμε τις πληρωμές για το συγκεκριμένο ακουστικό        
        $.ajax({
            url: '<?= base_url('admin/stocks/get_payments') ?>/' + stockId,
            method: 'GET',
            success: function(data) {
                // Καθαρίζουμε τον πίνακα
                $('#paymentsTableBody').empty();

                if (data.length > 0) {
                    // Προσθήκη των πληρωμών στον πίνακα
                    $.each(data, function(index, payment) {
                        $('#paymentsTableBody').append('<tr><td>' + payment.pay_date + '</td><td>' + payment.pay_amount + ' €</td></tr>');
                    });
                } else {
                    // Αν δεν υπάρχουν πληρωμές
                    $('#paymentsTableBody').append('<tr><td colspan="2" class="text-center">Δεν βρέθηκαν πληρωμές</td></tr>');
                }

                // Εμφάνιση του modal
                $('#paymentsModal').modal('show');
            },
            error: function() {
                alert('Πρόβλημα κατά την ανάκτηση των πληρωμών.');
            }
        });
    });
});

</script>