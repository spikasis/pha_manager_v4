<?php if ( ! defined('BASEPATH')) exit('No direct file access!'); 
//Begin email.php 
$config['protocol'] = 'smtp'; 
$config['smtp_host'] = 'ssl://stmp.googlemail.com'; 
$config['smtp_port'] = '465'; 
$config['smtp_timeout'] = '45'; 

// *** Replace with your Gmail *** 
$config['smtp_user'] = 'info@pikasishearing.gr'; 

// *** Replace with your Gmail password *** 
$config['smtp_pass'] = '038213sp'; 
$config['charset']='utf-8'; 
$config['newline']="\r\n"; 

//End email.php
