<?php
$dev = "";
$msg = '<p>';
$dir = dirname(dirname(__FILE__));
require_once $dir.'/includes/config.php';

// Check if the form has been submitted...
if (isset($_POST['multifileupload'])) {
	
	// checking wheather the uploaded texts from form are save to use with php scripts
	$to_clean = array('', 'title', 'description');
	$clean = array();
	$clean = sanitiseInput($_POST, $to_clean);
	
	if(!$clean[0]){
		// if data have been provided and sanitised we ca go on...
	$dev .= " fielsd from image upload form are now sanitised".'<br/>';
	
	$updir = $config['upload_dir'];
	$thumbs = $config['upload_dir'].'thumbs/';
	
	//  database connection ....
	$db = new myDB(
			$config['db_host'],
			$config['db_user'],
			$config['db_pass'],
			$config['db_name']);
	
	//  file info array 
	// for collectin information about uploaded images
	$fi  = array();
	
	if($_FILES['img']['error'] == UPLOAD_ERR_OK){
		$dev .= "no upload error".'<br/>';  
		
		$upfile = basename($_FILES['img']['name']);
		$newname = $updir.$upfile;
		if( file_exists($newname)){
			$msg .= $lang['us_imageExists'];
		} else {
			$dev .= " new non existing file has been uploaded".'<br/>';  
			
			$tmpname = $_FILES['img']['tmp_name'];
			$tempFileName = explode(".", $upfile);
			$fileExtention = strtolower(end($tempFileName));
			// escaping file name in order to provide savety in the php code
			$fileName =  $tempFileName[0];
			// file path of to be created thumbs images 
			$fp_150px = $thumbs.$fileName.'_150.'.$fileExtention;
			$fp_600px = $thumbs.$fileName.'_600.'.$fileExtention;
			
			$type = $_FILES['img']['type'];
			// checking if the uploaded file is an image type. not perfect! to be updated later on !!
			if($type == 'image/jpeg' && ( $fileExtention == 'jpeg' || $fileExtention == 'jpg')){  //  ||  $fileExtention == 'gif' ||  $fileExtention == 'png')){ 
				//becouse checking mime and extention is not a reliabe form of checkin for an file type
				//in case of images we can reliebeli check whether a file is an image by checkin its size
				if($temp = getimagesize($tmpname)){
					
					$dev .= 'this file type is:  '.$_FILES['img']['type'].' !!!'.'<br/>';
					if(move_uploaded_file($tmpname, $newname)){
						$dev .= 'file successfully moved to \'upload\' location'.'<br/>';
						$dev .= 'begining creating thumbs 150px and 600px ones'.'<br/>';
						
						$temp = getimagesize($newname);
						
						$fi['fileNameExt'] = $upfile;
						$fi['fileName'] = $fileName;
						$fi['fileExt'] = $fileExtention;
						$fi['imageType'] = $temp['mime'];
						$fi['title'] = $clean[1];
						$fi['descr'] = $clean[2];
						$fi['width'] = $temp[0];
						$fi['height'] = $temp[1];
						$fi['widthHeight'] = "width=$temp[0] height=$temp[1]";
						$fi['imagePath'] = $newname;
						$fi['thumb150'] = img_res($newname, $fp_150px, 150, 150);
						$fi['thumb600'] = img_res($newname, $fp_600px, 600, 600);
						$temp = getimagesize($fi['thumb600']);
						$fi['thumb600size'] = "width=$temp[0] height=$temp[1]";
						// uploading data to database !!...
						$sql = sprintf(
								'INSERT INTO gallery (%s) VALUES("%s")',
								implode(',',array_keys($fi)),
								implode('","',array_values($fi))
						);
						$db->myQuery($sql);
						
						$msg .= $lang['us_uploadSuccessful'];
						
					}else {
						// possbli becouse user has no rights to writhe to this locaton...
						$dev .= 'moving uploaded file to new location failed'.'<br/>';
					}
					
					
				}else{// in case in second type check fails
					$msg .= $lang['us_wrongType'];
				}
				
			} else {
				$msg .= $lang['us_wrongType'];
				$dev .= 'this file is not a \'image/jpeg\' type of file....'.'<br/>'; 
				$dev .= 'it\'s type is: '.$_FILES['img']['type'].'<br/>';
			}
		}
	} else {
		// prepering information for user about errors during uploading. what possible could go wrong
		$msg .= $lang['us_uploadUnsuccessful'];
		switch ($_FILES['img']['error']){
			case 1:
				$dev .= 'The file exceeds the upload_max_filesize directive in php.ini.'.'<br/>';
				$msg .= $lang['us_sizeLimitExcess'];
				break;
			case 2:
				$dev .= 'The file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.'.'<br/>';
				$msg .= $lang['us_sizeLimitExcess'];
				break;
			case 3:
				$dev .= 'The uploaded file was only partially uploaded'.'<br/>';
				$msg .= $lang['us_uploadErrors'];
				break;
			case 4:
				$dev .= 'No file was uploaded(not always an error)'.'<br/>';
				$msg .= $lang['us_noFileUploaded'];
				break;
		}
	}
} else $msg .= $lang[$clean[0]];

}
// if ist is in development display some additional/development/helpful output 
if($config['in_development']) echo $dev;

$content .= $msg.'</p>';

// formatowanie form for images upload for internacionalisation
$arr = array(
		'[+form_Legend+]' => $lang['form_Legend'],
		'[+form_Title+]' => $lang['form_Title'],
		'[+form_Desc+]' => $lang['form_Desc'],
		'[+form_Browse+]' => $lang['form_Browse'],
		'[+form_Message+]' => $lang['form_Message']
);
$content .= tpl(1, './templates/form_tpl.html', $arr);
?>












