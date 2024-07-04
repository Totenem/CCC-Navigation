<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file here
    include_once 'dbcon.php';

    // Escape user inputs for security
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $announcement = mysqli_real_escape_string($conn, $_POST['anouncement']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Insert announcement into the database
    $sql = "INSERT INTO announcements (section, announcement, announcement_description) VALUES ('$section', '$announcement', '$description')";
    if (mysqli_query($conn, $sql)) {
        // Announcement added successfully, you can redirect or do anything else here
        header("Location: dashboard.php"); // Redirect to the dashboard after adding announcement
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
