<?php
@include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the data based on ID
    $select = mysqli_query($conn, "SELECT * FROM students WHERE id = '$id'");
    $student = mysqli_fetch_assoc($select);
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $roll = $_POST['roll'];
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $enrollment_no = $_POST['enrollment_no'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update the student data
    $update = mysqli_query($conn, "UPDATE students SET name = '$name', roll = '$roll', branch = '$branch', semester = '$semester', enrollment_no = '$enrollment_no', email = '$email', phone = '$phone' WHERE id = '$id'");

    if ($update) {
        header('Location: admin_page.php'); // Redirect to the panel after update
    } else {
        echo "Error updating data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"],
        input[type="email"] {
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Edit Student Details</h1>
    <form method="post">
        <label>Name</label><input type="text" name="name" value="<?php echo $student['name']; ?>" required><br>
        <label>Roll No</label><input type="text" name="roll" value="<?php echo $student['roll']; ?>" required><br>
        <label>Branch</label><input type="text" name="branch" value="<?php echo $student['branch']; ?>" required><br>
        <label>Semester</label><input type="text" name="semester" value="<?php echo $student['semester']; ?>" required><br>
        <label>Enrollment No.</label><input type="text" name="enrollment_no" value="<?php echo $student['enrollment_no']; ?>" required><br>
        <label>Email</label><input type="email" name="email" value="<?php echo $student['email']; ?>" required><br>
        <label>Phone</label><input type="text" name="phone" value="<?php echo $student['phone']; ?>" required><br>
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
