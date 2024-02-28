<?php
session_start();
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $todoId = $_GET['id'];
    $userId = $_SESSION['id'];

    $sql = "SELECT * FROM todo_items WHERE id='$todoId' AND user_id='$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $task = $row['task'];
        $status = $row['status'];
    } else {
        echo "Invalid request.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = $_POST['task'];
    $status = $_POST['status'];
    $todoId = $_POST['id'];

    $sql = "UPDATE todo_items SET task='$task', status='$status' WHERE id='$todoId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: todo.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit To-Do Item</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit To-Do Item</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $todoId; ?>">
            <div class="form-group">
                <label for="task">Task:</label>
                <input type="text" class="form-control" id="task" name="task" value="<?php echo $task; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="completed" <?php if ($status === 'completed') echo 'selected'; ?>>Completed</option>
                    <option value="pending" <?php if ($status === 'pending') echo 'selected'; ?>>Pending</option>
                    <option value="canceled" <?php if ($status === 'canceled') echo 'selected'; ?>>Canceled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
