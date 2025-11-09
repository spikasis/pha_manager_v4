<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modular Extensions
|--------------------------------------------------------------------------
|
| Modular Extensions - HMVC
|
| Modular Extensions makes the CodeIgniter PHP framework modular. 
| Modules are groups of independent components, typically model, controller 
| and view, arranged in an application modules sub-directory that can be 
| dropped into other CodeIgniter applications.
|
| IMPORTANT: The modules feature must be enabled by setting the module 
| locations as shown below.
|
*/

/*
|--------------------------------------------------------------------------
| Module locations
|--------------------------------------------------------------------------
|
| These are the directories that contain your modules. You may use a relative or 
| absolute path. Multiple module locations are supported.
|
| Example: $config['modules_locations'] = array(APPPATH.'modules/');
|
*/
$config['modules_locations'] = array(
    APPPATH.'modules/' => '../modules/',
);

/*
|--------------------------------------------------------------------------
| Module 404 override
|--------------------------------------------------------------------------
|
| When set to TRUE, the 404 override will be used even in modules.
| When set to FALSE, show_404() in modules will show a normal CI 404.
| 
*/
$config['modules_override_404'] = FALSE;