<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

  <title>Sign Up - FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks&libraries=places"></script>
  <style>
    body, html {
      height: 100%;
      background:linear-gradient(135deg,rgb(167, 240, 167) 0%, #c3cfe2 100%);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .bg-image {
      min-height: 100vh;
      padding: 40px 0;
      background: linear-gradient(135deg,rgb(167, 240, 167) 0%, #c3cfe2 100%);
    }

    .login-container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-form {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 800px;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
    }

    .form-grid .form-group {
      margin: 0;
    }

    .form-grid .form-group.full-width {
      grid-column: 1 / -1;
    }

    @media (max-width: 768px) {
      .login-form {
        padding: 25px;
      }

      .form-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }
    }

    .login-form h2 {
      color: #1a1a1a;
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
      text-align: center;
    }

    .text-muted {
      color: #65676b !important;
      font-size: 13px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      color: #1a1a1a;
      font-size: 14px;
      font-weight: 500;
    }

    .help-icon {
      color: #4CBB17;
      font-size: 14px;
      margin-left: 4px;
      cursor: help;
      opacity: 0.8;
      transition: all 0.2s ease;
    }

    .help-icon:hover {
      opacity: 1;
      transform: scale(1.1);
    }

    /* Custom tooltip style */
    .tooltip {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .tooltip-inner {
      background-color: #2d3748;
      color: #fff;
      border-radius: 6px;
      padding: 8px 12px;
      font-size: 13px;
      max-width: 250px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-control {
      width: 100%;
      padding: 8px 12px;
      font-size: 15px;
      border: 1px solid #dddfe2;
      border-radius: 6px;
      background: #fff;
      color: #1a1a1a;
    }

    .form-control:focus {
      border-color: #1877f2;
      box-shadow: 0 0 0 2px #e7f3ff;
      outline: none;
    }

    .form-control::placeholder {
      color: #8e8e8e;
    }

    .form-check {
      margin: 15px 0;
    }

    .form-check-input {
      margin-right: 8px;
    }

    .form-check-label {
      font-size: 14px;
      color: #1a1a1a;
      display: inline-flex;
      align-items: center;
    }

    .form-check-label a {
      color: #1877f2;
      text-decoration: none;
      margin-left: 4px;
      font-weight: 500;
    }

    .form-check-label a:hover {
      text-decoration: underline;
    }

    .btn-primary {
      width: 100%;
      padding: 12px 24px;
      font-size: 16px;
      font-weight: 600;
      color: white;
      background: #1877f2;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      margin-top: 10px;
    }

    .btn-primary:hover:not(:disabled) {
      background: #166fe5;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(24, 119, 242, 0.15);
    }

    .btn-primary:active:not(:disabled) {
      transform: translateY(0);
    }

    .btn-primary:disabled {
      background: #e4e6eb;
      color: #bcc0c4;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    /* Form field enhancements */
    .form-control {
      height: 48px;
      font-size: 16px;
      transition: all 0.2s ease;
    }

    .form-control:focus {
      transform: translateY(-1px);
      box-shadow: 0 2px 8px rgba(24, 119, 242, 0.1);
    }

    /* Simple validation styles */
    .form-control.is-valid {
      border-color: #42b72a;
      background-color: #f8fff8;
    }

    .form-control.is-invalid {
      border-color: #ff4d4f;
      background-color: #fff8f8;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .login-form {
        max-width: 600px;
        padding: 30px;
      }
    }

    @media (max-width: 576px) {
      .bg-image {
        padding: 20px 0;
      }

      .login-container {
        padding: 0 15px;
      }

      .login-form {
        padding: 20px;
        margin: 10px;
      }

      .form-control {
        height: 44px;
      }

      .btn-primary {
        padding: 10px 20px;
      }
    }

    /* Animation for form elements */
    .form-control, .btn-primary {
      will-change: transform;
    }

    .form-group {
      opacity: 0;
      animation: fadeInUp 0.4s ease forwards;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Stagger the animations */
    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }
    .form-group:nth-child(4) { animation-delay: 0.4s; }
    .form-group:nth-child(5) { animation-delay: 0.5s; }
    .form-group:nth-child(6) { animation-delay: 0.6s; }
    .form-group:nth-child(7) { animation-delay: 0.7s; }
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
    <div class="login-container">
      <div class="login-form">
        <h2>Create Account</h2>
        <p class="text-muted text-center">Fields marked with * are required</p>

        <form id="signupForm" action="add_customer.php" method="POST" enctype="multipart/form-data">
          <div class="form-grid">
            <div class="form-group">
              <label for="FirstName">
                First Name * 
                <i class="fa fa-question-circle help-icon" data-toggle="tooltip" title="Enter your legal first name as it appears on official documents"></i>
              </label>
              <input 
                type="text" 
                class="form-control" 
                id="FirstName" 
                name="FirstName" 
                placeholder="Enter your first name" 
                value="<?= isset($_COOKIE['FirstName']) ? htmlspecialchars($_COOKIE['FirstName']) : '' ?>" 
                required>
            </div>

            <div class="form-group">
              <label for="LastName">
                Last Name * 
                <i class="fa fa-question-circle help-icon" data-toggle="tooltip" title="Enter your legal last name as it appears on official documents"></i>
              </label>
              <input 
                type="text" 
                class="form-control" 
                id="LastName" 
                name="LastName" 
                placeholder="Enter your last name" 
                value="<?= isset($_COOKIE['LastName']) ? htmlspecialchars($_COOKIE['LastName']) : '' ?>" 
                required>
            </div>

            <div class="form-group">
              <label for="Email">
                Email * 
                <i class="fa fa-question-circle help-icon" data-toggle="tooltip" title="This will be your primary contact email and cannot be changed"></i>
              </label>
              <input 
                readonly 
                type="email" 
                class="form-control" 
                id="Email" 
                name="Email" 
                placeholder="Enter your email" 
                value="<?= isset($_COOKIE['Email']) ? htmlspecialchars($_COOKIE['Email']) : '' ?>" 
                required>
            </div>

            <div class="form-group">
              <label for="PhoneNumber">
                Phone Number * 
                <i class="fa fa-question-circle help-icon" data-toggle="tooltip" title="Enter a valid phone number for order updates and notifications"></i>
              </label>
              <input 
                type="tel" 
                class="form-control" 
                id="PhoneNumber" 
                name="PhoneNumber" 
                placeholder="Enter your phone number" 
                value="<?= isset($_COOKIE['PhoneNumber']) ? htmlspecialchars($_COOKIE['PhoneNumber']) : '' ?>" 
                required>
            </div>

            <div class="form-group full-width">
              <label for="BirthYear">
                Year of Birth * 
                <i class="fa fa-question-circle help-icon" data-toggle="tooltip" title="Must be at least 12 years old to register"></i>
              </label>
              <input 
                type="number" 
                class="form-control" 
                id="BirthYear" 
                name="BirthYear" 
                min="1900" 
                max="<?= date('Y') - 18 ?>" 
                placeholder="Enter your birth year" 
                value="<?= isset($_COOKIE['BirthYear']) ? htmlspecialchars($_COOKIE['BirthYear']) : '' ?>" 
                required>
            </div>

            <input type="hidden" id="DateOfBirth" name="DateOfBirth">
            <input type="hidden" id="Latitude" name="Latitude">
            <input type="hidden" id="Longitude" name="Longitude">

            <div class="form-group full-width">
              <div class="form-check mb-2">
                <div id="termsScrollMessage" style="color: #dc3545;">Please scroll through entire <a href="Terms.php" target="_blank" style="color: #4CBB17;">Terms and Conditions</a> to proceed</div>
              </div>

              <!-- Scrollable Terms and Conditions Box with Scroll Indicator -->
              <div class="position-relative">
                <div class="scroll-indicator" style="position: absolute; right: 10px; top: 10px; background: rgba(255,255,255,0.9); padding: 5px 10px; border-radius: 15px; font-size: 12px; display: none;">
                  <span id="scrollPercentage">0%</span> scrolled
                </div>
                <div id="termsContainer" style="
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
                ">
                  <strong>Terms and Conditions</strong>
                  <p>
Please read these consumer terms and conditions carefully. These consumer terms and conditions ("Agreement," "Terms and Conditions," or "Terms") defined below constitute a legal agreement between you and FoodnPals.

1. FoodnPals
This section outlines who we are, how our platform operates, and the role we play in facilitating transactions and information sharing between Users and Merchants.
1.1 Who we are FoodnPals operates an online marketplace and connection platform to:
(a) broker the exchange of goods and services among you and other consumers, restaurants, and other businesses ("Merchants"), and
(b) provide you with access to information on the "Services." FoodnPals is not a merchant, retailer, restaurant, delivery service, or food preparation business.
1.2 What we do
The "Services" we provide or make available include:
(a) the Platform,
(b) booking table(s) for fine-dining ("Booking").
When you book a table, FoodnPals acts as a facilitator on behalf of that Merchant to facilitate, process, and conclude the Booking.

2. Application of this Agreement This Agreement governs your access to and use of the website, web portal, and mobile applications provided by FoodnPals and is between you and FoodnPals (or referred to as "we" or "us") (collectively the "Platform").

3. Acceptance of this Agreement If you access our website located at www.foodnpals.com/ and access or use any information, function, feature, or service made available or enabled by FoodnPals ("Services"), click or tap a button or take similar action to signify your affirmative acceptance of this Agreement, or complete the FoodnPals account registration process, you, your heirs, assigns, and successors (collectively "you" or "your") hereby present and warrant that:
(a) you have read, understood, and agreed to be bound by this Agreement,
(b) you are of legal age in the jurisdiction in which you reside to form a legally binding contract with FoodnPals, and
(c) you have the authority to enter into the Agreement personally and, if applicable, on behalf of any corporate legal entity for whom you have created an account or been named as the "User" during the FoodnPals account registration process and to bind such organization to the Agreement. Users below the legal age must obtain consent from parent(s) or legal guardian(s), who by accepting this Agreement shall agree to take responsibility for your actions and any charges associated with your use of the Platform. If you do not have consent from your parent(s) or legal guardian(s), you must stop using/accessing the Platform immediately.

[... Rest of the terms and conditions ...]</p>
                </div>
              </div>
            </div>

            <div class="form-group full-width">
              <button style="background-color: #4CBB17;" type="submit" class="btn btn-primary btn-lg btn-block" disabled>Please read Terms & Conditions</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

    <div style="visibility:hidden;" class="form-row">
        <div style="visibility:hidden;" class="form-group">
            <label for="Password">Password</label>
            <input 
                type="password" 
                class="form-control" 
                value="" 
                id="Password" 
                name="Password" 
                placeholder="Enter password" 
                required>
        </div>
        <div  class="form-group">
            <label for="Username">Username</label>
            <input 
                type="text" 
                class="form-control" 
                id="Username" 
                name="Username" 
                placeholder="username123" 
                value="<?= isset($_COOKIE['Email']) ? htmlspecialchars($_COOKIE['Email']) : '' ?>" 
                required>
        </div>
    </div>

    <div style="visibility:hidden;" class="form-row">
        <div class="form-group">
            <label for="Longitude">Longitude</label>
            <input 
                readonly 
                type="text" 
                class="form-control" 
                id="Longitude" 
                name="Longitude" 
                placeholder="Longitude (optional)" 
                value="<?= isset($_COOKIE['Longitude']) ? htmlspecialchars($_COOKIE['Longitude']) : '' ?>">
        </div>
        <div class="form-group">
            <label for="Latitude">Latitude</label>
            <input 
                readonly 
                type="text" 
                class="form-control" 
                id="Latitude" 
                name="Latitude" 
                placeholder="Latitude (optional)" 
                value="<?= isset($_COOKIE['Latitude']) ? htmlspecialchars($_COOKIE['Latitude']) : '' ?>">
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
      const form = document.querySelector('form');
      const submitButton = document.querySelector('button[type="submit"]');
      const birthYearInput = document.getElementById('BirthYear');
      const dateOfBirthInput = document.getElementById('DateOfBirth');
      const phoneInput = document.getElementById('PhoneNumber');
      const termsContainer = document.getElementById('termsContainer');
      const scrollMessage = document.getElementById('termsScrollMessage');
      const scrollIndicator = document.querySelector('.scroll-indicator');
      const scrollPercentage = document.getElementById('scrollPercentage');
      let hasScrolledToBottom = false;

      // Terms and conditions are now loaded directly in the HTML

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
          submitButton.innerHTML = "Create Account";
        }
      });

      // Handle birth year
      birthYearInput.addEventListener('change', function() {
        if (this.value) {
          dateOfBirthInput.value = `${this.value}-01-01`;
        }
      });

      // Format phone number
      phoneInput.addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : `${x[1]}-${x[2]}${x[3] ? `-${x[3]}` : ''}`;
      });

      // Form validation and submission
      form.addEventListener('submit', function(event) {
        event.preventDefault();

        if (!hasScrolledToBottom) {
          scrollMessage.style.color = '#dc3545';
          scrollMessage.textContent = 'Please scroll through entire Terms and Conditions to proceed';
          termsContainer.style.borderColor = '#dc3545';
          setTimeout(() => {
            termsContainer.style.borderColor = '#ccc';
          }, 2000);
          return;
        }

        if (!form.checkValidity()) {
          const firstInvalid = form.querySelector(':invalid');
          if (firstInvalid) {
            firstInvalid.focus();
          }
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
    }
  });
