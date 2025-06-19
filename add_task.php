<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Task | RemindU</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            max-width: 400px;
            margin: auto;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<?php include "menu.php"; ?>

<h2>➕ Add New Task</h2>

<form method="post" action="add.php">
    <label for="task_name">Task Name:</label>
    <input type="text" name="task_name" id="task_name" required>

    <label for="task_date">Date:</label>
    <input type="date" name="task_date" id="task_date" required>

    <label for="task_time">Time:</label>
    <input type="time" name="task_time" id="task_time" required>

    <label for="category">Category:</label>
    <select name="category" id="category" required>
        <option value="">-- Please Select --</option>
        <option value="personal">Personal</option>
        <option value="study">Study</option>
        <option value="work">Work</option>
    </select>

    <input type="submit" value="Add Task">
</form>

</body>
</html>
