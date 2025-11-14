<?php
include '../Admin/connection.php';
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO inquiries_tbl (name, email, subject, message,status) VALUES ('$name','$email','$subject','$message','Pending')";
    if (mysqli_query($conn, $query)) {
        // Send confirmation email
        $to = $email;
        $email_subject = "KCP: Inquiry Received";
        $email_message = "Hello $name,\n\nThank you for contacting KRISHNA CAR PARTS!\n\nWe have received your inquiry with the subject: \"$subject\".\n\nOur team will respond to you as soon as possible.\n\nBest Regards,\nHireHunt Team";
        $headers = "From: support@kcp.in";

        // Uncomment if mail() is configured on your server
        @mail($to, $email_subject, $email_message, $headers);

        $success = "Your message has been sent successfully! You will also receive a confirmation email.";
    } else {
        $error = "Something went wrong! Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us | Krishna Car Parts</title>
  <link rel="icon" href="../assets/images/kcp.png" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    body { 
      font-family: 'Inter', sans-serif; 
      background: linear-gradient(135deg, #0b0d10 0%, #111317 50%, #1b1f27 100%);
      color: #f6f7fb;
      min-height: 100vh;
    }
    .contact-section { padding: 60px 20px; }
    .glass-box { 
      background: linear-gradient(145deg, rgba(17, 19, 23, 0.95), rgba(27, 31, 39, 0.95));
      border: 1px solid rgba(0, 255, 229, 0.2);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
      backdrop-filter: blur(15px);
      padding: 30px;
      height: 100%;
    }
    .form-control { 
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #f6f7fb;
      border-radius: 12px;
    }
    .form-control:focus { 
      background: rgba(255, 255, 255, 0.08);
      border-color: #00ffe5;
      color: #f6f7fb;
      box-shadow: 0 0 0 0.2rem rgba(0, 255, 229, 0.25);
    }
    .form-control::placeholder { color: rgba(246, 247, 251, 0.6); }
    .btn-submit { 
      background: linear-gradient(135deg, #ff3b2f, #00ffe5);
      border: none;
      color: #fff;
      padding: 12px 30px;
      border-radius: 30px;
      font-weight: 600;
      width: 100%;
      transition: all 0.3s ease;
    }
    .btn-submit:hover { 
      background: linear-gradient(135deg, #00ffe5, #ff3b2f);
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(255, 59, 47, 0.4);
    }
    iframe { border-radius: 16px; width: 100%; height: 350px; margin-top: 40px; }
    .info-item { margin-bottom: 20px; }
    .info-item h6 { font-weight: 700; margin-bottom: 5px; color: #f6f7fb; }
    .info-item p { margin: 0; color: rgba(246, 247, 251, 0.8); }
    h2, h4 { color: #f6f7fb; }
    .text-success { color: #00ffe5 !important; }
    .alert-success {
      background: rgba(0, 255, 229, 0.1);
      border: 1px solid rgba(0, 255, 229, 0.3);
      color: #00ffe5;
    }
    .alert-danger {
      background: rgba(255, 59, 47, 0.1);
      border: 1px solid rgba(255, 59, 47, 0.3);
      color: #ff3b2f;
    }
  </style>
</head>
<body>
<?php include 'header1.php'; ?>

<section class="contact-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Contact <span style="color: #00ffe5;">KRISHNA CAR PARTS</span></h2>
      <p>We'd love to hear from you — whether it's a question, suggestion, or just a hello!</p>
    </div>

    <?php
    if (isset($success)) {
        echo '<div class="alert alert-success text-center">'.$success.'</div>';
    } elseif (isset($error)) {
        echo '<div class="alert alert-danger text-center">'.$error.'</div>';
    }
    ?>

    <div class="row g-4">
      <div class="col-lg-6">
        <div class="glass-box h-100">
          <h4 class="mb-4">Send Us a Message</h4>
          <form action="" method="POST">
            <div class="mb-3">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required />
            </div>
            <div class="mb-3">
              <input type="email" name="email" class="form-control" placeholder="Your Email" required />
            </div>
            <div class="mb-3">
              <input type="text" name="subject" class="form-control" placeholder="Subject" required />
            </div>
            <div class="mb-3">
              <textarea name="message" rows="4" class="form-control" placeholder="Your Message" required></textarea>
            </div>
            <button type="submit" class="btn btn-submit">Send Message</button>
          </form>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="glass-box h-100">
          <h4 class="mb-4">Contact Information</h4>
          <div class="info-item">
            <h6><i class="fas fa-map-marker-alt me-2 text-success"></i>Address</h6>
            <p>SHOP-1, FIRST FLOOR, Siddhi Residency,<br>Pal Gam Rd, opp. RAJ VICTORIA, Pal Gam,<br> Surat, Gujarat 395009</p>
          </div>
          <div class="info-item">
            <h6><i class="fas fa-phone-alt me-2 text-success"></i>Phone</h6>
            <p>+91 98765 43210</p>
          </div>
          <div class="info-item">
            <h6><i class="fas fa-envelope me-2 text-success"></i>Email</h6>
            <p>support@kcp.in</p>
          </div>
          <div class="info-item">
            <h6><i class="fas fa-globe me-2 text-success"></i>Website</h6>
            <p>www.kcp.in</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-12">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3680.034994124313!2d72.55762441540565!3d23.046518021720063!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e84fc8e7fd5db%3A0x81e9390d6a75bc32!2sGujarat%20University!5e0!3m2!1sen!2sin!4v1718281349433!5m2!1sen!2sin" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
