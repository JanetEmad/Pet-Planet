<?php

$title = "Appointments";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\VST_Reservation;

$sitter_reservation = new VST_Reservation;

$appointments = $sitter_reservation->viewSTAppointments($_SESSION['user']->id);

?>

<div class="viewappointmentscontent">


    <div class="appointmentslist">

        <h1>Reservations</h1>

        <?php foreach ($appointments as $appointment) { ?>
            <div class="appointment">
                <p class="name">Customer Name: <?= $appointment['userFirstName'] . " " . $appointment['userLastName'] ?> </p>
                <p class="date">From: <?= $appointment['come_at'] ?></p>
                <p class="date">To: <?= $appointment['leave_at'] ?></p>

            </div>
        <?php } ?>


    </div>

</div>

</body>

</html>