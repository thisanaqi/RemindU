<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include "db_connect.php";

$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM tasks WHERE task_id = $task_id AND user_id = $user_id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Task deleted'); window.location='view_tasks.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
