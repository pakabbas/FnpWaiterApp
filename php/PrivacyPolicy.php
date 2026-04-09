
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/banner.css">
  <link rel="stylesheet" href="assets/css/Explore.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">

  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_active_reservation.php' ?>

  <style>
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

  <script src="assets/js/Explore.js"></script>

</head>

<body style="margin:0px; padding:0px;">
  <?php if (isset($isReservationActive) && $isReservationActive == "Yes"): ?>
    <div class="floating-banner" id="active-booking-banner">
      <div class="banner-header">Booking in progress...</div>
      <div class="banner-content d-flex align-items-center">
        <img src="Resources/<?php echo $restaurantIcon; ?>" alt="Restaurant Icon" class="restaurant-icon">
        <div class="restaurant-details ml-3">
          <div class="restaurant-name"><?php echo $restaurantName; ?></div>
        <div class="reservation-time">
    <?php echo date('F j, Y \a\t g:i A', $reservationTime); ?>
</div>


        </div>
      </div>
    </div>
  <?php endif; ?>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


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
    <div class="row">
        <div class="col-md-16 mb-4">
            <div class="pricing-card container">
<br>
            <h3 class="pricing-title">PRIVACY POLICY</h3>
                <p class="pricing-price">This Privacy Policy (“Policy”) describes how FoodnPals 
                  
                (“FoodnPals”, “we”, “our”, or “us”) collects, processes, retains, and discloses
                
                your Personal Information when providing its services, including, but not limited to, its Platform, website, and mobile applications, any website, platform or application that contains or includes a link to this Policy, and channels of communication (collectively the “Platform” or “Services”). 
</p>

<h4 class="pricing-title">What Personal Information does FoodnPals collect or process?</h4>
                <p class="pricing-price">
                  <br>
                What Personal Information does FoodnPals collect or process?
<br>
Personal Information is any information that FoodnPals can reasonably use to identify you, whether that information identifies you on its own or when combined with other information. Anonymous information and information that has been de-identified such that it cannot identify you is not Personal Information.
<br>
We may process the following categories of Personal Information in connection with our Services:
<br><br>
(a) Contact Information, including name, address (such as home address, work address, or other delivery address), email address(es), phone number(s), and other contact information provided to us.
<br><br>
(b) Account and Profile Information, including username and credentials, privacy settings and notification preferences, pictures, and other information you add to your FoodnPals profile, and identifiers that we may link to an account and information received from third-party platforms or authentication services that are linked to our Services.
<br><br>
(c) Communications with FoodnPals, including the content of in-app messages, communications with Merchants through or in-connection with our Services (including, without limitation, through our and third-party platforms), SMS/text messages, chats, phone calls, and emails with us related to our Services, customer support inquiries and outreach, the date and time of communications, method or channel used, call recordings (if applicable), the outcomes, actions, and/or resolutions from the communications, and other information. 
<br><br>
(d) Content you create or share, including reviews about experiences on our platform, such as about Merchants you order or book from or photos you upload.
<br><br>
(e) Payment Information, including credit card or debit card information and information about the payment methods and services (such as PayPal or Venmo) used to make purchases on or through our Services. Payment information is primarily stored and processed by our third-party service providers, including our payment processors. However, we may store and process limited payment-related information such as the last four digits of a payment card, the name of the financial institution, and the payment service.
<br><br>
(f) Activity and Transactions on or with our Services, including information about the items and products ordered, order history, items placed in the cart, special instructions included in an order (e.g., dietary preferences, delivery preferences), transaction amounts, promotional codes and discounts used and received, the Merchants ordered from, gift cards ordered, the features and functionality used or interacted with, searches and actions on our Services, responses to our surveys or other market research activities, participation in sweepstakes, promotions, or contests, photos and/or videos that you may send or provide to us related to your activity and transactions on or with our Services.
<br><br>
(g) Geolocation Information, if you have consented by enabling location access, we may receive and store your precise location information, including when our apps are running in the foreground (our app is open and on screen) or background (our app is open, not on screen) of your device. You may use our Services without enabling the collection of precise location information from your device; however, this may impact your experience, including the accuracy of deliveries and/or the availability of certain content, features, and functionality (e.g., you may have to enter your delivery address manually). If you have not allowed us to receive your precise location, we can only determine your approximate location.
<br><br>
(h) Device Information and Access Data, including information about the computers, phones, and other devices you use to interact with FoodnPals or our Platform, internet-protocol address, device-based identifiers, operating system and version, preferred language, hardware model identifiers, browser information including type and settings, notification access, microphone access, and other device information.
<br>
When we process de-identified information, we maintain and use the information in de-identified form and do not attempt to re-identify the information, except as permitted by applicable law.
<br><br>3. How does FoodnPals collect or receive Personal Information?

