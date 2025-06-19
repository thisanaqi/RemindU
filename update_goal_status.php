<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include "db_connect.php";

$goal_id = $_GET['id'];
$status = $_GET['status'];
$user_id = $_SESSION['user_id'];

$sql = "UPDATE goals SET status = '$status' WHERE goal_id = $goal_id AND user_id = $user_id";

if ($conn->query($sql) === TRUE) {
    header("Location: view_goals.php");
} else {
    echo "Error: " . $conn->error;
}
?>
