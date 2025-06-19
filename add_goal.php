<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include "db_connect.php";
include "menu.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goal_name = $_POST['goal_name'];
    $target_value = $_POST['target_value'];
    $target_date = $_POST['target_date'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO goals (user_id, goal_name, target_value, target_date, status)
            VALUES ('$user_id', '$goal_name', '$target_value', '$target_date', 'in progress')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Goal added successfully'); window.location='view_goals.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Add New Goal</h2>
<form method="POST" action="">
    Goal Name: <input type="text" name="goal_name" required><br><br>
    Target (e.g., 5 tasks): <input type="number" name="target_value" min="1" required><br><br>
    Target Date: <input type="date" name="target_date" required><br><br>
    <input type="submit" value="Add Goal">
</form>
