<?php
session_start();
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $todoId = $_GET['id'];
    $userId = $_SESSION['id'];

    $sql = "DELETE FROM todo_items WHERE id='$todoId' AND user_id='$userId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: todo.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
