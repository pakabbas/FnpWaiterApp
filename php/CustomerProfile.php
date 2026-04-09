<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

    <title>Customer Profile</title>
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
                margin: 10px auto !important;
                width: calc(100% - 20px) !important;
            }

            .card-body {
                padding: 15px !important;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .col-12 {
                padding: 0;
            }

            /* Hide image upload div on mobile */
            .form-group:has(label[for="profilePicture"]) {
                display: none;
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
        include 'check_profile_image.php';
        ?>
<body>

    <!-- Header -->
    <div class="container-fluid p-3 d-flex justify-content-between align-items-center">
     <a href="Home.php">
      <img src="Resources/logo.png" alt="Location" class="img-fluid" style="width: 160px;">
    </a>
    <?php
    $userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
    if ($userID): ?>
     <div class="d-flex align-items-center">
  <a href="#" class="dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
  <?php echo getProfileImageHtml($profilePictureURL); ?>
  <p style="font-size: 20px; color: #4cbb17;"></p>
  </a>
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
  <a class="dropdown-item" href="CustomerProfile.php">Profile</a>
    <a class="dropdown-item" href="CustomerBookings.php">Bookings </a>
    <a class="dropdown-item" href="CustomerReviews.php">Reviews </a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="CustomerDeletion.php" style="color: #d9534f;">Delete Account</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="logout.php">Logout </a>
  
  </div>
</div>
    <?php else: ?>
        <div class="header-buttons">
                   <a href="Login.html" class="header-btn login-btn" style="background:rgb(218, 217, 217);">
            <span class="btn-text">Login</span>
            <img src="Resources/si_sign-in-fill.svg" alt="Sign In" class="mobile-icon" />
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
                echo renderSidebarMenu('profile');
            ?>
        </div>

        <!-- Main Content -->
        <div id="div2" class="col-12 col-md-8 col-lg-9" style="margin: 0 auto; border-radius: 10px; background-color: #f9f9f9;">
            <div class="card-body">
                <h4 style="color: #4cbb17; margin-bottom: 30px;">Edit Your Profile</h4>
               <div class="form-group">
  <label for="profilePicture" style="background-color: #4cbb17; color: white; padding: 8px 16px; border-radius: 4px; cursor: pointer; display: inline-block;">
  Choose Profile Picture
</label>
<input type="file" id="profilePicture" name="profilePicture" accept=".jpg,.jpeg,.png,.gif" style="display: none;">

 <?php 
$profileImg = isset($userData['profilePicture']) ? $userData['profilePicture'] : '';
$imagePath = "AppUsers/uploads/" . $profileImg;

if (!empty($profileImg) && file_exists($imagePath)) {
    echo '<img id="previewImage" src="AppUsers/uploads/' . $profileImg . '" style="margin-top:10px; max-width:150px; display:block;">';
} else {
    echo '<i id="previewImage" class="fas fa-user-circle" style="margin-top:10px; font-size:150px; color:#4cbb17; display:block;"></i>';
}
?>

</div>

                <form action="update_profile.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input style="background-color:#eff2ed;" type="text" class="form-control" id="firstName" name="firstName" placeholder="Name" value="<?php echo isset($userData['firstName']) ? $userData['firstName'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input style="background-color:#eff2ed;" type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo isset($userData['lastName']) ? $userData['lastName'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input readonly type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($userData['email']) ? $userData['email'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Mobile</label>
                                <input style="background-color:#eff2ed;" type="text" class="form-control" id="address" name="address" placeholder="Mobile No" value="<?php echo isset($userData['phoneNumber']) ? $userData['phoneNumber'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password Changes</label>
                        <input style="background-color:#eff2ed;" type="password" class="form-control" name="currentPassword" placeholder="Current Password">
                        <input style="background-color:#eff2ed;" type="password" class="form-control" name="newPassword" placeholder="New Password">
                        <input style="background-color:#eff2ed;" type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password">
                    </div>

                    <div class="text-right mt-4">
                        <button type="button" class="cancel-button" onclick="window.location.href='CustomerProfile.php'">Cancel</button>
                        <button type="submit" class="save-button">Save Changes</button>
                    </div>
                </form>
                <!-- Delete Profile Button -->
                <div style="display: none;" class="mt-4">
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteProfileModal">
                        <i class="fas fa-trash-alt"></i> Delete Profile
                    </button>
                </div>
                <!-- Delete Profile Modal -->
                <div class="modal fade" id="deleteProfileModal" tabindex="-1" role="dialog" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form id="deleteAccountForm" method="POST">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteProfileModalLabel">Delete Profile</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="deleteReason">Please tell us why you are deleting your account:</label>
                            <textarea class="form-control" id="deleteReason" name="deleteReason" rows="3" required></textarea>
                          </div>
                          <input type="hidden" name="action" value="deleteProfile">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-danger">Delete Account</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </section>

    <br>
    <br>
    <?php include 'footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</body><script>
    // Add this to your CustomerProfile.php
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

<script>
document.getElementById('profilePicture').addEventListener('change', function () {
    var fileInput = this;
    var formData = new FormData();
    formData.append('profilePicture', fileInput.files[0]);

    // Show loading indicator
    Swal.fire({
        title: 'Uploading...',
        text: 'Please wait while we upload your profile picture',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('upload_profile_picture.php', {
        method: 'POST',
        body: formData
    }).then(async res => {
        const raw = await res.text(); // read once as text

        let data;
        try {
            data = JSON.parse(raw); // try parsing JSON
        } catch (e) {
            console.error('Non-JSON response:', raw);
            Swal.fire({
                title: 'Error!',
                text: 'Upload failed: Unexpected server response.',
                icon: 'error'
            });
            return;
        }

        if (data.status === 'success') {
            document.getElementById('previewImage').src = 'AppUsers/uploads/' + data.filename;
            Swal.fire({
                title: 'Success!',
                text: 'Profile picture updated!',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'swal-custom-btn'
                }
            });
        } else {
            console.error('Upload error:', data);
            Swal.fire({
                title: 'Error!',
                text: 'Upload failed: ' + data.message,
                icon: 'error'
            });
        }
    }).catch(err => {
        console.error('Error uploading image:', err);
        Swal.fire({
            title: 'Error!',
            text: 'Upload failed: Network error',
            icon: 'error'
        });
    });
});
</script>

</html>