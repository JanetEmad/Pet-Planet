<?php

$title = "Contact Us";
include "layouts/header.php";
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->admin_status == 0) {
        if ($_SESSION['user']->service_provider_status == 0) {
            include "layouts/navbarRegisteredCustomer.php";
        } else {
            include "layouts/navbarRegisteredSP.php";
        }
    } else {
        include "layouts/navbarAdmin.php";
    }
} else {
    include "layouts/navbar.php";
}

?>

<div class="contactcontent">
    <div class="container">

        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

            </div>
        </div>
        <div class="contactform">

            <div class="left">
                <h1>Contact us</h1><br>
                <p>Egypt, 1234567890<br><u>petplanet@gmail.com</u></p>
                <span><i class="ri-twitter-fill"></i></span>
                <span><i class="ri-facebook-fill"></i></span>
                <span><i class="ri-instagram-fill"></i></span>
                <span><i class="ri-google-fill"></i></span>
            </div>

            <div class="right">
                <form>
                    <input type="text" placeholder="Enter your name"><br><br>
                    <input type="text" placeholder="Enter a valid email address"><br><br>
                    <input type="text" placeholder="Enter your messege"><br><br>
                    <button>SUBMIT</button>
                </form>
            </div>

        </div>
    </div>
</div>


</body>

</html>