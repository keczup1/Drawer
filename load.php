<?php
	$id = $_POST['idtable'];
	
	$host = "localhost"; /* Host name */
	$user = "hpgrouph_bazuka"; /* User */
	$password = "5CKhm2L88"; /* Password */
	$dbname = "hpgrouph_bazka"; /* Database name */

	$con = mysqli_connect($host, $user, $password,$dbname);
	// Check connection
	if (!$con) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT imageTable FROM images WHERE image_id='$id'";
	$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row["imageTable"];
    }
} else {
    echo "0 results";
}

$con->close();
?>