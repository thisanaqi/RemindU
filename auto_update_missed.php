<?php
// Tunjuk semua error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "db_connect.php";

// Auto-update tasks
$sql = "UPDATE tasks 
        SET status = 'missed' 
        WHERE status = 'pending' 
        AND CONCAT(task_date, ' ', task_time) < NOW()";

if (!$conn->query($sql)) {
    die("Task update error: " . $conn->error);
}

// Auto-update goals
$sql_goals = "SELECT g.goal_id, g.target_value, g.user_id,
                     (SELECT COUNT(*) FROM tasks 
                      WHERE user_id = g.user_id AND status = 'completed') AS completed_count
              FROM goals g
              WHERE g.status = 'in progress'";

$result = $conn->query($sql_goals);

if (!$result) {
    die("Goal select error: " . $conn->error);
}

while ($row = $result->fetch_assoc()) {
    if ($row['completed_count'] >= $row['target_value']) {
        $goal_id = $row['goal_id'];
        $update = $conn->query("UPDATE goals SET status = 'achieved' WHERE goal_id = $goal_id");

        if (!$update) {
            echo "Failed to update goal_id $goal_id: " . $conn->error;
        }
    }
}

// Jangan letak echo terus — hanya untuk debug jika perlu
?>
