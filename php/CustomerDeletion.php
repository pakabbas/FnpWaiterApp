<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

    <title>Delete Account - FoodnPals</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/banner.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/footer.css">

    <style>
        /* Responsive container */
        .row {
            margin: 0;
            padding: 15px;
        }

        /* Responsive spacing */
        @media (max-width: 768px) {
            .row {
                padding: 10px;
            }
            
            #div1, #div2 {
                width: calc(100% - 20px) !important;
            }

            .card-body {
                padding: 15px !important;
            }

            .col-12 {
                padding: 0;
            }
        }

        /* Base styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: white;
        }
          .swal-custom-btn {
    background: #4cbb17 !important;
    color:white;
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
        }

        .form-control {
            background-color: #f8f8f8;
            border: none;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .save-button {
            background-color: #4cbb17;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px 30px;
            cursor: pointer;
        }
        
        .delete-warning {
            background-color: #fff8f8;
            border-left: 4px solid #d9534f;
            padding: 15px;
            margin-bottom: 20px;
        }

        .cancel-button {
            background-color: transparent;
            color: #666;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            margin-right: 10px;
        }
    </style>
</head>
<?php
        include 'fetch_cookies.php';
        include 'fetch_userdata.php';
        ?>
<body>

    <!-- Header -->
    <div class="container-fluid p-3 d-flex justify-content-between align-items-center">
     <a href="Home.php">
      <?php if (file_exists('Resources/logo.png')): ?>
      <img src="Resources/logo.png" alt="Location" class="img-fluid" style="width: 160px;">
      <?php else: ?>
      <span style="font-size: 24px; font-weight: bold; color: #4cbb17;">FoodnPals</span>
      <?php endif; ?>
    </a>
    <?php
    $userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
    if ($userID): ?>
     <div class="d-flex align-items-center">
  <a href="#" class="dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
  <?php if (!empty($profilePictureURL) && file_exists('AppUsers/uploads/' . $profilePictureURL)): ?>
  <img src="AppUsers/uploads/<?php echo $profilePictureURL; ?>" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
  <?php else: ?>
  <i class="fas fa-user-circle" style="font-size: 36px; color: #4cbb17;"></i>
  <?php endif; ?>
  <p style="font-size: 20px; color: #4cbb17;"></p>
  </a>
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
  <a class="dropdown-item" href="CustomerProfile.php">Profile</a>
    <a class="dropdown-item" href="CustomerBookings.php">Bookings </a>
    <a class="dropdown-item" href="CustomerReviews.php">Reviews </a>
    <a class="dropdown-item" href="logout.php">Logout </a>
  
  </div>
</div>
    <?php else: ?>
        <div class="header-buttons">
                   <a href="Login.html" class="header-btn login-btn" style="background:rgb(218, 217, 217);">
            <span class="btn-text">Login</span>
            <?php if (file_exists('Resources/si_sign-in-fill.svg')): ?>
            <img src="Resources/si_sign-in-fill.svg" alt="Sign In" class="mobile-icon" />
            <?php else: ?>
            <i class="fas fa-sign-in-alt mobile-icon" style="color: #4cbb17;"></i>
            <?php endif; ?>
          </a>
          
          <a href="SignUp.php" class="header-btn signup-btn">
            <span class="btn-text">Sign Up</span>
            <i class="fas fa-user-plus mobile-icon"></i>
          </a>
        </div>

    <?php endif; ?>
  </div>


    <section class="row">
        <!-- Left Sidebar -->
        <div id="div1" class="col-12 col-md-3 col-lg-2" style="margin: 0 auto 20px auto; border-radius: 10px; background-color: #f9f9f9;">
            <?php 
                include 'sidebar_menu.php';
                echo renderSidebarMenu('delete');
            ?>
        </div>

        <!-- Main Content -->
        <div id="div2" class="col-12 col-md-8 col-lg-9" style="margin: 0 auto; border-radius: 10px; background-color: #f9f9f9;">
            <div class="card-body">
                <h4 style="color: #d9534f; margin-bottom: 30px;">Delete Your Account</h4>
                <div class="alert alert-warning" role="alert">
                    <h5><i class="fas fa-exclamation-triangle"></i> Warning</h5>
                    <p>Deleting your account is permanent and cannot be undone. All your data, including profile information, booking history, and reviews will be removed.</p>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Account Information</h5>
                        <div class="d-flex align-items-center mb-3">
                            <?php if (isset($userData['ProfilePictureURL']) && !empty($userData['ProfilePictureURL']) && file_exists('AppUsers/uploads/' . $userData['ProfilePictureURL'])): ?>
                            <img src="AppUsers/uploads/<?php echo $userData['ProfilePictureURL']; ?>" alt="Profile" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                            <?php else: ?>
                            <i class="fas fa-user-circle" style="font-size: 80px; color: #4cbb17; margin-right: 20px;"></i>
                            <?php endif; ?>
                            <div>
                                <h6><?php echo isset($userData['firstName']) ? $userData['firstName'] . ' ' . $userData['lastName'] : 'User'; ?></h6>
                                <p class="text-muted mb-0"><?php echo isset($userData['email']) ? $userData['email'] : ''; ?></p>
                                <p class="text-muted mb-0"><?php echo isset($userData['phoneNumber']) ? $userData['phoneNumber'] : ''; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-trash-alt"></i> Delete Your Account</h5>
                    </div>
                    <div class="card-body">
                        <form id="deleteAccountForm" method="POST">
                            <div class="form-group">
                                <label for="deleteReason">Please tell us why you are deleting your account:</label>
                                <textarea class="form-control" id="deleteReason" name="deleteReason" rows="3" required></textarea>
                            </div>
                            <input type="hidden" name="action" value="deleteProfile">
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-danger btn-lg btn-block">
                                    <i class="fas fa-trash-alt"></i> Permanently Delete My Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="CustomerProfile.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Return to Profile
                    </a>
                </div>

            </div>
        </div>
    </section>

    <br>
    <br>
    <?php include 'footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</body><script>
    // Account deletion handler
    document.addEventListener('DOMContentLoaded', function() {
        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');
        const success = urlParams.get('success');

        // Create alert div if needed
        function showMessage(message, isError) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert ${isError ? 'alert-danger' : 'alert-success'} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
            document.querySelector('.card-body').insertBefore(alertDiv, document.querySelector('form'));
        }

        // Show messages if they exist
        if (error) showMessage(decodeURIComponent(error), true);
        if (success) showMessage(decodeURIComponent(success), false);

        // Handle delete account form submission (new handler)
        const deleteForm = document.getElementById('deleteAccountForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const reason = document.getElementById('deleteReason').value.trim();
                if (!reason) {
                    Swal.fire('Please provide a reason for deleting your account.');
                    return;
                }
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone! Your account will be marked as deleted.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleting Account...',
                            text: 'Please wait while we process your request',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        const formData = new FormData(deleteForm);
                        fetch('deleteProfile.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(async response => {
                            const text = await response.text();
                            let data;
                            try {
                                data = JSON.parse(text);
                            } catch (e) {
                                throw new Error('Invalid server response. Please check the console for details.');
                            }
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Account Deleted!',
                                    text: 'Your account has been marked as deleted. You will be logged out.',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#4cbb17',
                                    allowOutsideClick: false
                                }).then(() => {
                                    document.cookie = 'UserID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                                    document.cookie = 'Username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                                    window.location.href = 'logout.php';
                                });
                            } else {
                                throw new Error(data.message || 'Unknown error occurred');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to delete account: ' + error.message,
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        });
                    }
                });
            });
        }
    });
</script>

</html>