<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
  header("Location index.php");
  exit;
}

// Fetch user information based on ID
$userID = $_SESSION['user_id'];
$vehicle_id = $_SESSION['vehicle_id'];
$shop_id = $_GET['shop_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);

$servicename_id = $_GET['servicename_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT s.*, sn.service_name, s.shop_id, s.last_updated
          FROM offered_services s
          JOIN service_names sn ON s.servicename_id = sn.servicename_id
          WHERE s.servicename_id = '$servicename_id'";

// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$servicenameData = mysqli_fetch_assoc($result);





// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="icon" href="NEW SM LOGO.png" type="image/x-icon">
  <link rel="shortcut icon" href="NEW SM LOGO.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
  <title>SPARK MOBILE </title>
</head>
<style>
  @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap");

  body,
  button {
    font-family: "Poopins", sans-serif;
    margin-top: 20px;
    background-color: #fff;
    color: #fff;
  }

  :root {
    --offcanvas-width: 200px;
    --topNavbarHeight: 56px;
  }

  .sidebar-nav {
    width: var(--offcanvas-width);
    background-color: orangered;
  }

  .sidebar-link {
    display: flex;
    align-items: center;
  }

  .sidebar-link .right-icon {
    display: inline-flex;
  }

  .sidebar-link[aria-expanded="true"] .right-icon {
    transform: rotate(180deg);
  }

  @media (min-width: 992px) {
    body {
      overflow: auto !important;
    }

    main {
      margin-left: var(--offcanvas-width);
    }

    /* this is to remove the backdrop */
    .offcanvas-backdrop::before {
      display: none;
    }

    .sidebar-nav {
      -webkit-transform: none;
      transform: none;
      visibility: visible !important;
      height: calc(100% - var(--topNavbarHeight));
      top: var(--topNavbarHeight);
    }
  }


  .welcome {
    font-size: 15px;
    text-align: center;
    margin-top: 20px;
    margin-right: 15px;
  }

  .me-2 {
    color: #fff;
    font-weight: normal;
    font-size: 13px;

  }

  .me-2:hover {
    background: orangered;
  }

  span {
    color: #fff;
    font-weight: bold;
    font-size: 20px;
  }

  img {
    width: 30px;
    border-radius: 50px;
    display: block;
    margin: auto;
  }

  .img-account-profile {
    width: 80%;
    height: auto;
    border-radius: 50%;
    display: block;
    margin: auto;
  }

  li:hover {
    background: #072797;
  }

  .v-1 {
    background-color: #072797;
    color: #fff;
  }

  .v-2 {
    background-color: orangered;
  }

  .main {
    margin-left: 200px;
  }

  .form-group {
    color: black;
  }

  .dropdown-item:hover {
    background-color: orangered;
    color: #fff;
  }

  .my-4:hover {
    background-color: #fff;
  }

  .navbar {
    background-color: #072797;
  }

  .btn:hover {
    background-color: orangered;
  }

  .nav-links ul li:hover a {
    color: white;
  }

  .img-account-profile {
    width: 200px;
    /* Adjust the size as needed */
    height: 200px;
    object-fit: cover;
    border-radius: 50%;
  }

  .img-account-permit {
    width: 200px;
    /* Adjust the size as needed */
    height: 200px;
    object-fit: cover;
  }

  .profile-btn {

    margin-left: 50%;
  }

  .owner-btn {
    margin-left: 51%
  }

  /* Modern Card and Table Styling */
  .card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    margin-bottom: 1.5rem;
  }

  .card-header {
    background: linear-gradient(45deg, #072797, #1a4dff);
    padding: 1rem 1.35rem;
    border-bottom: none;
  }

  .card-header h4 {
    font-size: 1.25rem;
    font-weight: 600;
  }

  /* Table Styling */
  .table {
    margin-bottom: 0;
  }

  .table thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.04em;
    padding: 1rem;
    background-color: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
  }

  .table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
    color: #495057;
  }

  /* Button Styling */
  .btn-primary {
    background-color: #072797;
    border-color: #072797;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
  }

  .btn-primary:hover {
    background-color: #0a31b3;
    border-color: #0a31b3;
    transform: translateY(-1px);
  }

  .btn-light {
    background-color: rgba(255, 255, 255, 0.15);
    border-color: transparent;
  }

  .btn-light:hover {
    background-color: rgba(255, 255, 255, 0.25);
    border-color: transparent;
  }

  /* Service Row Styling */
  .fw-500 {
    font-weight: 500;
  }

  .service-icon {
    width: 24px;
    text-align: center;
  }

  /* Animation */
  tbody tr {
    transition: all 0.2s ease-in-out;
  }

  tbody tr:hover {
    background-color: rgba(7, 39, 151, 0.05);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .card-body {
      padding: 1rem;
    }
    
    .table thead th {
      font-size: 0.8rem;
    }
    
    .btn-sm {
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
    }
  }

  /* Price Column */
  .table td:nth-child(2) {
    font-family: 'Roboto Mono', monospace;
    color: #072797;
  }
