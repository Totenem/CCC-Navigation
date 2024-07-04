<?php
session_start();
require_once 'dbcon.php'; // Include your database connection file

// Check if the user is not logged in
if (!isset($_SESSION['user_logged_in'])) {
  // Redirect to login page
  header("Location: login.php");
  exit;
}

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch the user's role from the database
$stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$userRole = $stmt->fetchColumn();

/* If the user is an admin, redirect to admin_login.php
if ($userRole === 'admin') {
    header("Location: http://localhost/CCC%20NAVIGATION/teacher_dash/admin_login.php");
    exit;
}
*/

// Fetch the user's section from the database
$stmt = $pdo->prepare("SELECT section FROM users WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$userSection = $stmt->fetchColumn();

// Get the username from the session
$username = $_SESSION['username'];

// Set the timezone to GMT+8 (Asia/Manila)
date_default_timezone_set('Asia/Manila');

// Get current day and time
$currentDay = date('l'); // Full textual representation of the day
$currentTime = date('H:i'); // Current time in 24-hour format

/* to debug
echo "Current Day: $currentDay<br>";
echo "Current Time: $currentTime<br>";
*/

// Query to count upcoming classes for the current day
$stmt = $pdo->prepare("SELECT COUNT(*) AS totalClasses FROM schedule WHERE day = :currentDay");
$stmt->execute(['currentDay' => $currentDay]);
$row = $stmt->fetch();
$totalClasses = $row['totalClasses'];

/* to debug
echo "Total Classes Today: $totalClasses<br>";
*/

// Query to find the next upcoming class
$stmt = $pdo->prepare("SELECT class_start FROM schedule WHERE day = :currentDay AND class_start > :currentTime ORDER BY class_start ASC LIMIT 1");
$stmt->execute(['currentDay' => $currentDay, 'currentTime' => $currentTime]);
$nextClass = $stmt->fetch();
$nextClassTime = ($nextClass) ? $nextClass['class_start'] : 'No upcoming class';

/* to debug
echo "Next Class Time: $nextClassTime<br>";
*/

// Get current date in GMT+8
$currentDate = date('l m/d'); // Full textual representation of the day and m/d format of month/day
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CCC Navigation | Homepage</title>
  <!-- custom style -->
  <style>
    * {
      font-family: "Open Sans", sans-serif;
    }

    .navbar-brand,
    .nav-link {
      font-size: 20px;
    }

    .sidemenu {
      text-decoration: none;
      font-size: 30px;
      color: white;
      font-weight: 700;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
      background-color: #03045e;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      padding: 30px;
    }

    .customs {
      height: 100%;
    }

    #sidemenu {
      padding-left: 0;
    }

    .sidebar {
      background-color: #03045e;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      padding: 30px;
    }

    #sidebar {
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
    }

    .main-content {
      padding: 20px;
    }

    .sidebar-link {
      justify-content: flex-start;
      /* Align items to the left */
    }

    @media screen and (max-width: 1010px) {
      .sidemenu {
        text-decoration: none;
        font-size: 30px;
        color: white;
        font-weight: 700;
        position: sticky;
        top: 0;
        height: auto;
        overflow-y: auto;
        background-color: #03045e;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        padding: 30px;
      }

      .hehe {
        visibility: hidden;
      }

      #hehe1 {
        visibility: visible;
      }
    }
  </style>
  <!-- Bootstrap CSS -->
  <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>

