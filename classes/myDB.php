<?php
class myDB extends mysqli {

	public function __construct($host, $user, $pass, $db){
		// call to parent constructor
		parent::__construct($host, $user, $pass, $db);
		// use $this to access mysqli members
		// detectin errors in connecton to db
		if ($this->connect_errno){
			exit($this->connect_errno);
		}
	}
	
	public function myQuery($sql){
		// using the query method of parent object
		$result = $this->query($sql);
		if($result === false){
			// Get error string from object property
			echo $this->error;
		} else {
			// if successful returns $result
			//echo 'Query successful ! ! !'.'</br>';  // <<<<<<<<<<<<<<<<<<<<<
			return $result;
		}
	}
}

/*
Using our object
-----------------------------------------------------------
// Instantiate a myDB object
$db = new myDB(
'hostname',
'user',
'pass',
'dbname');
// Errors are detected in the object…
$sql = "SELECT name, age FROM students";
$result = $db->query($sql);
-----------------------------------------------------------
// result object has methods, e.g. fetch_assoc
// and properties, e.g. num_rows
while($row = $result->fetch_assoc()) {
echo $row['name'].' is '.$row['age'].' yrs old';
}
// result object method to free result set
$result->free();
-----------------------------------------------------------
// Use fetch_object to get each row as an object!
// By default, object has no methods
// Each "field" from query becomes a property
while($obj = $result->fetch_object()){
echo $obj->name.' is '.$obj->age.' yrs old';
}
$result->free();
-----------------------------------------------------------
*/
?>