<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include "db_connect.php";
include "menu.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM goals WHERE user_id = $user_id ORDER BY target_date";
$result = $conn->query($sql);

// Tambah semakan jika query gagal
if (!$result) {
    echo "<p style='color: red;'>SQL Error: " . $conn->error . "</p>";
    exit();
}
?>

<h2>Your Goals</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Goal</th>
        <th>Target</th>
        <th>Target Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php
$no = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . htmlspecialchars($row['goal_name']) . "</td>";
    echo "<td>" . $row['target_value'] . "</td>";
    echo "<td>" . $row['target_date'] . "</td>";
    echo "<td>" . ucfirst($row['status']) . "</td>";
    echo "<td>";

    if ($row['status'] == 'in progress') {
        echo "<a href='update_goal_status.php?id={$row['goal_id']}&status=achieved'>🏁 Achieved</a> | ";
        echo "<a href='update_goal_status.php?id={$row['goal_id']}&status=not achieved'>❌ Not Achieved</a>";
    } else {
        echo "-";
    }

    echo "</td>";
    echo "</tr>";
}
?>
</table>
