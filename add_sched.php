<?php
session_start();

// Check if the user is not logged in
if(!isset($_SESSION['user_logged_in'])) {
    // Redirect to login page
    header("Location: login.php");
    exit;
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "dbcon.php"; // Change this to your actual database connection file

    // Escape user inputs for security
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $sub_code = mysqli_real_escape_string($conn, $_POST['sub_code']);
    $day = isset($_POST['day']) ? mysqli_real_escape_string($conn, $_POST['day']) : '';
    $class_start = mysqli_real_escape_string($conn, $_POST['class_start']);
    $class_end = mysqli_real_escape_string($conn, $_POST['class_end']);
    $building = isset($_POST['building']) ? mysqli_real_escape_string($conn, $_POST['building']) : '';
    $room_num = mysqli_real_escape_string($conn, $_POST['room_num']);

    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
     

        // Attempt to insert the data into the schedule table using user_id
        $sql = "INSERT INTO schedule (user_id, subject_name, subject_code, building, room_number, class_start, class_end, day) 
                VALUES ($user_id, '$subject', '$sub_code', '$building', '$room_num', '$class_start', '$class_end', '$day')";

        if (mysqli_query($conn, $sql)) {
            // If insertion is successful, redirect to a success page
            header("location: personal_schedule.php"); // Change 'success.php' to your actual success page
            exit();
        } else {
            // If insertion fails, display an error message
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // If user_id is not set in session, handle it accordingly
        echo "User ID not found in session.";
    }
}
    // Close connection
    mysqli_close($conn);

?>