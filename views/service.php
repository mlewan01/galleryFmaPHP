<?php
// calling autoloader function from functons.php to load required classes
autoloader();

// seting jonson header to inform of the type of datat to be sent
header('Content-type: application/json');

// setting connection with database 
$myDB = new myDB($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
$sql = "select title, descr, fileNameExt, thumb600size  from gallery";
$result = $myDB->myQuery($sql);

// reading output from the database and imputing to an arrey to be used with json encoder
$arr = array();
$i=0;
while($row = $result->fetch_assoc()){
	$arr[$i]=$row;
	$i++;
}
// outputing encoded data from database as json
echo json_encode($arr);
?>