</style>

<body>
  <!-- top navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
        <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
      </button>
      <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="smweb.html"><img src="NEW SM LOGO.png" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="topNavBar">
        <form class="d-flex ms-auto my-3 my-lg-0">
        </form>
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
          <li class="">
            <a href="csnotification.php" class="nav-link px-3">
              <span class="me-2"><i class="fas fa-bell"></i></i></span>
            </a>
          </li>
          <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-fill"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Visual</a></li>
            <li>
              <a class="dropdown-item" href="logout.php">Log out</a>
            </li>
          </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <li class="my-4">
    <hr class="dropdown-divider bg-primary" />
  </li>
  <!-- top navigation bar -->
  <!-- offcanvas -->
  <div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="sidebar" <div class="offcanvas-body p-0">
    <nav class="">
      <ul class="navbar-nav">


        <div class=" welcome fw-bold px-3 mb-3">
          <h5 class="text-center">Welcome back <?php echo $userData['firstname']; ?>!</h5>
        </div>
        <div class="ms-3" id="dateTime"></div>
        </li>
        <li>
        <li class="">
          <a href="owner-dashboard.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-home"></i></i></span>
            <span class="start">DASHBOARD</span>
          </a>
        </li>
        <li class="v-1">
          <a href="user-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">PROFILE</span>
          </a>
        </li>
        <li>

        <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
            <span class="me-2"><i class="fas fa-building"></i></i></span>
            <span>MY SHOPS</span>
            <span class="ms-auto">
              <span class="right-icon">
                <i class="bi bi-chevron-down"></i>
              </span>
            </span>
          </a>
          <div class="collapse" id="layouts">
            <ul class="navbar-nav ps-3">
              <li class="v-1">
                <a href="owner-shop-profile1.php" class="nav-link px-3">
                  <span class="me-2">Profile</span>
                </a>
              </li>
              <li class="v-1">
                <a href="ower-shop-service.php" class="nav-link px-3">
                  <span class="me-2">Services</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
            <span class="me-2"><i class="fa fa-calendar"></i></span>
            <span>INVENTORY</span>
            <span class="ms-auto">
              <span class="right-icon">
                <i class="bi bi-chevron-down"></i>
              </span>
            </span>
          </a>
          <div class="collapse" id="layouts">
            <ul class="navbar-nav ps-3">
              <li class="v-1">
                <a href="setappoinment.php" class="nav-link px-3">
                  <span class="me-2">Appointments</span>
                </a>
              </li>
              <li class="v-1">
                <a href="checkingcar.php" class="nav-link px-3">
                  <span class="me-2">Checking car condition</span>
                </a>
              </li>
              <li class="v-1">
                <a href="csrequest_slot.php" class="nav-link px-3">
                  <span class="me-2">Request Slot</span>
                </a>
              </li>
              <li class="v-1">
                <a href="csprocess3.php" class="nav-link px-3">
                  <span class="me-2">Select Service</span>
                </a>
              </li>
              <li class="v-1">
                <a href="#" class="nav-link px-3">
                  <span class="me-2">Register your car</span>
                </a>
              </li>
              <li class="v-1">
                <a href="csservice_view.php?vehicle_id=<?php echo $vehicleData['vehicle_id']; ?>" class="nav-link px-3">
                  <span class="me-2">Booking Summary</span>
                </a>

              </li>
              <li class="v-1">
                <a href="#" class="nav-link px-3">
                  <span class="me-2">Booking History</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts2">
            <span class="me-2"><i class="fas fa-money-bill"></i>
              </i></i></span>
            <span>PAYMENTS</span>
            <span class="ms-auto">
              <span class="right-icon">
                <i class="bi bi-chevron-down"></i>
              </span>
            </span>
          </a>
          <div class="collapse" id="layouts2">
            <ul class="navbar-nav ps-3">
              <li>
                <a href="#" class="nav-link px-3">
                  <span class="me-2">Payment options</span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link px-3">
                  <span class="me-2">Car wash invoice</span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link px-3">
                  <span class="me-2">Payment History</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <a href="#" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-medal"></i>
              </i></span>
            <span>REWARDS</span>
          </a>
        </li>
        <li>
          <a href="logout.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-sign-out-alt"></i>
              </i></span>
            <span>LOG OUT</span>
          </a>
        </li>

      </ul>
    </nav>
  </div>
  </div>
  <!-- main content -->
  <main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="owner-shop-service-list.php?shop_id=<?php echo $servicenameData['shop_id'];?>" 
                               class="btn btn-light btn-sm me-3 text-white">
                                <i class="fas fa-arrow-left me-1 text-white"></i> Back
                            </a>
                            <h4 class="mb-0">
                                <i class="fas fa-tools me-2"></i>
                                <?php echo isset($servicenameData['service_name']) ? $servicenameData['service_name'] : ''; ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="bg-light">
                                        <th scope="col" class="text-dark">
                                            <i class="fas fa-cog me-2 text-primary"></i>Services
                                        </th>
                                        <th scope="col" class="text-dark">
                                            <i class="fas fa-peso-sign me-2 text-primary"></i>Price
                                        </th>
                                        <th scope="col" class="text-dark">
                                            <i class="fas fa-clock me-2 text-primary"></i>Last Updated
                                        </th>
                                        <th scope="col" class="text-center text-dark">
                                            <i class="fas fa-tasks me-2 text-primary"></i>Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result) {
                                        foreach ($result as $row) {
                                            // Format the last_updated date
                                            $last_updated = isset($row['last_updated']) ? date('M d, Y g:i A', strtotime($row['last_updated'])) : 'Not available';
                                            
                                            echo '<tr class="align-middle">';
                                            echo '<td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="service-icon me-2"><i class="fas fa-check-circle text-success"></i></span>
                                                        <span class="fw-500 text-dark">' . (isset($row['services']) ? $row['services'] : 'service') . '</span>
                                                    </div>
                                                  </td>';
                                            echo '<td class="fw-bold text-dark">₱' . number_format((isset($row['price']) ? $row['price'] : 0), 2) . '</td>';
                                            echo '<td class="text-dark"><i class="far fa-clock me-1 text-muted"></i>' . $last_updated . '</td>';
                                            echo '<td class="text-center">';
                                            echo '<a href="owner-shop-service-list-edit.php?service_id=' . $row['service_id'] . '&shop_id=' . $row['shop_id'] . '" 
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit me-1"></i> Edit Service
                                                  </a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="4" class="text-center text-muted">No services found</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>





  <script>
    function updateDateTime() {
      // Get the current date and time
      var currentDateTime = new Date();

      // Format the date and time
      var date = currentDateTime.toDateString();
      var time = currentDateTime.toLocaleTimeString();

      // Display the formatted date and time
      document.getElementById('dateTime').innerHTML = '<p>Date: ' + date + '</p><p>Time: ' + time + '</p>';
    }

    // Update the date and time every second
    setInterval(updateDateTime, 1000);

    // Initial call to display date and time immediately
    updateDateTime();
  </script>






  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
  <script src="./js/jquery-3.5.1.js"></script>
  <script src="./js/jquery.dataTables.min.js"></script>
  <script src="./js/dataTables.bootstrap5.min.js"></script>
  <script src="./js/script.js"></script>
</body>

</html>