<?php
@include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Step 1: Get student from hidden_students
    $getQuery = "SELECT * FROM hidden_students WHERE id = $id";
    $result = mysqli_query($conn, $getQuery);

    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);

        // Step 2: Insert into students table
        $insertQuery = "INSERT INTO students (roll, name, branch, semester, enrollment_no, email, phone)
                        VALUES (
                            '{$student['roll']}',
                            '{$student['name']}',
                            '{$student['branch']}',
                            '{$student['semester']}',
                            '{$student['enrollment_no']}',
                            '{$student['email']}',
                            '{$student['phone']}'
                        )";

        if (mysqli_query($conn, $insertQuery)) {
            // Step 3: Delete from hidden_students
            $deleteQuery = "DELETE FROM hidden_students WHERE id = $id";
            mysqli_query($conn, $deleteQuery);
            header("Location: hidden_students.php?msg=Student restored successfully");
            exit();
        } else {
            echo "Error restoring student: " . mysqli_error($conn);
        }
    } else {
        echo "Student not found.";
    }
} else {
    echo "Invalid request.";
}
?>
