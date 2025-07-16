<?php
@include 'config.php';

if (isset($_GET['id']) && isset($_GET['reason'])) {
    $id = intval($_GET['id']);
    $reason = mysqli_real_escape_string($conn, $_GET['reason']);

    $select = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);

        $insert = mysqli_query($conn, "INSERT INTO hidden_students (roll, name, branch, semester, enrollment_no, email, phone, reason)
            VALUES (
                '{$row['roll']}',
                '{$row['name']}',
                '{$row['branch']}',
                '{$row['semester']}',
                '{$row['enrollment_no']}',
                '{$row['email']}',
                '{$row['phone']}',
                '$reason'
            )");

        if (!$insert) {
            die("Insert failed: " . mysqli_error($conn));
        }

        $delete = mysqli_query($conn, "DELETE FROM students WHERE id = $id");

        if (!$delete) {
            die("Delete failed: " . mysqli_error($conn));
        }

        header("Location: admin_page.php?msg=Student hidden successfully");
        exit;
    } else {
        echo "Student not found.";
    }
} else {
    echo "Invalid request.";
}
?>
