<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_logged_in'])) {
  // Redirect to login page
  header("Location: login.php");
  exit;
}

// Get the username from the session
$username = $_SESSION['username'];  

// Include your database connection file here
include_once 'dbcon.php';

// Query to fetch schedule data
$sql = "SELECT * FROM schedule";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === FALSE) {
  die("Error: " . $conn->error);
}

// Create an array to hold schedule data for each day of the week
$scheduleData = array(
  'Sun' => array(),
  'Mon' => array(),
  'Tue' => array(),
  'Wed' => array(),
  'Thu' => array(),
  'Fri' => array(),
  'Sat' => array()
);

// Fetch and store the schedule data
while ($row = $result->fetch_assoc()) {
  // Assuming 'day' and 'subject_code' are the column names in your 'schedule' table
  $day = $row['day'];
  $subjectCode = $row['subject_code'];

  // Add the subject code to the array for the corresponding day
  $scheduleData[$day][] = $subjectCode;
}

// Close database connection
$conn->close();

// Format the schedule data into JSON format
$events = [];
foreach ($scheduleData as $day => $subjects) {
  foreach ($subjects as $subjectCode) {
    $events[] = [
      'title' => $subjectCode,
      'daysOfWeek' => [getDayIndex($day)]
    ];
  }
}

// Function to get the index of a day of the week (0 = Sunday, 1 = Monday, etc.)
function getDayIndex($day)
{
  $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  return array_search($day, $days);
}

// Convert the array to JSON format
$eventsJson = json_encode($events);
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
    }

    /* Calendar Customization */
    :root {
      --fc-border-color: black;
      --fc-daygrid-event-dot-width: 5px;
    }

    .fc .fc-col-header-cell-cushion {
      display: inline-block;
      padding: 2px 4px;
    }

    .fc {
      border-radius: 15px;
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
          <a
            href="homepage.php"
            class="navbar-brand text-primary fw-bold"
            style="font-size: 40px; margin-right: 20px"
            ><img
              src="img/cnav-logo.png"
              alt="Logo"
              class="header-logo"
              style="width: 200px; height: 80px; margin-right: 20px"
          /></a>
        </div>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <box-icon name="menu" color="#000000"></box-icon>
        </button>
        <div
          class="collapse navbar-collapse justify-content-end fw-bold"
          id="navbarSupportedContent"
        >
          <div class="d-flex align-items-center">
            <a href="#" class="navbar-brand text-dark">Student</a>
            <span class="navbar-brand text-dark">|</span>
            <span class="navbar-brand text-dark me-3"><?php echo htmlspecialchars($username); ?></span> <!--Username-->
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
              <a href="homepage.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center d-flex">
                <box-icon name="home-alt" type="solid" color="#ffffff" size="sm"></box-icon>
                <span class="side-text ms-3">DASHBOARD</span>
              </a>
              <div class="p-1 mb-1 rounded text-white">
                <a href="schedule.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center d-flex">
                  <box-icon name="edit" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">SCHEDULE</span>
                </a>
              </div>
              <div class="p-1 mb-1 rounded text-white">
                <a href="calendar.html" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center d-flex">
                  <box-icon name="calendar" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">CALENDAR</span>
                </a>
              </div>
              <div class="p-1 mb-1 rounded text-white">
                <a href="personal_schedule.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center d-flex">
                  <box-icon name="current-location" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">PERSONAL SCHEDULE</span>
                </a>
              </div>
              <div class="p-1 mb-1 rounded text-white">
                <a href="announcement.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center d-flex">
                  <box-icon name="megaphone" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">ANNOUNCEMENTS</span>
                </a>
              </div>
              <div class="p-1 mb-1 rounded text-white">
                  <a
                    href="logout.php"
                    type="button"
                    style="font-size: 20px;"
                    class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex"
                  >
                    <box-icon
                      name="exit"
                      type="solid"
                      color="#ffffff"
                      size="sm"
                    ></box-icon>
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
            <!-- Calendar -->
            <div id='calendar'></div>
            <!-- End of Calendar Content -->
            <!-- End of container -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal for announcement -->
  <!-- Calendar Event Modal 
  <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="eventDetails"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  -->
  <!-- Bootstrap JS and dependencies -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/homeapge_function.js"></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: <?php echo $eventsJson; ?>
      });
      calendar.render();
    });
  </script>


</body>

</html>