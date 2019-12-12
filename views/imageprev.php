<?php
// retriving information from sent with add
if(ctype_digit($_GET['l'])){
	$img = $_GET['l'];
	
	// retriving data from database
	$db = new myDB(
			$config['db_host'],
			$config['db_user'],
			$config['db_pass'],
			$config['db_name']
	);
	$sql = "select title, descr, thumb600 from gallery where id = $img";
	$result = $db->myQuery($sql);
	if($row = $result->fetch_assoc()){
		$result->free();
		
		// formating output with data from database
		$content .=
		"\n<div class = \"largeimage\">
		<a href=\"index.php\">
		<img src=\"$row[thumb600]\" alt=\"".htmlentities( $row["title"], ENT_QUOTES, "UTF-8" )."\"/>
		</a>
		<h3 class=\"imagetitle\">".
		   htmlentities( $row["title"], ENT_QUOTES, "UTF-8" )
		."</h3>
		<p class=\"imagedesc\">".
		htmlentities( $row["descr"], ENT_QUOTES, "UTF-8" )
		."</p>
		</div>";
	} else {
		
		$content .= $lang['img_preview'];
		
	}
	
}else{
	$content .= $lang['img_preview'];
}
?>