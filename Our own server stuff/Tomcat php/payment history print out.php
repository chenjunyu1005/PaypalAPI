<?php 
$servername = "localhost";
$username = "root";
$password = "gypd0231";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
// Create database
$sql="Select* from payments order by ID DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		echo "id: " . $row["id"]. 
		" - payment_amount: " . $row["payment_amount"].
		" - payment_status: " . $row["payment_status"]. 
		" - txnid: "          . $row["txnid"]. 
		" - payeremail: "     . $row["payer_email"].
		" - date: "            . $row["createdtime"].
				"<br>";
	}
	$conn->close();
} else {
	echo "0 results";
}
