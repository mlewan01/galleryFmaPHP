<?php 
// function sanitising data providet by user
function sanitiseInput($post, $arr){
	
	$dev = "sanitise function".'<br/>';
	// $clean array fields: error, title, description 
	$clean = array('','','');
	$repl = array(' ', '.', ',', '?', '!');
	
	for($i = 1; $i <= 2; $i++){
		
		if(isset($post[$arr[$i]])){
			$temp = str_replace($repl, '', $post[$arr[$i]]);
			// sanitisation 
			if(ctype_alnum($temp)){
				
			$clean[$i] = $post[$arr[$i]];
			
			}else {
				$clean[0] = 'fu_notAllProvided';
				return $clean;
			}
			
		}else {
			$clean[0] = 'fu_notAllProvided';
			return $clean;
		}
	}
	return $clean;
}

// function creating thumbnails of uploaded images 
function img_res($in_img_file, $out_img_file, $req_width, $req_height) {
	$dev = "resize image function first line !!".'</br>';
	// Get image file details
	$details = getimagesize($in_img_file, $info);
	
	if($details !== false){
		// Allow only gif, jpeg and png files
		if($details[2]<4){
			$src = NULL;
			$new = NULL;
			$width = $details[0];
			$height = $details[1];
			$dev .= 'file is one of legitimate images \o/'.'</br>';
			$dev .= $details[0].'</br>';
			$dev .= $details[1].'</br>';
			// Check image type and use correct imagecreatefrom* function
			switch ($details[2]){
				case 1:
					$dev .= "this is GIF file".'</br>';
					$src = imagecreatefromgif($in_img_file);
					break;
				case 2:
					$dev .= "this is JPEG file".'</br>';
					$src = imagecreatefromjpeg($in_img_file);
					break;
				case 3:
					$dev .= "this is PNG file".'</br>';
					$src = imagecreatefrompng($in_img_file);
					break;
			}
			// Check if image is smaller (in both directions) than required image
			if($details[0]<$req_width && $details[1]<$req_height){
				$dev .= "is smaller than required image";
				// If so, use original image dimensions. No resampling is nessesery !
				//$req_width = $details[0];
				//$req_height = $details[1];
				
				// seting function output as original file path 
				$out_img_file = $in_img_file;
				
			}else{
				// Otherwise, Test orientation of image and set new dimensions appropriately
				// i.e. calculate the scale factor
				$dev .= "is bigger than required image".'</br>';
				if($details[0]>$details[1]){
					$dev .= 'image is in landscape mode'.'</br>';
					$req_height = ($details[1]*$req_width)/$details[0];
				}else{
					$dev .= 'image is in portrait mode'.'</br>';
					$req_width = ($details[0]*$req_height)/$details[1];
				}
				
				// Create the new canvas ready for resampled image to be inserted into it
				$new = imagecreatetruecolor($req_width, $req_height);
				$dev .= 'copiowanie'.'</br>';
				// Resample input image into newly created image
				imagecopyresampled($new, $src, 0,0,0,0, $req_width, $req_height, $width, $height);
				// Create output jpeg at quality level of 90
				imagejpeg($new, $out_img_file, 90);
				// uncoment if you want to display image in the browsware
				//header('Content-type: image/jpeg');
				//imagejpeg($new, null, 90);
				
				// Destroy any intermediate image files
				imagedestroy($new);
				imagedestroy($src);
			}
			// Return a value indicating success or failure (true/false)
			return $out_img_file;
		}else {
			$dev .= 'this file is not a permitted image file(permitted file types: jpeg,gif,png)'.'</br>';
			return false;
		}
	}else {
		$dev .= 'This file probably is not an image...'.'</br>';
		return false;
	}
}

// to work with templates. needs file path and an array with key and value
 function tpl($readFile, $file, $arr){
	if($readFile){
		$out=file_get_contents($file);
		foreach ($arr as $key => $value){
			$out = str_replace($key, $value, $out);
		}
		
		//echo "tpl function read file";
		return $out;
	}else {
		foreach ($arr as $key => $value){
			$out = str_replace($key, $value, $out);
		}
		echo "tpl function no red file nessesery";
		return $out;
	}
}
// becarefule where you calling this function from.
	function autoloader(){
		spl_autoload_register('myAutoloader');
	}
	function myAutoloader($class){
		include 'classes/'.$class.'.php';// my need to adjust path acordingly
	}
	function addAuthor($id, $name, $surname, $link) {
		// adding an Author
		$sql = "INSERT INTO author VALUES ('$id', '$name', '$surname')";
		$result = mysqli_query($link, $sql);
		// check query rans ok
		if($result === false){
			echo mysqli_error($link);
		}else {
			echo 'Data inserted...';
		}
	}
	function connectToDB(){
		require 'config.php';
		$link = mysqli_connect(
			$config['db_host'],
			$config['db_user'],
			$config['db_pass'],
			$config['db_name']
		);
		if (mysqli_connect_errno()) {
			exit(mysqli_connect_error());
			return false;
		}else {
			return $link;
		}
	}
	function executeSQL($sql, $link){
		//executing sql query
		$result = mysqli_query($sql, $link);
		// checking query runs ok 
		if($result === false){
			echo mysqli_error($link);
			return false;
		}else {
			echo ' Query executed !!';
			return $result;
		}
	}
	function formatMoney($number){
		$formatted = number_format($number, 2);
		$price = '£'.$formatted;
		return $price;//htmlentities($price);
	}
	function authorList($an){
		$str="";
		$c = count($an);
		if($c==0) return null;
		else if($c==1)return $an[0];
		else if($c==2)return $an[0].' and '.$an[1];
		else if ($c>2) {
			for($i=0; $i<($c-1);$i++){
				$str .= $an[$i];
				if($i!=$c-2) $str.=" , ";
			}
			$str.= " and ".$an[$c-1];
		}
		return $str;
	}
	function bookDetails($title, $isbn, $price, $authors){
		$out = '<table border="1"><tr><th>Title</th><th>ISBN</th><th>Price</th><th>Authors</th></tr><tr>';
		$out .= "<td>$title</td><td>$isbn</td><td>".formatMoney($price)."</td><td>".authorList($authors)."</td>";
		
		$out .= "</tr></table>";
		return $out;
	}
	function formatDate($date){
		return date('d-m-Y', strtotime($date));
	}
?>