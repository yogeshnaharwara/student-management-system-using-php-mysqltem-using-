<?php
@include 'config.php'; // Include database connection

// In your register form (register_form.php)
if (isset($_POST['submit'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = $_POST['password'];  // Get password entered by user
   $cpass = $_POST['cpassword'];  // Get confirmed password
   $user_type = $_POST['user_type'];

   if ($pass != $cpass) {
      $error[] = 'Passwords do not match!';
   } else {
      // Hash the password before storing it
      $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

      // Check if email already exists
      $select = "SELECT * FROM user_form WHERE email = '$email'";
      $result = mysqli_query($conn, $select);
      if (mysqli_num_rows($result) > 0) {
         $error[] = 'User already exists!';
      } else {
         // Insert new user into the database with hashed password
         $insert = "INSERT INTO user_form (name, email, password, user_type) 
                    VALUES ('$name', '$email', '$hashed_pass', '$user_type')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <!-- Custom CSS link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="form-container">
    <form action="" method="post">
        

        <?php
        if (isset($error)) {
            foreach ($error as $error) {
                echo '<span class="error-msg">' . $error . '</span>';
            }
        }
        ?>

        <input type="text" name="name" required placeholder="Enter your name">
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="password" name="cpassword" required placeholder="Confirm your password">

        <select name="user_type">
            <option value="user">User</option>
            <option value="admin">Admin</option>
            <option value="faculty">Faculty</option>
        </select>

        <input type="submit" name="submit" value="Register Now" class="form-btn">
        <p>Already have an account? <a href="login_form.php">Login now</a></p>
    </form>
</div>

</body>
</html>