<body style="background: #dedcdc">
  <nav class="navbar navbar-expand-lg navbar-dark bg-light text-primary position-sticky">
    <div class="container-fluid">
      <div class="d-flex align-items-center">
        <a href="homepage.php" class="navbar-brand text-primary fw-bold" style="font-size: 40px; margin-right: 20px"><img src="img/cnav-logo.png" alt="Logo" class="header-logo" style="width: 200px; height: 80px; margin-right: 20px" /></a>
      </div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <box-icon name="menu" color="#000000"></box-icon>
      </button>
      <div class="collapse navbar-collapse justify-content-end fw-bold" id="navbarSupportedContent">
        <div class="d-flex align-items-center">
          <a href="" class="navbar-brand text-dark"><?php echo $userSection; ?></a>
          <span class="navbar-brand text-dark">|</span>
          <span class="navbar-brand text-dark me-3"><?php echo $username; ?></span> <!--Username-->
          <!--<div class="dropdown hehe"> settings
              <button
                class="btn position-relative"
                id="dropdownMenuButton"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <box-icon type="solid" name="cog"></box-icon>
              </button>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="dropdownMenuButton"
              >
                <li><h6 class="dropdown-header">Settings</h6></li>
                <li><a href="logout.php" class="dropdown-item">Logout</a></li>
              </ul>
            </div>-->
        </div>
      </div>
    </div>
  </nav>
  <!-- Main layout -->
  <div class="container-fluid mt-3">
    <div class="row">
      <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-lg-">
        <nav class="sidemenu navbar navbar-expand-lg rounded">
          <div class="customs container-fluid flex-lg-column align-items-stretch">
            <h4 class="navbar-brand text-center text-white mb-2" style="font-weight: 600; font-size: 30px">
              CCC Navigation
            </h4>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidemenu" aria-controls="sidemenu" aria-expanded="false" aria-label="Toggle navigation">
              <box-icon name="menu" color="#ffffff"></box-icon>
            </button>
            <div class="collapse flex-column navbar-collapse align-items-start" id="sidemenu">
              <!--Sidemenu items bellow-->
              <a href="homepage.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                <box-icon name="home-alt" type="solid" color="#ffffff" size="sm"></box-icon>
                <span class="side-text ms-3">DASHBOARD</span>
              </a>
              <div class="p-1 mb-1 rounded text-white">
                <a href="schedule.php" type="button" style="font-size: 20px;" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                  <box-icon name="edit" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">SCHEDULE</span>
                </a>
              </div>
              <div class="p-1 mb-1 rounded text-white">
                <a href="calendar.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                  <box-icon name="calendar" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">CALENDAR</span>
                </a>
              </div>
              <div class="p-1 mb-1 rounded text-white">
                <a href="personal_schedule.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                  <box-icon name="current-location" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">PERSONAL SCHEDULE</span>
                </a>
              </div>
              <div class="p-1 mb-1 rounded text-white">
                <a href="announcement.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                  <box-icon name="megaphone" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">ANNOUNCEMENTS</span>
                </a>
              </div>
              <div class="p-1 mb-1 rounded text-white">
                <a href="logout.php" type="button" style="font-size: 20px;" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                  <box-icon name="exit" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">LOGOUT</span>
                </a>
              </div>
            </div>
          </div>
        </nav>
      </div>
      <!-- Main content -->
      <div class="col-lg-9 main-content">
        <div class="container-fluid">
          <div class="row justify-content-around m-2 text-light fs-5 fw-bold">
            <!-- Dashboard -->
            <div class="col-md-3 sidebar m-2 p-4 d-flex align-items-center justify-content-center rounded">
              <div class="align-items-center">
                <p>Classes Today</p> <!--Schedule Total (for today)-->
                <h1 style="text-align: center"><?php echo $totalClasses; ?></h1>
                <a href="schedule.php" style="
                      text-decoration: none;
                      color: white;
                      font-size: 17px;
                      margin-left: 18px;
                    ">View Details</a>
              </div>
            </div>
            <div class="col-md-3 sidebar m-2 p-4 d-flex align-items-center justify-content-center rounded">
              <div>
                <p>Time of Next Class</p>
                <h3><?php echo $nextClassTime; ?></h3> <!--Based on the schedule of of next class on the databse-->
              </div>
            </div>
            <div class="col-md-3 sidebar m-2 p-4 align-items-center justify-content-center rounded">
              <div>
                <p style="text-align: center;">Date Today</p> <!--Based on GMT+8 date today-->
                <h3 style="text-align: center;"><?php echo $currentDate; ?></h3>
              </div>
            </div>
            <!-- end of dashboard -->
            <p class="mt-5 text-black" style="font-size: 40px">
              Announcements
            </p>
            <!--Show announcements here-->
            <?php
            $stmt = $pdo->query("SELECT * FROM announcements");
            while ($row = $stmt->fetch()) {
              echo '<div style="color: black; background-color: white; border: 2px solid black;" class= "mb-2">';
              echo '<div  class=" mb-2 d-flex align-items-center">';
              echo '<box-icon name="megaphone" type="solid" class="me-2" size="lg"></box-icon>';
              echo '<h3 class="mb-0">' . htmlspecialchars($row["announcement"]) . '</h3>';
              echo '</div>';
              echo '<div style="color: black;" class="d-flex align-items-center mt-2 ms-5">';
              echo '<p>' . htmlspecialchars($row["announcement_description"]) . '</p>';
              echo '</div>';
              echo '</div>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal for announcement -->
  <!-- Modal -->
  <div class="modal fade announcementModal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">
            Announcement 1
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1>AJdkajdksj</h1>
          <p>sfjaksfakhfahfah</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
            Understood
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS and dependencies -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/homeapge_function.js"></script>
</body>

</html>