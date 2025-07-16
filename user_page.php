<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['user_name'])) {
    header('location:login_form.php');
}

$user_name = $_SESSION['user_name']; // User name from session

$query = "SELECT * FROM students WHERE name = '$user_name'";
$result = mysqli_query($conn, $query);

if($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    echo "No data found for the given user.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Panel - SMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
    body { background: #f2f3f5; padding: 20px; color: #333; }
    header { text-align: center; background-color: #3498db; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    nav { display: flex; justify-content: center; gap: 10px; margin-bottom: 25px; flex-wrap: wrap; }
    .tab-btn { padding: 10px 20px; border: none; border-radius: 5px; background: #bdc3c7; cursor: pointer; transition: background 0.3s; }
    .tab-btn.active, .tab-btn:hover { background: #3498db; color: white; }
    .panel { background: white; border-radius: 10px; padding: 25px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
    .tab-section { display: none; }
    .tab-section.active { display: block; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
    .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
    .record-list li { margin: 10px 0; padding: 10px; background: #ecf0f1; border-radius: 5px; list-style: none; }
    .user-info { text-align: center; margin-bottom: 20px; }
    .user-info h3 span, .user-info h1 span { color: #3498db; }
    .btn { display: inline-block; margin: 5px; padding: 10px 15px; background-color: #2980b9; color: white; text-decoration: none; border-radius: 5px; transition: 0.3s; }
    .btn:hover { background-color: #1f618d; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
  </style>
</head>
<body>

<header>
  <h1>Student Panel - Student Management System</h1>
</header>

<div class="user-info">
  <h3>hi, <span><?php echo $user_data['name']; ?></span></h3>
  <h1>welcome <span><?php echo $user_data['name']; ?></span></h1> 
</div>

<nav>
  <button class="tab-btn active" data-tab="student-info">Student Info</button>
  <!-- <button class="tab-btn" data-tab="timetable">Timetable</button> -->
 
  <button class="tab-btn" data-tab="notices">Notices</button>
  <button class="tab-btn" data-tab="attendance">Attendance</button>
</nav>

<div class="panel">
  <!-- Student Info -->
  <div class="tab-section active" id="student-info">
    <?php
      function infoField($label, $value) {
        echo "<div class='form-group'><label>$label</label><input type='text' value='$value' readonly></div>";
      }
      infoField("Name", $user_data['name']);
      infoField("Roll No", $user_data['roll']);
      infoField("Branch", $user_data['branch']);
      infoField("Semester", $user_data['semester']);
      infoField("Enrollment No.", $user_data['enrollment_no']);
      infoField("Email", $user_data['email']);
      infoField("Phone", $user_data['phone']);
    ?>
  </div>

  <!-- Timetable
  <div class="tab-section" id="timetable">
    <h3>Weekly Timetable</h3>
    <ul id="timetableList"><li>Loading...</li></ul>
  </div> -->

  <!-- Student Records -->
  <div class="tab-section" id="records">
    <h3>Your Academic & Activity Records</h3>
    <ul class="record-list">
      <?php
        $res = mysqli_query($conn, "SELECT * FROM records WHERE student_name='$user_name' ORDER BY created_at DESC");
        while($row = mysqli_fetch_assoc($res)){
            echo "<li>{$row['record_text']}<br><small>Dated: {$row['created_at']}</small></li>";
        }
      ?>
    </ul>
  </div>

  <!-- Notices -->
  <div class="tab-section" id="notices">
    <h3>Existing Notices</h3>
    <table>
      <thead>
        <tr><th>ID</th><th>Title</th><th>Content</th><th>Date</th></tr>
      </thead>
      <tbody>
        <?php
        $notices = mysqli_query($conn, "SELECT * FROM notices ORDER BY created_at DESC");
        while ($row = mysqli_fetch_assoc($notices)) {
            echo "<tr><td>{$row['id']}</td><td>{$row['title']}</td><td>{$row['message']}</td><td>{$row['created_at']}</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>


  <!-- Attendance -->
<div class="tab-section" id="attendance">
  <h3>Your Attendance Record</h3>
  <table>
    <thead>
      <tr><th>Date</th><th>Status</th><th>Subject</th></tr>
    </thead>
    <tbody>
      <?php
      // $user_data['email'] mein currently logged-in user ka email hai
      $user_email = $user_data['email'];

      // Attendance data fetch query, email se filter kar ke
      $attendance_query = "SELECT * FROM attendance WHERE email = '$user_email' ORDER BY date DESC";
      $attendance_result = mysqli_query($conn, $attendance_query);

      if ($attendance_result && mysqli_num_rows($attendance_result) > 0) {
          while($row = mysqli_fetch_assoc($attendance_result)) {
              echo "<tr><td>{$row['date']}</td><td>{$row['status']}</td><td>{$row['subject']}</td></tr>";
          }
      } else {
          echo "<tr><td colspan='3'>No attendance records found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.tab-btn');
    const sections = document.querySelectorAll('.tab-section');

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const tab = button.dataset.tab;

        // Remove active from all
        buttons.forEach(btn => btn.classList.remove('active'));
        sections.forEach(sec => sec.classList.remove('active'));

        // Add active to selected
        button.classList.add('active');
        document.getElementById(tab).classList.add('active');
      });
    });

    // Simulate API call for timetable
    if (document.getElementById('timetableList')) {
      const timetableList = document.getElementById('timetableList');
      timetableList.innerHTML = `
        <li>Monday: 10AM - Math</li>
        <li>Tuesday: 12PM - Physics</li>
        <li>Wednesday: 9AM - Chemistry</li>
        <li>Thursday: 11AM - Computer</li>
        <li>Friday: 10AM - English</li>
      `;
    }
  });
</script>

</body>
</html>
