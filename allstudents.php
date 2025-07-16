<?php
@include 'config.php';  // DB connection file

$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9faff;
            margin: 20px;
            padding: 0;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0077b6;
        }
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #0077b6;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f1f7fc;
        }
        tr:hover {
            background-color: #d0e7ff;
        }
    </style>
</head>
<body>

<h2>Students List</h2>

<table>
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Roll</th>
            <th>Name</th>
            <th>Branch</th>
            <th>Semester</th>
            <th>Enrollment No</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>
                       
                        <td>{$row['roll']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['branch']}</td>
                        <td>{$row['semester']}</td>
                        <td>{$row['enrollment_no']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No students found.</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
