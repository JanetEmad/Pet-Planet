<?php


$title = "Vet Booking";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Address;
use App\Database\Models\clinic;

$clinic = new Clinic;
if (isset($_GET['id'])) {
    $clinic2 = new Clinic;

    $clinicAddId = $_GET['id'];


    $clinicData = $clinic2->fetchClinicDataFromDatabase($clinicAddId);

    if ($clinicData) {
        $_SESSION['clinicData'] = $clinicData;

        header('Location: VetBooking.php');
        exit();
    }
}

if (isset($_SESSION['clinicData'])) {
    $clinicData = $_SESSION['clinicData'];

    $name = $clinicData['name'];
    $phone = $clinicData['phone'];
    $open_at = $clinicData['opens_at'];
    $close_at = $clinicData['closes_at'];
    $work_days = $clinicData['work_days'];
    $price = $clinicData['price'];
    $address_id = $clinicData['address_id'];
    $image = $clinicData['image'];
    $rate = $clinicData['rate'];
    $id = $clinicData['id'];

    $clinic->setId($id);
    $serviceProviderIds = $clinic->retrieveClinicServiceProvider_id($id);

    foreach ($serviceProviderIds as $serviceProviderId) {
        $spId = $serviceProviderId;
    }

    $address1 = new Address;
    $address1->setId($address_id);
    $clinicAddress = $address1->getAddressInfoById();
} else {
    echo "Clinic data not available.";
}
?>

<head>
    <link rel="stylesheet" href="assets/css/rate.css">
</head>

<br>

<div class="spbooking">
    <div class="container">

        <div class="spinfo">

            <div class="spimage">
                <img src="assets/img/UsersUploads/<?= $image != "default.jpg" ? $image : "defaultClinic.jpeg" ?>">
            </div>

            <h3><?= $name . " Clinic" ?></h3>

            <div class="aboutsp">
                <div class="all">
                    <div class="left">
                        <P> Name</P>
                        <hr>
                        <p>phone</p>
                        <hr>
                        <p>Address</p>
                        <hr>
                        <p>Open at</p>
                        <hr>
                        <p>Close at</p>
                        <hr>
                        <p>Work Days</p>
                        <hr>
                        <p>Price</p>
                        <hr>
                        <p>Rate</p>
                        <hr>
                    </div>

                    <div class="right">
                        <p><?= $name . " Clinic" ?></p>
                        <hr>
                        <p><?= $phone ?></p>
                        <hr>
                        <p><?= $clinicAddress->address ?></p>
                        <hr>
                        <p><?= $open_at ?></p>
                        <hr>
                        <P><?= $close_at ?></P>
                        <hr>
                        <p><?= $work_days ?></p>
                        <hr>
                        <p><?= $price . " EP" ?></p>
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

            <a href="MakeVetAppointment.php?clinicid=<?= $id ?>&spId=<?= $spId ?>"><button type="button" class="btn btn-primary btn-lg">Book An Appointment</i></button></a>
            <a href="RatePage.php?type=<?= "Vet" ?>&id=<?= $address_id ?>"><button type="button" class="btn btn-primary btn-lg">Rate Clinic</i></button></a>

        </div>

    </div>
</div>

</body>

</html>