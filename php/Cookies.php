
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <link rel="stylesheet" href="assets/css/Explore.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">

  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_active_reservation.php' ?>

  <style>

       .tab-btn {
        cursor: pointer;
        padding: 10px 20px;
      
        border: none;
        background: none;
        font-size: 16px;
        color: #333;
        border-bottom: 2px solid transparent;
        transition: all 0.3s;
        margin-right: 10px;
        border-radius: 10px;

      }

    .tab-btn.active {
        background: #4CBB17;
         color: #fff;
        border-color: #4CBB17;
        font-weight: bold;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }
.banner {
    width: 100%; /* Full width */
    height: 75vh; /* Adjusted height */
    position: relative; /* Positioning for internal content */
    overflow: hidden; /* Ensures no content spills out */
    display: flex;
    flex-direction: column;
    color: white;
    background: black; /* Optional for fallback background color */
    background-image: url('Resources/par7.png');
    background-size: cover; /* Stretches the image to cover the div */
    background-repeat: no-repeat; /* Prevents the image from repeating */
    background-position: center; /* Centers the image within the div */
}

    .row::-webkit-scrollbar {
      display: none;
    }
  </style>


<style>
       .why-section {
            padding: 50px 20px;
            background-color: #ffffff;
        }
        .why-section h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 40px;
        }
        .why-card {
            text-align: center;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
            min-height:320px;
        }
        .why-card h5 {
            font-size: 16px;
        }
        .why-card p {
font-size:11px;
        }
        .why-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .why-card .icon {
            width: 50px;
            height: 50px;
            background-color: #4CBB17;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            border: 5px solid rgb(203, 228, 192); /* Red border with 5px thickness */
            border-radius: 50%; /* Optional: Makes it circular if it's a square element */
        }

        .faq-section {
            padding: 50px 20px;
            background-color: #ffffff;
        }
        .faq-section h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 40px;
        }
        .faq-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px 20px;
            background-color: #fff;
            margin-bottom: 15px;
            cursor: pointer;
            transition: box-shadow 0.3s;
        }
        .faq-item:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .faq-item .question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
        }
        .faq-item .description {
            display: none;
            margin-top: 10px;
            color: #555;
        }
        .faq-item.active .description {
            display: block;
        }
        .faq-item.active .icon {
            transform: rotate(45deg);
        }
        .faq-item .icon {
            font-size: 1.2rem;
            transition: transform 0.3s;
        }

        
  </style>


</head>

<body style="margin:0px; padding:0px;">

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

  <!-- Header -->
  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_restaurant.php' ?>

  <div class="container-fluid header-container" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; width: 100%;">
    <div class="logo-container" style="width: auto; display: flex; align-items: center;">
      <a href="Home.php" style="display: block;">
        <img src="Resources/logo.png" alt="Location" class="img-fluid" style="max-width: 160px; height: auto;">
      </a>
    </div>
    
    <?php
    $userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
    if ($userID): ?>
     <div class="profile-container" style="display: flex; align-items: center; margin-left: auto;">
     <?php  if ($isReservationActive === 'Yes' && $activeReservationRestaurant === $restaurant['RestaurantID']): ?>   
    
      <a href="#" onclick="$('#smallmodal').modal('show'); return false;" style="text-decoration: none; margin-right: 15px; position: relative;">
          <i class="fas fa-shopping-cart" style="font-size: 24px; color: #4CBB17;"></i>
          <span id="cartCount" style="position: absolute; top: -8px; right: -8px; background-color: #ff4757; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 11px; display: flex; align-items: center; justify-content: center; font-weight: bold;"></span>
        </a>
    
        <?php  endif; ?>      
      <a href="#" class="dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
        <?php 
$profilePath = 'AppUsers/uploads/' . $profilePictureURL;
if (!empty($profilePictureURL) && file_exists($profilePath)) {
    echo '<img src="' . $profilePath . '" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">';
} else {
    echo '<i class="fas fa-user-circle" style="font-size: 36px; color: #4CBB17;"></i>';
}
?>
        <p style="font-size: 20px; color: #4cbb17; margin: 0 0 0 5px;"></p>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
        <a class="dropdown-item" href="CustomerProfile.php">Profile</a>
        <a class="dropdown-item" href="CustomerBookings.php">Bookings </a>
        <a class="dropdown-item" href="CustomerReviews.php">Reviews </a>
        <a class="dropdown-item" href="logout.php">Logout </a>
      </div>
    </div>
    <?php else: ?>
        <div class="header-buttons" style="margin-left: auto;">
