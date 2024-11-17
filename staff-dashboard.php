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
$serviceID = $_SESSION['service_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM users WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);

$staff_query = "SELECT service, price, slotNumber, selected_id, servicename_id, user_id, shop_id, product_name, product_price FROM service_details WHERE is_deleted = '0'";
$staff_result = mysqli_query($connection, $staff_query);
$staffData = mysqli_fetch_assoc($staff_result);

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

    .game-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .game-logo {
        width: 80px;
        height: 80px;
        border-radius: 16px;
    }

    .ratings .star {
        color: gold;
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
                <li class="v-1">
                    <a href="staff-dashboard.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-home"></i></i></span>
                        <span class="start">DASHBOARD</span>
                    </a>
                </li>
                <li class="">
                    <a href="user-profile.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-user"></i></i></span>
                        <span class="start">PROFILE</span>
                    </a>
                </li>
                <li>

                <li class="">
                    <a href="staff-dashboard-history.php" class="nav-link px-3">
                        <span class="me-2"><i class="fas fa-calendar"></i></i></span>
                        <span>HISTORY</span>
                    </a>
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
        <div class="container py-5 text-dark">
            <!-- Service Header Section -->
            <div class="header-section mb-5">
                <h2 class="text-center position-relative">
                    <span class="service-title"><strong>SERVICES</strong></span>
                </h2>
                <p class="text-center text-muted">Click the button to proceed with cleaning</p>
                <div class="header-underline"></div>
            </div>

            <!-- Service Cards Container -->
            <div class="row mt-4 g-4">
                <?php if ($staff_result) {
                    $groupedServices = [];

                    foreach ($staff_result as $row) {
                        $slotNumber = isset($row['slotNumber']) ? $row['slotNumber'] : 'N/A';

                        if (!isset($groupedServices[$slotNumber])) {
                            $groupedServices[$slotNumber] = [
                                'services' => [],
                                'prices' => [],
                                'products' => [],
                                'product_prices' => [],
                                'selected_id' => $row['selected_id'],
                                'servicename_id' => $row['servicename_id'],
                                'user_id' => $row['user_id'],
                            ];
                        }

                        $groupedServices[$slotNumber]['service'][] = isset($row['service']) ? $row['service'] : 'N/A';
                        $groupedServices[$slotNumber]['prices'][] = isset($row['price']) ? $row['price'] : 'N/A';
                        $groupedServices[$slotNumber]['products'][] = isset($row['product_name']) ? $row['product_name'] : 'N/A';
                        $groupedServices[$slotNumber]['product_prices'][] = isset($row['product_price']) ? $row['product_price'] : 'N/A';
                    }

                    $isFirstSlotRendered = false;

                    foreach ($groupedServices as $slotNumber => $slotData) { ?>
                        <div class="col-lg-6 mb-4">
                            <div class="service-card">
                                <div class="card-body p-4">
                                    <!-- Slot Number Badge -->
                                    <div class="slot-badge mb-4">
                                        <span class="slot-number">Slot <?php echo $slotNumber; ?></span>
                                    </div>

                                    <!-- Service Details -->
                                    <div class="service-details">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="detail-box">
                                                    <h6 class="detail-title">
                                                        <i class="fas fa-tools me-2"></i>Services
                                                    </h6>
                                                    <div class="detail-content">
                                                        <?php foreach ($slotData['service'] as $service) {
                                                            echo "<div class='service-item'>$service</div>";
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-box">
                                                    <h6 class="detail-title">
                                                        <i class="fas fa-tag me-2"></i>Prices
                                                    </h6>
                                                    <div class="detail-content">
                                                        <?php foreach ($slotData['prices'] as $price) {
                                                            echo "<div class='price-item'>₱ $price</div>";
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if (array_filter($slotData['products'], fn($p) => $p !== 'N/A')) { ?>
                                            <div class="row g-4 mt-3">
                                                <div class="col-md-6">
                                                    <div class="detail-box">
                                                        <h6 class="detail-title">
                                                            <i class="fas fa-box me-2"></i>Products
                                                        </h6>
                                                        <div class="detail-content">
                                                            <?php foreach ($slotData['products'] as $product_name) {
                                                                if ($product_name !== 'N/A') {
                                                                    echo "<div class='product-item'>$product_name</div>";
                                                                }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-box">
                                                        <h6 class="detail-title">
                                                            <i class="fas fa-tag me-2"></i>Product Prices
                                                        </h6>
                                                        <div class="detail-content">
                                                            <?php foreach ($slotData['product_prices'] as $product_price) {
                                                                if ($product_price !== 'N/A') {
                                                                    echo "<div class='price-item'>₱ $product_price.00</div>";
                                                                }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <!-- Action Button -->
                                        <div class="action-button mt-4">
                                            <?php if (!$isFirstSlotRendered) { ?>
                                                <a href="staff-dashboard-view-details.php?selected_id=<?php echo $slotData['selected_id']; ?>&servicename_id=<?php echo $slotData['servicename_id']; ?>&user_id=<?php echo $slotData['user_id']; ?>&shop_id=<?php echo $staffData['shop_id']; ?>"
                                                   class="btn btn-primary w-100">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                                <?php $isFirstSlotRendered = true; ?>
                                            <?php } else { ?>
                                                <button class="btn btn-secondary w-100" disabled>
                                                    <i class="fas fa-lock me-2"></i>View Details
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </main>

    <style>
        /* Main Content Styling */
        main {
            background-color: #f8f9fa;
            padding-top: 2rem;
            min-height: 100vh;
        }

        /* Service Header Styling */
        .service-title {
            font-size: 2.5rem;
            color: #072797;
            position: relative;
            display: inline-block;
        }

        .service-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: #FF5722;
            border-radius: 2px;
        }

        /* Service Card Styling */
        .service-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(7, 39, 151, 0.1);
            overflow: hidden;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        /* Slot Badge Styling */
        .slot-badge {
            background: linear-gradient(135deg, #072797, #0a2d99);
            padding: 10px 20px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .slot-number {
            color: #ffffff;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Detail Box Styling */
        .detail-box {
            background: rgba(7, 39, 151, 0.03);
            padding: 15px;
            border-radius: 12px;
            height: 100%;
        }

        .detail-title {
            color: #072797;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .detail-content {
            color: #444;
        }

        /* Item Styling */
        .service-item, .product-item, .price-item {
            padding: 8px 0;
            border-bottom: 1px dashed rgba(7, 39, 151, 0.1);
        }

        .price-item {
            color: #FF5722;
            font-weight: 600;
        }

        /* Button Styling */
        .action-button .btn {
            padding: 12px 24px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF5722, #ff7043);
            border: none;
            box-shadow: 0 4px 15px rgba(255, 87, 34, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ff7043, #FF5722);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #e9ecef;
            color: #6c757d;
            border: none;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .service-title {
                font-size: 2rem;
            }
            
            .detail-box {
                margin-bottom: 15px;
            }
        }
    </style>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>