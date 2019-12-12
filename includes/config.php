<?php 
// General Settings 
$config['app_name'] = 'My Cool App';

//  database settings
$config['db_user'] = 'root';
$config['db_pass'] = '';
//$config['db_host'] = 'mysqlsrv.dcs.bbk.ac.uk';
$config['db_host'] = 'localhost';
$config['db_name'] = 'gallery';

// Language settings, commet out the right settings for you
$config['language'] = 'en';
//$config['language'] = 'pl';

/**
 * Absolute path to application root directory (one level above current dir)
 * Tip: using dynamically generated absolute paths makes the app more portable.
 */
$config['app_dir'] = dirname(dirname(__FILE__));

/**
 * Absolute path to directory where uploaded files will be stored
 * Using an absolute path to the upload dir can help circumvent security restrictions on some servers
 */
$config['upload_dir'] = './uploads/';

// a field used to indicate wheter the site is in development proces or not
// in order to turn on/of development output
$config['in_development'] = false;
?>