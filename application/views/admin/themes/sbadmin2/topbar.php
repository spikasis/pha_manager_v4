<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" 
          method="GET" action="<?= base_url('admin/search') ?>">
        <div class="input-group">
            <input type="text" name="q" class="form-control bg-light border-0 small" 
                   placeholder="Αναζήτηση πελατών, ακουστικών..." 
                   aria-label="Search" aria-describedby="basic-addon2"
                   id="topbar-search-input" autocomplete="off">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
        <!-- Search Results Dropdown -->
        <div id="search-dropdown" class="dropdown-menu dropdown-menu-left shadow" style="width: 350px; display: none;">
            <h6 class="dropdown-header">Γρήγορα Αποτελέσματα</h6>
            <div id="search-results-container">
                <!-- AJAX results will be inserted here -->
            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-center" href="#" id="view-all-results">
                <i class="fas fa-search fa-sm"></i> Προβολή όλων των αποτελεσμάτων
            </a>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Open Tasks -->
        <li class="nav-item mx-1">
            <a class="nav-link" href="<?= base_url('admin/tasks/filtered_tasks') ?>" 
               title="Ανοιχτές Εργασίες" data-toggle="tooltip" data-placement="bottom">
                <i class="fas fa-tasks fa-fw text-primary"></i>
                <span class="d-none d-md-inline ml-1 text-primary font-weight-bold">Εργασίες</span>
            </a>
        </li>

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Αναζήτηση..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Task Notifications -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Notifications -->
                <span class="badge badge-danger badge-counter" id="notification-counter" style="display: none;">0</span>
            </a>
            <!-- Dropdown - Notifications -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="notificationsDropdown" style="width: 380px;">
                <h6 class="dropdown-header d-flex justify-content-between align-items-center">
                    <span>Ειδοποιήσεις Εργασιών</span>
                    <button class="btn btn-sm btn-outline-primary" id="mark-all-read" style="font-size: 11px; padding: 2px 8px;">
                        Όλα ως διαβασμένα
                    </button>
                </h6>
                <div id="notifications-container">
                    <div class="dropdown-item text-center py-3">
                        <i class="fas fa-spinner fa-spin"></i>
                        <div class="small text-gray-500 mt-2">Φόρτωση ειδοποιήσεων...</div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center small text-gray-500" href="<?= base_url('admin/tasks/filtered_tasks') ?>">
                    <i class="fas fa-tasks fa-sm"></i> Προβολή όλων των εργασιών
                </a>
            </div>
        </li>

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Κέντρο Μηνυμάτων
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="<?= base_url() ?>assets/sbadmin2/img/undraw_profile_1.svg" alt="...">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate">Γεια σας! Θα θέλα να κλείσω ραντεβού για καθαρισμό...</div>
                        <div class="small text-gray-500">Μαρία Παπαδοπούλου · 58λ</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="<?= base_url() ?>assets/sbadmin2/img/undraw_profile_2.svg" alt="...">
                        <div class="status-indicator"></div>
                    </div>
                    <div>
                        <div class="text-truncate">Το ακουστικό μου έχει πρόβλημα και θέλω επισκευή...</div>
                        <div class="small text-gray-500">Γιάννης Κωνσταντίνου · 1ω</div>
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Περισσότερα μηνύματα</a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php 
                    if ($this->ion_auth->logged_in()) {
                        $user = $this->ion_auth->user()->row();
                        echo $user->first_name . ' ' . $user->last_name;
                    }
                    ?>
                </span>
                <img class="img-profile rounded-circle" src="<?= base_url() ?>assets/sbadmin2/img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('admin/profile') ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Προφίλ
                </a>
                <a class="dropdown-item" href="<?= base_url('admin/settings') ?>">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Ρυθμίσεις
                </a>
                <a class="dropdown-item" href="<?= base_url('admin/activity') ?>">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Δραστηριότητα
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Αποσύνδεση
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