<br>3.1 From Users of Our Platform

<br>We receive information from users of our Platform, such as during account or profile creation and updating, placing an order, participation in surveys, participation in sweepstakes, promotions or contests, creating or posting content such as photos or reviews, contacting us, and uploading or syncing your contacts. If a user provides Personal Information for or about others, such as in connection with our referral or gift programs, the user represents that they have all necessary rights and consents to provide the other person’s Personal Information to us.

<br>3.2 Automatically Through Our Platform

<br>When you use our Platform, certain Personal Information is collected automatically from your device, browser, camera, and microphone.

<br>3.3 Through Cookies and Similar Technologies

<br>Cookies are small text files that are placed on your device, commonly through your browser, and that are used to record information such as settings. Depending on your settings, certain parts of our Platform, including our website, may receive information about you from or through cookies or similar technologies (such as pixels or software development kits).

<br>3.4 From our Service Providers

<br>We may receive Personal Information from service providers whom we engage to perform services on our behalf, including communication services providers (e.g., email, SMS/text message, etc.), payment providers and processors (such as PayPal and Venmo), market research services providers, providers of services for promotions, sweepstakes and contests, gift card program providers/vendors, and those that provide us with marketing, advertising, analytics, security, fraud, identity, and age verification services.

<br>3.5 From Merchants

<br>If a Merchant has integrated its loyalty program with our Platform, we may receive Personal Information from the Merchant in connection with such integration, such as to identify users of our Platform who are also members of the Merchant’s loyalty program to better target or direct communications about the integration to such users or after a User consents to create a link between the User account with our Platform and the Merchant’s loyalty program, the Merchant may provide certain Personal Information to enable the user to receive loyalty program benefits and discounts for purchases made through our Platform. 

<br>3.6 From Legal Claims, Disputes, Requests, and Orders

<br>We may collect Personal Information from third parties or persons, such as law enforcement agencies, government agencies or authorities, users and non-users of our Platform, and any other person or party who may be involved in the matter.

<br><br>4. How does FoodnPals use Personal Information?

<br>Depending on how you interact with our Platform, FoodnPals may use your Personal Information (as described in Section 2 above):

<br>(a) To Provide and Customize FoodnPals Services, including allowing you to place and pay for orders, facilitating the orders you place on or through our Platform, recommending and ranking Merchants based on your searches, location, reviews and order history and, if you have uploaded or synched your contacts, based upon where your contacts have ordered (however, we will not provide you with information on where a specific contact(s) ordered or what a specific contact(s) ordered), facilitating participation in promotions, sweepstakes and contests, making promotions, special offers and opportunities available to you, allowing or enabling you to purchase/order our gift cards, displaying reviews, photos and other content you post publicly, and customizing your experience (including, but not limited to, customization based on your preferences, location, and past use of our Platform).

<br>(b) To Provide Help and Support, including by exchanging communications, investigating, analyzing, and remediating support issues including as it relates to delivery of orders or bookings, evaluating our customer support and making improvements, and ensuring that support issues are handled in accordance with our internal standards, processes, and requirements and according to applicable law.

<br>(c) To Develop, Analyze, and Improve our Platform, including debugging or troubleshooting our Platform, understanding how you and other customers use our Platform and your preferences, improving the Platform, and developing new initiatives to provide our users with the best experience possible.

