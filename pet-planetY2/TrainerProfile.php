<?php

$title = "Trainer Profile";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Address;
use App\Database\Models\Trainer;

?>

<br>

<div class="sitterprofilecontent">
    <div class="container">
        <div class="sitterinfo">
            <a href="UpdateTrainer.php?id=<?= $_SESSION['user']->id ?>">
                <img src="assets/img/YImages/edit.png">
            </a>
            <div class="sitterimg">
                <?php
                if ($_SESSION['user']->image == 'default.jpg') {
                    if ($_SESSION['user']->gender == 'm') {
                        $image = 'Male.jpeg';
                    } else {
                        $image = 'Female.jpg';
                    }
                } else {
                    $image = $_SESSION['user']->image;
                }
                ?>
                <img src="assets/img/UsersUploads/<?= $image ?>">
            </div>
            <h2><?= $_SESSION['user']->first_name . " " . $_SESSION['user']->last_name ?></h2>
            <div class="aboutsitter">
                <div class="head">
                    <img src="assets/img/YImages/user.png">
                    <h3>About</h3>
                </div>
                <div class="all">
                    <div class="left">
                        <P>Full Name</P>
                        <hr>
                        <p>Gender</p>
                        <hr>
                        <p>Email</p>
                        <hr>
                        <P>Phone</P>
                        <hr>
                        <p>Address</p>
                        <hr>
                    </div>
                    <div class="right">
                        <p><?= $_SESSION['user']->first_name . " " . $_SESSION['user']->last_name ?></p>
                        <hr>
                        <p><?= $_SESSION['user']->gender == 'm' ? 'Male' : 'Female' ?></p>
                        <hr>
                        <p><u><?= $_SESSION['user']->email ?></u></p>
                        <hr>
                        <p><?= $_SESSION['user']->phone ?></p>
                        <hr>
                        <?php
                        $address = new address;
                        $address->setUser_id($_SESSION['user']->id);
                        $Traineraddress = $address->getAddressInfoByUserId($_SESSION['user']->id);
                        ?>
                        <p><?= $Traineraddress->address ?></p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <div class="myservice">
            <h2>My Service</h2>
            <?php
            $trainer = new Trainer;
            $trainer->setAddress_id($Traineraddress->id);
            $trainerinfo = $trainer->retrieveTrainerInfoByAddressId($Traineraddress->id);
            ?>
            <div class="serviceinfo">
                <div class="all-2">
                    <div class="left-2">
                        <P>Service</P>
                        <hr>
                        <p>Hour Price </p>
                        <hr>
                        <p>Work Days</p>
                        <hr>
                    </div>
                    <div class="right-2">
                        <p>Pet Trainer </p>
                        <hr>
                        <P><?= $trainerinfo['price_per_hour'] ?></P>
                        <hr>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp; <?= $trainerinfo['work_days'] ?></p>
                        <hr>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-lg"><a style="text-decoration: none; color: white;" href="ViewTrainerAppointments.php">View Reservations </a> </button>

        </div>
    </div>
</div>
</div>
</body>

</html>