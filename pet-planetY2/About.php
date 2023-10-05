<?php

$title = "About Us";
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

<body>

    <div class="aboutcontent">
        <div class="aboutcontainer">

            <div class="pink">
                <h4>Pets improve your mood</h4>
            </div>

            <div class="ChestnutRose">
                <h3>Who Are We?</h3>
                <p>Pet planet family developing website
                    its purpose is to produce a helpful community
                    to make it easy for pet owners overcome many
                    problems facing them when raising a pet.
                    <br><br>
                    Hope you enjoy joining us!
                </p>
            </div>

            <div class="image">
            </div>

        </div>
    </div>
</body>

</html>