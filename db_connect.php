<?php
$servername = "containers-us-west-142.railway.app"; // ganti dengan actual host
$username = "root";
$password = "MrHxIoSOlBwAPGgkPfrXBYdcbPzbtPes";
$dbname = "railway";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
