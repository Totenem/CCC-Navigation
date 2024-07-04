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

    // SQL query to delete schedule based on schedule_id
    $sql = "DELETE FROM schedule WHERE schedule_id = '$schedule_id'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Schedule deleted successfully
        header("Location: dashboard.php"); // Redirect back to the dashboard page
        exit;
    } else {
        // Error in deletion
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If schedule_id is not set or empty, handle the error accordingly
    echo "Schedule ID is not provided.";
}
?>