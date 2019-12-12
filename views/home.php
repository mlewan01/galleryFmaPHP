<?php
// connection with database 
$db = new myDB(
		$config['db_host'],
		$config['db_user'],
		$config['db_pass'],
		$config['db_name']
);

// retriving data from database
$sql = "select id, title, thumb150 from gallery";
$result = $db->myQuery($sql);
$content .= "\n";

// formating output with data from database
while($row = $result->fetch_assoc()) {
	$content .= 
	"<div class=\"thumbnail\">
		<div class=\"image\">
			<a href=\"index.php?page=imageprev&amp;l=$row[id]\">
				<img src=\"$row[thumb150]\" alt =\"$row[title]\" />
			</a>
		</div>
		<span class=\"title\">".$row['title']."</span>
	</div>

";
}
// result object method to free result set
$result->free();
?>