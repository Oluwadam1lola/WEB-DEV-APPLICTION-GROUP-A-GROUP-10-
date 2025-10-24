<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Enrollment Report</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>Enrollment Administration View</h1>
  <p><a href="enrollment_controller.php">&larr; Back to Enrollment Form</a></p>

  <h2>1. Student Count per Course</h2>
  <table class="count-table">
    <thead>
      <tr>
        <th>Course Name</th>
        <th>Enrolled Students</th>
      </tr>
    </thead>
    <tbody>
      <?php

      while ($row = $count_result->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['course_name']); ?></td>
          <td><?php echo $row['student_count']; ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <hr>

  <h2>2. Display Enrolled Students (Filter)</h2>
  <div class="filter-form">
    <form method="GET" action="admin_controller.php">
      <label for="course_id">Filter by Course:</label>
      <select id="course_id" name="course_id" onchange="this.form.submit()">
        <option value="0">-- Show All Students --</option>
        <?php

        if ($courses_result->num_rows > 0) {
          while ($row = $courses_result->fetch_assoc()) {

            $selected = ($filter_course_id == $row['course_id']) ? 'selected' : '';
            echo "<option value='{$row['course_id']}' $selected>{$row['course_name']}</option>";
          }
        }
        ?>
      </select>
    </form>
  </div>

  <table>
    <thead>
      <tr>
        <th>Student Name</th>
        <th>Matric Number</th>
        <th>Course Name</th>
        <th>Enrollment Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php

      if ($enrollments_result->num_rows > 0) {
        while ($row = $enrollments_result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
          echo "<td>" . htmlspecialchars($row['matric_no']) . "</td>";
          echo "<td>" . htmlspecialchars($row['course_name']) . "</td>";
          echo "<td>" . htmlspecialchars($row['enrollment_date']) . "</td>";
          echo "<td>
              <form method='POST' action='admin_controller.php' onsubmit=\"return confirm('Are you sure you want to delete this enrollment?');\">
                <input type='hidden' name='delete_enrollment_id' value='{$row['enrollment_id']}'>
                <input type='hidden' name='filter_course_id' value='{$filter_course_id}'> <button type='submit' class='delete-btn'>Delete</button>
              </form>
          </td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No students enrolled" . ($filter_course_id > 0 ? " in this filtered course." : ".") . "</td></tr>";
      }
      ?>
    </tbody>
  </table>
</body>

</html>