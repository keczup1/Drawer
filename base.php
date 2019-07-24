<?php
	//include("config.php");

$host = "localhost"; /* Host name */
	$user = "hpgrouph_bazuka"; /* User */
	$password = "5CKhm2L88"; /* Password */
	$dbname = "hpgrouph_bazka"; /* Database name */

	$con = mysqli_connect($host, $user, $password,$dbname);
	// Check connection
	if (!$con) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$filename = $_POST['filename'];
	$date = $_POST['date'];
	$imgdata = $_POST['data'];

	$sql = "INSERT INTO images (image_id, name, datetime, imageTable)
VALUES (null, '$filename' , '$date' , '$imgdata')";

if (mysqli_query($con, $sql)) {
    echo "Your image has been saved";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);

?>