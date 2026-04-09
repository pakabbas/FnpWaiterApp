<?php
// This is a reusable component for the "Booking in progress..." banner
// It uses variables from fetch_active_reservation.php which should be included before this file
?>

<?php if (isset($isReservationActive) && $isReservationActive == "Yes"): ?>
<style>
  #active-booking-banner {
    position: fixed;
    bottom: calc(5px + 1vh);
    background: white;
    border: 2px solid #4cbb17;
    border-radius: 12px;
    padding: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    z-index: 1001;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  /* Mobile view (up to 768px) */
  @media (max-width: 768px) {
    #active-booking-banner {
      left: 16px;
      right: 16px;
    }
  }

  /* Tablet and Desktop view (above 768px) */
  @media (min-width: 769px) {
    #active-booking-banner {
      right: 16px;
      width: 300px;
    }
  }
</style>

<div id="active-booking-banner">
  <button id="close-banner" aria-label="Close banner" style="position: absolute; top: 6px; right: 6px; background: rgba(255, 255, 255, 0.3); border: none; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; padding: 0; color: black; font-size: 15px; z-index: 10;">×</button>
  <div style="text-align: center; font-size: 16px; font-weight: 600; color: #4cbb17; margin-bottom: 4px;">Booking in progress...</div>
  <div style="display: flex; align-items: center; gap: 8px;">
    <img src="Resources/<?php echo $restaurantIcon; ?>" alt="Restaurant Icon" style="width: 32px; height: 32px; border-radius: 6px; object-fit: cover;">
    <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
      <div style="font-weight: 600; font-size: 16px; color: #333;"><?php echo $restaurantName1; ?></div>
      <div style="text-align: right; line-height: 1.1;">
        <div style="font-size: 11px; color: #666;"><?php echo date('F j, Y', $reservationTime); ?></div>
        <div style="font-size: 11px; color:rgb(122, 122, 122);"><?php echo date('g:i A', $reservationTime); ?></div>
      </div>
    </div>
  </div>
</div>

<script>
  // Close banner functionality
  document.addEventListener('DOMContentLoaded', function() {
    const closeBanner = document.getElementById('close-banner');
    const banner = document.getElementById('active-booking-banner');
    
    if (closeBanner && banner) {
      closeBanner.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent banner click event from firing
        banner.style.display = 'none';
      });
    }
    
    // Make the banner clickable to go to the reservation page
    if (banner) {
      banner.addEventListener('click', function() {
        window.location.href = 'Confirmation.php?ID=<?php echo $activeReservation; ?>';
      });
    }
  });
</script>
<?php endif; ?>
