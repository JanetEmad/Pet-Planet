<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;

$title = "Signin";

include "layouts/header.php";
include "layouts/navbar.php";
include "App/Http/Middlewares/guest.php";


$validation = new Validation;

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

  $validation->setInputValue($_POST['email'])->setInputValueName('email')->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/', "wrong email or password")->exists('users', 'email');

  $validation->setInputValue($_POST['password'])->setInputValueName('password')->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', "wrong email or password");

  if (empty($validation->getErrors())) {

    $user = new User;

    $databaseResult = $user->setEmail($_POST['email'])->getUserInfo();

    if ($databaseResult->num_rows == 1) {

      $databaseUser = $databaseResult->fetch_object();

      if (password_verify($_POST['password'], $databaseUser->password) || $_POST['password'] == $databaseUser->password) {


        // if (is_null($databaseUser->email_verified_at)) {
        //   $_SESSION['verication_email'] = $_POST['email'];
        //   header('location:verification-code.php');

        //   die;
        // } else {
        //   $_SESSION['user'] = $databaseUser;

        //   if ($_SESSION['user']->service_provider_status == 0) {
        //     header('location:CustomerHome.php');
        //   } else {
        //     header('location:ServiceProviderHome.php');
        //   }
        //   die;
        // }

        //----------------------------------------------------------------------------
        //delete this part when the email verification part work
        $_SESSION['user'] = $databaseUser;

        if ($_SESSION['user']->admin_status == 0) {
          if ($_SESSION['user']->service_provider_status == 0) {
            header('location:CustomerHome.php');
          } else {
            header('location:ServiceProviderHome.php');
          }
        } else {
          header('location:AdminHome.php');
        }
        die;
        //----------------------------------------------------------------------------

      } else {
        $error = "<p class='text-danger font-weight-bold'>wrong email or password</p>";
      }
    } else {
      $error = "<p class='text-danger font-weight-bold'>wrong email or password</p>";
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Sign-in Form</title>

  <head>
    <link rel="stylesheet" href="assets/css/forSignn.css">
  </head>
</head>

<body>
  <div class="signin-container">
    <div class="signin-page">
      <div class="form">
        <div class="signin">
          <div class="signin-header">
            <h3 style="text-align:center;">Sign In</h3>
          </div>
        </div>

        <?= $error ?? "" ?>
        <form class="signin-form" action="#" method="post">

          <label for="email">Email*</label>
          <input id="email" type="text" placeholder="Enter your email..." name="email" />
          <?= $validation->getMessage('email') ?>

          <label for="password">Password*</label>
          <input id="password" type="password" placeholder="Enter your password..." name="password" />
          <?= $validation->getMessage('password') ?>

          <!-- <div class="button-box">
                      <div class="login-toggle-btn">
                        <input type="checkbox" />
                        <label>Remember me</label>
                        <a href="#">Forgot Password?</a>
                      </div>
      </div>-->

          <button class="blueButton">Sign in</button>
          <p style="text-align:center ;" class="message">Need an account? <a href="signup.php">Sign up</a></p>
        </form>
      </div>
    </div>
    <div class="images">
      <img class="signinimage" src="assets/img/other/signinPhoto.jpg" alt="">
    </div>
  </div>
</body>

</html>