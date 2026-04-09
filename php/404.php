<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page Not Found - FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/banner.css">
  <link rel="stylesheet" href="assets/css/Explore.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <?php include 'fetch_cookies.php' ?>
  <style>
    body, html {
      height: 100%;
    }
    .main-container {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .content-wrap {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 20px;
    }
    .error-container {
      max-width: 500px;
    }
    .error-container h1 {
      font-size: 6rem;
      font-weight: bold;
      color: #4CBB17;
    }
    .error-container h2 {
      font-size: 1.75rem;
      margin-top: 0;
      margin-bottom: 20px;
    }
    .error-container p {
      margin-bottom: 30px;
      color: #6c757d;
    }
    .btn-home {
      background-color: #4CBB17;
      color: white;
      border-radius: 50px;
      padding: 12px 30px;
      font-weight: bold;
      text-transform: uppercase;
      text-decoration: none;
      transition: background-color 0.2s;
    }
    .btn-home:hover {
      background-color: #45a049;
      color: white;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="main-container">
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Error Content -->
    <div class="content-wrap">
      <div class="error-container">
        <h1>404</h1>
        <h2>Oops! Page Not Found.</h2>
        <p>We're sorry, but the page you are looking for doesn't exist or has been moved.</p>
        <a href="Home.php" class="btn btn-home">Go to Homepage</a>
      </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
