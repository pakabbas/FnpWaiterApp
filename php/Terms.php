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
       padding: 12px 24px;
       border: none;
       background: #f8f9fa;
       font-size: 16px;
       color: #333;
       transition: all 0.3s;
       margin-right: 15px;
       border-radius: 8px;
       box-shadow: 0 2px 5px rgba(0,0,0,0.05);
     }

   .tab-btn.active {
       background: #4CBB17;
       color: #fff;
       border-color: #4CBB17;
       font-weight: bold;
       box-shadow: 0 3px 8px rgba(76,187,23,0.3);
   }

   .tab-content {
       display: none;
   }

   .tab-content.active {
       display: block;
       animation: fadeIn 0.5s ease;
   }
   
   @keyframes fadeIn {
       from { opacity: 0; }
       to { opacity: 1; }
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

  <style>
    .terms-container {
      background-color: #fff;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.08);
      margin-top: 20px;
      max-height: none; /* Removed height restriction */
      overflow-y: visible; /* Allow full content visibility */
      scrollbar-width: thin;
      scrollbar-color: #4CBB17 #f1f1f1;
    }
    
    .terms-container::-webkit-scrollbar {
      display: none; /* Hide scrollbar */
    }
    
    .terms-content {
      font-size: 14px;
      line-height: 1.6;
      color: #333;
    }
    
    .pricing-title {
      color: #333;
      font-weight: 600;
      margin-bottom: 5px;
    }
    
    .text-muted {
      color: #6c757d;
      font-size: 14px;
      margin-bottom: 15px;
    }
    
    /* Section styling */
    .terms-content strong,
    .terms-content b {
      color: #4CBB17;
      font-weight: 600;
    }
    
    /* Numbered sections */
    .terms-content br + strong,
    .terms-content br + b {
      display: block;
      margin-top: 20px;
      margin-bottom: 10px;
      font-size: 16px;
    }
  </style>

</head>

<body style="margin:0px; padding:0px;">

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

  <!-- Header -->
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
<a href="index.html" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">
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
  
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="pricing-card">

                <div class="mb-4">
                    <button class="tab-btn active" data-tab="customers-tab">For App Users</button>
                    <button class="tab-btn" data-tab="restaurants-tab">For Restaurants</button>
                </div>

                <!-- Customers Tab -->
                <div class="tab-content active" id="customers-tab">
                    <h4 class="pricing-title">FoodnPals Terms and Conditions for App Users</h4>
                    <p class="text-muted">Effective: July 23, 2025</p>
                    <div class="terms-container">
                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>Terms of Service Agreement</strong><br>
                            This Terms of Service Agreement ("Agreement") governs the use of the FoodnPals Platform ("Platform") by customers ("Users," "you," or "your") for table booking services. By registering on the Platform, you agree to comply with this Agreement.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>1. FoodnPals</strong><br>
                            This section outlines who we are, how our platform operates, and the role we play in facilitating transactions and information sharing between Users and Merchants.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>1.1 Who we are</strong><br>
                            FoodnPals operates an online marketplace and connection platform to:<br>
                            (a) broker the exchange of goods and services among you and other consumers, restaurants, and other businesses ("Merchants"), and<br>
                            (b) provide you with access to information on the "Services." FoodnPals is not a merchant, retailer, restaurant, delivery service, or food preparation business.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>1.2 What we do</strong><br>
                            The "Services" we provide or make available include:<br>
                            (a) the Platform,<br>
                            (b) booking table(s) for fine-dining ("Booking").<br>
                            When you book a table, FoodnPals acts as a facilitator on behalf of that Merchant to facilitate, process, and conclude the Booking.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>2. Application of this Agreement</strong><br>
                            This Agreement governs your access to and use of the website, web portal, and mobile applications provided by FoodnPals and is between you and FoodnPals (collectively the "Platform").
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>3. Acceptance of this Agreement</strong><br>
                            By accessing www.foodnpals.com or using any Services provided by FoodnPals, or by completing the account registration process, you confirm that:<br>
                            (a) You have read, understood, and agree to be bound by this Agreement.<br>
                            (b) You are of legal age in your jurisdiction to form a legally binding contract.<br>
                            (c) You have the authority to enter into the Agreement personally or on behalf of a legal entity.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>4. Amendments</strong><br>
                            FoodnPals may modify this Agreement or related policies at any time. Updates will be posted at <a href="https://www.foodnpals.com/Terms.php" style="color:#1a73e8;">www.foodnpals.com/terms/</a>. If changes are material, we’ll notify you via email or another method. Your continued use of the Platform means you accept the updated Agreement.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>5. Use of the Platform and FoodnPals Account</strong><br>
                            You can access the Platform by:<br>
                            (a) Registering for a FoodnPals account<br>
                            (b) Logging into your existing FoodnPals account<br>
                            You must provide accurate and complete details. We reserve the right to disable your account if false information is provided or legal requirements are not met.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>6. Rules and Restrictions</strong><br>
                            By using the Platform, you agree not to engage in prohibited activities including, but not limited to:<br>
                            (a) unlawful use,<br>
                            (b) posting harmful or abusive content,<br>
                            (c) impersonation, spam, or harassment,<br>
                            (d) and other violations as listed in the Agreement.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>7. Intellectual Property Ownership</strong><br>
                            All trademarks, logos, and content on the Platform are owned by FoodnPals or its partners. You may not use, reproduce, or modify them without prior written consent.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>8. Communications with FoodnPals</strong><br>
                            By using the Platform, you agree to receive communications from us via email, SMS, push notifications, or in-app messaging. Message rates may apply.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>9. Bookings</strong><br>
                            (a) You will receive a confirmation email after placing a Booking.<br>
                            (b) Special instructions are not guaranteed.<br>
                            (c) FoodnPals does not guarantee allergen-free food. Contact the Merchant directly if you have allergies.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>10. Payment Terms</strong><br>
                            (a) Prices are listed in USD and may vary.<br>
                            (b) Refunds are issued for cancellations within 24 hours.<br>
                            (c) A $25 fee applies for no-shows.<br>
                            (d) Payments are processed via Stripe. Your card data is stored by Stripe—not FoodnPals.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>11. Termination</strong><br>
                            We may suspend or terminate your access for violations. This Agreement survives such termination.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>12. Personal Data Protection</strong><br>
                            You agree to our collection and processing of your personal data under the Privacy Policy located at <a href="https://www.foodnpals.com/PrivacyPolicy.php/" style="color:#1a73e8;">foodnpals.com/PrivacyPolicy.php</a>.
                        </p>

                        <p style="margin-bottom: 16px; line-height: 1.6;">
                            <strong>13. Contact Information</strong><br>
                            For any queries or feedback, reach out via the Help Center on the Platform or email us at <a href="mailto:support@foodnpals.com" style="color:#1a73e8;">support@foodnpals.com</a>.
                        </p>
                    </div>
                </div>

                <!-- Restaurants Tab -->
                <div class="tab-content" id="restaurants-tab">
                    <h4 class="pricing-title">FoodnPals Terms and Conditions for Restaurants</h4>
                    <p class="text-muted">Effective: July 23, 2025</p>
                    <div class="terms-container">
                    <p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>Terms of Service Agreement</strong><br>
  This Terms of Service Agreement (“Agreement”) governs the use of the FoodnPals Employee App (“App”) by restaurants (“Merchants,” “you," or "your”) for table booking services. By registering on the App, you agree to comply with this Agreement.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>1. FoodnPals</strong><br>
  This section outlines who we are, how our platform operates, and the role we play in facilitating transactions and information sharing between Users and Merchants.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>1.1 Who we are</strong><br>
  FoodnPals operates an online marketplace and connection platform to:<br>
  (a) broker the exchange of goods and services among you and other consumers, restaurants, and other businesses (“Merchants”), and<br>
  (b) provide you with access to information on the “Services.” FoodnPals is not a merchant, retailer, restaurant, delivery service, or food preparation business.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>1.2 What we do</strong><br>
  The “Services” we provide or make available include:<br>
  (a) the Platform,<br>
  (b) booking table(s) for fine-dining (“Booking”).<br>
  When you book a table, FoodnPals acts as a facilitator on behalf of that Merchant to facilitate, process, and conclude the Booking.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>2. Application of this Agreement</strong><br>
  This Agreement governs your access to and use of the Employee App (“App”) provided by FoodnPals and is between you and FoodnPals (or referred to as “we” or “us”).
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>3. Acceptance of this Agreement</strong><br>
  By accessing our App or using any Services, you agree to:<br>
  (a) read, understand, and be bound by this Agreement,<br>
  (b) be of legal working age to form a contract,<br>
  (c) have authority to enter into this Agreement on behalf of a business if applicable.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>4. Amendments</strong><br>
  FoodnPals may modify this Agreement at any time. Continued use of the App indicates your acceptance of the updated terms.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>5. Rules and Restrictions</strong><br>
  You agree not to engage in prohibited activities including, but not limited to:<br>
  (a) unlawful use,<br>
  (b) selling restricted substances,<br>
  (c) posting unlawful or harmful content,<br>
  (d) impersonation, spam, or harassment,<br>
  (e) and other violations as listed in the Agreement.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>6. Registration and Account Management</strong><br>
  You must:<br>
  (a) be a legally operating restaurant,<br>
  (b) provide accurate and current information,<br>
  (c) safeguard your login credentials.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>7. Booking Management</strong><br>
  You must honor confirmed reservations unless in exceptional situations. Unauthorized cancellations may result in penalties. You will be paid $25 for each customer no-show, subject to fees and taxes.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>8. Payment Terms</strong><br>
  Users must pay a subscription fee. Payments are processed via Stripe. FoodnPals does not store your card details.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>9. Warranties and Liabilities</strong><br>
  FoodnPals provides the App “as is” without guarantees. We are not liable for indirect, incidental, or consequential damages. Your exclusive remedy is to stop using the App.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>10. Internet Delays</strong><br>
  FoodnPals is not responsible for delays or failures due to internet issues.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>11. Termination</strong><br>
  We may suspend or terminate your access for violations. This Agreement survives such termination.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>12. Severability</strong><br>
  If any part of this Agreement is deemed invalid, the rest remains enforceable.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>13. Personal Data Protection</strong><br>
  By using the App, you consent to our handling of your personal data per our Privacy Policy: <a href="https://www.foodnpals.com/PrivacyPolicy.php/" target="_blank">www.foodnpals.com/PrivacyPolicy</a>
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>14. Prevailing Language</strong><br>
  In case of discrepancies, the English version of this Agreement shall prevail.
</p>

<p style="margin-bottom: 16px; line-height: 1.6;">
  <strong>15. Contact Information</strong><br>
  For any questions, reach us via the Help Center on the App or email us at <a href="mailto:support@foodnpals.com">support@foodnpals.com</a>.
</p>

                   
                </div>
                </div>

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