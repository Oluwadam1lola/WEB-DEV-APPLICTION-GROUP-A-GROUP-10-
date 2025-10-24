<?php
include 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $matric_no = $conn->real_escape_string($_POST['matric_no']);
    $course_id = (int)$_POST['course_id'];

    // 1. Insert/Update Student and get the ID
    $stmt_student = $conn->prepare("INSERT INTO students (student_name, matric_no) VALUES (?, ?) ON DUPLICATE KEY UPDATE student_name=VALUES(student_name), student_id=LAST_INSERT_ID(student_id)");
    $stmt_student->bind_param("ss", $student_name, $matric_no);
    $stmt_student->execute();
    $stmt_student->close();

    // After the insert/update, retrieve the guaranteed student_id.
    $stmt_select_id = $conn->prepare("SELECT student_id FROM students WHERE matric_no = ?");
    $stmt_select_id->bind_param("s", $matric_no);
    $stmt_select_id->execute();
    $result = $stmt_select_id->get_result();
    $student_row = $result->fetch_assoc();
    $student_id = $student_row['student_id'];
    $stmt_select_id->close();


    // 2. Attempt Enrollment using try-catch for exception handling
    $stmt_enroll = $conn->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
    $stmt_enroll->bind_param("ii", $student_id, $course_id);

    try {
        if ($stmt_enroll->execute()) {
            // Success: Redirect (PRG pattern)
            header("Location: enrollment_controller.php?msg=success");
            exit;
        } else {
             // This branch is rarely hit if exceptions are enabled, but kept for older configurations
             header("Location: enrollment_controller.php?msg=error");
             exit;
        }
    } catch (mysqli_sql_exception $e) {
        // Catch the specific MySQLi exception
        
        // Error code 1062 is for "Duplicate entry" (Unique constraint violation)
        if ($e->getCode() == 1062) {
            // Duplicate: Redirect with duplicate message (PRG pattern)
            header("Location: enrollment_controller.php?msg=duplicate");
            exit;
        } else {
            // Other SQL errors
            // Use the $conn->error or $e->getMessage() for detailed feedback if needed
            error_log("Enrollment SQL Error: " . $e->getMessage()); 
            header("Location: enrollment_controller.php?msg=error&detail=" . urlencode($e->getMessage()));
            exit;
        }
    } finally {
        // Ensure the statement is always closed
        if ($stmt_enroll) {
            $stmt_enroll->close();
        }
    }
}

// 3. Handle Messages after Redirect (GET)
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'success') {
        $message = "<div style='color: green; background-color: #a3d0a3ff; padding: 10px'>Enrollment successful!</div>";
    } elseif ($_GET['msg'] === 'duplicate') {
        $message = "<div style='color: orange;'>⚠ You are already enrolled in this course.</div>";
    } elseif ($_GET['msg'] === 'error') {
        // Display a generic error, or the specific detail if you chose to pass it
        $error_detail = isset($_GET['detail']) ? htmlspecialchars(urldecode($_GET['detail'])) : "An unexpected error occurred.";
        $message = "<div style='color: red;'>Error: Enrollment failed. " . $error_detail . "</div>";
    }
}

$courses_result = $conn->query("SELECT course_id, course_name FROM courses ORDER BY course_name");
include 'enrollment_view.php';
$conn->close();