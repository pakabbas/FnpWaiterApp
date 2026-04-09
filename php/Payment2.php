<?php
include 'creds.php';

$planID = isset($_GET['PlanID']) ? (int)$_GET['PlanID'] : 0;
$plan = null;

if ($planID > 0) {
    $stmt = $conn->prepare("SELECT * FROM Plans WHERE PlanID = ?");
    $stmt->bind_param("i", $planID);
    $stmt->execute();
    $result = $stmt->get_result();
    $plan = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FoodnPals - Payment</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png" />
  <script src="https://js.stripe.com/v3/"></script>
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .payment-container {
      max-width: 600px;
      margin: 60px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
    }

    .payment-container h2 {
      margin-bottom: 30px;
      text-align: center;
      color: #343a40;
    }

    .label-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #e9ecef;
    }

    .label-row:last-child {
      border-bottom: none;
    }

    .label-row label {
      font-weight: 500;
      margin: 0;
      color: #495057;
    }

    .label-row span {
      font-weight: 600;
      color: #212529;
    }

    .pay-button {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      background-color: #4CBB17;
      color: white;
      border: none;
      border-radius: 6px;
      margin-top: 30px;
    }

    .pay-button:hover {
      background-color: #3ca113;
    }
  </style>
</head>

<body>
  <div class="payment-container">
    <h2>Complete Your Payment</h2>

    <?php if ($plan): ?>
      <div class="label-row">
        <label>Plan Name</label>
        <span><?= htmlspecialchars($plan['PlanName']) ?></span>
      </div>
    
    
      <div class="label-row">
        <label>Billing Cycle</label>
        <span><?= ucfirst($plan['BillingCycle']) ?></span>
      </div>
      <div class="label-row">
        <label>Amount</label>
        <span>$<?= $plan['Amount'] ?></span>
      </div>
      <div class="label-row">
        <label>Details</label>
        <span><?= nl2br(htmlspecialchars($plan['Details'])) ?></span>
      </div>

      <input type="hidden" id="RestaurantID" value="6">
      <input type="hidden" id="PlanID" value="<?= $plan['PlanID'] ?>">
      <input type="hidden" id="StripePriceID" value="<?= $plan['StripePriceID'] ?>">

      <button id="pay-now-btn" class="pay-button">Pay Now</button>
    <?php else: ?>
      <div class="alert alert-danger text-center">
        Invalid Plan ID.

      </div>
    <?php endif; ?>
  </div>

  <script>
    const stripe = Stripe("pk_test_51RSL48QQYpP9NcW7p8x1GwTt41Xx06ERmQQ5IbhpcFyXXXQWmsczYqw8w0WeUvxqyv7IDL1ibTTISq2yPyFkwAuw00IybgJukG");

    document.getElementById('pay-now-btn')?.addEventListener('click', () => {
      const restaurantID = document.getElementById('RestaurantID').value;
      const planID = document.getElementById('PlanID').value;

      fetch(`create-checkout-session.php?RestaurantID=${restaurantID}&PlanID=${planID}`)
        .then(res => res.json())
        .then(data => {
          if (data.error) {
            alert('Error: ' + data.error);
            return;
          }
          window.location.href = data.url;
        })
        .catch(err => alert('Fetch error: ' + err.message));
    });
  </script>
</body>
</html>
