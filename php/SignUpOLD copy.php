<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodnPals - Login</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Custom CSS for logo and form centering */
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            height: 20px;
            /* Adjust the height as needed */
            width: 20px;
            /* Adjust the width as needed */
        }


        .form-container {
            padding-top: 8%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* Align form content to the left */
            justify-content: center;
            height: 100%;
        }

        /* Custom styling for the login button and right div background */
        .left-div {
            height: 700px;
            background-image: url('images/fleft.png');
            /* Relative path to the image */
            background-size: cover;
            background-position: center;
        }

        @media only screen and (max-width: 600px) {
            .left-div {
                height: 400px;
            }
        }

        .right-inner {
            padding-left: 15%;
        }

        .login-btn {
            background: linear-gradient(to bottom, #7367F0 50%, #7367F1 90%);
            color: white;
            /* Text color on the gradient background */
            width: 100%;
        }

        .container {
            height: 1000px;
            width: 100%;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            padding-left: 40px;
            /* Add space for the icon */
        }

        .form-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            font-size: 20px;
        }

        .new-account {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .new-account .create-account {
            color: linear-gradient(to bottom, #7367F0 100%, #7367F0 70%);
            padding: 5px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .new-account .forgot-password {
            color: linear-gradient(to bottom, #7367F0 100%, #7367F0 70%);
            padding: 5px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 left-div">
                <div class="logo-container">
                    <img style="height:75px; width:100;" src="images/flogo.png" alt="Logo">
                    <!-- <h1>Food & Pals</h1> -->
                </div>

            </div>
            <div class="col-md-5 right-div">
                <div class="form-container right-inner">
                    <h2 style="text-align: left;">Customer Sign Up</h2>
                    <br>
                    <form style="width:70%; ">
                        <div class="form-group loginform">
                            <input type="text" class="form-control" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-group loginform">
                            <input type="text" class="form-control" id="Username" placeholder="Username" required>
                        </div>
                        <div class="form-group loginform">
                            <input type="password" class="form-control" id="password" placeholder="Password" required>
                        </div>
                        <div class="form-group loginform">
                            <input type="password" class="form-control" id="password2" placeholder="Re-Enter Password" required>
                        </div>
                        <div class="form-group loginform">
                            <input type="text" class="form-control" id="Contact" placeholder="Contact" required>
                        </div>
                        <div class="form-group loginform">
                            <input type="text" class="form-control" id="coordinates" placeholder="Coordinates" required>
                        </div>
                        <div class="form-group loginform">
                            <select id="Loation" name="Loation" class="form-control" required>
                                <option value="Select">Select City</option>
                                <option value="Albuquerque">Albuquerque</option>
                                <option value="Anaheim">Anaheim</option>
                                <option value="Anchorage">Anchorage</option>
                                <option value="Arlington">Arlington</option>
                                <option value="Atlanta">Atlanta</option>
                                <option value="Aurora">Aurora</option>
                                <option value="Austin">Austin</option>
                                <option value="Bakersfield">Bakersfield</option>
                                <option value="Baltimore">Baltimore</option>
                                <option value="Boston">Boston</option>
                                <option value="Charlotte">Charlotte</option>
                                <option value="Chicago">Chicago</option>
                                <option value="Cleveland">Cleveland</option>
                                <option value="Colorado Springs">Colorado Springs</option>
                                <option value="Columbus">Columbus</option>
                                <option value="Dallas">Dallas</option>
                                <option value="Denver">Denver</option>
                                <option value="Detroit">Detroit</option>
                                <option value="El Paso">El Paso</option>
                                <option value="Fort Worth">Fort Worth</option>
                                <option value="Fresno">Fresno</option>
                                <option value="Honolulu">Honolulu</option>
                                <option value="Houston">Houston</option>
                                <option value="Indianapolis">Indianapolis</option>
                                <option value="Jacksonville">Jacksonville</option>
                                <option value="Kansas City">Kansas City</option>
                                <option value="Las Vegas">Las Vegas</option>
                                <option value="Los Angeles">Los Angeles</option>
                                <option value="Louisville">Louisville</option>
                                <option value="Memphis">Memphis</option>
                                <option value="Mesa">Mesa</option>
                                <option value="Miami">Miami</option>
                                <option value="Milwaukee">Milwaukee</option>
                                <option value="Minneapolis">Minneapolis</option>
                                <option value="Nashville">Nashville</option>
                                <option value="New Orleans">New Orleans</option>
                                <option value="New York">New York</option>
                                <option value="Oakland">Oakland</option>
                                <option value="Oklahoma City">Oklahoma City</option>
                                <option value="Omaha">Omaha</option>
                                <option value="Philadelphia">Philadelphia</option>
                                <option value="Phoenix">Phoenix</option>
                                <option value="Portland">Portland</option>
                                <option value="Raleigh">Raleigh</option>
                                <option value="Sacramento">Sacramento</option>
                                <option value="Salt Lake City">Salt Lake City</option>
                                <option value="San Antonio">San Antonio</option>
                                <option value="San Diego">San Diego</option>
                                <option value="San Francisco">San Francisco</option>
                                <option value="San Jose">San Jose</option>
                                <option value="Seattle">Seattle</option>
                                <option value="Tampa">Tampa</option>
                                <option value="Tucson">Tucson</option>
                                <option value="Tulsa">Tulsa</option>
                                <option value="Virginia Beach">Virginia Beach</option>
                                <option value="Washington">Washington</option>
                                <option value="Wichita">Wichita</option>

                            </select>
                        </div>


                        <button type="button" onclick="redirectToDashboard()" class="btn login-btn">Sign Up</button>

                        <div class="new-account">
                            <a class="create-account" href="index.php">Already have account? Sign in</a>
                        </div>
                    </form>
                    <div class="new-account">
                        <p>Or sign in with</p>
                    </div>
                    <table style="border-collapse: collapse; width: 70%;">
                        <tr>
                            <td> <button type="button" class="btn btn-lg social facebook" style="margin-bottom: 4px">
                                    <i class="fa fa-facebook"></i>
                                </button></td>
                            <td>
                                <button type="button" class="btn btn-lg social twitter" style="margin-bottom: 4px">
                                    <i class="fa fa-twitter"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-lg social google-plus" style="margin-bottom: 4px">
                                    <i class="fa fa-google-plus"></i>
                                </button>
                            </td>
                        </tr>
                    </table>



                </div>
            </div>
        </div>
        <br>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function redirectToDashboard() {
            // Use the window.location.href property to redirect to dashboard.html



            // Get the values of the email and password inputs
            var emailInput = document.getElementById("email").value;
            var passwordInput = document.getElementById("password").value;

            // Check if the email and password meet the specified conditions
            // Redirect to dashboard.html
            window.location.href = "dashboard.php";
            //  alert("valid email or password");
        }
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            showCoordinates();
        });

        function showCoordinates() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    document.getElementById('coordinates').value = latitude + ', ' + longitude;
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }
    </script>

</body>

</html>