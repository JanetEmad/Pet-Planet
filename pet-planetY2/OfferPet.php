<?php

$title = "Offer pet";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

?>

<body>

    <br>

    <div class="wantpetscontent">

        <h1>Pets</h1>

        <div class="bg">
            <img src="assets/img/YImages/bg.png">
        </div>
        <div class="bg2">
            <img src="assets/img/YImages/bg2.png">
        </div>


        <div class="boxes">
            <div class="row">

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                    <a href="PlacePetForSelling.php">
                        <div class="onebox">
                            <img src="assets/img/YImages/buy.png">
                            <h3>Place Pet
                                For Selling</h3>
                        </div>
                    </a>
                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                    <a href="PlacePetForAdoption.php">
                        <div class="onebox">
                            <img src="assets/img/YImages/adopt.png">
                            <h3>Place Pet
                                For Adoption</h3>
                        </div>
                    </a>
                </div>


                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                    <a href="PlacePetForMating.php">
                        <div class="onebox">
                            <img src="assets/img/YImages/mate.png">
                            <h3>Place Pet
                                For Mating</h3>
                        </div>
                    </a>
                </div>


            </div>
        </div>

    </div>



</body>

</html>