<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include "db_connect.php";

$task_id = $_GET['id'];
$status = $_GET['status'];
$user_id = $_SESSION['user_id'];

// Update hanya task milik user ni
$sql = "UPDATE tasks SET status = '$status' WHERE task_id = $task_id AND user_id = $user_id";

if ($conn->query($sql) === TRUE) {
    header("Location: view_tasks.php");
} else {
    echo "Error: " . $conn->error;
}
?>
