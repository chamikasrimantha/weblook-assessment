<?php
session_start();
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = $_POST['task'];
    $status = $_POST['status'];
    $userId = $_SESSION['id'];

    $sql = "INSERT INTO todo_items (user_id, task, status) VALUES ('$userId', '$task', '$status')";
    if ($conn->query($sql) === TRUE) {
        header("Location: todo.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