<br>(d) To Advertise and Promote FoodnPals and our Services, including displaying advertising related to our Platform or Merchants on our Platform and on third-party websites and platforms, improving, developing and implementing marketing campaigns, analyzing whether our advertising is effective, and showing you ads that are most relevant to you about FoodnPals and our Merchants. 

<br>(e) To Allow and/or Facilitate Communications with FoodnPals and Merchants, including communications about our Services, Service updates, orders and account, changes to our terms and policies, and to allow or facilitate communications with FoodnPals and Merchants.

<br>(f) For Authentication, Integrity, Security, Quality and Safety, including verifying your account and identity as applicable to our Platform, providing a secure payment and shopping experience, to detect, investigate, and prevent malicious or illegal conduct, bugs, malware, fraudulent activity, illegal or unsafe experiences (such as ensuring age-restricted orders are delivered to the intended recipient), and any other actions we deem necessary to protect your safety and security as well as that of other people, property, and businesses, and to secure our Platform.

<br>(g) For Legal Reasons and Policy Compliance, including to comply with our obligations under applicable law and to respond to valid legal process (e.g., requests or orders from law enforcement, courts, regulators and other government agencies), to investigate or participate in civil discovery, litigation, or other adversarial legal proceedings, to enforce or investigate potential or actual violations of our terms, policies or other legal agreements, to investigate, monitor or mitigate any actual or alleged illegal activities in connection with our Platform, to comply with any tax obligations, to perform audits and assessments, and to enable you to exercise your rights as legally required. 

<br><br>5. How does FoodnPals disclose Personal Information?

<br>Depending on how you interact with the Platform, FoodnPals may provide or disclose Personal Information (as described in Section 2 above) as follows:

<br>5.1 To Service Providers

<br>To enable us to meet our business operations needs and to perform our Services, we may provide Personal Information to our service providers and Merchants, including, but not limited to, providers of identification and verification services, cloud services, payment services, gift card program services, auditing services, security services, marketing and advertising services, promotions, sweepstakes and contest services, market research services, communication services, analytics services that help us understand usage of our Platform, market enrichment services, location and mapping services, and help and support functions.

<br> 5.2 To Merchants

<br>We disclose Personal Information to Merchants in connection with the Platform including, without limitation, disclosing Personal Information for the processing of the Order or Booking, facilitating the delivery, for fraud, trust, and safety concerns or matters, and in connection with a Merchant’s loyalty program if you choose to link your account with our Services to a Merchant’s loyalty program. By placing an order, you acknowledge and agree that, if the Merchant is responsible for the delivery of an order, the Merchant may use your Personal Information to facilitate the delivery of the order to you (including using your contact information to communicate with you via phone calls, emails and/or SMS/text messages about the order and delivery). The Merchant is solely liable and responsible for all communications initiated or sent by the Merchant to you.

<br>5.3 Publicly

<br>We display content and information that you share publicly or permit or authorize us to share publicly, such as reviews about Merchants or photos of things you have ordered, so that others can read and learn about your experiences with Merchants on our Platform.

<br>5.4 To Marketing and Advertising Partners

<br>We may use third-party marketing and advertising partners to deliver advertising to you on behalf of FoodnPals and/or our Merchants, including advertising that may be personalized based on your interactions with our Platform as well as your activity on third-party services.

<br>5.5 For Actual or Potential Corporate Transactions

<br>If we are involved in strategic transactions including any sale, merger, acquisition, joint venture, assignment, transfer, reorganization, bankruptcy or receivership, we may disclose your Personal Information and other information in the diligence process with counterparties and others assisting with the transaction and transferred to a successor or affiliate as part of that transaction along with other assets.

<br>5.6 To Government Authorities or Where Legally Required or Permitted

<br>We and our service providers (including domestic and foreign service providers) may share your Personal Information, including information about your interaction with our Services, with third parties such as government authorities, industry peers, or other third parties if legally required or permitted, or as necessary to enforce our agreements, prevent fraud, or protect the rights, property, or safety of our business, employees, merchants, customers, or other persons or parties. These disclosures may include lawful access by US or foreign courts, law enforcement, or other government authorities.

<br>5.7 Other Third Parties or Persons

