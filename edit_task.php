<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include "db_connect.php";
include "menu.php";

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'] ?? null;

// Ambil data lama
if ($task_id) {
    $sql = "SELECT * FROM tasks WHERE task_id = $task_id AND user_id = $user_id";
    $result = $conn->query($sql);
    $task = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_name = $_POST['task_name'];
    $task_date = $_POST['task_date'];
    $task_time = $_POST['task_time'];
    $category  = $_POST['category'];

    $sql = "UPDATE tasks SET task_name = '$task_name', task_date = '$task_date',
            task_time = '$task_time', category = '$category' 
            WHERE task_id = $task_id AND user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Task updated'); window.location='view_tasks.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Edit Task</h2>
<form method="post">
    Task Name: <input type="text" name="task_name" value="<?= $task['task_name'] ?>" required><br><br>
    Date: <input type="date" name="task_date" value="<?= $task['task_date'] ?>" required><br><br>
    Time: <input type="time" name="task_time" value="<?= $task['task_time'] ?>" required><br><br>
    Category:
    <select name="category">
        <option value="personal" <?= $task['category'] == 'personal' ? 'selected' : '' ?>>Personal</option>
        <option value="study" <?= $task['category'] == 'study' ? 'selected' : '' ?>>Study</option>
        <option value="work" <?= $task['category'] == 'work' ? 'selected' : '' ?>>Work</option>
    </select><br><br>
    <input type="submit" value="Update Task">
</form>
