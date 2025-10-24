<?php
include 'config.php';

$delete_message = ''; // Variable for delete feedback

if (isset($_POST['delete_enrollment_id'])) {
    $enrollment_id = (int)$_POST['delete_enrollment_id'];

    if ($enrollment_id > 0) {
        $stmt_delete = $conn->prepare("DELETE FROM enrollments WHERE enrollment_id = ?");
        $stmt_delete->bind_param("i", $enrollment_id);

        if ($stmt_delete->execute()) {
            // SUCCESS: Implement PRG pattern by redirecting.
            // Preserve the filter setting in the redirect URL.
            $redirect_url = "admin_controller.php?msg=deleted" . (isset($_POST['filter_course_id']) && $_POST['filter_course_id'] > 0 ? "&course_id=" . (int)$_POST['filter_course_id'] : "");
            header("Location: " . $redirect_url);
            exit;
        } else {
            // Handle error (you could redirect with an error param too, but for simplicity, we set the message here)
            $delete_message = "<div style='color: red;'>❌ Error deleting enrollment: " . $conn->error . "</div>";
        }
        $stmt_delete->close();
    }
}

if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $delete_message = "<div style='color: green; background-color: #a3d0a3ff; padding: 10px'>✅ Enrollment deleted successfully!</div>";
}

$count_query = "SELECT c.course_name, COUNT(e.student_id) AS student_count
FROM courses c
LEFT JOIN enrollments e ON c.course_id = e.course_id
GROUP BY c.course_id
ORDER BY c.course_name";
$count_result = $conn->query($count_query);


$filter_course_id = 0;
$where_clause = '';

if (isset($_GET['course_id']) && is_numeric($_GET['course_id']) && $_GET['course_id'] > 0) {
$filter_course_id = (int)$_GET['course_id'];
$where_clause = "WHERE e.course_id = $filter_course_id";
}

// 2. Retrieve enrollment_id for delete link
$enrollments_query = "SELECT e.enrollment_id, s.student_name, s.matric_no, c.course_name, e.enrollment_date
FROM enrollments e
JOIN students s ON e.student_id = s.student_id
JOIN courses c ON e.course_id = c.course_id
$where_clause
ORDER BY c.course_name, s.student_name";
$enrollments_result = $conn->query($enrollments_query);

$courses_result = $conn->query("SELECT course_id, course_name FROM courses ORDER BY course_name");

include 'admin_view.php';

$conn->close();