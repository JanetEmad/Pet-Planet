<?php

$title = "Book Hotel";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\clinic;
use App\Database\Models\VST_Reservation;

use App\Http\Requests\Validation;

if (isset($_GET['clinicid']) && isset($_GET['spId'])) {
    $clinicId = $_GET['clinicid'];
    $serviceProviderid = $_GET['spId'];
}
$clinic = new Clinic;
$clinic->setId($clinicId);
$clinics = $clinic->getClinicInfoById();

foreach ($clinics as $clinic) {
    $targetClinic = $clinic;
}

$validation = new Validation;

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['date'] ?? "")->setInputValueName('date')->required();

    // Check if the selected date is within the doctor's working days
    $stringWithoutSpaces = preg_replace('/\s+/', '', $targetClinic['work_days']);
    $workingDays = explode(",", $stringWithoutSpaces);
    $selectedDay = date('l', strtotime($_POST['date']));


    if (empty($validation->getErrors())) {

        $vst_reservation = new VST_Reservation;


        $vst_reservation->setDate($_POST['date'])
            ->setTotal_price($targetClinic['price'])
            ->setService_provider_id($serviceProviderid)
            ->setUser_id($_SESSION['user']->id)
            ->setClinic_id($targetClinic['id']);
        if (in_array($selectedDay, $workingDays)) {

            if ($vst_reservation->create()) {
                $success = "<div class='alert alert-success text-center'> Your appointment is made successfully.</div>";
                header('refresh:3;url=PetServices.php');
            } else {
                $error = "<div class='alert alert-danger'> Something went wrong.</div>";
            }
        } else {
            $error = "<div class='alert alert-danger' > The selected day is not available for appointments.</div>";
        }
    }
}
$opensAt = DateTime::createFromFormat('H:i:s', $targetClinic['opens_at']);
$closesAt = DateTime::createFromFormat('H:i:s', $targetClinic['closes_at']);
?>

<div class="makevetappointment">

    <div class="vetappointmentform">

        <form method="post">

            <form>
                <h1>Appointment Details</h1>
                <?= $error ?? "" ?>
                <?= $success ?? "" ?>
                <div class="days">
                    <p class="pone">Available Days:</p>
                    <p class="ptwo"><?= $targetClinic['work_days'] ?></p>
                    <p class="pone">The clinic is open From </p>
                    <p class="ptwo"><?= $opensAt->format('h:i A') ?></p>
                    <p class="pone"> To </p>
                    <p class="ptwo"><?= $closesAt->format('h:i A') ?></p>
                    <p class="pone">Appointment Price:</p>
                    <p class="ptwo"><?= $targetClinic['price'] . " LE" ?></p>
                </div>


                <div class="mb-3">
                    <label for="date" class="form-label">Date*</label>
                    <div class="input-group date" id="datepicker">
                        <input name="date" type="date" class="form-control" id="date" value="<?= $validation->getOldValue('date') ?>" />
                        <span class="input-group-append"><span class="input-group-text "><i class="fa fa-calendar"></i></span></span>
                    </div>
                </div>
                <p style="font-size: large; font-weight: bold;">Reservation Required. First come, First served.</p>
                <?= $validation->getMessage('date') ?>


                <button type="submit" class="btn confirm ">Confirm</button>

            </form>

        </form>


    </div>
</div>

<script>
    $(function() {
        $('#datepicker').datepicker({
            orientation: "bottom center"
        });
    });
</script>

<script src="https://kit.fontawesome.com/c442858b7c.js" crossorigin="anonymous"></script>
</body>

</html>