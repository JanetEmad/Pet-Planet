<?php

$title = "Confirmation";
include "layouts/header.php";

include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

if (isset($_GET["type"])) {
    if ($_GET["type"] == 'Selling') {
        $placingType = 'Buying';
    } else {
        $placingType = $_GET["type"];
    }
}

?>
<div class="confirmationcontent">


    <div style="margin-top: 200px; width: 1200px;" class="confirmationbox">

        <div style="flex-wrap: nowrap;" class="row">
            <div class="con">
                <h1>Your Pet has been placed for <?= $_GET["type"] ?> successfully !</h1>
                <h3>You will recieve a notification when someone want your pet for <?= $placingType ?>. </h3>
            </div>
            <div class="checkmark">
                <img src="assets/img/YImages/chechmark.png">
            </div>

        </div>
    </div>

</div>

</body>

</html>