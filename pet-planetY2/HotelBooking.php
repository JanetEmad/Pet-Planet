<?php


$title = "Hotel Booking";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Address;
use App\Database\Models\Hotel;

$hotel = new Hotel;
if (isset($_GET['id'])) {
    $hotel2 = new Hotel;

    $hotelAddId = $_GET['id'];

    $hotelData = $hotel2->fetchHotelDataFromDatabase($hotelAddId);

    if ($hotelData) {
        $_SESSION['hotelData'] = $hotelData;

        header('Location: HotelBooking.php');
        exit();
    }
}

if (isset($_SESSION['hotelData'])) {
    $hotelData = $_SESSION['hotelData'];

    $name = $hotelData['name'];
    $phone = $hotelData['phone'];
    $address_id = $hotelData['address_id'];
    $image = $hotelData['image'];
    $rate = $hotelData['rate'];
    $id = $hotelData['id'];

    $hotel->setId($id);
    $serviceProviderIds = $hotel->retrieveHotelServiceProvider_id($id);

    foreach ($serviceProviderIds as $serviceProviderId) {
        $spId = $serviceProviderId;
    }

    $address1 = new Address;
    $address1->setId($address_id);
    $hotelAddress = $address1->getAddressInfoById();
} else {
    echo "Hotel data not available.";
}
?>

<head>
    <link rel="stylesheet" href="assets/css/rate.css">
</head>

<div class="spbooking">
    <div class="container">

        <div class="spinfo">

            <div class="spimage">
                <img src="assets/img/UsersUploads/<?= $image != "default.jpg" ? $image : "defaultHotel.jpeg" ?>">
            </div>

            <h3><?= $name . " Hotel" ?></h3>

            <div class="aboutsp">
                <div class="all">
                    <div class="left">
                        <P>Name</P>
                        <hr>
                        <p>phone</p>
                        <hr>
                        <p>Address</p>
                        <hr>
                        <p>Rate</p>
                        <hr>
                    </div>
                    <div class="right">
                        <p><?= $name . " Hotel" ?></p>
                        <hr>
                        <p><?= $phone ?></p>
                        <hr>
                        <p><?= $hotelAddress->address ?></p>
                        <hr>
                        <div>
                            <?php
                            $rating = $rate; // Replace with the actual rating value retrieved from the database
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

            <a href="MakeHotelAppointment.php?hotelid=<?= $id ?>&spId=<?= $spId ?>"><button type="button" class="btn btn-primary btn-lg">Book</i></button></a>
            <a href="RatePage.php?type=<?= "Hotel" ?>&id=<?= $id ?>"><button type="button" class="btn btn-primary btn-lg">Rate Hotel</i></button></a>
        </div>

    </div>
</div>

</body>

</html>