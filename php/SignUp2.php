<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

  <title>Sign Up Page - FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body,
    html {
      height: 100%;
    }

    .bg-image {
      background-color: #ccfab6;
      /* height: 100%; */
     
      background-position: center;
      background-repeat: no-repeat;
      /* background-size: cover; */
    }

    .login-container {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .login-form {

      background-color: rgba(255, 255, 255, 0.7);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      margin-top: 30px;
      /* Add margin to the top */
      width: 100%;
      /* Make the form 30% larger */
    }


    @media (min-width: 768px) {
      .form-row {
        row-gap: 15px;
        column-gap: 20px;
        /* Increase space between columns */
      }

      .form-group {
        flex: 0 0 48%;
        /* Set form-group width to 48% to leave space between columns */
        max-width: 48%;
      }
    }
  </style>

  <script>
    // Replace with your actual API Key
    const GOOGLE_API_KEY = 'AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks';

    window.onload = function() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError, {
          enableHighAccuracy: true,
          timeout: 10000, // 10 second timeout
          maximumAge: 0 // Force a fresh location
        });
      } else {
        console.error("Geolocation is not supported by this browser.");
      }
    };

    function showPosition(position) {
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;

      // Fill the longitude and latitude fields
      document.getElementById('Longitude').value = longitude;
      document.getElementById('Latitude').value = latitude;

      // Call Google Maps Geocoding API for reverse geocoding
      const geocodingURL = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${GOOGLE_API_KEY}`;

      fetch(geocodingURL)
        .then(response => response.json())
        .then(data => {
          if (data.status === "OK") {
            // Extract the necessary information
            let city = '';
            let postalCode = '';
            let country = '';

            data.results[0].address_components.forEach(component => {
              if (component.types.includes("locality")) {
                city = component.long_name;
              }
              if (component.types.includes("postal_code")) {
                postalCode = component.long_name;
              }
              if (component.types.includes("country")) {
                country = component.long_name;
              }
            });

            // Fill the location (city) and postal code fields
            document.getElementById('Location').value = postalCode + ", " + city + ", " + country;
            // You can add a postal code input if needed
            //  alert(`Detected City: ${city}, Postal Code: ${postalCode}`);
          } else {
            console.error('Geocoding failed:', data.status);
          }
        })
        .catch(error => console.error('Error with geocoding request:', error));
    }

    function showError(error) {
      let errorMessage = "An unknown error occurred.";
      switch (error.code) {
        case error.PERMISSION_DENIED:
          errorMessage = "User denied the request for Geolocation. Note: This feature requires a secure connection (HTTPS).";
          break;
        case error.POSITION_UNAVAILABLE:
          errorMessage = "Location information is unavailable.";
          break;
        case error.TIMEOUT:
          errorMessage = "The request to get user location timed out.";
          break;
        case error.UNKNOWN_ERROR:
          errorMessage = "An unknown error occurred.";
          break;
      }
      console.error("Geolocation Error: " + errorMessage, error);
    }
  </script>

</head>

<body>

  <div class="bg-image">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2 col-md-12 offset-md-2 login-container">
          <div class="login-form">
            <h2 class=" mb-4">Create Account</h2>
            <!-- <label>Sign up or log in to continue</label> -->

            <form id="signupForm" action="add_customer.php" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: auto;">
  <div class="form-row">
    <div class="form-group">
      <label for="FirstName">First Name</label>
      <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="John" required>
    </div>
    <div class="form-group">
      <label for="LastName">Last Name</label>
      <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Doe" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="Email">Email</label>
      <input readonly type="email" class="form-control" id="Email" name="Email" placeholder="user@mail.com" required>
    </div>
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->

<div class="form-group">
  <label for="DOB">Date of Birth</label>
  <input type="text" class="form-control" id="DOB" name="DOB" placeholder="Select your birth date" required>
</div>

    
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="Password">Password</label>
      <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter password" required>
    </div>
    <div class="form-group">
      <label for="Password">Confirm Password</label>
      <input type="password" class="form-control" id="Password1" name="Password1" placeholder="Enter password" required>
    </div>
   
  </div>

<div class="form-row">
    <div class="form-check mb-2">
      <div id="termsScrollMessage" style="color: #dc3545;">Please scroll through entire <a href="Terms.php" target="_blank" style="color: #4CBB17;">Terms and Conditions</a> to proceed</div>
    </div>

    <!-- Scrollable Terms and Conditions Box with Scroll Indicator -->
    <div class="position-relative">
      <div class="scroll-indicator" style="position: absolute; right: 10px; top: 10px; background: rgba(255,255,255,0.9); padding: 5px 10px; border-radius: 15px; font-size: 12px; display: none;">
        <span id="scrollPercentage">0%</span> scrolled
      </div>
    <div style="
        max-height: 200px;
        overflow-y: auto;
        background: #f9f9f9;
        border: 1px solid #ccc;
        padding: 15px;
        margin-top: 10px;
        border-radius: 5px;
        font-size: 14px;
        line-height: 1.5;
        color: #333;
      "
    >
      <strong>Terms and Conditions</strong>
      <p>

Please read these consumer terms and conditions carefully. These consumer terms and conditions (“Agreement,” “Terms and Conditions,” or “Terms”) defined below constitute a legal agreement between you and FoodnPals.

1. FoodnPals
This section outlines who we are, how our platform operates, and the role we play in facilitating transactions and information sharing between Users and Merchants.
1.1 Who we are FoodnPals operates an online marketplace and connection platform to:
(a) broker the exchange of goods and services among you and other consumers, restaurants, and other businesses (“Merchants”), and
(b) provide you with access to information on the “Services.” FoodnPals is not a merchant, retailer, restaurant, delivery service, or food preparation business.
1.2 What we do
The “Services” we provide or make available include:
(a) the Platform,
(b) booking table(s) for fine-dining (“Booking”).
When you book a table, FoodnPals acts as a facilitator on behalf of that Merchant to facilitate, process, and conclude the Booking.

2. Application of this Agreement This Agreement governs your access to and use of the website, web portal, and mobile applications provided by FoodnPals and is between you and FoodnPals (or referred to as “we” or “us”) (collectively the “Platform”).

3. Acceptance of this Agreement If you access our website located at www.foodnpals.com/ and access or use any information, function, feature, or service made available or enabled by FoodnPals (“Services”), click or tap a button or take similar action to signify your affirmative acceptance of this Agreement, or complete the FoodnPals account registration process, you, your heirs, assigns, and successors (collectively “you” or “your”) hereby present and warrant that:
(a) you have read, understood, and agreed to be bound by this Agreement,
(b) you are of legal age in the jurisdiction in which you reside to form a legally binding contract with FoodnPals, and
(c) you have the authority to enter into the Agreement personally and, if applicable, on behalf of any corporate legal entity for whom you have created an account or been named as the “User” during the FoodnPals account registration process and to bind such organization to the Agreement. Users below the legal age must obtain consent from parent(s) or legal guardian(s), who by accepting this Agreement shall agree to take responsibility for your actions and any charges associated with your use of the Platform. If you do not have consent from your parent(s) or legal guardian(s), you must stop using/accessing the Platform immediately.

4. Amendments FoodnPals reserves the right to modify this Agreement or its policies relating to the Platform or Services at any time, effective upon posting an updated version of this Agreement at www.foodnpals.com/terms/. If we make any material changes to this Agreement, we will notify you by email at the email address that you provide us or by another means. You should regularly review this Agreement, as you will be deemed to have agreed to the modified Agreement (whether or not reviewed by you) by your continued use of the Platform following the date when the modified Agreement is posted. If you do not agree to this Agreement or any modifications made to this Agreement, you should immediately cease using the Platform and Services.

5. Use of the Platform and FoodnPals Account You may gain access to the Platform by:
(a) Registering to create a FoodnPals account and become a “User” to use parts of the Services, and
(b) If you already have a FoodnPals account, then by logging into your FoodnPals account on the website, web portal, or mobile applications. We will create your FoodnPals account for your use of the Platform based upon the personal information you provide to us, including your full name, a valid email address, a mobile phone number, and a unique password (“User Details”). You must provide accurate, current, and complete information during the registration process and at all other times when you use the Platform and update it to keep it accurate, current, and complete. If you provide any information that is untrue, inaccurate, not current, or incomplete, or if FoodnPals has reasonable grounds to suspect that such information is untrue, inaccurate, not current, or incomplete, we reserve the right to disable your account and all current and future use of the Services or any portion thereof. We may request further information or documentation from you to comply with our legal and regulatory obligations. We reserve the right to transmit a One-time Password (“OTP”) via email for multi-factor authentication (MFA) at our sole discretion. To make a Booking, depending on your choice of payment method, you may need to provide us with your credit/debit card details. FoodnPals will not be liable for Bookings that encounter service delivery issues due to incomplete, incorrect, or missing information provided by you. You are obliged to provide information that is complete, accurate, current, and truthful for the proper processing of the Booking, including your delivery address and contact information. If you choose to use the Platform, it shall be your responsibility to treat your password, OTP, or any other piece of information that we may provide as confidential and to not disclose the same to any person or entity other than us. You are the sole authorized User of any account you create through the Platform. You are solely and fully responsible for all activities that occur under your password or account or through your device, whether or not authorized by you. You agree that you shall monitor your account to prevent use by minors, and you will accept responsibility for any unauthorized use of your password, OTP, or your account. You shall immediately notify us of any unauthorized use of your FoodnPals account. We shall, at times and at our sole discretion, reserve the right to disable any FoodnPals account if you fail to comply with any of the provisions of this Agreement.

6. Rules and Restrictions Without limiting other rules and restrictions in this Agreement, by using or accessing the Services, you agree to not engage in any of the following prohibited activities:
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

7. Intellectual Property Ownership
All trademarks, logos, images, and service marks, including these Terms as displayed on the Platform or in our marketing material, whether registered or unregistered, are the intellectual property of FoodnPals and/or third parties who have authorized us with the use (collectively the “Trademarks”). You may not use, copy, reproduce, republish, upload, post, transmit, distribute, or modify these Trademarks in any way without our prior express written consent. Using the Trademarks on any other website not approved by us is strictly prohibited. FoodnPals will aggressively enforce its intellectual property rights to the fullest extent of the law, including criminal prosecution. FoodnPals neither warrants nor represents that your use of materials displayed on the Platform will not infringe rights of third parties not owned by or affiliated with FoodnPals. Use of any materials on the Platform is at your own risk.

8. Communications with FoodnPals
By creating a FoodnPals account or using the Platform, you agree to:
(a) accept and receive communications from or on behalf of FoodnPals, Merchants, and/or third parties providing services to you, including via email, text message, chat, and calls, to the contact information you provide to FoodnPals when registering an account or using the Platform,
(b) receive communications via push notifications or in-app messages in the FoodnPals mobile application.
Message and data rates may apply and message frequency may vary. The communications may include, without limitation, commercial or marketing messages, transactional or relationship messages, security and/or fraud, safety, responses to communications initiated by you, updates to policies/legal agreements, newsletters, and messages relating to research or customer support (those initiated by you or us).

9. Bookings
This section outlines the key policies and procedures governing your bookings on FoodnPals. It covers important information about booking confirmations, special requests, allergen considerations, and our policies regarding fraudulent activity.
9.1 Booking Confirmation
When you place a Booking on FoodnPals, FoodnPals will confirm your Booking by sending you a confirmation email containing the Booking receipt.
9.2 Special Instructions
FoodnPals and the Merchant (as the case may be) reasonably endeavor to comply with your special instructions for a Booking. However, in some cases where this is not feasible, possible, or commercially reasonable, FoodnPals and/or the Merchant reserve the right to proceed to process the Booking per standard operating procedures. Neither FoodnPals nor the Merchant shall be responsible for replacing or refunding a Booking that does not conform to special instructions that you have provided.
9.3 Allergens
FoodnPals is not obligated to provide ingredient information or allergen information on the Platform. Further, FoodnPals does not guarantee that the food sold by Merchants are free of allergens, unless otherwise required by applicable laws. If you have allergies, allergic reactions, or dietary restrictions and requirements, please contact the Merchant before placing a Booking on our Platform.
FoodnPals reserves the right to cancel any Booking and/or suspend, deactivate, or terminate your FoodnPals account in its sole discretion if it reasonably suspects or detects fraudulent behaviour or activity associated with your FoodnPals account and/or with your Booking.

10. Payment Terms
This sections governs all financial transactions on FoodnPals, including pricing structures, refund policies, promotional offers, service fees, and payment methods.
10.1 Prices and Charges
You understand that:
(a) Prices quoted on the Platform shall be displayed in United States Dollars (“USD”).
(b) The prices for menu or other items displayed through the Platform may differ from the prices offered or published by Merchants elsewhere for the same menu or other items and/or from prices available at third-party websites, mobile applications, and brick-and-mortar outlets and that such prices may not be the lowest prices at which the menu or other items are sold and may change at any time without notice,
(c) Pricing may change at any time at the discretion of FoodnPals or the Merchant, depending on which party sets the given price,
(d) FoodnPals may use strikethrough pricing for certain items (for example, when presenting a discount or promotional price for items).
10.2 Refunds and Cancellations
You acknowledge that:
(a) In the event that you inadvertently or mistakenly place a Booking, you have the right to a refund for a Booking placed within 24 hours. In case 24 hours have passed, you understand that no refunds (whether in whole or in part) will be issued to you, and you forfeit the delivery of your canceled Booking.
(b) Your cancellation, or attempted or purported cancellation of a Booking or, cancellation due to reasons not attributable to FoodnPals, that is, in the event you provide incorrect particulars, contact number, etc., or that you were unresponsive, not reachable, or unavailable for fulfillment of the services offered to you shall amount to a breach of your unconditional and irrevocable authorization in favour of FoodnPals to place that Booking against the Merchant on your behalf (“Authorization Breach”).
(c) If you commit an Authorization Breach, you shall be liable to pay the liquidated damages of an amount equivalent to the Booking value. You hereby authorize FoodnPals to deduct or collect the amount payable as liquidated damages through such means as FoodnPals may determine in its discretion, including, without limitation, by deducting such amount from any payment made towards your next Booking.
(d) There may be cases where FoodnPals is either unable to accept your Booking or cancels the Booking, due to reasons including, without limitation, technical errors, unavailability of the item(s) ordered, or any other reason attributable to FoodnPals or Merchant. In such cases, FoodnPals shall not charge a cancellation fee from you. If the Booking is canceled after payment has been charged, and you are eligible for a refund of the Booking value or any part thereof, the said amount will be returned to you.
(e) In the event that you have elected to enroll in automatic subscription, you retain the right to terminate said subscription, provided that such cancellation is effected no later than seven (7) calendar days preceding the scheduled auto-renewal date. This right of cancellation shall be exercised in accordance with the procedures set forth in these Terms or as otherwise designated by the FoodnPals.
10.3 Vouchers, Discounts, and Promotions
FoodnPals, at its sole discretion, may make promotional offers with different features and different pricing to any User. These promotional offers are subject to the terms of this Agreement and may be valid only for certain Users as indicated in the offer. You agree that promotional offers:
(a) may only be used by the intended audience, for the intended purpose, and in a lawful manner,
(b) may not be duplicated, sold, or transferred in any manner, or made available to the general public, unless expressly permitted by FoodnPals,
(c) are subject to the specific terms that FoodnPals establishes for such promotional offer,
(d) cannot be redeemed for cash or cash equivalent,
(e) are not valid for use after the date indicated in the offer,
(f) may only be redeemable towards eligible Bookings placed on www.foodnpals.com/ or in the FoodnPals mobile application
FoodnPals reserves the right to withhold or deduct credits or benefits obtained through a promotion, or to charge additional amounts that would have applied to the transaction had the promotion not applied, if FoodnPals determines or believes on reasonable grounds that the redemption of the promotion or receipt of the credit or benefit was in error, fraudulent, illegal, or in violation of the applicable promotion terms or this Agreement.
10.4 Fees for Services
FoodnPals may change the fees that FoodnPals charges you as we deem necessary or appropriate for our business, including but not limited to Delivery Fees and Service Fees. FoodnPals may also charge you additional fees as required by law. Further, FoodnPals may charge Merchants fees on Bookings that you place through the Platform, including commissions and other fees, and may change those Merchant fees as we deem necessary or appropriate for our business or to comply with applicable law. FoodnPals may charge you a Service Fee for the convenience of Booking through the Platform.
10.5 Payment Methods
FoodnPals reserves the right to offer additional payment methods and/or remove existing payment methods at any time in its sole discretion. If you choose to pay using an online payment method, the payment shall be processed by our third-party payment service provider(s). With your consent, your credit card/payment information will be stored with our third-party payment service provider(s) for future Bookings. FoodnPals does not store your credit card or payment information.

11. Transactions Involving Alcohol and Other Age-restricted Products
FoodnPals strictly prohibits Merchants from serving alcohol and other age-restricted products to Users through the Platform. You do not have the option to request the Merchant to serve you alcohol and other age-restricted products.

12. Blacklisting Merchants
The Platform reserves the right, at its sole discretion, to permanently or temporarily remove (hereinafter "Blacklist") a Merchant from the Platform in cases of repeated or egregious violations, including but not limited to:
(a) Fraudulent or deceptive practices (e.g., misrepresentation of menu items, prices, or availability);
(b) Failure to honor confirmed reservations or orders;
(c) Multiple substantiated complaints regarding service, hygiene, or food safety;
(d) Breach of the FoodnPals Restaurant Terms and Conditions or applicable laws;
(e) Any conduct that harms the Platform’s reputation or user experience.

13. Representation, Warranties, and Limitation of Liabilities
This section defines the legal boundaries of FoodnPals’ responsibilities and your rights as a User of our Platform. This section also outlines the extent of our liability, or lack thereof, for any damages, losses, or disruptions you may encounter while using the App.
13.1 Disclaimer of Warranties
You expressly understand and agree that your use of the Platform is entirely at your own risk. Changes are periodically made to the Platform and may be made at any time without providing notice to you. FoodnPals will use reasonable endeavors to ensure the Platform is available as much of the time as possible, but does not guarantee they will be available all the time. The Platform is provided on an “as is” basis without guarantees, warranties, or conditions of any kind, either express or implied, including, but not limited to, guarantees, warranties, or conditions of merchantability, fitness for a particular or general purpose, and non-infringement. FoodnPals makes no warranties, conditions, or representations about the accuracy, reliability, completeness, or timeliness of the content made available through the Platform. FoodnPals does not warrant that the Platform will operate error-free or that the Platform is free of computer viruses and other harmful malware. If your use of the Platform results in the need for servicing or replacing equipment or data, FoodnPals shall not be responsible for those economic costs.
13.2 Indemnification
To the extent permitted by law, FoodnPals (which shall include its employees, directors, agents, representatives, and affiliates) exclude all liability (whether arising in contract, in negligence or otherwise) for loss or damage which you or any third party may incur in connection with our Platform, our Services, and any website linked to our Platform and any content or material posted on it. Your exclusive remedy concerning your use of the Platform is to discontinue your use of the Platform. The FoodnPals entities, their agents, representatives, and service providers shall not be liable for any indirect, special, incidental, consequential, or exemplary damages arising from your use of the Platform or for any other claim related in any way to your use of the Platform. These exclusions for indirect, special, consequential, and exemplary damages include, without limitation, damages for lost profits, lost data, loss of goodwill, work stoppage, computer failure, or malfunction, or any other commercial damages or losses, even if the FoodnPals entities, their agents, representatives, and service providers have been advised of the possibility thereof and regardless of the legal or equitable theory upon which the claim is based. Because some states or jurisdictions do not allow the exclusion or the limitation of liability for consequential or incidental damages, in such states or jurisdictions, FoodnPals, the FoodnPals entities, its agents, representatives, and service providers' liability shall be limited to the extent permitted by law.
13.3 Merchant’s Representations
FoodnPals shall neither be liable for the actions or omissions of the Merchant nor you regarding the provision of the Services. FoodnPals does not assume any liability for the quantity, quality, condition, or other representations of the Services provided by Merchants or guarantee the accuracy or completeness of the information (including menu information, photographs, and images of the Goods) displayed on the Merchant’s listing/offering on the Platform. Nothing in this Agreement shall exclude the Merchant’s liability for death or personal injury arising from the Merchant’s gross negligence or willful misconduct.
13.4 Merchant Liability
Merchants are solely responsible for the preparation, condition, and quality of Services sold to you. FoodnPals shall not be responsible or liable for any loss, damage, expense, cost, or fees arising from your contractual relationship with the Merchant.
14. Notice of Copyright Infringement
FoodnPals shall not be liable for any infringement of copyright arising out of materials posted on or transmitted through the Platform or items advertised on the Platform by end users or any other third parties. We respect the intellectual property rights of others and require those who use the Platform to do the same. We may, in appropriate circumstances and at our discretion, remove or disable access to material on the Platform that infringes upon the copyright rights of others. We also may, at our discretion, remove or disable links or references to an online location that contains infringing material or infringing activity. If any Users of the Platform repeatedly infringe on others' copyrights, we may, at our sole discretion, terminate those individuals' rights to use the Services.
15. Internet Delays
The Platform may be subject to limitations, delays, and other problems inherent in using the Internet and electronic communications. FoodnPals is not responsible for any delays, delivery failures, damage, loss, injury, or other economic damage resulting from such problems.
16. Termination
If you violate this Agreement, FoodnPals may respond based on several factors, including, but not limited to, the egregiousness of your actions and whether a pattern of harmful behavior exists. In addition, at its sole discretion, FoodnPals may modify or discontinue the Platform or modify, suspend, or terminate your access to the Platform for any reason, with or without notice to you and without liability to you or any third party. In addition to suspending or terminating your access to the Platform, FoodnPals reserves the right to take appropriate legal action, including, without limitation, pursuing civil, criminal, or injunctive redress. Even after your right to use the Platform is terminated, this Agreement will remain enforceable against you. All provisions, which by their nature should survive to give effect to those provisions, shall survive the termination of this Agreement.

17. Severability
If any provision of this Agreement is found to be invalid by any court having competent jurisdiction, the invalidity of such provision shall not affect the validity of the remaining provisions of this Agreement, which shall remain in full force and effect. No waiver of any provision in this Agreement shall be deemed a further or continuing waiver of such provision or any other provision.
18. Personal Data (Personal Information) Protection
You agree and consent to FoodnPals collecting, using, processing, and disclosing your Personal Data in accordance with this Agreement and as further described in our Privacy Policy. Our Privacy Policy is incorporated by reference herein and accessible here (www.foodnpals.com/privacypolicy/) or via the links on our Platform.
19. Prevailing Language
In the event of a dispute as to this Agreement, the English version shall prevail. The English language version of this Agreement shall control in all respects and shall prevail in case of any inconsistencies with translated versions.

20. Contact Information
If you wish to contact us regarding any questions or comments you may have, please reach out to us via the Help Center available on the Platform or by emailing us at support@foodnpals.com.  </p>
  </div>
</div>


  <button
    style="width: 100%; max-width: 300px; height: 40px; background: #4CBB17; display: block; margin: 20px auto;"
    type="submit" class="btn btn-primary btn-block">
    Sign Up
  </button>

  <!-- Hidden fields without causing extra space -->
  <div style="position: absolute; visibility: hidden; height: 0; overflow: hidden;">
    <div class="form-row">
      <div class="form-group">
        <label for="Allergies">Allergies</label>
        <input type="text" class="form-control" id="Allergies" name="Allergies" placeholder="List your allergies">
      </div>
      <div class="form-group">
        <label for="PreferredCuisine">Preferred Cuisine</label>
        <input type="text" class="form-control" id="PreferredCuisine" name="PreferredCuisine" placeholder="Italian, Chinese, etc.">
      </div>
      <div class="form-group">
      <label for="Username">Username</label>
      <input type="text" class="form-control" id="Username" name="Username" placeholder="username123">
    </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="Address">Address</label>
        <input type="text" class="form-control" id="Address" name="Address" placeholder="Your address" >
      </div>
      <div class="form-group">
        <label for="Location">Location</label>
        <input readonly type="text" class="form-control" id="Location" name="Location" placeholder="City or Area">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="DateOfBirth">Date of Birth</label>
        <input type="date" class="form-control" id="DateOfBirth" name="DateOfBirth" >
      </div>
      <div class="form-group">
        <label for="DietaryPreferences">Dietary Preferences</label>
        <input type="text" class="form-control" id="DietaryPreferences" name="DietaryPreferences" placeholder="Vegan, Vegetarian, etc.">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="Longitude">Longitude</label>
        <input type="text" class="form-control" id="Longitude" name="Longitude" placeholder="Longitude (optional)">
      </div>
      <div class="form-group">
        <label for="Latitude">Latitude</label>
        <input type="text" class="form-control" id="Latitude" name="Latitude" placeholder="Latitude (optional)">
      </div>
    </div>
    <div class="form-group">
    <label for="ProfilePicture">Profile Picture</label>
    <input type="file" class="form-control-file" id="ProfilePicture" name="ProfilePicture">
  </div>

  </div>

</form>


            <!-- <div class="text-center mt-3">
                Already have an account? <a style=" color: #4CBB17;" href="Login.html">Login</a>
              </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const submitButton = document.querySelector('button[type="submit"]');
      const termsContainer = document.querySelector('.form-row > div > div[style*="max-height"]');
      const scrollMessage = document.getElementById('termsScrollMessage');
      const scrollIndicator = document.querySelector('.scroll-indicator');
      const scrollPercentage = document.getElementById('scrollPercentage');
      let hasScrolledToBottom = false;

      // Disable the submit button by default
      submitButton.disabled = true;
      submitButton.innerHTML = "Please read Terms & Conditions";

      // Show scroll indicator when user starts scrolling
      termsContainer.addEventListener('scroll', function() {
        scrollIndicator.style.display = 'block';
        
        const scrollableHeight = termsContainer.scrollHeight - termsContainer.clientHeight;
        const currentScroll = termsContainer.scrollTop;
        const scrollPercentageValue = Math.round((currentScroll / scrollableHeight) * 100);
        
        scrollPercentage.textContent = scrollPercentageValue + '%';

        // Check if scrolled to bottom (with a small threshold)
        if (scrollableHeight - currentScroll <= 5) {
          hasScrolledToBottom = true;
          scrollMessage.style.color = '#28a745';
          scrollMessage.textContent = 'Thank you for reading the Terms and Conditions';
          submitButton.disabled = false;
          submitButton.innerHTML = "Sign Up";
        }
      });

      // Prevent form submission if hasn't scrolled
      document.querySelector('form').addEventListener('submit', function(e) {
        if (!hasScrolledToBottom) {
          e.preventDefault();
          scrollMessage.style.color = '#dc3545';
          scrollMessage.textContent = 'Please scroll through entire Terms and Conditions to proceed';
          termsContainer.style.borderColor = '#dc3545';
          setTimeout(() => {
            termsContainer.style.borderColor = '#ccc';
          }, 2000);
        }
      });
    });
  </script>

<script>
  // Function to extract query parameters
  function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  // Populate the email input field on page load
  document.addEventListener("DOMContentLoaded", () => {
    const email = getQueryParam('email'); // Get 'email' parameter from the URL
    if (email) {
      document.getElementById('Email').value = decodeURIComponent(email);
      document.getElementById('Username').value = decodeURIComponent(email);
    }
  });
</script>
<script>
flatpickr("#DOB", {
  dateFormat: "Y-m-d",
  maxDate: new Date().fp_incr(-6570), // 18 years ago
  minDate: "1920-01-01",
  altInput: true,
  altFormat: "F j, Y",
  defaultDate: "1995-01-01",
  disableMobile: false // force Flatpickr on mobile too
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('signupForm');
  const submitButton = document.querySelector('button[type="submit"]');
  const termsContainer = document.querySelector('.form-row > div > div[style*="max-height"]');
  const scrollMessage = document.getElementById('termsScrollMessage');
  const scrollIndicator = document.querySelector('.scroll-indicator');
  const scrollPercentage = document.getElementById('scrollPercentage');
  let hasScrolledToBottom = false;

  // Handle terms container scroll
  termsContainer.addEventListener('scroll', function() {
    scrollIndicator.style.display = 'block';
    
    const scrollableHeight = termsContainer.scrollHeight - termsContainer.clientHeight;
    const currentScroll = termsContainer.scrollTop;
    const scrollPercentageValue = Math.round((currentScroll / scrollableHeight) * 100);
    
    scrollPercentage.textContent = scrollPercentageValue + '%';

    // Check if scrolled to bottom (with a small threshold)
    if (scrollableHeight - currentScroll <= 5) {
      hasScrolledToBottom = true;
      scrollMessage.style.color = '#28a745';
      scrollMessage.textContent = 'Thank you for reading the Terms and Conditions';
      submitButton.disabled = false;
      submitButton.innerHTML = "Sign Up";
    }
  });
  
  form.addEventListener('submit', function(event) {
    event.preventDefault();

    // Check if terms have been scrolled
    if (!hasScrolledToBottom) {
      scrollMessage.style.color = '#dc3545';
      scrollMessage.textContent = 'Please scroll through entire Terms and Conditions to proceed';
      termsContainer.style.borderColor = '#dc3545';
      setTimeout(() => {
        termsContainer.style.borderColor = '#ccc';
      }, 2000);
      return;
    }

    // Check form validity
    if (!form.checkValidity()) {
      return;
    }

    // Submit form via AJAX
    const formData = new FormData(form);
    fetch('add_customer.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          title: 'Success!',
          text: data.message,
          icon: 'success',
          confirmButtonText: 'OK',
          confirmButtonColor: '#4CBB17'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = data.redirect;
          }
        });
      } else {
        Swal.fire({
          title: 'Error!',
          text: data.message,
          icon: 'error',
          confirmButtonText: 'OK',
          confirmButtonColor: '#4CBB17'
        }).then((result) => {
          if (result.isConfirmed && data.redirect) {
            window.location.href = data.redirect;
          }
        });
      }
    })
    .catch(error => {
      console.error('Error:', error);
      Swal.fire({
        title: 'Error!',
        text: 'An unexpected error occurred. Please try again.',
        icon: 'error',
        confirmButtonText: 'OK',
        confirmButtonColor: '#4CBB17'
      });
    });
  });
});
</script>

</body>

</html>