<div class="dropdown" style="position: relative; display: inline-block;">
  <button class="header-btn login-btn" style="background:rgb(218, 217, 217); border: none; cursor: pointer;">
    <span class="btn-text">Login</span>
    <img src="Resources/si_sign-in-fill.svg" alt="Sign In" class="mobile-icon" />
  </button>
  <div class="dropdown-content" style="
    display: none;
    position: absolute;
    background-color:rgb(255, 255, 255);
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  ">
<a href="Login.html" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">
  <i  style="color:#4cbb17;" class="fas fa-user"></i> User Login
</a> 
<a href="./admin/index.php" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">
  <i style="color:#4cbb17;" class="fas fa-store"></i> Partner Login
</a>

  </div>
</div>

<script>
  const dropdown = document.querySelector('.dropdown');
  const content = dropdown.querySelector('.dropdown-content');

  dropdown.addEventListener('mouseenter', () => {
    content.style.display = 'block';
  });

  dropdown.addEventListener('mouseleave', () => {
    content.style.display = 'none';
  });
</script>

          
          <a href="SignUp.php" class="header-btn signup-btn">
            <span class="btn-text">Sign Up</span>
            <i class="fas fa-user-plus mobile-icon"></i>
          </a>
        </div>

    <?php endif; ?>
  </div>

  <!-- Banner -->
   <!-- <h1 class="discover-title" style="font-size: 4rem; margin-bottom: 20px;">About Us</h1> -->
 
  <!-- <div class="banner" >
   
  
  </div>
<br><br> -->



<section class="pricing-section container">
  
    <div class="row ">
        <div class="col-md-12 mb-4">
            <div class="pricing-card">

                <div class="mb-4">
                </div>

                <!-- Customers Tab -->
                <div class="tab-content active" id="customers-tab">
                    <h4 class="pricing-title">FoodnPals Cookie Policy</h4>
                    <br>
<h6>This Cookies Policy supplements our Privacy Policy to explain how we use cookies and similar technologies to process device data when providing our website to you.
</h6>
                <p class="pricing-price">
       <br> 1. Cookies
<br>
For your visit to – or use of – our website to be attractive and to allow some features of our website to be deployed, we use cookies on various pages. Cookies are small text files that are stored on your device. Some cookies we use are deleted after the end of your browser session, i.e., after you close the browser (session cookies). Other cookies remain in your browser, allowing us to recognize your browser on your next visit (persistent cookies). If you don’t like cookies being used on your device, you can configure your browser to decline using cookies altogether. Not accepting any cookies may limit the functionality of our website.

<br><br>2. Similar Technologies

<br>Cookies are not the only way to process device data online. There are similar technologies, like web beacons (sometimes called “tracking pixels”, “pixel tags,” or “clear gifs”). These tiny graphics files contain a unique identifier enabling us to recognize when someone has visited our website. This allows us, for example, to monitor the traffic patterns of users from one page within our website to another, to deliver or communicate with cookies, to understand whether you have come to our website from an online advertisement displayed on a third-party website, or to improve performance. These technologies rely on cookies to function, so declining cookies will impair their functioning.

<br><br>3. Cookies Used by Us

<br>Essential cookies are required to navigate our website or service to use its core features. Without using such cookies, the proper functioning of our web offering cannot be guaranteed. You cannot opt out of these technologies. We only collect data, such as the user ID and session length.

<br><br>4. Changes to this Policy

<br>Further, FoodnPals may modify or amend this Policy from time to time at its discretion. When FoodnPals makes changes to this Policy, it will amend the revision date at the top of this page, and such modified or amended Cookie Policy shall be effective to you and your information as of that revision date. FoodnPals encourages you to periodically review this Policy to be informed about how it uses cookies.


                </p>

                  
                </div>

                <!-- Restaurants Tab -->
              

            </div>
        </div>
    </div>
</section>

<script>
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-tab');

            // Remove active classes
            tabButtons.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));

            // Add active classes
            btn.classList.add('active');
            document.getElementById(target).classList.add('active');
        });
    });
</script>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>





  <br>
 
  <?php include 'footer.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
   function scroll1 () {
        document.getElementById('plans').scrollIntoView({ behavior: 'smooth' });
    }
</script>

</html>