<?php
include 'config.php';
include("auth_session.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';



error_reporting(0);



if (isset($_POST["submit"])) {
  $serial_num = mysqli_real_escape_string($conn, $_POST["sno"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
  $date = mysqli_real_escape_string($conn, $_POST["date"]);
  $check_serial = mysqli_num_rows(mysqli_query($conn, "SELECT serial_no FROM registeration WHERE serial_no='$serial_num'"));

  $sql = "SELECT * FROM users WHERE id='{$_SESSION["user_id"]}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $full_name = $data['full_name'];
  }


  if ($check_serial > 0) {
    echo "<script>alert('Serial Number already in use.');</script>";
  } else {
    $sql = "INSERT INTO `registeration` (email, serial_no, purchase_date, product_name) VALUES ('$email', '$serial_num', '$date', '$product_name')";
    $result = mysqli_query($conn, $sql);
    if ($result) {

      $to = $email;
      $subject = "Enigma Product Registered!";

      $message = "
      <html>
      <head>
      <title>{$subject}</title>
      </head>
      <body>
      <p><strong>Hello {$full_name},</strong></p>
      <p><strong>Thank you for owning an Enigma product. Welcome to the community.</strong></p>
      <p>Your Enigma product has been registered successfully, please find the details for the same below.</p>
      <p><strong>Product Name</strong> : {$product_name}</p>
      <p><strong>Serial Number</strong> : {$serial_num}</p>
      <p><strong>Date Of Purchase</strong> : {$date}</p>
      </body>
      </html>
      ";


      $mail = new PHPMailer();


      try {
        //Server settings
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";   //Send using SMTP
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $smtp['user'];                     //SMTP username
        $mail->Password   = $smtp['pass'];

        //Set Params
        $mail->setFrom($my_email);


        $mail->FromName = 'Enigma Hub';
        $mail->addAddress($email, $first_name);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();

        echo "<script>alert('Your Product has been registered.'); 
        window.location.href='dashboard1.php';
        </script>";
      } catch (Exception $e) {
        echo "<script>alert('Error! Please try again.');</script>";
      }
    } else {
      echo "<script>alert('Registeration Failed, please try again later.');</script>";
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Registration</title>






  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
  <link rel="manifest" href="favicon/site.webmanifest">
  <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <link href="register.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container">
    <main>
      <div class="py-5 text-center">
        <a href="index.php">
          <img class="d-block mx-auto mb-4" src="logo.png" alt="" width="72" height="72">
        </a>
        <h2>Product Registration</h2>
        <p class="lead">Please provide the appropriate details for warranty registeration of your Enigma Product.</p>
      </div>
      <div class="col-md-7 col-lg-8" style="margin-left: auto; margin-right: auto;">

        <form class="needs-validation" method="post" action="">
          <div class="row g-3">
            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" placeholder="you@example.com" required>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="product name" class="form-label">Product Name</label>
              <input type="text" class="form-control" name="product_name" placeholder="Enigma XYZ" required>
              <div class="invalid-feedback">
                Please enter correct product name.
              </div>
            </div>

            <div class="col-12">
              <label for="serial_num" class="form-label">Serial Number</label>
              <input type="text" class="form-control" name="sno" placeholder="XXXXXXXXXXX" required>
              <div class="invalid-feedback">
                Please enter Serial Number.
              </div>
            </div>

            <div class="col-12">
              <label for="DOP" class="form-label">Date of Purchase</label>
              <input type="date" class="form-control" name="date" placeholder="XX/XX/XXXX" required>
            </div>

            <button class="w-100 btn btn-primary btn-lg" type="submit" name="submit">Continue</button>
        </form>
      </div>
  </div>
  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2022 Enigma</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
  </div>

</body>

</html>