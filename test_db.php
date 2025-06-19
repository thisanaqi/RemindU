<?php
$servername = "sql109.infinityfree.com";
$user = "if0_39224548";
$password = "remindU12345678"; // Masukkan password akaun InfinityFree kau
$database = "if0_39224548_epiz_12345678_remindu";

$conn = new mysqli($servername, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "✅ Berjaya sambung database!";
?>
