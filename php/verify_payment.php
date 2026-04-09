<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); ?>
    <meta charset="UTF-8">
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

    <title>FoodnPals - Verify Payment</title>
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
        
        .btn-primary {
            background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            margin-top: 20px;

            transition: all 0.3s ease;
        }
        
        .btn-secondary {
            background: #f1f2f3;
            color: #666;
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
        
        .card-info {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #eee;
        }
        
        .card-brand-icon {
            font-size: 24px;
            margin-right: 10px;
            vertical-align: middle;
        }
        
        .visa {
            color: #1A1F71;
        }
        
        .mastercard {
            color: #EB001B;
        }
        
        .amex {
            color: #006FCF;
        }
        
        .discover {
            color: #FF6600;
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
    // Check if booking data and payment method exist in session
    if (!isset($_SESSION['reservation_data']) || !isset($_SESSION['existing_payment_method'])) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No booking data or payment method found. Please try again.',
                confirmButtonColor: '#4CBB17'
            }).then(() => {
                window.location.href = 'Home.php';
            });
        </script>";
        exit;
    }
    
    $restaurantID = $_GET['restaurant'] ?? $_SESSION['reservation_data']['restaurantID'];
    $paymentMethod = $_SESSION['existing_payment_method'];
    
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
    
    // Get card brand icon class
    $cardBrandIcon = "fa-credit-card";
    $cardBrandClass = "";
    
    switch(strtolower($paymentMethod['CardBrand'])) {
        case 'visa':
            $cardBrandIcon = "fa-cc-visa";
            $cardBrandClass = "visa";
            break;
        case 'mastercard':
            $cardBrandIcon = "fa-cc-mastercard";
            $cardBrandClass = "mastercard";
            break;
        case 'amex':
            $cardBrandIcon = "fa-cc-amex";
            $cardBrandClass = "amex";
            break;
        case 'discover':
            $cardBrandIcon = "fa-cc-discover";
            $cardBrandClass = "discover";
            break;
    }
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
                    <div class="step-label">Payment Verification</div>
                </div>
                
                <div class="step inactive">
                    <div class="step-icon">
                        <i class="fas fa-check-circle" style="font-size: 12px;"></i>
                    </div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>
            
            <div class="payment-header">
                <h2>Verify Payment Method</h2>
                <p>We found an existing payment method on file</p>
            </div>
            
            <div class="card-info">
                <h5><i class="fab <?php echo $cardBrandIcon; ?> card-brand-icon <?php echo $cardBrandClass; ?>"></i> Card ending in <?php echo htmlspecialchars($paymentMethod['Last4']); ?></h5>
                <p>Expires: <?php echo htmlspecialchars($paymentMethod['ExpMonth'] . '/' . $paymentMethod['ExpYear']); ?></p>
            </div>
            
            <div class="security-info">
                <i class="fas fa-shield-alt"></i>
                <div>
                    <p><strong>Booking Guarantee Policy</strong></p>
                    <p>Your card will only be charged $30 in case of a no-show. No charges will be made for successful attendance.</p>
                </div>
            </div>
            
            <div class="text-center" style="display: flex; justify-content: space-between; margin-top: 20px;">
                <button id="new-card-button" class="btn btn-secondary">
                    <i class="fas fa-plus-circle mr-2"></i> Use New Card
                </button>
                
                <button id="confirm-button" class="btn btn-primary">
                    <i class="fas fa-check-circle mr-2"></i> Use This Card
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Handle button clicks
        document.getElementById('new-card-button').addEventListener('click', function() {
            window.location.href = 'payment_setup.php?restaurant=<?php echo $restaurantID; ?>&new=1';
        });
        
        document.getElementById('confirm-button').addEventListener('click', function() {
            // Show loading state
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            
            // Verify payment method with Stripe and create reservation
            fetch('verify_existing_payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'payment_method_id=' + <?php echo json_encode($paymentMethod['PaymentMethodID']); ?> +
                      '&customer_id=' + <?php echo json_encode($paymentMethod['CustomerID']); ?>
            })
            .then(async (response) => {
                const text = await response.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    throw new Error('Non-JSON response: ' + text);
                }
                return result;
            })
            .then(result => {
                if (result.success) {
                    // Redirect to confirmation page
                    window.location.href = 'Confirmation.php?ID=' + result.reservationID;
                } else {
                    // Show error
                    Swal.fire({
                        icon: 'error',
                        title: 'Verification Error',
                        text: result.message || 'Could not verify payment method. Please try again or use a new card.',
                        confirmButtonColor: '#4CBB17'
                    }).then(() => {
                        // Reset button state
                        document.getElementById('confirm-button').disabled = false;
                        document.getElementById('confirm-button').innerHTML = '<i class="fas fa-check-circle mr-2"></i> Use This Card';
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: (error && error.message) ? error.message.substring(0, 300) : 'An unexpected error occurred. Please try again.',
                    confirmButtonColor: '#4CBB17'
                });
                // Reset button state
                document.getElementById('confirm-button').disabled = false;
                document.getElementById('confirm-button').innerHTML = '<i class="fas fa-check-circle mr-2"></i> Use This Card';
            });
        });
        
        // Automatically click 'Use This Card' after page load if card details are present
        window.addEventListener('DOMContentLoaded', function() {
            // Small delay to ensure everything is loaded properly
            setTimeout(function() {
                var confirmBtn = document.getElementById('confirm-button');
                if (confirmBtn) {
                    confirmBtn.click();
                }
            }, 500);
        });
    </script>
    
    <?php include 'footer.php'; ?>
</body>
</html> 