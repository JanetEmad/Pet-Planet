<?php

$title = "Trainer Booking";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Address;
use App\Database\Models\Trainer;

$trainer = new Trainer;
if (isset($_GET['id'])) {
    $trainer2 = new Trainer;
    $trainerAddId = $_GET['id'];

    $trainerData = $trainer2->fetchTrainerDataFromDatabase($trainerAddId);

    if ($trainerData) {
        $_SESSION['trainerData'] = $trainerData;

        header('Location: TrainerBooking.php');
        exit();
    }
}

if (isset($_SESSION['trainerData'])) {
    $trainerData = $_SESSION['trainerData'];

    $name = $trainerData['first_name'] . " " . $trainerData['last_name'];
    $phone = $trainerData['phone'];
    $gender = $trainerData['gender'];
    $work_days = $trainerData['work_days'];
    $price_per_hour = $trainerData['price_per_hour'];
    $email = $trainerData['email'];
    $address_id = $trainerData['address_id'];
    $image = $trainerData['image'];
    $rate = $trainerData['rate'];
    $id = $trainerData['id'];

    $trainer->setId($id);
    $serviceProviderIds = $trainer->retrieveTrainerServiceProvider_id($id);

    foreach ($serviceProviderIds as $serviceProviderId) {
        $spId = $serviceProviderId;
    }

    $address1 = new Address;
    $address1->setId($address_id);
    $trainerAddress = $address1->getAddressInfoById();
} else {
    echo "Trainer data not available.";
}
?>

<br>

<head>
    <link rel="stylesheet" href="assets/css/rate.css">
</head>
<div class="spbooking">
    <div class="container">

        <div class="spinfo">

            <div class="spimage">
                <img src="assets/img/UsersUploads/<?= $image != "default.jpg" ? $image : "defaultTrainer.jpeg" ?>">
            </div>

            <h3><?= $name ?> </h3>

            <div class="aboutsp">
                <div class="all">
                    <div class="left">
                        <P>Full Name</P>
                        <hr>
                        <p>Gender</p>
                        <hr>
                        <p>phone</p>
                        <hr>
                        <p>Email</p>
                        <hr>
                        <p>Address</p>
                        <hr>
                        <p>Work Days</p>
                        <hr>
                        <p>Hour Price</p>
                        <hr>
                        <p>Rate</p>
                        <hr>
                    </div>

                    <div class="right">
                        <p><?= $name ?></p>
                        <hr>
                        <p><?= $gender == "f" ? "Female" : "Male" ?></p>
                        <hr>
                        <p><?= $phone  ?></p>
                        <hr>
                        <p><?= $email  ?></p>
                        <hr>
                        <p><?= $trainerAddress->address  ?></p>
                        <hr>
                        <p><?= $work_days  ?></p>
                        <hr>
                        <p><?= $price_per_hour  ?></p>
                        <hr>
                        <div>
                            <?php
                            $rating = $rate;
                            $maxStars = 5; // Maximum number of stars

                            // Loop through each star
                            for ($i = 1; $i <= $maxStars; $i++) {
                                // Check if the current star should be filled or empty
                                if ($i <= $rating) {
                                    $iconClass = "fas fa-star filled";
                                } else {
                                    $iconClass = "fas fa-star empty";
                                }

                                // Output the star icon
                                echo '<span class="star"><i class="' . $iconClass . '"></i></span>';
                            }
                            ?>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>

            <a href="MakeTrainerAppointment.php?id=<?= $id ?>&spId=<?= $spId ?>"><button type="button" class="btn btn-primary btn-lg">Book An Appointment</i></button></a>
            <a href="RatePage.php?type=<?= "Trainer" ?>&id=<?= $id ?>"><button type="button" class="btn btn-primary btn-lg">Rate Trainer</i></button></a>
        </div>

    </div>
</div>

</body>

</html>