<?php
@include 'config.php';  // Include the database connection file

session_start();  // Start the session to handle user authentication

if (isset($_POST['submit'])) {
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = $_POST['password'];  // Password entered by the user (plain text)

   // Query to check if the email exists in the database
   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);

   if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);

      // Verify if the entered password matches the stored hashed password
      if (password_verify($pass, $row['password'])) {  // Verify the password hash
         if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];  // Use 'Name' with capital N here
            header('location:admin_page.php');
            exit;
         } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];  // Use 'Name' with capital N here
            header('location:user_page.php');
            exit;
         } elseif ($row['user_type'] == 'faculty') {
            $_SESSION['faculty_name'] = $row['name'];  // Use 'Name' with capital N here
            header('location:faculitypanel.php');
            exit;
         }

      } else {
         $error[] = 'Incorrect email or password!';
      }
   } else {
      $error[] = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">


</head>
<body>

<div class="form-container">
   <!-- Form to login -->
   <form action="" method="post">
      

      <!-- Display any error messages -->
      <?php
      if (isset($error)) {
         foreach ($error as $error_message) {
            echo '<span class="error-msg">' . $error_message . '</span>';
         }
      }
      ?>

      <!-- Email input field -->
      <input type="email" name="email" required placeholder="Enter your email">

      <!-- Password input field -->
      <input type="password" name="password" required placeholder="Enter your password">

      <!-- Submit button -->
      <input type="submit" name="submit" value="Login Now" class="form-btn">

      <!-- Link to register page -->
      <!-- <p>Don't have an account? <a href="register_form.php">Register now</a></p> -->
   </form>
</div>

</body>
</html>
