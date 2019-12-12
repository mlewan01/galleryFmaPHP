<?php
$dir = dirname(dirname(__FILE__));
require_once $dir.'/includes/config.php';

// Check if the form has been submitted...
if (isset($_POST['multifileupload'])) {
	$i = 1;
	
	$updir = $config['upload_dir'];
	$thumbs = $config['upload_dir'].'thumbs/';
	
	echo $updir.'</br>';    /// tests <<<<<<<<<<<<<<<<<<<<<<<<
	echo $thumbs.'</br>';   /// tests <<<<<<<<<<<<<<<<<<<<<<<<
	
	//  database connection ....
	$db = new myDB(
			$config['db_host'],
			$config['db_user'],
			$config['db_pass'],
			$config['db_name']);
	
	//  file info array 
	
	
	
	foreach ($_FILES['userfile']['error'] as $key => $error) {
		
		// for collectin information about uploaded images
		$fi  = array();
		
		echo $i.' . ';
		if($error == UPLOAD_ERR_OK){
			echo "no upload error".'</br>';
			$upfile = basename($_FILES['userfile']['name'][$key]);
			$newname = $updir.$upfile;
			if( file_exists($newname)){
				echo 'ten plik ju¿ istnieje: '.$upfile.'</br>';
			} else {
				$tmpname = $_FILES['userfile']['tmp_name'][$key];
				$tempFileName = explode(".", $upfile);
				$fileExtention = strtolower(end($tempFileName));
				$fileName = $tempFileName[0];
				// file path of thumbs images 
				$fp_150px = $thumbs.$fileName.'_150.'.$fileExtention;
				$fp_600px = $thumbs.$fileName.'_600.'.$fileExtention;
				
				// for thests. to be deleted aretr testing period   <<<<<<
				print_r($tempFileName);
				echo '</br>'.$fileName.'</br>';
				echo $_FILES['userfile']['type'][$key].'</br>';
				echo $fileExtention.'</br>';
				echo $upfile.'</br>';
				print_r($_FILES);
				echo '</br>'; 
				// end of testing code                            <<<<<<<<
				
				$type = $_FILES['userfile']['type'][$key];
				// checking if the uploaded file is an image type. not perfect! to be updated later on !!
				if($type == 'image/jpeg' && ( $fileExtention == 'jpeg' || $fileExtention == 'jpg')){  //  ||  $fileExtention == 'gif' ||  $fileExtention == 'png')){ 
					
					echo 'this type of file is :  '.$_FILES['userfile']['type'][$key].' !!!'.'</br>';
					if(move_uploaded_file($tmpname, $newname)){
						echo 'file successfully moved to \'upload\' location'.'</br>';
						echo 'begining creating thumbs 150px and 600px ones'.'</br>';
						
						$temp = getimagesize($newname);
						
						$fi['fileName'] = $fileName;
						$fi['fileExt'] = $fileExtention;
						$fi['imageType'] = $temp['mime'];
						$fi['witdh'] = $temp[0];
						$fi['height'] = $temp[1];
						$fi['imagePath'] = $newname;
						$fi['thumb150'] = img_res($newname, $fp_150px, 150, 150);
						$fi['thumb600'] = img_res($newname, $fp_600px, 600, 600);
						
						// uploading data to database !!...
						//$sql = "INSERT INTO gallery (fileName, fileExt, imageType, witdh, height, imagePath, thumb150, thumb600) VALUES ($fi['fileName'], $fi['fileExt'], $fi['imageType'], $fi['witdh'], $fi['height'], $fi['imagePath'], $fi['thumb150'], $fi['thumb600'])";
						$sql = sprintf(
								'INSERT INTO gallery (%s) VALUES("%s")',
								implode(',',array_keys($fi)),
								implode('","',array_values($fi))
						);
						
						$db->myQuery($sql);
						
					}else {
						echo 'moving uploaded file to new location failed'.'</br>';
					}
				} else {
					echo 'this file is not a \'image/jpeg\' type of file....'.'</br>'; 
					echo 'it\'s type is: '.$_FILES['userfile']['type'][$key].'</br>';
				}
			}
		} else {
			switch ($_FILES['userfile']['error'][$key]){
				case 1:
					echo 'The file exceeds the upload_max_filesize directive in php.ini.'.'</br>';
					break;
				case 2:
					echo 'The file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.'.'</br>';
					break;
				case 3:
					echo 'The uploaded file was only partially uploaded'.'</br>';
					break;
				case 4:
					echo 'No file was uploaded(not always an error)'.'</br>';
					break;
			}
			//echo 'nothing has been uploaded'.'</br>';
		}
		$i++;
			
	}
	
}

$thisDir = dirname(__FILE__);
$content = file_get_contents($thisDir.'/form_m.php');

//echo htmlentities($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');

?>
