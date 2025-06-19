<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";
include "auto_update_missed.php"; // Auto update task/goal status

$user_id = $_SESSION['user_id'];

// Query untuk tasks
$stmt_task = $conn->prepare("SELECT 
    COUNT(*) as total, 
    SUM(status = 'completed') as completed, 
    SUM(status = 'missed') as missed 
    FROM tasks WHERE user_id = ?");
$stmt_task->bind_param("i", $user_id);
$stmt_task->execute();
$task_result = $stmt_task->get_result()->fetch_assoc();
$stmt_task->close();

// Query untuk goals
$stmt_goal = $conn->prepare("SELECT 
    COUNT(*) as total, 
    SUM(status = 'achieved') as achieved 
    FROM goals WHERE user_id = ?");
$stmt_goal->bind_param("i", $user_id);
$stmt_goal->execute();
$goal_result = $stmt_goal->get_result()->fetch_assoc();
$stmt_goal->close();

// Default nilai jika kosong/null
$task_result['completed'] = $task_result['completed'] ?? 0;
$task_result['missed'] = $task_result['missed'] ?? 0;
$goal_result['achieved'] = $goal_result['achieved'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>RemindU Dashboard</title>
</head>
<body>
    <?php include "menu.php"; ?>

    <h2>Welcome to RemindU Dashboard</h2>

    <?php if ($task_result['missed'] > 0): ?>
        <p style='color: red; font-weight: bold;'>⚠️ You have <?= $task_result['missed'] ?> missed task(s)! Please check and update.</p>
    <?php endif; ?>

    <?php 
    $not_achieved = $goal_result['total'] - $goal_result['achieved'];
    if ($not_achieved > 0): ?>
        <p style='color: orange; font-weight: bold;'>🎯 You still have <?= $not_achieved ?> goal(s) in progress. Keep going!</p>
    <?php endif; ?>

    <p><strong>Total Tasks:</strong> <?= $task_result['total'] ?> |
       <strong>Completed:</strong> <?= $task_result['completed'] ?> |
       <strong>Missed:</strong> <?= $task_result['missed'] ?></p>

    <p><strong>Total Goals:</strong> <?= $goal_result['total'] ?> |
       <strong>Achieved:</strong> <?= $goal_result['achieved'] ?></p>

    <a href="add_task.php">➕ Add New Task</a> |
    <a href="add_goal.php">🎯 Add New Goal</a> |
    <a href="view_tasks.php">📋 View Tasks</a> |
    <a href="view_goals.php">📊 View Goals</a> |
    <a href="logout.php">🚪 Logout</a>
</body>
</html>
