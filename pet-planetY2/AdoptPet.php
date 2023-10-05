<?php

$title = "Adopt pet";

include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Pet;

$pet = new Pet;
$pets = $pet->getAvailablePetsForAdoption()->fetch_all(MYSQLI_ASSOC);

if ($_GET && isset($_GET['cat'])) {
    $pet = new Pet;
    $pet->setCategory_id($_GET['cat']);
    $pets = $pet->getPetByCat('adopt')->fetch_all(MYSQLI_ASSOC);
}

?>


<div class="adoptpetcontent">

    <h1>Adopt A Pet</h1>

    <div class="boxes">
        <div class="row">

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                <a href="BuyPet.php">
                    <div class="onebox one">
                        <img src="assets/img/YImages/buy.png">
                        <h3>Buy a Pet</h3>

                    </div>
                </a>
            </div>


            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                <a href="AdoptPet.php">
                    <div class="onebox two">
                        <img src="assets/img/YImages/adopt.png">
                        <h3>Adopt a Pet</h3>
                    </div>
                </a>
            </div>


            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                <a href="FindMate.php">
                    <div class="onebox three">
                        <img src="assets/img/YImages/mate.png">
                        <h3>Find a Mate</h3>
                    </div>
                </a>
            </div>

        </div>
    </div>


    <h3>Find Your Future Best Friend</h3>

    <div class="circles">
        <div class="row">

            <div class="col-xs-2">
                <a href="AdoptPet.php?cat=1" onclick="changeImage(this)">
                    <div class="circle one">
                        <img src="assets/img/YImages/dogfilter.png">
                    </div>
                </a>
            </div>

            <div class="col-xs-2 col-half-offset">
                <a href="AdoptPet.php?cat=2" onclick="changeImage(this)">
                    <div class="circle one">
                        <img src="assets/img/YImages/catfilter.png">
                    </div>
                </a>
            </div>

            <div class="col-xs-2 col-half-offset">
                <a href="AdoptPet.php?cat=3" onclick="changeImage(this)">
                    <div class="circle one">
                        <img src="assets/img/YImages/birdfilter.png">
                    </div>
                </a>
            </div>

            <div class="col-xs-2 col-half-offset">
                <a href="AdoptPet.php?cat=4" onclick="changeImage(this)">
                    <div class="circle one">
                        <img src="assets/img/YImages/hamsterfilter.png">
                    </div>
                </a>
            </div>

            <div class="col-xs-2 col-half-offset">
                <a href="AdoptPet.php?cat=5" onclick="changeImage(this)">
                    <div class="circle one">
                        <img src="assets/img/YImages/turtlefilter.png">
                    </div>
                </a>
            </div>

        </div>
    </div>


    <h3>Pets Available For Adoption</h3>

    <div class="results">
        <div class="row">

            <?php if (!empty($pets)) { ?>

                <?php foreach ($pets as $pet) { ?>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                        <a href="PetProfileForOperation.php?adopt=<?= $pet['id'] ?>">
                            <div class="result">
                                <div class="image">
                                    <img src="assets/img/UsersUploads/<?= $pet['image'] ?>">
                                </div>
                                <div class="name">
                                    <p><?= $pet['name'] ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>

            <?php } else { ?>
                <h3 style='margin:auto;'>No available pets now</h3>
            <?php } ?>

        </div>
    </div>
</div>

<script>
    var selectedImage = null;

    function changeImage(clickedElement) {
        var clickedImage = clickedElement.querySelector("img");
        if (selectedImage) {
            selectedImage.src = selectedImage.src.replace("-choosed", ""); // Remove "-choosed" from the previous selected image
        }
        clickedImage.src = clickedImage.src.replace(/\.[^/.]+$/, "-choosed$&"); // Add "-choosed" to the clicked image
        selectedImage = clickedImage; // Update the selected image
    }
</script>


</body>

</html>