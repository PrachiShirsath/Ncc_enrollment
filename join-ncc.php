<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Join NCC - DBATU</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(90deg, #e0f7fa 0%, #b2ebf2 50%, #c8e6c9 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            min-height: 100vh;
        }
    </style>
</head>
<body>
  <!-- ======= Header/Navbar ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center">
      <nav id="navbar" class="navbar justify-content-center w-100" style="display: flex; justify-content: center;">
        <ul style="margin: 0 auto; display: flex; justify-content: center; align-items: center;">
          <li><a class="nav-link scrollto" href="index.html#hero">HOME</a></li>
          <li><a class="nav-link scrollto" href="index.html#about">ABOUT</a></li>
          <li><a class="nav-link scrollto" href="index.html#contact">CONTACT</a></li>
          <li><a class="nav-link scrollto" href="https://nccauto.gov.in/alumni">ALUMNI</a></li>
          <li><a class="nav-link scrollto" href="Portfolio-details.html">GALLERY</a></li>
          <li><a class="nav-link scrollto active" href="join-ncc.php">JOIN NCC</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>
<!-- ======= Join NCC Section ======= -->
<section id="join-ncc" class="contact section-bg">
    <div class="container-fluid px-0" style="max-width:100vw;">
      <div class="section-title text-center mx-auto" style="max-width:600px;">
        <h2>Join NCC</h2>
        <p>Interested in joining NCC? Fill out the form below to express your interest and get started on your journey!</p>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-8 mt-5 mt-lg-0 d-flex align-items-stretch mx-auto">
          <form action="forms/contact.php" method="post" role="form" class="php-email-form mx-auto">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="join-name">Full Name</label>
                <input type="text" name="name" class="form-control" id="join-name" required>
              </div>
              <div class="form-group col-md-6">
                <label for="join-email">Email Address</label>
                <input type="email" class="form-control" name="email" id="join-email" required pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" >
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6 mt-3">
                <label for="join-phone">Phone Number</label>
                <input type="tel" class="form-control" name="phone" id="join-phone" required pattern="\d{10}" title="Phone number must be exactly 10 digits">
              </div>
              <div class="form-group col-md-6 mt-3">
                <label for="join-branch">Branch/Department</label>
                <select class="form-control" name="branch" id="join-branch" required>
                  <option value="">Select your branch...</option>
                  <option value="Computer Engineering">Computer Engineering</option>
                  <option value="Mechanical Engineering">Mechanical Engineering</option>
                  <option value="Electrical Engineering">Electrical Engineering</option>
                  <option value="Civil Engineering">Civil Engineering</option>
                  <option value="Chemical Engineering">Chemical Engineering</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6 mt-3">
                <label for="join-year">Current Year</label>
                <select class="form-control" name="year" id="join-year" required>
                  <option value="">Select year...</option>
                  <option value="First Year">First Year</option>
                  <option value="Second Year">Second Year</option>
                  <option value="Third Year">Third Year</option>
                  <option value="Fourth Year">Fourth Year</option>
                </select>
              </div>
              <div class="form-group col-md-6 mt-3">
                <label for="join-gender">Gender</label>
                <select class="form-control" name="gender" id="join-gender" required>
                  <option value="">Select gender...</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>
            <div class="my-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your application has been submitted successfully! We'll get back to you soon.</div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-lg px-5 py-3 animate__animated btn-3d" id="cta-btn" style="background: linear-gradient(135deg, #4469d8 0%, #00b894 100%); border: none; border-radius: 50px; font-weight: 600; font-size: 1.1rem; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(68, 105, 216, 0.3); transition: all 0.3s ease; text-transform: uppercase;">
                <i class="bi bi-send-fill me-2"></i>Submit Application
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.php-email-form');
  if (form) {
    form.addEventListener('submit', function(e) {
      const emailInput = document.getElementById('join-email');
      const email = emailInput.value.trim();
      const gmailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
      if (!gmailPattern.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email in the format username@gmail.com');
        emailInput.focus();
        return false;
      }
      const phoneInput = document.getElementById('join-phone');
      const phone = phoneInput.value.trim();
      const phonePattern = /^\d{10}$/;
      if (!phonePattern.test(phone)) {
        e.preventDefault();
        alert('Please enter a valid 10-digit phone number');
        phoneInput.focus();
        return false;
      }
    });
  }
});
</script>
</body>
</html> 
