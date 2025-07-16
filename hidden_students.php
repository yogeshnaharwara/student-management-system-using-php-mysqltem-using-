<?php
@include 'config.php';

$query = "SELECT * FROM hidden_students";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deleted Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #0077b6;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a.restore-btn {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        a.restore-btn:hover {
            background-color: #218838;
        }

        .home-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            text-align: center;
            background-color: #0077b6;
            color: white;
            padding: 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .home-btn:hover {
            background-color: #005f87;
        }
    </style>
</head>
<body>

<h2>Deleted Students</h2>

<table>
    <tr>
        <th>Roll</th>
        <th>Name</th>
        <th>Branch</th>
        <th>Semester</th>
        <th>Enrollment No</th>
        <th>Email</th>
        <th>Phone</th>
        <th> Reason </th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['roll']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['branch']; ?></td>
            <td><?php echo $row['semester']; ?></td>
            <td><?php echo $row['enrollment_no']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['reason']; ?></td>
            <td>
                <a class="restore-btn" href="restore.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Restore this student?');">Add Student</a>
            </td>
        </tr>
    <?php } ?>
</table>

<a class="home-btn" href="admin_page.php">⬅ Back to Home Page</a>

</body>
</html>
