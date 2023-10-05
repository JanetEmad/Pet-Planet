<?php

$title = "Appointments";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Sitter;
use App\Database\Models\VST_Reservation;
use App\Http\Requests\Validation;


$st_reservation = new VST_Reservation;

function calculateNumberOfHours($start_at, $end_at)
{
    $t1 = strtotime($start_at);
    $t2 = strtotime($end_at);
    $diff = $t2 - $t1;
    $hours = $diff / (60 * 60);

    return $hours;
}

if (isset($_GET['id']) && isset($_GET['spId'])) {
    $serviceProviderid = $_GET['spId'];

    $sitterId = $_GET['id'];
    $sitter = new Sitter;
    $sitter->setId($_GET['id']);
    $target = $sitter->fetchSitterDataFromDatabaseByUserId($sitterId);
}


$validation = new Validation;
$showPriceSection = false; // Variable to control the visibility of the price section
$showSuccessMessage = false; // Variable to control the visibility of the success message

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST && isset($_POST['se'])) {
    $validation->setOldValues($_POST);


    $validation->setInputValue($_POST['start_at'] ?? "")->setInputValueName('start_at')->required();
    $validation->setInputValue($_POST['end_at'] ?? "")->setInputValueName('end_at')->required();

    $numberOfHours = calculateNumberOfHours($_POST['start_at'], $_POST['end_at']);

    if (empty($validation->getErrors())) {
        $vst_reservation = new VST_Reservation;

        $vst_reservation->setTotal_price($target['price_per_hour'] * $numberOfHours)
            ->setService_provider_id($serviceProviderid)
            ->setUser_id($_SESSION['user']->id)
            ->setCome_at($_POST['start_at'])
            ->setLeave_at($_POST['end_at']);

        $startTime = new DateTime($_POST['start_at']);
        $endTime = new DateTime($_POST['end_at']);

        $stringWithoutSpaces = preg_replace('/\s+/', '', $target['work_days']);
        $workingDays = explode(",", strtolower($stringWithoutSpaces));
        $selectedDay = date('l', strtotime($_POST['start_at']));

        if ($startTime->format('Y-m-d') === $endTime->format('Y-m-d')) {
            if (in_array(strtolower($selectedDay), $workingDays)) {
                if ($vst_reservation->create()) {
                    $showPriceSection = true; // Show the price section
                    $showSuccessMessage = true; // Show the success message
                } else {
                    $error = "<div class='alert alert-danger'> Something went wrong.</div>";
                }
            } else {
                $error = "<div class='alert alert-danger' > The selected day is not available for appointments.</div>";
            }
        } else {
            $error = "<div class='alert alert-danger' > The two times must be in the same day.</div>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST && isset($_POST['price'])) {
    $success = "<div id='successMessage' class='alert alert-success text-center'>Your appointment is done successfully.</div>";
    header("refresh:3,url='PetServices.php'");
}
?>

<div class="makeS-Tappointment">
    <div class="sitterappointmentform">
        <form method="post">
            <h1>Appointment Details</h1>
            <?= $error ?? "" ?>
            <?= $success ?? "" ?>

            <div class="days">
                <p class="pone">Available Days:</p>
                <p class="ptwo"><?= $target['work_days'] ?></p>
            </div>
            <h4>Please Choose Service Interval</h4>
            <div class="form-group">
                <label for="start_at" class="form-label">Start*</label>
                <div class="input-group date" id="id_startTime" data-target-input="nearest">
                    <input name="start_at" type="datetime-local" class="form-control datetimepicker-input" data-target="#id_startTime" value="<?= $validation->getOldValue('start_at') ?>" />
                    <div class="input-group-append" data-target="#id_startTime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa-solid fa-clock"></i></div>
                    </div>
                </div>
            </div>
            <?= $validation->getMessage('start_at') ?>
            <div class="form-group">
                <label for="end_at" class="form-label">End*</label>
                <div class="input-group date" id="id_endTime" data-target-input="nearest">
                    <input name="end_at" type="datetime-local" class="form-control datetimepicker-input" data-target="#id_endTime" value="<?= $validation->getOldValue('end_at') ?>" />
                    <div class="input-group-append" data-target="#id_endTime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa-solid fa-clock"></i></div>
                    </div>
                </div>
            </div>
            <?= $validation->getMessage('end_at') ?>
            <input type="hidden" name="se" value="1">
            <button type="submit" class="btn ok">OK</button>
        </form>

        <?php if ($showPriceSection && isset($_POST['start_at']) && isset($_POST['end_at'])) : ?>
            <form id="confirmForm" method="post">
                <?php
                $numberOfHours = calculateNumberOfHours($_POST['start_at'], $_POST['end_at']);
                $price_per_hour = $target['price_per_hour'];
                $totalPrice = $price_per_hour * $numberOfHours;
                ?>
                <div class="price">
                    <p class="pone">Price Per Hour:</p>
                    <p class="ptwo"><?= $price_per_hour ?> LE</p>
                    <p class="pone">Total Price:</p>
                    <p class="ptwo"><?= $totalPrice ?> LE</p>
                </div>
                <input type="hidden" name="price" value="1"> <!-- Add hidden input field to detect form submission -->
                <button type="submit" class="btn confirm">Confirm</button>
            </form>
        <?php endif; ?>

    </div>
</div>

<script>
    $('#id_startTime').datetimepicker({
        format: 'LT'
    });
    $('#id_endTime').datetimepicker({
        format: 'LT'
    });

    //::Time Condition
    $('#id_startTime').on("change.datetimepicker", function(e) {
        if (e.date) {
            $('#id_endTime').datetimepicker(e.date.add(15, 'm'));
        }
        $('#id_endTime').datetimepicker('minDate', e.date)
    });
</script>

<script src="https://kit.fontawesome.com/c442858b7c.js" crossorigin="anonymous"></script>
</body>

</html>