<!-- Notifications JavaScript -->
<script>
$(document).ready(function() {
    
    // Load initial notification count
    loadNotificationCount();
    
    // Load notifications when dropdown is opened
    $('#notificationsDropdown').on('click', function() {
        loadNotifications();
    });
    
    // Mark all as read
    $('#mark-all-read').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        markAllAsRead();
    });
    
    // Check for new notifications every 30 seconds
    setInterval(loadNotificationCount, 30000);
    
    function loadNotificationCount() {
        $.ajax({
            url: '<?= base_url("admin/notifications/get_unread_count") ?>',
            method: 'GET',
            success: function(response) {
                if (response.count > 0) {
                    $('#notification-counter').text(response.count > 99 ? '99+' : response.count).show();
                    // Add animation class to bell icon
                    $('.fa-bell').addClass('fa-shake');
                } else {
                    $('#notification-counter').hide();
                    $('.fa-bell').removeClass('fa-shake');
                }
            },
            error: function() {
                console.log('Error loading notification count');
            }
        });
    }
    
    function loadNotifications() {
        $('#notifications-container').html(`
            <div class="dropdown-item text-center py-3">
                <i class="fas fa-spinner fa-spin"></i>
                <div class="small text-gray-500 mt-2">Φόρτωση ειδοποιήσεων...</div>
            </div>
        `);
        
        $.ajax({
            url: '<?= base_url("admin/notifications/get_notifications") ?>',
            method: 'GET',
            success: function(response) {
                var html = '';
                
                if (response.notifications.length > 0) {
                    response.notifications.forEach(function(notification) {
                        html += `
                            <a class="dropdown-item d-flex align-items-center notification-item" 
                               href="<?= base_url('admin/tasks/filtered_tasks') ?>" 
                               data-id="${notification.id}">
                                <div class="mr-3">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-tasks text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-fill">
                                    <div class="small text-gray-500">${notification.time_ago}</div>
                                    <div class="text-truncate" style="max-width: 280px;" title="${notification.message}">
                                        ${notification.message}
                                    </div>
                                    ${notification.from_selling_point ? 
                                        `<div class="small text-primary">από: ${notification.from_selling_point}</div>` : 
                                        ''}
                                </div>
                                <div class="ml-2">
                                    <button class="btn btn-sm btn-outline-secondary mark-read-btn" 
                                            data-id="${notification.id}" 
                                            title="Σήμανση ως διαβασμένο"
                                            onclick="event.preventDefault(); event.stopPropagation(); markAsRead(${notification.id});">
                                        <i class="fas fa-check fa-xs"></i>
                                    </button>
                                </div>
                            </a>
                        `;
                    });
                } else {
                    html = `
                        <div class="dropdown-item text-center py-4">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <div class="text-gray-500">Δεν υπάρχουν νέες ειδοποιήσεις</div>
                        </div>
                    `;
                }
                
                $('#notifications-container').html(html);
            },
            error: function() {
                $('#notifications-container').html(`
                    <div class="dropdown-item text-center py-3">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        <div class="small text-gray-500 mt-2">Σφάλμα φόρτωσης ειδοποιήσεων</div>
                    </div>
                `);
            }
        });
    }
    
    function markAsRead(notificationId) {
        $.ajax({
            url: '<?= base_url("admin/notifications/mark_as_read") ?>',
            method: 'POST',
            data: { id: notificationId },
            success: function(response) {
                if (response.status === 'success') {
                    // Remove notification from list
                    $(`[data-id="${notificationId}"]`).fadeOut(300);
                    // Update counter
                    loadNotificationCount();
                }
            }
        });
    }
    
    function markAllAsRead() {
        $.ajax({
            url: '<?= base_url("admin/notifications/mark_all_as_read") ?>',
            method: 'POST',
            success: function(response) {
                if (response.status === 'success') {
                    // Clear notifications list
                    $('#notifications-container').html(`
                        <div class="dropdown-item text-center py-4">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <div class="text-gray-500">Όλες οι ειδοποιήσεις σημάνθηκαν ως διαβασμένες</div>
                        </div>
                    `);
                    // Update counter
                    loadNotificationCount();
                }
            }
        });
    }
    
    // Make markAsRead available globally
    window.markAsRead = markAsRead;
});
</script>

<style>
.fa-shake {
    animation: fa-shake 2s ease-in-out infinite;
}

@keyframes fa-shake {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(5deg); }
    75% { transform: rotate(-5deg); }
}

.notification-item:hover {
    background-color: #f8f9fc;
}

.mark-read-btn {
    padding: 2px 6px;
    font-size: 10px;
}
</style>