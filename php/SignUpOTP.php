<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body,
    html {
      height: 100%;
    }

    .bg-image {
      background-image: url('Resources/banner1.png');
      height: 100%;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
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

  

</head>

<body>

  <div class="bg-image">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3 col-md-12 offset-md-2 login-container">
          <div class="login-form" style=" justify-content: center; align-items: center;">
            <h2 class=" mb-4">Create Account</h2>
            <!-- <label>Sign up or log in to continue</label> -->

            <form action="SignUp2.php" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: auto;">
              <div class="form-row">
                <label for="OTP">Enter OTP Sent to your Email</label>
                <input type="text" class="form-control" id="OTP" name="OTP" placeholder="000000" required>
              </div>

              <button
                style="width: 100%; max-width: 300px; height: 40px; background: #4CBB17; display: block; margin: 20px auto;"
                type="submit" class="btn btn-primary btn-block">
                Verify
              </button>
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

</body>

</html>