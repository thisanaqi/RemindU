<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

// DEBUG
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$task_name = $_POST['task_name'] ?? '';
$task_date = $_POST['task_date'] ?? '';
$task_time = $_POST['task_time'] ?? '';
$category  = $_POST['category'] ?? '';
$user_id   = $_SESSION['user_id'];

if ($task_name && $task_date && $task_time && $category) {
    $status = 'pending';

    $sql = "INSERT INTO tasks (user_id, task_name, task_date, task_time, category, status)
            VALUES ('$user_id', '$task_name', '$task_date', '$task_time', '$category', '$status')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_tasks.php");
        exit();
    } else {
        echo "SQL Error: " . $conn->error;
    }
} else {
    echo "Form data missing.";
}
?>
