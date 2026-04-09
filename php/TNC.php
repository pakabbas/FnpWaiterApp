<?php
include 'creds.php';

// Automatically set user as active and redirect to Home.php
if (isset($_COOKIE['UserID'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $conn->real_escape_string($_COOKIE['UserID']);
    $conn->query("UPDATE AppUsers SET AccountStatus = 'Active' WHERE UserID = '$userId'");
    $conn->close();
}

setcookie("AccountStatus", "Active", time() + (86400 * 60), "/"); // expires in 30 days
header("Location: Home.php");
exit;
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Terms & Conditions</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #ffffff;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 700px;
      margin: 40px auto;
      padding: 20px;
      border: 1px solid #4cbb17;
      border-radius: 8px;
    }
    h2 {
      color: #4cbb17;
      text-align: center;
    }
    .terms {
      max-height: 360px;
      overflow-y: auto;
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    .buttons {
      display: flex;
      justify-content: space-between;
    }
    .btn {
      padding: 12px 25px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      width: 48%;
    }
    .btn-confirm {
      background-color: #4cbb17;
      color: white;
    }
    .btn-decline {
      background-color: #f44336;
      color: white;
    }

    @media (max-width: 600px) {
      .buttons {
        flex-direction: column;
      }
      .btn {
        width: 100%;
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="container" style="margin:10px;">
    <h2>Terms and Conditions</h2>
    <div class="terms">

<p>Please read these terms and conditions (“FoodnPals User Account Terms”) carefully before registering, accessing, or using the FoodnPals user account ( located at https://foodnpals.com or the FoodnPals mobile application (hereinafter collectively referred to as “Platform”) on any device and/or before using any services in relation to the Account that may be offered by FoodnPals on the Platform (hereinafter referred to as “Services”). These FoodnPals User Account Terms form a legal agreement between you (“User” or “you”) and FoodnPals (“FoodnPals” or “we”). These FoodnPals User Account Terms are supplemental to and deemed to be incorporated into the FoodnPals Customer Terms and Conditions and FoodnPals Restaurant Terms and Conditions, which govern your use of the Platform. Capitalized terms used but not otherwise defined herein shall have the same meanings ascribed to them in the FoodnPals Customer Terms and Conditions and FoodnPals Restaurant Terms and Conditions.</p>
      <p>Whenever the context requires, “User” or “you” shall mean any natural person who has reached the legal age who is eligible to contract and has registered for the Account by accepting these FoodnPals User Account Terms.

You agree and acknowledge that you have read the FoodnPals User Account Terms set forth below. If you do not agree to these FoodnPals User Account Terms or do not wish to be bound by these FoodnPals User Account Terms, or are below the legal age, please do not use the Services and Account and/or immediately discontinue your use of the Services and Account.

FoodnPals may amend these FoodnPals User Account Terms at any time by publishing an updated version at the FoodnPals website. The updated version of the FoodnPals User Account Terms shall take effect immediately upon posting. It is your responsibility to review these FoodnPals User Account Terms periodically for updates/changes. Your continued use of the Services following the posting of such changes shall mean that you accept and agree to the revised FoodnPals User Account Terms.
</p>

<h4>1. Use of the Platform and FoodnPals Account</h4>
      <p>You may gain access to the Platform by:

(a) Registering to create an Account and become a “User” to use parts of the Services, and

(b) If you already have an Account, then by logging into your FoodnPals account on the website, web portal, or mobile applications.

We will create your Account for your use of the Platform based upon the personal information you provide to us, including your full name, a valid email address, a mobile phone number, and a unique password (“User Details”).

You must provide accurate, current, and complete information during the registration process and at all other times when you use the Platform and update it to keep it accurate, current, and complete. If you provide any information that is untrue, inaccurate, not current, or incomplete, or if FoodnPals has reasonable grounds to suspect that such information is untrue, inaccurate, not current, or incomplete, we reserve the right to disable your Account and all current and future use of the Services or any portion thereof.

We may request further information or documentation from you to comply with our legal and regulatory obligations. We reserve the right to transmit a One-time Password (“OTP”) via email for multi-factor authentication (MFA) at our sole discretion. To make a Booking, depending on your choice of payment method, you may need to provide us with your credit/debit card details.
</p>

<h4>2. Rules and Restrictions</h4>
      <p>Without limiting other rules and restrictions in this Agreement, by using or accessing the Services, you agree to not engage in any of the following prohibited activities:

(a) using the Platform for any unlawful purpose or in violation of any applicable laws, regulations, or ethical standards, including fraudulent, deceptive, or misleading conduct,

(b) posting content that violates intellectual property, privacy, publicity, trade secrets, or any other rights of any third party,

(c) posting unlawful, obscene, defamatory, threatening, harassing, abusive, hateful, or otherwise objectionable content, as determined by FoodnPals in its sole discretion,

(d) engaging in or promoting cyberbullying or any form of online harassment,

(e) posting content that depicts or encourages dangerous, life-threatening, or harmful activities,

(f) sharing unauthorized personal details, including phone numbers, addresses, or last names of any individual,

(g) posting unsolicited advertisements, spam, external URLs, or any HTML/code without permission,

(h) Misrepresenting yourself as another person or entity,

(i) harvesting or collecting others’ information, including email addresses, without consent,

(j) allowing others to use your account to post or view content,

(k) threatening, stalking, or abusing any user on the Platform,

(l) engaging in any behavior that restricts others’ use of the Platform or exposes FoodnPals or its users to liability, or

(m) soliciting or encouraging others to engage in any prohibited activities listed above.
</p>

<h4>3. Mode of Refund</h4>
<p>If you are entitled to a refund in accordance with the FoodnPals Refund Policy, the default mode of refund for Bookings in which payments were done through credit or debit cards will be a refund to the FoodnPals User Account. The amount approved for refund to you shall be in the sole discretion of FoodnPals. The refund will be processed as soon as reasonably practicable and will be instantaneous where possible. Once the refunded amount is reflected in the Account, the refunded amount can be redeemed immediately on your next order.</p>
   
<h4>4. Personal Data (Personal Information) Protection</h4>
<p>You agree and consent to FoodnPals collecting, using, processing, and disclosing your Personal Data in accordance with this Agreement and as further described in our Privacy Policy. Our Privacy Policy is incorporated by reference herein and accessible here (www.foodnpals.com/privacypolicy/) or via the links on our Platform.
</p>

<h4>5. Account Deletion</h4>
<p>This section outlines the aspects of account deletion and data retention for both customers and employees.</p>


<h4>5.2 For FoodnPals Employee App</h4>
<p>Restaurants must delete the account within 15 days from the Employee App as the employee leaves or is terminated from the employment.</p>


<h4>8. Contact Information</h4>
<p>If you wish to contact us regarding any questions or comments you may have, please reach out to us via the Help Center available on the Platform or by emailing us at support@foodnpals.com.</p>

<!-- Add more content as needed -->
    </div>

    <form method="post">
      <div class="buttons">
        <button type="submit" name="confirm" class="btn btn-confirm">I Agree</button>
        <button type="submit" name="decline" class="btn btn-decline">Decline</button>
      </div>
    </form>
  </div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm'])) {
        header("Location: Home.php");
        exit;
    } elseif (isset($_POST['decline'])) {
        header("Location: logout.php");
        exit;
    }
}
?>
</body>
</html>
