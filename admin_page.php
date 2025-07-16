<?php  
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}





// Insert Student Data
if (isset($_POST['submit'])) {
  $roll = mysqli_real_escape_string($conn, $_POST['roll']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $branch = mysqli_real_escape_string($conn, $_POST['branch']);
  $semester = mysqli_real_escape_string($conn, $_POST['semester']);
  $enrollment_no = mysqli_real_escape_string($conn, $_POST['enrollment_no']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);

  // Phone number validation (only 10 digits)
  if (!preg_match("/^\d{10}$/", $phone)) {
    $message = "Phone number must be exactly 10 digits!";
  } else {
    // Check for duplicates (roll, enrollment_no, email)
    $check_query = "SELECT * FROM students WHERE roll='$roll' OR enrollment_no='$enrollment_no' OR email='$email'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
      $message = "Duplicate entry: Roll No, Enrollment No, or Email already exists!";
    } else {
      // Insert data
      $insert = "INSERT INTO students (roll, name, branch, semester, enrollment_no, email, phone)
                 VALUES ('$roll', '$name', '$branch', '$semester', '$enrollment_no', '$email', '$phone')";

      if (mysqli_query($conn, $insert)) {
        $message = "Student added successfully!";
      } else {
        $message = "Failed to add student!";
      }
    }
  }

  echo "<script>alert('$message');</script>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title']) && isset($_POST['message'])) {
  $title = $conn->real_escape_string($_POST['title']);
  $message = $conn->real_escape_string($_POST['message']);

  // Check for duplicate notice
  $check_sql = "SELECT * FROM notices WHERE title = '$title' AND message = '$message'";
  $check_result = $conn->query($check_sql);

  if ($check_result->num_rows > 0) {
      $_SESSION['notice_msg'] = "This notice already exists!";
  } else {
      $sql = "INSERT INTO notices (title, message) VALUES ('$title', '$message')";
      if ($conn->query($sql) === TRUE) {
          $_SESSION['notice_msg'] = "Notice added successfully!";
      } else {
          $_SESSION['notice_msg'] = "Error: " . $conn->error;
      }
  }

  // Redirect once after submission
  header("Location: admin_page.php");
  exit();
}

// Handle notice deletion
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  $sql = "DELETE FROM notices WHERE id = $id";
  if ($conn->query($sql) === TRUE) {
      $_SESSION['notice_msg'] = "Notice deleted successfully!";
  } else {
      $_SESSION['notice_msg'] = "Error deleting notice: " . $conn->error;
  }

  // Redirect once after deletion
  header("Location: admin_page.php");
  exit();
}
?>



<!DOCTYPE html>    
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* Basic Styles for layout */
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f4f7fb;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 80%;
      margin: 0 auto;
    }

    .header {
      background-color: #0047ab;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .header h1 {
      margin: 0;
      font-size: 2.5rem;
    }

    .header h3 {
      font-size: 1.5rem;
    }

    .header span {
      color: #ffb84d;
    }

    .btn {
      background-color: #ffb84d;
      padding: 10px 20px;
      margin: 10px;
      border: none;
      cursor: pointer;
      text-decoration: none;
      font-weight: 600;
    }

    .section {
      background-color: white;
      padding: 20px;
      margin-top: 20px;
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
      font-size: 1.8rem;
      margin-bottom: 20px;
    }

    .input-group input {
      padding: 10px;
      margin-right: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      width: 200px;
    }

    .input-group button {
      padding: 10px;
      background-color: #0047ab;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 1rem;
      width: 220px;
      border-radius: 4px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    table, th, td {
      border: 1px solid #ccc;
    }

    th, td {
      padding: 12px;
      text-align: center;
    }

    th {
      background-color: #0047ab;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .edit-btn, .delete-btn {
      padding: 6px 12px;
      background-color: #ffb84d;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 1rem;
      border-radius: 4px;
      margin: 5px;
    }

    .edit-btn:hover, .delete-btn:hover {
      background-color: #ff9f00;
    }

    .search-bar input {
      padding: 10px;
      width: 300px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    .search-bar input:focus {
      outline: none;
      border-color: #0047ab;
    }

    #attendanceSummary table {
      width: 100%;
    }

    #attendanceSummary td, #attendanceSummary th {
      padding: 10px;
      text-align: center;
    }

    #attendanceSummary th {
      background-color: #0047ab;
      color: white;
    }

    /* Time Table Styles */
    #timeTable td, #timeTable th {
      padding: 10px;
      text-align: center;
    }

    #timeTable th {
      background-color: #0047ab;
      color: white;
    }

    #timeTable td[contenteditable="true"] {
      background-color: #f9f9f9;
    }
    .form-section {
  background-color: #fff;
  border-radius: 10px;
  padding: 30px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  max-width: 600px;
  margin: 20px auto;
}

.form-section h2 {
  font-size: 24px;
  color: #2c3e50;
  margin-bottom: 20px;
  text-align: center;
}

.form-section form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-section input {
  padding: 12px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 8px;
  outline: none;
  transition: all 0.3s ease;
}

.form-section input:focus {
  border-color: #2980b9;
  box-shadow: 0 0 5px rgba(41, 128, 185, 0.6);
}

