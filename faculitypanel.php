<?php
@include 'config.php';
session_start();

// Check if faculty session is set
if (!isset($_SESSION['faculty_name'])) {
    header('location:login_form.php');
    exit();
}

// Handle attendance submission
// if (isset($_POST['submit_attendance'])) {

//   foreach ($_POST['attendance'] as $student_id => $attendance_status) {
    
//       $query = "SELECT roll, name, email FROM students WHERE id = '$student_id'";
//       $result = mysqli_query($conn, $query);
//       if ($student_data = mysqli_fetch_assoc($result)) {
//           $roll_no = $student_data['roll'];
//           $name = $student_data['name'];
//           $email = $student_data['email'];  // email fetch kar liya
//           $status = ($attendance_status === 'present') ? 'Present' : 'Absent';
//           $date = date('Y-m-d');

//           // Ab attendance table mein email bhi insert karna hoga,
//           // to agar attendance table mein email column nahi hai to pehle usse add karna hoga
//           $insert = "INSERT INTO attendance (student_id, roll_no, name, email, date, status) 
//                      VALUES ('$student_id', '$roll_no', '$name', '$email', '$date', '$status')";
//           mysqli_query($conn, $insert);
//       }
//   }

//   // Redirect once after submission
//   header('Location: faculitypanel.php');
//   exit();
// }


if (isset($_POST['submit_attendance'])) {
  $date = date('Y-m-d');
  $subject = $conn->real_escape_string($_POST['Subject']); // Get selected subject safely

  foreach ($_POST['attendance'] as $student_id => $attendance_status) {
      // Check if attendance for this student on this date and subject already exists
      $check_sql = "SELECT * FROM attendance WHERE student_id = '$student_id' AND date = '$date' AND subject = '$subject'";
      $check_result = mysqli_query($conn, $check_sql);

      if (mysqli_num_rows($check_result) == 0) {
          $query = "SELECT roll, name, email FROM students WHERE id = '$student_id'";
          $result = mysqli_query($conn, $query);
          if ($student_data = mysqli_fetch_assoc($result)) {
              $roll_no = $student_data['roll'];
              $name = $student_data['name'];
              $email = $student_data['email'];
              $status = ($attendance_status === 'present') ? 'Present' : 'Absent';

              $insert = "INSERT INTO attendance (student_id, roll_no, name, email, date, status, subject) 
                         VALUES ('$student_id', '$roll_no', '$name', '$email', '$date', '$status', '$subject')";
              mysqli_query($conn, $insert);
          }
      }
  }
  
  header('Location: faculitypanel.php');
  exit();
}



// Handle notice submission
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
    header("Location: faculitypanel.php");
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
    header("Location: faculitypanel.php");
    exit();
}
?>

