<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); ?>
    <meta charset="UTF-8">
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

    <title>FoodnPals - Payment Setup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/banner.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .payment-container {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        .payment-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .payment-header h2 {
            color: #333;
            font-weight: 600;
        }
        
        .payment-header p {
            color: #666;
            margin-top: 10px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 187, 23, 0.4);
        }
        
        .card-element {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        
        .progress-bar-bg {
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #e9ecef;
            z-index: 1;
        }
        
        .progress-bar-fill {
            position: absolute;
            top: 15px;
            left: 0;
            width: 66.6%;
            height: 3px;
            background-color: #4CBB17;
            z-index: 2;
        }
        
        .step {
            position: relative;
            z-index: 3;
            text-align: center;
        }
        
        .step-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        
        .step.active .step-icon {
            background-color: #4CBB17;
            color: white;
        }
        
        .step.inactive .step-icon {
            background-color: #e9ecef;
            color: #6c757d;
        }
        
        .step-label {
            font-size: 12px;
            margin-top: 5px;
        }
        
        .step.active .step-label {
            color: #4CBB17;
            font-weight: 500;
        }
        
        .step.inactive .step-label {
            color: #6c757d;
        }
        
        .security-info {
            display: flex;
            align-items: center;
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        
        .security-info i {
            font-size: 24px;
            color: #4CBB17;
            margin-right: 15px;
        }
        
        .security-info p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body style="margin:0px; padding:0px; background-color: #f8f9fa;">
    <?php include 'fetch_cookies.php' ?>
    
    <?php
    // Check if reservation data exists in session
    if (!isset($_SESSION['reservation_data'])) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No reservation data found. Please try again.',
                confirmButtonColor: '#4CBB17'
            }).then(() => {
                window.location.href = 'Home.php';
            });
        </script>";
        exit;
    }
    
    $restaurantID = $_GET['restaurant'] ?? $_SESSION['reservation_data']['restaurantID'];
    
    // Get restaurant name
    include 'creds.php';
    $sql = "SELECT Name FROM restaurants WHERE RestaurantID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $restaurantID);
    $stmt->execute();
    $result = $stmt->get_result();
    $restaurantName = "Restaurant";
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $restaurantName = $row['Name'];
    }
    $stmt->close();
    $conn->close();
    ?>
    
    <div class="container-fluid p-3" style="position: fixed; top: 0; left: 0; width: 100%; z-index: 1000; background-color: white; justify-content: space-between; flex-wrap: wrap; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <!-- Logo -->
        <a href="Home.php" class="" style="flex-shrink: 0; max-width:50%;">
            <img src="Resources/logo.png" alt="Location" class="img-fluid" style="width: 160px;">
        </a>
    </div>
    
    <div class="container" style="margin-top: 100px;">
        <div class="payment-container">
            <div class="progress-steps">
                <div class="progress-bar-bg"></div>
                <div class="progress-bar-fill"></div>
                
                <div class="step active">
                    <div class="step-icon">
                        <i class="fas fa-check" style="font-size: 12px;"></i>
                    </div>
                    <div class="step-label">Table Selected</div>
                </div>
                
                <div class="step active">
                    <div class="step-icon">
                        <i class="fas fa-credit-card" style="font-size: 12px;"></i>
                    </div>
                    <div class="step-label">Payment Setup</div>
                </div>
                
                <div class="step inactive">
                    <div class="step-icon">
                        <i class="fas fa-check-circle" style="font-size: 12px;"></i>
                    </div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>
            
            <div class="payment-header">
                <h2>Payment Information</h2>
                <p>Please provide your card details for booking guarantee</p>
            </div>
            
            <form id="payment-form">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="card-element">Card Information</label>
                        <div id="card-element" class="card-element"></div>
                        <div id="card-errors" class="error-message" role="alert"></div>
                    </div>
                </div>
                
                <div class="security-info">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <p><strong>Booking Guarantee Policy</strong></p>
                        <p>Your card will be securely stored and will only be charged $30 in case of a no-show. No charges will be made for successful attendance.</p>
                    </div>
                </div>
                
                <div class="text-center">
                    <button id="submit-button" type="submit" class="btn btn-primary">
                        <i class="fas fa-lock mr-2"></i> Secure & Complete Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Initialize Stripe
        const stripe = Stripe("pk_test_51RSL3zKylmRSpfKAmTcwDYU9EnNbge6U6eQMQtao8xwGkGMZDqZn9acTN4PSgSya7K8kh3HrjsbxeEHEanR5PyZH00bQzJ3iTm");
        const elements = stripe.elements();
        
        // Create card Element and mount it
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
                invalid: {
                    color: '#dc3545',
                    iconColor: '#dc3545',
                },
            },
        });
        cardElement.mount('#card-element');
        
        // Handle form submission
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            // Disable the submit button to prevent multiple clicks
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            
            try {
                // Create a payment method
                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                });
                
                if (error) {
                    // Show error to customer
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-lock mr-2"></i> Secure & Complete Booking';
                    return;
                }
                
                // Send payment method ID to server
                const response = await fetch('save_payment_method.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `paymentMethodId=${paymentMethod.id}`,
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Create the actual reservation
                    window.location.href = 'finalize_reservation.php';
                } else {
                    // Show error
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Error',
                        text: result.message || 'An error occurred while processing your payment method.',
                        confirmButtonColor: '#4CBB17'
                    });
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-lock mr-2"></i> Secure & Complete Booking';
                }
            } catch (err) {
                console.error('Error:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: 'An unexpected error occurred. Please try again.',
                    confirmButtonColor: '#4CBB17'
                });
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-lock mr-2"></i> Secure & Complete Booking';
            }
        });
    </script>
    
    <?php include 'footer.php'; ?>
</body>
</html> 