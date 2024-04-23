<?php


$servername = "192.168.1.3:3306";
$database = "butl_v2";
$username = "tool";
$password = "tooltool123";

// Create connection
 $conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
echo 'aaaaaa';
if ($conn->connect_error) {
    echo '"@#42432';exit;

  die("Connection failed: " . $conn->connect_error);
}
echo '"22222222';exit;

echo "Connected successfully";
?>
?>