<!-- Rest of your HTML content here... -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f4f6f8;
      padding: 20px;
      color: #333;
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

    .container {
      max-width: 1200px;
      margin: auto;
      background: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h1, h2 { color: #2c3e50; }
    h1 span { color: #2980b9; }
    .btn {
      padding: 10px 15px;
      background-color: #2980b9;
      color: white;
      border: none;
      border-radius: 6px;
      margin: 5px;
      text-decoration: none;
      cursor: pointer;
    }
    .btn:hover { background-color: #1e5f8b; }
    .section { margin-top: 30px; }
    input, textarea {
      padding: 10px;
      width: 100%;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th { background-color: #2980b9; color: white; }
    .edit-btn { background: #3498db; color: white; }
    .delete-btn { background: #e74c3c; color: white; }
    /* Attendance select box */
select[name^="attendance"] {
  padding: 8px 12px;
  border-radius: 6px;
  font-weight: bold;
  color: white;
  border: none;
  outline: none;
  transition: background-color 0.3s ease;
  cursor: pointer;
}

/* Default gray background */
select[name^="attendance"] {
  background-color: #7f8c8d;
}

/* Green for Present */
select[name^="attendance"].present {
  background-color: #2ecc71;
}

/* Red for Absent */
select[name^="attendance"].absent {
  background-color: #e74c3c;
}

    
  </style>
</head>
<body>
<div class="container">
 <h3>Hi, <span>Faculity</span></h3>
  <h1>Welcome <span><?php echo $_SESSION['faculty_name']; ?></span></h1>
    <p>This is an faculity page</p>
    <a href="login_form.php" class="btn">Login</a>
    <a href="register_form.php" class="btn">Register</a>
    <a href="logout.php" class="btn">Logout</a>
  

  
  <div class="section">
    <h2>Search Student</h2>
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search by name, roll no, or ID..." onkeyup="searchStudent()">
    </div>
  </div>
  <div class="section">
   <h2>Student List</h2>

   <form method="POST" action="">   <!-- ✅ Form start -->
    <select name="Subject" class="btn">
      <option value="subjects">Subjects</option>
      <option value="physics">Physics</option>
      <option value="chemistry">Chemistry</option>
      <option value="math">Math</option>
      <option value="english">English</option>
      <option value="hindi">Hindi</option>
    </select>

   <table>
    <thead>
      <tr>
        
        <th>Roll No</th>
        <th>Name</th>
        <th>Branch</th>
        <th>Semester</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Attendance</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $query = "SELECT * FROM students";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          
          echo "<td>" . $row['roll'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['branch'] . "</td>";
          echo "<td>" . $row['semester'] . "</td>";
          echo "<td>" . $row['email'] . "</td>";
          echo "<td>" . $row['phone'] . "</td>";
          echo "<td>
                  <select name='attendance[" . $row['id'] . "]'>
                    <option value='present'>Present</option>
                    <option value='absent'>Absent</option>
                  </select>
                </td>";
          echo "</tr>";
        }
      ?>
    </tbody>
   </table>

   <button class="btn" type="submit" name="submit_attendance">Submit Attendance</button>

   </form> <!-- ✅ Form end -->
   </div>

  </div>

 <div class="section">
  <h2>Attendance Records</h2>
  <form method="POST" action="">
  <select name="filter_subject" class="btn" onchange="this.form.submit()">
    <option value="">Filter by Subject</option>
    <option value="all" <?php if (isset($_POST['filter_subject']) && $_POST['filter_subject'] == 'all') echo 'selected'; ?>>All</option>
    <option value="physics" <?php if (isset($_POST['filter_subject']) && $_POST['filter_subject'] == 'physics') echo 'selected'; ?>>Physics</option>
    <option value="chemistry" <?php if (isset($_POST['filter_subject']) && $_POST['filter_subject'] == 'chemistry') echo 'selected'; ?>>Chemistry</option>
    <option value="math" <?php if (isset($_POST['filter_subject']) && $_POST['filter_subject'] == 'math') echo 'selected'; ?>>Math</option>
    <option value="english" <?php if (isset($_POST['filter_subject']) && $_POST['filter_subject'] == 'english') echo 'selected'; ?>>English</option>
    <option value="hindi" <?php if (isset($_POST['filter_subject']) && $_POST['filter_subject'] == 'hindi') echo 'selected'; ?>>Hindi</option>
  </select>
</form>
  <table id="attendanceTable">
    <thead>
      <tr>
        <th>S. No.</th>
        <th>Roll No</th>
        <th>Name</th>
        <th>Date</th>
        <th>Status</th>
        <th>subject </th>
      </tr>
    </thead>
    <tbody>
    <?php
$today = date("Y-m-d");
$subjectFilter = isset($_POST['filter_subject']) ? $_POST['filter_subject'] : '';

if (!empty($subjectFilter) && $subjectFilter != 'all') {
    // Filter by selected subject
    $attendance_query = "SELECT * FROM attendance WHERE date = '$today' AND subject = '$subjectFilter' ORDER BY roll_no ASC";
} else {
    // Show all subjects
    $attendance_query = "SELECT * FROM attendance WHERE date = '$today' ORDER BY roll_no ASC";
}

$attendance_result = mysqli_query($conn, $attendance_query);
$counter = 1;

while ($attendance = mysqli_fetch_assoc($attendance_result)) {
    echo "<tr>";
    echo "<td>" . $counter++ . "</td>";
    echo "<td>" . $attendance['roll_no'] . "</td>";
    echo "<td>" . $attendance['name'] . "</td>";
    echo "<td>" . $attendance['date'] . "</td>";
    echo "<td>" . $attendance['status'] . "</td>";
    echo "<td>" . $attendance['subject'] . "</td>";
    echo "</tr>";
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
  function updateAttendanceColor(select) {
    select.classList.remove('present', 'absent');
    if (select.value === 'present') {
      select.classList.add('present');
    } else if (select.value === 'absent') {
      select.classList.add('absent');
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.attendance-select');
    selects.forEach(select => {
      updateAttendanceColor(select); // Set initial color
      select.addEventListener('change', function () {
        updateAttendanceColor(select); // Update on change
      });
    });
  });
  function searchStudent() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("table tbody tr");

    rows.forEach(row => {
      const id = row.cells[0]?.textContent.toLowerCase();
      const roll = row.cells[1]?.textContent.toLowerCase();
      const name = row.cells[2]?.textContent.toLowerCase();

      if (id.includes(input) || roll.includes(input) || name.includes(input)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }
</script>

</body>
</html>
