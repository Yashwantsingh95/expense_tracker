<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $amount = floatval($_POST['amount']); 
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    if (!empty($title) && $amount > 0 && !empty($category) && !empty($date)) {
        $sql = "INSERT INTO expenses (title, amount, category, expense_date) VALUES ('$title', $amount, '$category', '$date')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?status=success");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        header("Location: index.php?status=invalid");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
