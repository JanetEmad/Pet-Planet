<?php

$title = "Pet Services";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";


?>

<div class="Petsevicescontent">
    <div class="row">
        <div class="serviceimage">
            <img src="assets/img/YImages/serviceee.jpeg">
        </div>
    </div>

    <div class="section2">
        <div class="row">
            <hr class="line">
            <h1>Pet Services</h1>
            <hr class="line">
        </div>
    </div>

    <div class="section3">
        <div class="row">


            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                <a href="Hotels.php">
                    <div class="box">
                        <div class="petimage">
                            <img src="assets/img/YImages/hotel.jpeg">
                        </div>
                        <div class="text">
                            <img src="assets/img/YImages/pawprint.png">
                            <h3>Pet-Friendly Hotels</h3>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                <a href="Sitters.php">
                    <div class="box">
                        <div class="petimage">
                            <img src="assets/img/YImages/sitter.jpeg">
                        </div>
                        <div class="text">
                            <img src="assets/img/YImages/pawprint.png">
                            <h3>Sitters</h3>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                <a href="Trainers.php">
                    <div class="box">
                        <div class="petimage">
                            <img src="assets/img/YImages/trainer.jpeg">
                        </div>
                        <div class="text">
                            <img src="assets/img/YImages/pawprint.png">
                            <h3>Trainers</h3>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                <a href="Vets.php">
                    <div class="box">
                        <div class="petimage">
                            <img src="assets/img/YImages/vet.png">
                        </div>
                        <div class="text">
                            <img src="assets/img/YImages/pawprint.png">
                            <h3>Vets</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

</body>

</html>