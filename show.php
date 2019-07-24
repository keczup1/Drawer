<?php
	$host = "localhost"; /* Host name */
	$user = "hpgrouph_bazuka"; /* User */
	$password = "5CKhm2L88"; /* Password */
	$dbname = "hpgrouph_bazka"; /* Database name */

	$con = mysqli_connect($host, $user, $password,$dbname);
	// Check connection
	if (!$con) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT image_id,name,datetime FROM images ORDER BY datetime DESC";
	$result = $con->query($sql);

if ($result->num_rows > 0) {
    echo "<table><thead><tr><th>ID</th><th>Name</th><th>Date</th></tr></thead><tbody>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["image_id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["datetime"]. "</td></tr>";
    }
    echo "</tbody></table>";
} else {
    echo "0 results";
}

$con->close();

?> 