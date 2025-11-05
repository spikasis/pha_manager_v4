<?php

// Custom main index that disables Locale functionality
use CodeIgniter\Boot;
use Config\Paths;

$minPhpVersion = '8.1';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION,
    );
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;
    exit(1);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

// DISABLE LOCALE FUNCTIONALITY TEMPORARILY
// This is a hack to bypass the Locale class issues
class_alias('stdClass', 'Locale', false);

// Mock Locale methods that CI might use
if (!class_exists('Locale', false)) {
    class Locale {
        public static function getDefault() {
            return 'en_US';
        }
        
        public static function setDefault($locale) {
            return true;
        }
        
        public static function acceptFromHttp($header) {
            return 'en_US';
        }
    }
}

try {
    // LOAD OUR PATHS CONFIG FILE
    require FCPATH . '../app/Config/Paths.php';
    
    $paths = new Paths();
    
    // LOAD THE FRAMEWORK BOOTSTRAP FILE  
    require $paths->systemDirectory . '/Boot.php';
    
    exit(Boot::bootWeb($paths));
    
} catch (Exception $e) {
    // If CodeIgniter fails, redirect to backup
    header('Location: /simple_login.php');
    exit;
} catch (Error $e) {
    // If fatal error occurs, redirect to backup
    header('Location: /simple_login.php');
    exit;
}

?>