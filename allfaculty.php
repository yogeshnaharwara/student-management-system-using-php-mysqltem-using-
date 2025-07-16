<?php
@include 'config.php';

$query = "SELECT * FROM user_form WHERE user_type = 'faculty'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #d1ecf1;
        }
    </style>
</head>
<body>

<h2>Faculty Members</h2>

<table>
    <tr>
        <!-- <th>ID</th> -->
        <th>Name</th>
        <th>Email</th>
        <th>User Type</th>
        <!-- Add more columns if needed -->
    </tr>

    <?php
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>
                
                <td>".$row['name']."</td>
                <td>".$row['email']."</td>
                <td>".$row['user_type']."</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No faculty found</td></tr>";
    }
    ?>
</table>

</body>
</html>
