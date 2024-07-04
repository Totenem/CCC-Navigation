<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit;
}

// Include your database connection file here
include_once 'dbcon.php';

// Check if schedule_id is set and not empty
if (isset($_POST['schedule_id']) && !empty($_POST['schedule_id'])) {
    // Sanitize the input to prevent SQL injection
    $schedule_id = mysqli_real_escape_string($conn, $_POST['schedule_id']);

    // SQL query to delete schedule based on schedule_id and where section is NULL
    $sql = "DELETE FROM schedule WHERE schedule_id = '$schedule_id' AND section IS NULL";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Check if any rows were affected by the deletion
        if (mysqli_affected_rows($conn) > 0) {
            // Schedule deleted successfully
            echo "<script>alert('Deleted succesfully.'); window.location.href = 'personal_schedule.php'</script>";
            exit;
        } else {
            // No schedule with given ID or section is not NULL
            echo "<script>alert('Schedule ID is not accessible.'); window.location.href = 'personal_schedule.php'</script>";
        }
    } else {
        // Error in deletion
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If schedule_id is not set or empty, handle the error accordingly
    echo "<script>alert('Schedule ID is not accessible.'); window.location.href = 'personal_schedule.php'</script>";
}
?>