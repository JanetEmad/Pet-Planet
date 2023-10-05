<?php

$title = "Appointments";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Hotel;
use App\Database\Models\Hotel_Reservation;

if (isset($_GET['id'])) {
    $hotelId = $_GET['id'];
}

$hotel_reservation = new Hotel_Reservation;

$hotel_reservation->setHotel_id($hotelId);
$appointments = $hotel_reservation->read();

?>

<div class="viewappointmentscontent">


    <div class="appointmentslist">

        <h1>Reservations</h1>

        <?php foreach ($appointments as $appointment) { ?>
            <div class="appointment">
                <p class="name">Guest Name: <?= $appointment['userFirstName'] . " " . $appointment['userLastName'] ?> </p>
                <p class="date">From: <?= $appointment['start_at'] ?></p>
                <p class="date">To: <?= $appointment['end_at'] ?></p>
                <p class="name">Room: <?= $appointment['type_of_room'] == 0 ? "Single" : "Double" ?> </p>

            </div>
        <?php } ?>


    </div>

</div>

</body>

</html>