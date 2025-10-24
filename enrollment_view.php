<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Course Enrollment Portal</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>Course Enrollment System</h1>
  <p><a href="admin_controller.php">View Enrollment Report (Admin)</a></p>

  <?php echo $message; ?>

  <h2>Enrollment Form</h2>
  <form method="POST" action="enrollment_controller.php">

    <label for="student_name">Your Full Name:</label>
    <input type="text" id="student_name" name="student_name" required>

    <label for="matric_no">Matric Number:</label>
    <input type="text" id="matric_no" name="matric_no" required>

    <label for="course_id">Select Course:</label>
    <select id="course_id" name="course_id" required>
      <option value="">-- Choose a Course --</option>
      <?php
      if ($courses_result->num_rows > 0) {

        while ($row = $courses_result->fetch_assoc()) {
          echo "<option value='{$row['course_id']}'>{$row['course_name']}</option>";
        }
      } else {
        echo "<option value='' disabled>No courses available</option>";
      }
      ?>
    </select>

    <button type="submit">Enroll Now</button>
  </form>
  
<div id="messageBox" style="display:none; text-align:center; font-size:20px; margin-top:20px; color:green;">
  I know what I am doing
</div>

<script>
  setTimeout(function() {
    const message = document.getElementById("messageBox");
    message.style.display = "block";

    setTimeout(function() {
      message.style.display = "none";
    }, 5000); // Hide after 5 seconds
  }, 60000); // Show after 1 minute
</script>

</body>

</html>