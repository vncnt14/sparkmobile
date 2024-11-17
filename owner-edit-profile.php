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

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);




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
  .profile-btn{

  margin-left: 43.5%;
  }
  .address-btn{
  margin-left: 43.5%;
  margin-top: -2px;
  }

  .profile-container {
    padding: 40px;
    margin-top: 80px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
  }

  .section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
  }

  .profile-btn, .save-btn, .edit-profile-btn {
    background: #072797;
    color: white;
    padding: 12px 25px;
    border-radius: 5px;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
  }

  .profile-btn:hover, .save-btn:hover, .edit-profile-btn:hover {
    background: orangered;
    color: white;
    transform: translateY(-2px);
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-group label {
    color: #072797;
    font-weight: 500;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .form-control, .form-select {
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
  }

  .form-control:focus, .form-select:focus {
    border-color: #072797;
    box-shadow: 0 0 0 0.2rem rgba(7, 39, 151, 0.25);
  }

  .profile-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    overflow: hidden;
  }

  .profile-card .card-header {
    background: #072797;
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 1.2rem;
  }

  .upload-section {
    padding: 20px;
  }

  .address-section {
    margin-top: 40px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
  }

  @media (max-width: 768px) {
    .profile-container {
        padding: 20px;
    }
    
    .section-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .profile-btn, .save-btn {
        width: 100%;
        justify-content: center;
    }
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
          <a href="dashboard.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-home"></i></i></span>
            <span class="start">DASHBOARD</span>
          </a>
        </li>
        <li class="v-1">
          <a href="profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-user"></i></i></span>
            <span class="start">PROFILE</span>
          </a>
        </li>
        <li>

        <li class="">
          <a href="cars-profile.php" class="nav-link px-3">
            <span class="me-2"><i class="fas fa-car"></i></i></span>
            <span>MY CARS</span>
          </a>
        </li>
        <li><a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
            <span class="me-2"><i class="fas fa-calendar"></i></i></span>
            <span>BOOKINGS</span>
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
  <main>
    <div class="profile-container">
        <div class="section-header text-dark">
            <h1><i class="fas fa-user-edit me-2"></i>Edit Owner Details</h1>
            <a href="owner-profile.php" class="profile-btn">
                <i class="fas fa-arrow-left"></i>Back to Profile
            </a>
        </div>

        <div class="row">
            <!-- Profile picture card -->
            <div class="col-xl-4 mb-4">
                <div class="profile-card">
                    <div class="card-header">
                        <?php echo $userData['firstname']; ?>'s Profile Picture
                    </div>
                    <form action="upload-profile-backend.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?php echo $userData['user_id']; ?>">
                        <div class="card-body text-center">
                            <img class="img-account-profile mb-3" src="<?php echo $userData['profile']; ?>" alt="Profile Picture">
                            <div class="upload-section">
                                <input type="file" class="form-control mb-3" id="profile" name="profile" accept="image/*">
                                <button type="submit" class="edit-profile-btn">
                                    <i class="fas fa-upload"></i>Update Picture
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="col-xl-8">
                <form action="update-owner-profile-backend.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $userData['user_id']; ?>">
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname"><i class="fas fa-user"></i> First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" 
                                    value="<?php echo $userData['firstname']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="contact"><i class="fas fa-phone"></i> Phone Number</label>
                                <input type="text" class="form-control" id="contact" name="contact" 
                                    value="<?php echo $userData['contact']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="username"><i class="fas fa-user-tag"></i> Username</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                    value="<?php echo $userData['username']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="gender"><i class="fas fa-venus-mars"></i> Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Choose Gender</option>
                                    <option value="Male" <?php if ($userData['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if ($userData['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                    <option value="Prefer not to say" <?php if ($userData['gender'] == 'Prefer not to say') echo 'selected'; ?>>Prefer Not to Say</option>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname"><i class="fas fa-user"></i> Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" 
                                    value="<?php echo $userData['lastname']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                    value="<?php echo $userData['email']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="password" name="password" 
                                    value="<?php echo $userData['password']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="role"><i class="fas fa-user-shield"></i> User Type</label>
                                <select class="form-select" id="role" name="role">
                                    <option value="">Select Role</option>
                                    <option value="User" <?php if ($userData['role'] == 'User') echo 'selected'; ?>>User</option>
                                    <option value="Owner" <?php if ($userData['role'] == 'Owner') echo 'selected'; ?>>Owner</option>
                                    <option value="Admin" <?php if ($userData['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                                    <option value="Staff" <?php if ($userData['role'] == 'Staff') echo 'selected'; ?>>Staff</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div class="address-section">
                        <div class="section-header">
                            <h2><i class="fas fa-map-marked-alt"></i>Complete Address</h2>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="street_address"><i class="fas fa-road"></i> Street Address</label>
                                    <input type="text" class="form-control" id="street_address" name="street_address" 
                                        value="<?php echo isset($userData['street_address']) ? htmlspecialchars($userData['street_address']) : ''; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="optional_address"><i class="fas fa-building"></i> Address Line 2 (Optional)</label>
                                    <input type="text" class="form-control" id="optional_address" name="optional_address" 
                                        placeholder="Apartment, suite, unit, building, floor, etc."
                                        value="<?php echo isset($userData['optional_address']) ? htmlspecialchars($userData['optional_address']) : ''; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="barangay"><i class="fas fa-map-marker"></i> Barangay</label>
                                    <input type="text" class="form-control" id="barangay" name="barangay" 
                                        value="<?php echo isset($userData['barangay']) ? htmlspecialchars($userData['barangay']) : ''; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city"><i class="fas fa-city"></i> City</label>
                                    <input type="text" class="form-control" id="city" name="city" 
                                        value="<?php echo isset($userData['city']) ? htmlspecialchars($userData['city']) : ''; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="province"><i class="fas fa-map me-2"></i> Province</label>
                                    <input type="text" class="form-control" id="province" name="province" 
                                        value="<?php echo isset($userData['province']) ? htmlspecialchars($userData['province']) : ''; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="postal"><i class="fas fa-mail-bulk"></i> Postal Code</label>
                                    <input type="text" class="form-control" id="postal" name="postal" 
                                        value="<?php echo isset($userData['postal']) ? htmlspecialchars($userData['postal']) : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="save-btn">
                                <i class="fas fa-save me-2"></i>Save All Changes
                            </button>
                        </div>
                    </div>
                </form>
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