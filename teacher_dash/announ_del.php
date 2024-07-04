<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file here
    include_once 'dbcon.php';

    // Escape user input for security
    $announcement_id = mysqli_real_escape_string($conn, $_POST['announcemnt_id']);

    // Delete announcement from the database
    $sql = "DELETE FROM announcements WHERE announcemnt_id = $announcement_id";
    if (mysqli_query($conn, $sql)) {
        // Announcement deleted successfully, you can redirect or do anything else here
        header("Location: dashboard.php"); // Redirect to the dashboard after deleting announcement
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
