<?php
$title = "Pet Profile";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Pet;
?>
<?php

if (isset($_GET["data"])) {
    $data = $_GET["data"];
}
$petObj = new Pet;
$pet = new Pet;
$petObj->setId($data);
$pets = $petObj->getPetInfo()->fetch_all(MYSQLI_ASSOC);
?>

<div class="petprofilecontent" style="font-family: Goudy Old Style;">
    <div class="container">

        <div class="petinfo" style="width: 650px; height:720px;">
            <!-- <a href="updatepetprofile.php">
                <img src="assets/img/YImages/edit.png">
            </a> -->
            <?php foreach ($pets as $pet) { ?>
                <div class="petimg">
                    <img src="assets/img/UsersUploads/<?= $pet['image'] ?>" alt="">
                </div>
                <h2><?= $pet['name'] ?></h2>
                <div class="aboutpet">
                    <div class="allp">
                        <div class="leftp">
                            <P>Name</P>
                            <hr>
                            <p>Gender</p>
                            <hr>
                            <p>Age</p>
                            <hr>
                            <p>Family</p>
                            <hr>
                            <p>Type</p>
                            <hr>
                        </div>
                        <div class="rightp">
                            <p><?= $pet['name'] ?></p>
                            <hr>
                            <p><?= $pet['gender'] == 'm' ? 'Male' : 'Female' ?></p>
                            <hr>
                            <p><?= $pet['age'] ?></p>
                            <hr>
                            <p>
                                <?php
                                $family = $pet['family'];
                                $petType = ($family == '1') ? 'Dog' : (($family == '2') ? 'Cat' : (($family == '3') ? 'Bird' : (($family == '4') ? 'Hamster' : 'Turtle')));
                                echo $petType;
                                ?>
                            </p>

                            <hr>
                            <p><?= $pet['type'] ?></p>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="buttonsnew">
                    <div>
                        <a href="PlacingPet.php?adopt=<?= $pet['id'] ?>" class="btn ">Place for adoption</a>
                        <a href="PlacingPet.php?sell=<?= $pet['id'] ?>" class="btn ">Place for selling</a>
                        <a href="PlacingPet.php?mate=<?= $pet['id'] ?>" class="btn ">Place for mating</a>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>
</body>

</html>