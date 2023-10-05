<?php

$title = "Appointments";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Clinic;
use App\Database\Models\Veterinary;
use App\Database\Models\VST_Reservation;

if (isset($_GET['id'])) {
    $clinicId = $_GET['id'];
}

$vet_reservation = new VST_Reservation;

$appointments = $vet_reservation->viewVetAppointments($_SESSION['user']->id, $clinicId);



?>

<div class="viewappointmentscontent">


    <div class="appointmentslist">

        <h1>Appointments</h1>

        <?php foreach ($appointments as $appointment) { ?>
            <div class="appointment">
                <p class="name"><?= $appointment['userFirstName'] . " " . $appointment['userLastName'] ?> </p>
                <p class="date"> <?= $appointment['date'] ?></p>
                <p class="clinic"><?= $appointment['clinicName'] ?> </p>

            </div>
        <?php } ?>


    </div>

</div>

</body>

</html>