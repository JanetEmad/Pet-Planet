<?php

$title = "Sitter Booking";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Address;
use App\Database\Models\Sitter;

$sitter = new Sitter;
if (isset($_GET['id'])) {
    $sitter2 = new Sitter;

    $sitterAddId = $_GET['id'];

    $sitterData = $sitter2->fetchSitterDataFromDatabase($sitterAddId);

    if ($sitterData) {
        $_SESSION['sitterData'] = $sitterData;

        header('Location: SitterBooking.php');
        exit();
    }
}

if (isset($_SESSION['sitterData'])) {
    $sitterData = $_SESSION['sitterData'];

    $name = $sitterData['first_name'] . " " . $sitterData['last_name'];
    $phone = $sitterData['phone'];
    $gender = $sitterData['gender'];
    $work_days = $sitterData['work_days'];
    $price_per_hour = $sitterData['price_per_hour'];
    $email = $sitterData['email'];
    $address_id = $sitterData['address_id'];
    $image = $sitterData['image'];
    $rate = $sitterData['rate'];
    $id = $sitterData['id'];

    $sitter->setId($id);
    $serviceProviderIds = $sitter->retrieveSitterServiceProvider_id($id);

    foreach ($serviceProviderIds as $serviceProviderId) {
        $spId = $serviceProviderId;
    }

    $address1 = new Address;
    $address1->setId($address_id);
    $sitterAddress = $address1->getAddressInfoById();
} else {
    echo "Sitter data not available.";
}
?>

<br>

<head>
    <link rel="stylesheet" href="assets/css/rate.css">
</head>

<br>

<div class="spbooking">
    <div class="container">

        <div class="spinfo">

            <div class="spimage">
                <img src="assets/img/UsersUploads/<?= $image != "default.jpg" ? $image : "defaultSitter.jpeg" ?>">
            </div>

            <h3><?= $name ?></h3>

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
                        <p><?= $sitterAddress->address  ?></p>
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

            <a href="MakeSitterAppointment.php?id=<?= $id ?>&spId=<?= $spId ?>"><button type="button" class="btn btn-primary btn-lg">Book An Appointment</i></button></a>
            <a href="RatePage.php?type=<?= "Sitter" ?>&id=<?= $id ?>"><button type="button" class="btn btn-primary btn-lg">Rate Sitter</i></button></a>

        </div>

    </div>
</div>

</body>

</html>