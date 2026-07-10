<?php
require_once 'db.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM expenses WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?status=deleted");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
