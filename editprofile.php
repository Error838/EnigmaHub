<?php
require('config.php');
include("function.php");
include("auth_session.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

error_reporting(1);



if (isset($_POST["submit"])) {


  $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
  $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);
  $address = mysqli_real_escape_string($conn, $_POST["address"]);
  $address2 = mysqli_real_escape_string($conn, $_POST["address2"]);
  $city = mysqli_real_escape_string($conn, $_POST["city"]);
  $state = mysqli_real_escape_string($conn, $_POST["state"]);
  $country = mysqli_real_escape_string($conn, $_POST["country"]);
  $mobile = mysqli_real_escape_string($conn, $_POST["mobile"]);
  $old_password = mysqli_real_escape_string($conn, md5($_POST["old_password"]));
  $new_password = mysqli_real_escape_string($conn, md5($_POST["new_password"]));
  $check_password = mysqli_num_rows(mysqli_query($conn, "SELECT password FROM users WHERE password='$old_password'"));


  $sql = "SELECT * FROM users WHERE id='{$_SESSION["user_id"]}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $email = $data['email'];
  }




  if ($check_password > 0) {
    $sql = "UPDATE `users` SET `full_name`='$first_name $last_name',`password`='$new_password', `address`='$address $address2 $city $state $country', `mobile_no`='$mobile'  WHERE `id`='{$_SESSION["user_id"]}' ";
    $result = mysqli_query($conn, $sql);
    if ($result) {

      $to = $email;
      $subject = "Enigma Profile Updated.";

      $message = "
      <html>
      <head>
      <title>{$subject}</title>
      </head>
      <body>
      <p><strong>Hello {$first_name},</strong></p>
      <p>Your Enigma profile has been updated successfully, please find the details for the same below.</p>
      <p><strong>Name</strong> : {$first_name} {$last_name}</p>
      <p><strong>Address</strong> : {$address},{$address2},{$city} {$state} {$country}</p>
      <p><strong>Mobile Number</strong> : {$mobile}</p>
      <p>Please verify and if the need ,edit these details carefully as they help associate your warranty.</p>
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

        echo "<script>alert('Your Profile has been updated.'); 
          window.location.href='dashboard1.php';
          </script>";
      } catch (Exception $e) {
        echo "<script>alert('Error! Please try again.');</script>";
      }
    } else {
      echo "<script>alert('Updation Failed, please try again later.'); window.location.href='dashboard1.php';</script>";
    }
  } else {
    echo "<script>alert('Old password does not match'); window.location.href='dashboard1.php';</script>";
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Profile</title>




  <!-- Bootstrap core CSS -->
  <link href="css/styles.css" rel="stylesheet">

  <!-- Favicons -->
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


  <!-- Custom styles for this template -->
  <link href="register.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container">
    <main>
      <div class="py-5 text-center">
        <a href="index.php">
          <img class="d-block mx-auto mb-4" src="logo.png" alt="" width="72" height="72">
        </a>
        <h2>Edit Profile</h2>
        <p class="lead">Please provide the appropriate details for warranty registeration of your Enigma Product.</p>
      </div>

      <div class="row g-5">

        <div class="col-md-7 col-lg-8" style="margin-left: auto; margin-right: auto;">

          <form class="needs-validation" action="" method="POST">
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">First name</label>
                <input type="text" class="form-control" name="first_name" placeholder="John" value="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>

              <div class="col-sm-6">
                <label for="lastName" class="form-label">Last name</label>
                <input type="text" class="form-control" name="last_name" placeholder="Doe" value="" required>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>

              <div class="col-12">
                <label for="mobile" class="form-label">Mobile Number<span class="text-muted">(Optional)</span></label>
                <input type="text" class="form-control" name="mobile" placeholder="+91-1234567890">
                <div class="invalid-feedback">
                  Please enter your Mobile Number.
                </div>
              </div>

              <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" placeholder="House no., Flat" required>
                <div class="invalid-feedback">
                  Please enter your address.
                </div>
              </div>

              <div class="col-12">
                <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                <input type="text" class="form-control" name="address2" placeholder="Area, Street, Locality">
              </div>

              <div class="col-md-3">
                <label for="country" class="form-label">Country</label>
                <select class="form-select" name="country" required>
                  <option value="">Choose...</option>
                  <option>India</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid country.
                </div>
              </div>

              <div class="col-md-4">
                <label for="state" class="form-label">State</label>
                <select class="form-select" name="state" required>
                  <option value="">Choose...</option>
                  <option>Andaman and Nicobar</option>
                  <option>Andhra Pradesh</option>
                  <option>Arunachal Pradesh</option>
                  <option>Assam</option>
                  <option>Bihar</option>
                  <option>Chandigarh</option>
                  <option>Chhattisgarh</option>
                  <option>Dadra and Nagar Haveli</option>
                  <option>Daman and Diu </option>
                  <option>Delhi</option>
                  <option>Goa </option>
                  <option>Gujarat</option>
                  <option>Haryana</option>
                  <option>Himachal Pradesh</option>
                  <option>Jammu and Kashmir</option>
                  <option>Jharkhand</option>
                  <option>Karnataka </option>
                  <option>Kerala</option>
                  <option>Lakshadweep</option>
                  <option>Madhya Pradesh</option>
                  <option>Maharashtra</option>
                  <option>Manipur</option>
                  <option>Meghalaya</option>
                  <option>Mizoram </option>
                  <option>Nagaland</option>
                  <option>Orissa</option>
                  <option>Puducherry </option>
                  <option>Punjab</option>
                  <option>Rajasthan </option>
                  <option>Sikkim</option>
                  <option>Tamil Nadu</option>
                  <option>Telangana</option>
                  <option>Tripura </option>
                  <option>Uttar Pradesh</option>
                  <option>Uttarakhand</option>
                  <option>West Bengal</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>

              <div class="col-md-5">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" name="city" placeholder="" required>
                <div class="invalid-feedback">
                  Please provide a valid city.
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="old_password" class="form-label">Current Password</label>
              <div class="input-group has-validation">
                <input type="password" class="form-control" name="old_password" required>
                <div class="invalid-feedback">
                  Enter your current password.
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="new_password" class="form-label">New Password</label>
              <input type="password" class="form-control" name="new_password" required>
              <div class="invalid-feedback">
                Enter New Password.
              </div>
            </div>


            <button class="w-100 btn btn-primary btn-lg" type="submit" name="submit" style="margin-top: 18px;">Continue</button>
          </form>
        </div>
      </div>
    </main>

    <footer class="my-5 ptva-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2022 Enigma</p>

    </footer>
  </div>

</body>

</html>