<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

function displayTodoItems() {
    global $conn;

    $userId = $_SESSION['id'];
    $sql = "SELECT * FROM todo_items WHERE user_id='$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table'>";
        echo "<thead><tr><th>Task</th><th>Status</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        $completedCount = 0;
        $pendingCount = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['task']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td><a href='edit.php?id={$row['id']}' class='btn btn-primary btn-sm'>Edit</a> ";
            echo "<a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a></td>";
            echo "</tr>";
            
            if ($row['status'] === 'completed') {
                $completedCount++;
            } else {
                $pendingCount++;
            }
        }
        echo "</tbody>";
        echo "</table>";

        echo "<div>Completed: $completedCount</div>";
        echo "<div>Pending: $pendingCount</div>";
    } else {
        echo "No to-do items found.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #007bff; /* Navbar background color */
        }
        .navbar-brand {
            color: #fff; /* Navbar brand text color */
        }
        .navbar-nav .nav-item .nav-link {
            color: #fff; /* Navbar link text color */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <a class="navbar-brand" href="#">To-Do List</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h2>To-Do List</h2>
        <form action="add.php" method="post">
            <div class="form-group">
                <label for="task">New Task:</label>
                <input type="text" class="form-control" id="task" name="task" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="completed">Completed</option>
                    <option value="pending" selected>Pending</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
        <hr>
        <h3>Your Tasks</h3>
        <?php displayTodoItems(); ?>
        <br>
    </div>
</body>
</html>
