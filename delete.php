<?php
@include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the student data
    $delete = mysqli_query($conn, "DELETE FROM students WHERE id = '$id'");

    if ($delete) {
        header('Location: admin_page.php'); // Redirect after deletion
    } else {
        echo "Error deleting data!";
    }
}
?>