</script>

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Google Places Autocomplete
    var locationInput = document.getElementById('Location');
    var autocomplete = new google.maps.places.Autocomplete(locationInput, {
        types: ['geocode'],
        componentRestrictions: { country: ['us'] } // Restrict to US addresses, remove or modify for other countries
    });

    // Handle place selection
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        
        if (!place.geometry) {
            console.log("No location details available for input: '" + place.name + "'");
            return;
        }

        // Get latitude and longitude
        document.getElementById('Latitude').value = place.geometry.location.lat();
        document.getElementById('Longitude').value = place.geometry.location.lng();

        // Format the address
        var formattedAddress = '';
        if (place.address_components) {
            var components = {
                street_number: '',
                route: '',
                locality: '',
                administrative_area_level_1: '',
                postal_code: ''
            };

            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (components.hasOwnProperty(addressType)) {
                    components[addressType] = place.address_components[i].long_name;
                }
            }

            // Format the address
            if (components.street_number && components.route) {
                formattedAddress = components.street_number + ' ' + components.route;
            }
            if (components.locality) {
                formattedAddress += (formattedAddress ? ', ' : '') + components.locality;
            }
            if (components.administrative_area_level_1) {
                formattedAddress += (formattedAddress ? ', ' : '') + components.administrative_area_level_1;
            }
            if (components.postal_code) {
                formattedAddress += ' ' + components.postal_code;
            }

            // Update the Address field if it exists
            var addressField = document.getElementById('Address');
            if (addressField) {
                addressField.value = formattedAddress;
            }
        }
    });

    // Prevent form submission on enter key in location field
    locationInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
});
</script>

</body>

</html>