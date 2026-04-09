<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

    <title>Customer Reviews</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/banner.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <link rel="stylesheet" href="/vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="/assets/css/style.css">

    <link rel="stylesheet" href="assets/css/footer.css">

    <style>
        /* Custom CSS styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: white;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .menu-bar {
            display: flex;
        }

        .signup-button {
            color: white;
            background-color: #4cbb17;
            border: 1px solid #4cbb17;
            border-radius: 5px;
            padding: 10px 20px;
            margin-left: 10px;
            cursor: pointer;
        }

        .login-button {
            background-color: white;
            color: #4cbb17;
            border: 1px solid #4cbb17;
            border-radius: 5px;
            padding: 10px 20px;
            margin-left: 10px;
            cursor: pointer;
        }

        .login-button:hover,
        .signup-button:hover {
            background-color: #2cda60;
            /* Change color on hover */
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
         <a href="Home.php">
            <img src="Resources/logo.png" alt="Location" style="margin-left: 10px; width: 120px" /></a>
        <?php
        include 'fetch_cookies.php';
        $userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
        $username = isset($_COOKIE['Username']) ? $_COOKIE['Username'] : null;
        if ($userID): ?>
            <div class="menu-bar">
                       <a href="Login.html" class="header-btn login-btn" style="background:rgb(218, 217, 217);">
            <span class="btn-text">Login</span>
            <img src="Resources/si_sign-in-fill.svg" alt="Sign In" class="mobile-icon" />
          </a>
            </div>
        <?php else: ?>
            <div class="menu-bar">
                <button onclick="window.location.href='Login.html'" class="login-button">Login</button>
                <button onclick="window.location.href='SignUp.php'" class="signup-button">Sign Up</button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Banner -->
    <br />

    <section class="row">
        <div id="div1" class="col-sm-6 col-lg-2" style=" margin-left: 4%; border-radius: 10px; background-color: #f9f9f9;">
            <div class="modal-body" style="margin-left: 0%;">
                <div style="padding: 0px; font-family: Arial, sans-serif;">
                    <br>
                    <h5 style="color: black;">My Account</h5>
                    <br>
                    <ul style="list-style-type: none; padding: 0;">
                        <li style="display: flex; align-items: center; margin-bottom: 10px;">
                            <a href="CustomerProfile.php" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
                                <i class="fas fa-user" style="font-size: 20px; margin-right: 10px; color: #bfbfbf;"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li style="display: flex; align-items: center; margin-bottom: 10px;">
                            <a href="CustomerBookings.php" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
                                <i class="far fa-file-alt" style="font-size: 20px; margin-right: 10px; color: #bfbfbf;"></i>
                                <span>Booking History</span>
                            </a>
                        </li>
                        <li style="display: flex; align-items: center; margin-bottom: 10px;">
                            <a href="CustomerOrders.php" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
                                <i class="fas fa-store" style="font-size: 20px; margin-right: 10px; color: #bfbfbf;"></i>
                                <span>Order History</span>
                            </a>
                        </li>
                        <li style="display: flex; align-items: center; margin-bottom: 10px;">
                            <a href="CustomerReviews.php" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
                                <i class="fas fa-star" style="font-size: 20px; margin-right: 10px; color: #4cbb17;"></i>
                                <span style="color: #4cbb17;">Reviews & Rating</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="div2" class="col-sm-6 col-lg-8" style="margin-left: 2%; border-radius: 10px; background-color: #f9f9f9;">
            <h4 style="color: #4cbb17; margin-top:10px; margin-left:2%;">Review & Ratings</h4>
            <div class="card-body">
                <div class="row">
                    <?php include 'ReviewsGrid.php'; ?>
                </div> <!-- Close the row -->
            </div>
        </div>

    </section>

    <br /><br />
    <br>
    <br>
    <br>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <!-- Cities Section -->
                <div class="footer-section">
                    <h3 class="footer-title">Our top cities</h3>
                    <ul class="footer-links">
                        <li><a href="#">Michighan</a></li>
                        <li><a href="#">Los Angeles</a></li>
                        <li><a href="#">New York City</a></li>
                        <li><a href="#">Chicago</a></li>
                        <li><a href="#">Miami</a></li>
                    </ul>
                </div>

                <!-- Company Section -->
                <div class="footer-section">
                    <h3 class="footer-title">Company</h3>
                    <ul class="footer-links">
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Team</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="footer-section">
                    <h3 class="footer-title">Contact</h3>
                    <ul class="footer-links">
                        <li><a href="#">Help & Support</a></li>
                        <li><a href="#">Partner with us</a></li>
                    </ul>
                </div>

                <!-- Legal Section -->
                <div class="footer-section">
                    <h3 class="footer-title">Legal</h3>
                    <ul class="footer-links">
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Refund & Cancellation</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>

                <!-- Follow Us Section -->
                <div class="footer-section">
                    <h3 class="footer-title">Follow Us</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>

                    <div class="newsletter">
                        <p class="newsletter-title">Receive exclusive offers in your mailbox</p>
                        <form class="newsletter-form">
                            <input type="email" class="newsletter-input" placeholder="Enter Your email">
                            <button type="submit" class="newsletter-button">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</body>

</html>