<br>We may disclose or provide your Personal Information to other third parties or persons, such as with your consent or at your direction, including to individuals to whom you send a gift through our gift program or to whom you refer FoodnPals or the Platform, in connection with co-branded opportunities, and in connection with you linking accounts with third parties to your account with us or signing into your account with us through third-parties.

<br><br>6. What Privacy Rights and Choices do You Have?

<br>We offer you tools and processes to manage and make choices regarding your Personal Information. Depending on your jurisdiction, and subject to certain exceptions, exemptions, and restrictions, you or your authorized agent may exercise the following rights:

<br>6.1 Access/Portability

<br>You may have the right to request access to your Personal Information (including which third parties have received Personal Information) and receive it in a portable and machine-readable format. This right includes the ability to confirm whether we process any Personal Information about you.

<br>6.2 Deletion

<br>You may have the right to ask us to delete your Personal Information, including your FoodnPals account, although this may impact your ability to use the Services. Please note that we may retain some Personal Information to the extent permitted or required by applicable law.

<br>6.3 Correction

<br>You may have the right to correct, rectify, or update inaccurate Personal Information that we hold about you.

<br>6.4 Opt-Out of Sale or Sharing (Targeted Advertising or Ads Personalization)
<br>
We may disclose Personal Information (e.g., identifiers and service and platform usage) to advertising partners to provide you with personalized ads on third-party platforms, which may constitute a “sale” or “sharing” of your Personal Information. You have the right to opt out of our selling or sharing (for purposes of targeted advertising) of your Personal Information.
<br>
6.5 Right to Appeal
<br>
You may have the right to appeal decisions that we make with regard to a rights request.
<br>
6.6 Right to Withdraw Consent
<br>
You have the right to withdraw consent when consent is legally required (subject to our legal or contractual restrictions and reasonable notice). If you withdraw consent, we may not be able to provide certain services to you.

FoodnPals will not discriminate against you for exercising any of your applicable rights. We reserve the right to deny your request if we cannot verify your identity or if an exemption or exception applies.
<br><br>
7. Data Security and Retention
<br>
We use commercially reasonable administrative, organizational, technical, and physical security controls to protect your Personal Information from unauthorized access, modification, disclosure, or destruction. However, we are not able to guarantee that your Personal Information is absolutely secure since no Internet or email transmission is ever fully secure or error-free. You should take special care in deciding what information you send to us via our Services or when you communicate with us through email, SMS/texts, chat, or other modes of communication. In addition, we are not responsible for circumvention of any privacy settings or security measures contained on our Platform or those on third-party websites. Please recognize that protecting your Personal Information is also your responsibility, and we urge you to take precautions to protect your Personal Information. If you have reason to believe that your FoodnPals account or any interaction with us is no longer secure, please let us know immediately by contacting our Help and Support.
<br>
We retain your Personal Information for only as long as required to provide our Services to you and engage in the uses described in this Policy, unless a different retention period is required by applicable law.
<br><br>
8. Personal Information from Children
<br>
Our Platform is not intended for individuals under the age of majority in the applicable jurisdictions. Therefore, we do not knowingly process Personal Information from individuals under the age of majority.
<br><br>
9. Third-Party Sites
<br>
Our Platform may link to other third-party websites that are not controlled by FoodnPals, such as when you sign up for a loyalty card on a Merchant’s website. These third parties are not under our control, and we are not responsible for their privacy policies or practices. If you provide any Personal Information to any third party or through any such third-party websites, it will be subject to the privacy policies and practices of that third party.
<br><br>
10. How to Contact Us?
<br>
For questions or concerns related to this Policy, please contact us at Help and Support.
<br><br>
11. Changes to this Policy
<br>
We reserve the right to change this Policy to ensure compliance with relevant legal and statutory provisions. We will inform you of any significant changes, such as changes of purpose or new purposes of processing.





</p>
               
            </div>
        </div>
       
    
    </div>
</section>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



<script>
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
</script>

  <br>
 

<?php include 'footer.php'; ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks&libraries=places"></script>
<script>
   function scroll1 () {
        document.getElementById('plans').scrollIntoView({ behavior: 'smooth' });
    }
</script>

</html>