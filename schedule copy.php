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
$section = $_SESSION['section'];
$userid = $_SESSION["user_id"];

// Include your database connection file here
include_once 'dbcon.php';

// Fetch schedules from the database
if (isset($_GET['day']) && $_GET['day'] != 'ALL') {
  // If a specific day is selected, filter schedules by that day
  $selected_day = $_GET['day'];
  $sql = "SELECT * FROM schedule WHERE day = '$selected_day'";
} else {
  // If 'ALL' is selected or no day is selected, fetch all schedules
  $sql = "SELECT * FROM schedule WHERE section = '$section'";
}
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Schedule | CCC Navigation</title>
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

    .main-content {
      padding: 20px;
    }

    .sidebar-link {
      justify-content: flex-start;
      /* Align items to the left */
    }

    @media screen and (max-width: 1010px) {
      .sidemenu {
        height: auto;
        padding: 30px;
      }
    }

    .scrollable-dashboard {
      max-height: 600px;
      /* Adjust this value as needed */
      overflow-y: auto;
    }

    img {
      width: 50%;

    }
  </style>
  <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>

<body style="background: #dedcdc">
  <!--Navbar-->
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
      <div class="col-lg-3 col-md-9 mb-lg-0 mb-4 px-lg-0">
        <nav class="sidemenu navbar navbar-expand-lg rounded">
          <div class="customs container-fluid flex-lg-column align-items-stretch">
            <h4 class="navbar-brand text-center text-white mb-2" style="font-weight: 600; font-size: 30px">CCC Navigation</h4>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidemenu" aria-controls="sidemenu" aria-expanded="false" aria-label="Toggle navigation">
              <box-icon name="menu" color="#ffffff"></box-icon>
            </button>
            <div class="collapse flex-column navbar-collapse align-items-start" id="sidemenu">
              <!--Sidemenu items below-->
              <a href="homepage.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                <box-icon name="home-alt" type="solid" color="#ffffff" size="sm"></box-icon>
                <span class="side-text ms-3">DASHBOARD</span>
              </a>
              <div class="p-1 mb-1 rounded text-white">
                <a href="schedule.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
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
                <a href="navigation.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                  <box-icon name="current-location" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">ROOMS NAVIGATION</span>
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
          <!-- Button trigger modal -->
          <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#searchDay">
              <box-icon name="search-alt-2" size="md"></box-icon>
            </button>
          </div>
          <div class="row m-2 text-light fw-bold scrollable-dashboard">
            <!-- Dashboard -->
            <!--Schedule Cards-->
            <?php
            // Loop through each schedule fetched from the database
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
              <!-- Schedule card -->
              <div class="col-md-3 m-3 sidebar p-4 d-flex align-items-center justify-content-center rounded">
                <div class="align-items-center">
                  <!-- Display schedule details -->
                  <p style="text-align: center;"><?php echo $row['subject_name']; ?></p><!-- Subject Name -->
                  <h1 style="text-align: center; font-weight: 600"><?php echo $row['subject_code']; ?></h1><!-- Subject Code -->
                  <h3 class="mt-4" style="text-align: center">ROOM <?php echo $row['building']; ?>-<?php echo $row['room_number']; ?></h3>
                  <!-- Day and time of the week -->
                  <p style="text-align: center;" class="mt-4"><?php echo $row['day']; ?> | <?php echo $row['class_start']; ?>-<?php echo $row['class_end']; ?></p>
                  <p style="text-align: center; font-size: 10px" class="mb-5">Schedule Ref: #<?php echo $row['schedule_id']; ?></p><!-- Subject Name -->
                  <a type="button" data-bs-toggle="modal" data-bs-target="#<?php echo $row['building'] ; ?>" onclick="handleNavigateRoomClick('<?php echo $row['building']; ?>', '<?php echo $row['room_number']; ?>')" style="text-decoration: none; color: white; font-size: 17px; text-align: center; margin-left: 25px;">Navigate Room</a>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modals -->

  <!--Search / Filter sched modals-->
  <div class="modal fade" id="searchDay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Search</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="schedule.php" method="get">
            <label for="day" class="form-label">Week Day</label>
            <select name="day" class="form-select shadow-none"> <!--day selection-->
              <option selected>ALL</option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
              <option value="Saturday">Saturday</option>
              <option value="Sunday">Sunday</option>
            </select>
            <button type="submit" class="btn btn-success mt-3">Search</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation to rooms (1JMC) -->
  <div class="modal fade" id="1JMC" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content" >
        <div class="modal-header" >
          <h5 class="modal-title" id="staticBackdropLabel1">FLOOR 1: JMC</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="1JMC_building">
          <img style="width: 40px" src="floorplan/1JMC.svg" alt="" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Navigation to rooms (2JMC) -->
  <div class="modal fade" id="2JMC" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel1">FLOOR 2: JMC</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="2JMC_building">
          <img src="floorplan/2JMC.svg" alt="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
        </div>
      </div>
    </div>
  </div>
  <!--Navigation to rooms (3JMC)-->
  <div class="modal fade" id="3JMC" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel1">FLOOR 3: JMC</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="3JMC_building">
          <img src="floorplan/3JMC.svg" alt="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
        </div>
      </div>
    </div>
  </div>
  <!--Navigation to rooms (RIZAL)-->
  <div class="modal fade" id="R" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel1">Rizal Building</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="R_building">
          <img src="floorplan/R.svg" alt="" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
        </div>
      </div>
    </div>
  </div>

  <!--Navigation to admin building-->
  <div class="modal fade" id="R" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel1">Admin building</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="R_building">
          <img src="floorplan/R.svg" alt="" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <script>
    console.log('test');
    // Assuming you have a function that handles the click event on a room
    function handleNavigateRoomClick(building, room_number) {
      console.log(building);
      console.log(room_number);
      // Assuming 'building' contains the name of the building and 'room_number' contains the ID of the room
      const floorplanFilePath = `floorplan/${building}.svg`;
      console.log(floorplanFilePath);

      // Load the SVG file
      fetch(floorplanFilePath)
        .then(response => response.text())
        .then(svgText => {
          // Create a temporary div to hold the SVG content
          const tempDiv = document.createElement('div');
          tempDiv.innerHTML = svgText;

          // Find the floorplan SVG element
          const svgElement = tempDiv.querySelector('svg');

          // Find the path element with the room number
          const roomGroup = svgElement.querySelector(`#floorplan path[id="${room_number}"]`);
          console.log(roomGroup);
          // Now you can work with the 'roomGroup' element
          roomGroup.setAttribute("fill", "#66FF66");
          // Assuming 'svgContainer' is the container where you display the SVG
          const svgContainer = document.getElementById(building+'_building');
          console.log(svgContainer);
          // Clear the container
          svgContainer.innerHTML = '';
          // Append the updated SVG
          svgContainer.appendChild(tempDiv);
          console.log(svgContainer);
        })
        .catch(error => {
          console.error('Error loading SVG:', error);
        });
    }
  </script>
</body>

</html>