<?php

$title = "Confirmation";
include "layouts/header.php";
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->service_provider_status == 0) {
        include "layouts/navbarRegisteredCustomer.php";
    } else {
        include "layouts/navbarRegisteredSP.php";
    }
} else {
    include "layouts/navbar.php";
}
include "App/Http/Middlewares/Auth.php";

use App\Mail\OrderConfirmationMail;
// use App\Database\Models\Order;



// if ($order->create()) {
$subject = "Order Confirmation Mail";
$body = "<p> Hello {$_SESSION['user']->first_name} {$_SESSION['user']->last_name}.</p>
    <p> Your order has been confirmed.<br> The delivery man will call you in 5 days at most.</p>
    <p> Thank You!</p>";

// $confirmationMail = new OrderConfirmationMail;

// if ($confirmationMail->send($_POST['email'], $subject, $body)) {

//     $success = "<div class='alert alert-success text-center'>Order has been confirmed successfuly.</div>";
//     header('refresh:3');
//     die;
// } else {
//     $error = "<div class='alert alert-danger' > Please Try Again Later </div>";
// }

?>
<div class="confirmationcontent">
    <div class="row">
        <div class="storeimage">
            <img src="assets/img/YImages/store.png">
        </div>
    </div>

    <?= isset($success) ? $success : "" ?>
    <?= isset($error) ? $error : "" ?>
    <div class="confirmationbox">
        <div class="row">
            <div class="con">
                <h1>Your order has been confirmed !</h1>
                <h3>All order details sent to your email. </h3>
                <h3>Thank you for your order.</h3>
            </div>

            <div class="checkmark">
                <img src="assets/img/YImages/chechmark.png">
            </div>

        </div>
    </div>

</div>

</body>

</html>