<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include "db_connect.php";
include "menu.php";

$user_id = $_SESSION['user_id'];

// Papar senarai tugas ikut tarikh & masa
$sql = "SELECT * FROM tasks WHERE user_id = $user_id ORDER BY task_date, task_time";
$result = $conn->query($sql);
?>

<h2>Your Tasks</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Task</th>
        <th>Date</th>
        <th>Time</th>
        <th>Category</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php
$no = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . htmlspecialchars($row['task_name']) . "</td>";
    echo "<td>" . $row['task_date'] . "</td>";
    echo "<td>" . $row['task_time'] . "</td>";
    echo "<td>" . ucfirst($row['category']) . "</td>";
    echo "<td>" . ucfirst($row['status']) . "</td>";
    echo "<td>";

    if ($row['status'] == 'pending') {
        echo "<a href='update_task_status.php?id={$row['task_id']}&status=completed'>✅ Complete</a> | ";
        echo "<a href='update_task_status.php?id={$row['task_id']}&status=missed'>❌ Missed</a> | ";
    }

    // Tambah butang Edit dan Delete
    echo "<a href='edit_task.php?id={$row['task_id']}'>✏️ Edit</a> | ";
    echo "<a href='delete_task.php?id={$row['task_id']}' onclick=\"return confirm('Are you sure to delete this task?')\">🗑️ Delete</a>";

    echo "</td>";
    echo "</tr>";
}
?>
</table>
