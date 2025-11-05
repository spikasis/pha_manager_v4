<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-3">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list me-2"></i>
                    Περιεχόμενα Βοήθειας
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="#getting-started" class="list-group-item list-group-item-action">
                        <i class="fas fa-play-circle me-2 text-primary"></i>
                        Πρώτα Βήματα
                    </a>
                    <a href="#navigation" class="list-group-item list-group-item-action">
                        <i class="fas fa-compass me-2 text-primary"></i>
                        Πλοήγηση
                    </a>
                    <a href="#customers" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2 text-primary"></i>
                        Διαχείριση Πελατών
                    </a>
                    <a href="#inventory" class="list-group-item list-group-item-action">
                        <i class="fas fa-boxes me-2 text-primary"></i>
                        Αποθέματα
                    </a>
                    <a href="#reports" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Αναφορές
                    </a>
                    <a href="#settings" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2 text-primary"></i>
                        Ρυθμίσεις
                    </a>
                    <a href="#faq" class="list-group-item list-group-item-action">
                        <i class="fas fa-question-circle me-2 text-primary"></i>
                        Συχνές Ερωτήσεις
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="card shadow">
            <div class="card-body">
                <!-- Getting Started Section -->
                <section id="getting-started">
                    <h3 class="text-primary mb-3">
                        <i class="fas fa-play-circle me-2"></i>
                        Πρώτα Βήματα
                    </h3>
                    <p>Καλώς ήρθατε στο PHA Manager v4! Αυτός ο οδηγός θα σας βοηθήσει να ξεκινήσετε.</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-left-primary shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">1. Πρώτη Σύνδεση</h5>
                                    <p class="card-text">Συνδεθείτε με τα διαπιστευτήριά σας και εξοικειωθείτε με το περιβάλλον.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-left-success shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">2. Εξερεύνηση Dashboard</h5>
                                    <p class="card-text">Δείτε τις βασικές στατιστικές και πλοηγηθείτε στα μενού.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr>

                <!-- Navigation Section -->
                <section id="navigation">
                    <h3 class="text-primary mb-3">
                        <i class="fas fa-compass me-2"></i>
                        Πλοήγηση στο Σύστημα
                    </h3>
                    <p>Το σύστημα είναι οργανωμένο σε κύριες κατηγορίες:</p>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <h5><i class="fas fa-users text-primary me-2"></i>Βασικά Δεδομένα</h5>
                            <ul>
                                <li>Πελάτες</li>
                                <li>Γιατροί</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h5><i class="fas fa-boxes text-success me-2"></i>Αποθήκη</h5>
                            <ul>
                                <li>Αποθέματα</li>
                                <li>Χαμηλά Αποθέματα</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h5><i class="fas fa-cog text-info me-2"></i>Διαχείριση</h5>
                            <ul>
                                <li>Χρήστες</li>
                                <li>Ρυθμίσεις</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <hr>

                <!-- Customers Section -->
                <section id="customers">
                    <h3 class="text-primary mb-3">
                        <i class="fas fa-users me-2"></i>
                        Διαχείριση Πελατών
                    </h3>
                    <p>Μάθετε πώς να διαχειρίζεστε αποτελεσματικά τους πελάτες σας:</p>
                    
                    <div class="accordion" id="customersAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#addCustomer">
                                    Προσθήκη Νέου Πελάτη
                                </button>
                            </h2>
                            <div id="addCustomer" class="accordion-collapse collapse show" data-bs-parent="#customersAccordion">
                                <div class="accordion-body">
                                    <ol>
                                        <li>Πλοηγηθείτε στο μενού "Πελάτες"</li>
                                        <li>Κλικ στο κουμπί "Νέος Πελάτης"</li>
                                        <li>Συμπληρώστε τα απαιτούμενα στοιχεία</li>
                                        <li>Αποθηκεύστε τα δεδομένα</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#searchCustomer">
                                    Αναζήτηση Πελάτη
                                </button>
                            </h2>
                            <div id="searchCustomer" class="accordion-collapse collapse" data-bs-parent="#customersAccordion">
                                <div class="accordion-body">
                                    Χρησιμοποιήστε το πεδίο αναζήτησης για να βρείτε γρήγορα έναν πελάτη βάσει ονόματος, τηλεφώνου ή ΑΜΚΑ.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr>

                <!-- FAQ Section -->
                <section id="faq">
                    <h3 class="text-primary mb-3">
                        <i class="fas fa-question-circle me-2"></i>
                        Συχνές Ερωτήσεις
                    </h3>
                    
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Πώς μπορώ να αλλάξω τον κωδικό μου;
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Μεταβείτε στο Προφίλ σας (κλικ στο όνομά σας στην κορυφή δεξιά) και επιλέξτε "Προφίλ". Εκεί μπορείτε να αλλάξετε τον κωδικό σας.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Πώς μπορώ να εκτυπώσω αναφορές;
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Οι περισσότερες σελίδες υποστηρίζουν εκτύπωση. Χρησιμοποιήστε το Ctrl+P ή το μενού εκτύπωσης του προγράμματος περιήγησης.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Τι κάνω αν ξεχάσω τον κωδικό μου;
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Επικοινωνήστε με τον διαχειριστή του συστήματος για επαναφορά του κωδικού σας.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr>

                <div class="alert alert-info">
                    <h5><i class="fas fa-info-circle me-2"></i>Χρειάζεστε Περισσότερη Βοήθεια;</h5>
                    <p class="mb-0">Αν δεν βρήκατε την απάντηση που ψάχνετε, επικοινωνήστε με την τεχνική υποστήριξη:</p>
                    <ul class="mb-0">
                        <li>Email: support@pikasishearing.gr</li>
                        <li>Τηλέφωνο: 22620-12345</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Smooth scrolling for anchor links in help content
    $('.list-group-item[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });
    
    // Auto-expand accordion items based on URL hash
    if (window.location.hash) {
        var targetAccordion = $(window.location.hash + 'Accordion').find('.accordion-collapse').first();
        if (targetAccordion.length) {
            targetAccordion.addClass('show');
        }
    }
});
</script>
<?= $this->endSection() ?>