.form-section button {
  padding: 12px 20px;
  background-color: #2980b9;
  color: white;
  font-size: 16px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.form-section button:hover {
  background-color: #1e5f8b;
}

.form-section button:active {
  transform: scale(0.98);
}

.container {
  max-width: 1200px;
  margin: auto;
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Section Styling */
.section {
  margin-top: 40px;
}

h2 {
  font-size: 24px;
  color: #2980b9;
  border-bottom: 2px solid #2980b9;
  padding-bottom: 5px;
}

h3 {
  margin-top: 20px;
  font-size: 20px;
  color: #34495e;
}

/* Form Styling */
form {
  margin-top: 20px;
  background-color: #fafafa;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

input, textarea {
  width: 100%;
  padding: 12px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-sizing: border-box;
  font-size: 16px;
}

textarea {
  height: 150px;
}

button {
  padding: 10px 15px;
  background-color: #2980b9;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #1e5f8b;
}

/* Table Styling */
table {
  width: 100%;
  margin-top: 20px;
  border-collapse: collapse;
}

th, td {
  padding: 12px;
  text-align: center;
  border: 1px solid #ddd;
}

th {
  background-color: #2980b9;
  color: white;
  font-size: 16px;
}

td {
  font-size: 14px;
  color: #555;
}

td a {
  text-decoration: none;
  color: #e74c3c;
  font-weight: bold;
}

td a:hover {
  color: #c0392b;
}


@media (max-width: 768px) {
  .form-section {
    padding: 20px;
    max-width: 100%;
  }

  .form-section input {
    font-size: 14px;
  }

  .form-section button {
    font-size: 14px;
    padding: 10px 15px;
  }
}


  </style>
</head>
<body>

<div class="container">
  <div class="header">
    <h3>Hi, <span>admin</span></h3>
    <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
    <p>This is an admin page</p>
    <a href="login_form.php" class="btn">Login</a>
    <a href="register_form.php" class="btn">Register</a>
    <a href="logout.php" class="btn">Logout</a>
    <a href="allstudents.php" class="btn">All Students</a>
    <a href="allfaculty.php" class="btn">All Faculty </a>
    <a href="hidden_students.php" class="btn">Detain student list </a>

  </div>

  <div class="form-section">
    <h2>Add New Student</h2>
    <form method="post">
  <input type="text" name="roll" placeholder="Roll No" required>
  <input type="text" name="name" placeholder="Name" required>
  <input type="text" name="branch" placeholder="Branch" required>
  <input type="number" name="semester" placeholder="Semester" min="1" max="6" required>
  <input type="text" name="enrollment_no" placeholder="Enrollment No" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="text" name="phone" placeholder="Phone (10 digits only)" pattern="\d{10}" title="Enter 10-digit phone number" required>
  <button type="submit" name="submit">Add Student</button>
</form>

  </div>


  <div class="section">
    <h2>Search Student</h2>
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search by name, Enrollment no...." onkeyup="searchStudent()">
    </div>
  </div>

  <!-- New Section: Student Records -->
  <div class="section">
    <h2>Student Records</h2>
    <table>
      <thead>
        <tr>
          <th>Roll No</th>
          <th>Name</th>
          <th>Branch</th>
          <th>Enrollment No.</th>
          <th>Semester</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="studentTable">
        <?php
        // @include 'config.php'; // database connection include karna mat bhoolna

        $select = mysqli_query($conn, "SELECT * FROM students");
        if (mysqli_num_rows($select) > 0) {
          while ($row = mysqli_fetch_assoc($select)) {
              echo "<tr>
                      <td>{$row['roll']}</td>
                      <td>{$row['name']}</td>
                      <td>{$row['branch']}</td>
                      <td>{$row['enrollment_no']}</td>
                      <td>{$row['semester']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['phone']}</td>
                      <td>
                          <a href='edit.php?id={$row['id']}'><button>Edit</button></a>
                          <a href='delete.php?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this student?\");'><button>Delete</button></a>
                          <a href='hide.php' onclick='deleteStudent({$row['id']}); return false;'><button>Detain Student</button></a>
                      </td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='8'>No records found</td></tr>";
      }
      
        ?>
      </tbody>
   </table>
      </div>
   

 <div class="section">
    <h2>Manage Notices</h2>
    <form action="" method="POST">
    <input type="text" name="title" placeholder="Notice Title" required>
    <textarea name="message" placeholder="Notice Details" required></textarea>
    <button type="submit">Add Notice</button>
    </form>

    <h3>Existing Notices</h3>
    <table>
      <thead>
        <tr><th>ID</th><th>Title</th><th>Content</th><th>Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
      <?php
      $query = "SELECT * FROM notices ORDER BY created_at DESC";
      $notices = mysqli_query($conn, $query);

      if (!$notices) {
        echo "Error in query: " . mysqli_error($conn); // Debugging line
        exit;
      }

      while ($row = mysqli_fetch_assoc($notices)) {
        echo "<tr>
          <td>{$row['id']}</td>
          <td>{$row['title']}</td>
          <td>{$row['message']}</td>
          <td>{$row['created_at']}</td>
          <td>
            <a href='?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this notice?');\">Delete</a>
          </td>
        </tr>";
       }

       ?>



      </tbody>
    </table>
  </div>
</div>

<script>
function searchStudent() {
  var input = document.getElementById("searchInput");
  var filter = input.value.toUpperCase();
  var table = document.getElementById("studentTable");
  var tr = table.getElementsByTagName("tr");

  for (var i = 1; i < tr.length; i++) {  // i=1 to skip header row
    var td = tr[i].getElementsByTagName("td");
    var match = false;

    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        var txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          match = true;
          break;
        }
      }
    }

    tr[i].style.display = match ? "" : "none";
  }
}

function deleteStudent(id) {
  let reason = prompt("Enter reason for hiding this student:");
  if (reason && reason.trim() !== "") {
      // Encode and redirect to delete file with reason
      window.location.href = "hide.php?id=" + id + "&reason=" + encodeURIComponent(reason);
  } else {
      alert("Hiding cancelled. Reason is required.");
  }
}
</script>
</body>
</html>
