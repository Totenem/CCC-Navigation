<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_logged_in'])) {
  // Redirect to login page
  header("Location: admin_login.php");
  exit;
}

// Get the username from the session
$username = $_SESSION['username'];
$adminid = $_SESSION['admin_id'];

// Include your database connection file here
include_once 'dbcon.php';

$sql = "SELECT * FROM announcements";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Schedule | CCC Navigation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
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
      width: 100%;

    }
  </style>
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
          <a href="#" class="navbar-brand text-dark">Admin</a>
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
              <!--Sidemenu items below
              <a href="homepage.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                <box-icon name="home-alt" type="solid" color="#ffffff" size="sm"></box-icon>
                <span class="side-text ms-3">DASHBOARD</span>
              </a>
              -->
              <div class="p-1 mb-1 rounded text-white">
                <a href="dashboard.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                  <box-icon name="edit" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">ADD SCHEDULE</span>
                </a>
              </div>
              <!--
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
              -->
              <div class="p-1 mb-1 rounded text-white">
                <a href="add_announcement.php" type="button" style="font-size: 20px" class="sidebar-link text-decoration-none fw-bold text-light p-3 align-items-center active d-flex">
                  <box-icon name="megaphone" type="solid" color="#ffffff" size="sm"></box-icon>
                  <span class="side-text ms-3">ADD ANNOUNCEMENTS</span>
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
            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <box-icon name="add-to-queue" size="md"></box-icon>
            </button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteScheds">
              <box-icon name="x" size="md"></box-icon>
            </button>
          </div>
          <div class="row m-2 text-light fw-bold scrollable-dashboard">
            <!-- Loop through the fetched announcements -->
            <!-- Loop through the fetched announcements -->
            <?php

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<div style="color: black; background-color: white; border: 2px solid black;" class= "mb-2">';
                echo '<div style="color: black;" class="d-flex align-items-center">';
                echo '<box-icon name="megaphone" type="solid" class="me-2" size="lg"></box-icon>';
                echo '<h3 class="mb-0">' . $row["announcement"] . '</h3>';
                echo '</div>';
                echo '<div style = "color: black;" class="d-flex align-items-center mt-2 ms-5">';
                echo '<p>' . $row["announcement_description"] . '</p>';
                echo '</div>';
                echo '</div>';
              }
            } else {
              echo "0 results";
            }

            // Close connection
            mysqli_close($conn);
            ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modals -->

  <!--Adding anouncemennts modals-->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add A Announcements</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="anounce_script.php" method="post">
            <label for="section" class="form-label">Year & Section</label>
            <input type="text" name="section" id="section" class="form-control">
            <label for="anouncement" class="form-label">Announcement Headline</label>
            <input type="text" name="anouncement" id="anouncement" class="form-control">
            <label for="description" class="form-label">Announcemnt Description</label>
            <input type="text" name="description" id="description" class="form-control">
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--Delete announcement modals-->
  <div class="modal fade" id="deleteScheds" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete An Announcement</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="announ_del.php" method="post">
            <label for="announcemnt_id" class="form-label">Annoucnemt Ref:</label>
            <input type="number" name="announcemnt_id" id="announcemnt_id" class="form-control">
            <button type="submit" class="btn btn-danger mt-3">Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>