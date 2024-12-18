<?php
session_start();

// Include database connection file
include('config.php'); // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location index.php");
    exit;
}

// Fetch user information based on ID

$userID = $_SESSION['user_id'];
$vehicle_id = $_SESSION['vehicle_id'];
$serviceID = $_SESSION['service_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);




$finish_query = "SELECT sd.*, sn.service_name, co.firstname, co.lastname, v.vehicle_id, sd.total_price, ss.service, ss.price, sd.servicedone_id
                 FROM finish_jobs sd
                 INNER JOIN service_details ss ON ss.selected_id = sd.selected_id
                 INNER JOIN service_names sn ON sd.servicename_id = sn.servicename_id
                 INNER JOIN users co ON sd.user_id = co.user_id
                 INNER JOIN vehicles v ON sd.vehicle_id = v.vehicle_id 
                 WHERE sd.is_deleted = '0'
                 ORDER BY co.firstname ASC";
$finish_result = mysqli_query($connection, $finish_query);

// Group the data by user using an associative array
$finishData = array();
while ($row = mysqli_fetch_assoc($finish_result)) {
    $userId = $row['user_id'];
    $servicedoneId = $row['servicedone_id'];

    // Initialize the array structure for each user if it doesn't exist
    if (!isset($finishData[$userId])) {
        $finishData[$userId] = array(
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'service' => [],    // Array to store both services and prices
            'product_name' => [],       // Initialize as an empty array to store all products
            'totalPrice' => $row['total_price'] // Store total_price directly
        );
    }

    // Add the service and price to the user's array of services and prices
    $serviceWithPrice = $row['service'] . ' - ₱' . number_format($row['price'], 2);
    $finishData[$userId]['services_prices'][] = $serviceWithPrice;

    // Add the product name to the user's array of products if it exists
    if (!empty($row['product_name'])) {
        $finishData[$userId]['product_name'][] = $row['product_name'];
    }
}






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
        --offcanvas-width: 220px;
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

    .dashboard-payment {
        padding: 30px;
        margin-top: 60px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .dashboard-payment h2 {
        color: #072797;
        margin-bottom: 10px;
        font-size: 1.8rem;
    }

    .dashboard-payment p {
        color: #666;
        margin-bottom: 25px;
    }

    .payment-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .payment-table thead {
        background: #072797;
    }

    .payment-table th {
        color: white;
        font-weight: 500;
        padding: 15px;
        font-size: 1rem;
    }

    .payment-table td {
        padding: 15px;
        color: #333;
        vertical-align: middle;
    }

    .payment-table tbody tr {
        transition: background-color 0.3s ease;
    }

    .payment-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .btn-view-details {
        background: #072797;
        color: white;
        padding: 8px 20px;
        border-radius: 5px;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-view-details:hover {
        background: orangered;
        transform: translateY(-2px);
    }

    .price-column {
        font-weight: 600;
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
                    <h5 class="text-center">Welcome back <?php echo $userData['firstname']; ?> !</h5>
                </div>
                <div class="ms-3" id="dateTime"></div>
                </li>
                <li>
                <li class="">
                    <a href="cashier-dashboard.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-home"></i></i></span>
                        <span class="start">DASHBOARD</span>
                    </a>
                </li>
                <li class="">
                    <a href="cashier-dashboard-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-user"></i></i></span>
                        <span class="start">PROFILE</span>
                    </a>
                </li>
                <li>

                <li class="v-1">
                    <a href="cashier-dashboard-payment.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-money-bill"></i></i></span>
                        <span>PAYMENTS</span>
                    </a>
                </li>

                <li class="">
                    <a href="cashier-dashboard-sales-report.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-book"></i></i></span>
                        <span>SALES REPORT</span>
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
    <div class="dashboard-payment">
        <div class="container">
            <h2><i class="fas fa-money-bill me-2"></i>Payments</h2>
            <p>Click the button in the action column to view the payment details.</p>
            
            <div class="payment-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Total Price (₱)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($finishData)) {
                            foreach ($finishData as $userId => $user) {
                                echo '<tr>';
                                echo '<td><i class="fas fa-user me-2 text-dark"> </i>' . htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) . '</td>';
                                echo '<td class="price-column">₱ ' . number_format($user['totalPrice'], 2, '.', ',') . '</td>';
                                echo '<td>
                                        <a href="cashier-dashboard-payment-compute.php?user_id=' . urlencode($userId) . '&servicedone_id=' . urlencode($servicedoneId) . '" 
                                           class="btn btn-view-details">
                                           <i class="fas fa-eye me-2"></i>View Details
                                        </a>
                                     </td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="3" class="text-center">No payment records available</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
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