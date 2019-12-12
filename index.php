<?php
// connecting to required/included files
require 'includes/config.php';
require 'lang/'.$config['language'].'.php';
require_once 'includes/functions.php';

autoloader();
// Code to detect whether index.php has been requested without query string goes here
if (!isset($_GET['page'])) {
	$id = 'gallery'; // display home page	
} else {
	$id = $_GET['page']; // else requested page,
}

$content = '';
$headingh1='';
// including code from the required page
switch ($id) {
	case 'gallery' :
		include 'views/home.php';
		$headingh1 = 'h_home';
		break;
	case 'upload' :
		include 'views/upload_m.php';
		$headingh1 = 'h_upload';
		break;
	case 'imageprev' :
		include 'views/imageprev.php';
		$headingh1 = 'h_imageprev';
		break;
	case 'service' :
		include 'views/service.php';
		break;
	default :
		include 'views/404.php';
		$headingh1 = 'h_404';
		$id='404';
}
//-----------------------------------------------------------------------------------------------

if($id != 'service'){
// prepearing data fu use with usage with site template
$arr = array(
	'[+title+]' => $lang[$id],
	'[+headingh1+]' => $lang[$headingh1],
	'[+content+]' => $content,
	'[+f_message+]' => $lang['f_message'],
	'[+m1+]' => $lang['gallery'],
	'[+m2+]' => $lang['upload']
);
	$out = tpl(1, './templates/page_tpl.html', $arr);
// outputing all collected data to the browser
	echo $out;
}
?>