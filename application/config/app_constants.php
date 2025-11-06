<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Application Constants
|--------------------------------------------------------------------------
| 
| Configuration constants for the PHA Manager application
|
*/

// Default values for statistics and dashboard
define('DEFAULT_STATS_YEAR', 2014);
define('DEFAULT_SELLING_POINT', 1);
define('CURRENT_YEAR', date('Y'));

// Cache expiration times (in seconds)
define('DASHBOARD_CACHE_EXPIRATION', 3600);    // 1 hour
define('STATS_CACHE_EXPIRATION', 7200);        // 2 hours

// Pagination defaults
define('DEFAULT_PER_PAGE', 20);
define('MAX_PER_PAGE', 100);

// File upload limits
define('MAX_FILE_SIZE', 5242880);              // 5MB in bytes

// System status codes
define('STOCK_STATUS_AVAILABLE', 1);
define('STOCK_STATUS_SOLD', 4);
define('STOCK_STATUS_ON_HOLD', 3);

define('CUSTOMER_STATUS_ACTIVE', 1);
define('CUSTOMER_STATUS_PENDING', 5);
define('CUSTOMER_STATUS_NO_SALE', 3);

// Date formats
define('DATE_FORMAT_DISPLAY', 'd/m/Y');
define('DATE_FORMAT_DATABASE', 'Y-m-d');
define('DATETIME_FORMAT_DISPLAY', 'd/m/Y H:i');