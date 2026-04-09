<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<script>
  const detectEnvironment = () => {
    const ua = navigator.userAgent || navigator.vendor || window.opera;
    const isAndroid = /Android/i.test(ua);
    const isIOS = /iPhone|iPad|iPod/i.test(ua);
    const isMobile = isAndroid || isIOS;

    const isWebView = (() => {
      if (isIOS) return !ua.includes("Safari");
      if (isAndroid) return ua.includes("; wv") || ua.includes("Version/");
      return false;
    })();

    const isDesktop = !isMobile;
    const isMobileBrowser = isMobile && !isWebView;

    if (isWebView) return "WebView";
    if (isMobileBrowser) return "Mobile Browser";
    if (isDesktop) return "Desktop Browser";
    return "Unknown";
  };

  const environment = detectEnvironment();

  if (["Mobile Browser", "Desktop Browser"].includes(environment)) {
    document.write(`
      <footer class="footer" style="background:white;">
        <div class="footer-content">
          <div class="footer-grid">
            <!-- Cities Section -->
            <div class="footer-section">
              <h3 class="footer-title">Our Location</h3>
              <ul class="footer-links">
                <li><a style="color:#666;">United States of America</a></li>
              </ul>
            </div>

            <!-- Company Section -->
            <div class="footer-section">
              <h3 class="footer-title">Company</h3>
              <ul class="footer-links">
                <li><a href="PartnerWithUs.php">Partner with us</a></li>
                <li><a href="AboutUs.php">About us</a></li>
                <li><a href="#">Careers</a></li>
              </ul>
            </div>

            <!-- Contact Section -->
            <div class="footer-section">
              <h3 class="footer-title">Contact</h3>
              <ul class="footer-links">
                <li><a href="Help.php">Help & Support</a></li>
               <li><a href="mailto:info@foodnpals.com">info@foodnpals.com</a></li>
            <li><a href="tel:+17345893503">Phone: +1 (734) 329-4804</a></li>
                <li>
                  <div >
                    <p style="color:#666; font-size:14px; margin:2px 0; margin-top:10px;">47356 Sherstone Drive</p>
                    <p style="color:#666; font-size:14px; margin:2px 0;">Canton, Michigan</p>
                    <p style="color:#666; font-size:14px; margin:2px 0;">48188</p>
                  </div>
                </li>
              </ul>
            </div>

            <!-- Legal Section -->
            <div class="footer-section">
              <h3 class="footer-title">Legal</h3>
              <ul class="footer-links">
                <li><a href="Terms.php">Terms & Conditions</a></li>
                <li><a href="RefundPolicy.php">Refund & Cancellation</a></li>
                <li><a href="PrivacyPolicy.php">Privacy Policy</a></li>
                <li><a href="Cookies.php">Cookie Policy</a></li>
              </ul>
            </div>

            <!-- Follow Us Section -->
            <div class="footer-section">
              <h3 class="footer-title">Follow Us</h3>
              <div class="social-links">
<a href="https://www.instagram.com/foodnpals?igsh=MWtrYTM2eDN6bmdhYw=="><i class="fab fa-instagram"></i></a>
<a href="https://www.facebook.com/share/1CZd9hzHSu/"><i class="fab fa-facebook"></i></a>
<a href="https://www.youtube.com/@Foodnpals"><i class="fab fa-youtube"></i></a>
<a href="https://www.linkedin.com/company/foodnpals"><i class="fab fa-linkedin"></i></a>
<a href="https://x.com/foodnpals"><i class="fab fa-x-twitter"></i></a>


                </div>
              <div class="newsletter">
                <p class="newsletter-title">Receive exclusive offers in your mailbox</p>
                <form class="newsletter-form">
                  <input type="email" class="newsletter-input" placeholder="Enter Your email">
                  <button type="submit" class="newsletter-button">Subscribe</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div style="text-align: center; font-size: 14px; color: #888; padding: 10px;">
          © 2025 <a style="color: #4CBB17; text-decoration: none;">FoodnPals LLC</a> All rights reserved.
        </div>
        <div style="text-align: center; font-size: 13px; color: #aaa; padding-bottom: 10px;">
        </div>
      </footer>
    `);
  }
</script>
