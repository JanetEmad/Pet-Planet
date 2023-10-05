<?php

$title = "Book Hotel";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Hotel_Reservation;
use App\Http\Requests\Validation;

if (isset($_GET['hotelid']) && isset($_GET['spId'])) {
    $hotelId = $_GET['hotelid'];
    $serviceProviderid = $_GET['spId'];
}

function calculateNumberOfNights($startDate, $endDate)
{
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);

    // Calculate the time difference
    $interval = $end->diff($start);

    // Get the number of nights
    $numberOfNights = $interval->format('%a');

    return $numberOfNights;
}
$validation = new Validation;
$showPriceSection = false; // Variable to control the visibility of the price section
$showSuccessMessage = false; // Variable to control the visibility of the success message

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['start_at'] ?? "")->setInputValueName('start_at')->required();

    $validation->setInputValue($_POST['end_at'] ?? "")->setInputValueName('end_at')->required();

    $validation->setInputValue($_POST['type_of_room'] ?? "")->setInputValueName('type_of_room')->required();


    if (empty($validation->getErrors())) {

        $hotel_reservation = new Hotel_Reservation;

        $numberOfNights = calculateNumberOfNights($_POST['start_at'], $_POST['end_at']);
        $priceOfRoom = $_POST['type_of_room'] == 0 ? 600 : 1200;
        $totalPrice = $priceOfRoom * $numberOfNights;

        $hotel_reservation->setStart_at($_POST['start_at'])
            ->setEnd_at($_POST['end_at'])
            ->setType_of_room($_POST['type_of_room'])
            ->setTotal_price($totalPrice)
            ->setHotel_id($hotelId)
            ->setService_provider_id($serviceProviderid)
            ->setUser_id($_SESSION['user']->id);


        if ($hotel_reservation->create()) {
            $showPriceSection = true; // Show the price section
            $showSuccessMessage = true; // Show the success message
        } else {
            $error = "<div class='alert alert-danger'> Something went wrong.</div>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST && isset($_POST['price'])) {
    $success = "<div id='successMessage' class='alert alert-success text-center'>Your appointment is done successfully.</div>";
    header("refresh:2,url='PetServices.php'");
}

?>

<br>

<div class="makeS-Tappointment">
    <div class="sitterappointmentform">
        <form method="post">

            <h1>Appointment Details</h1>
            <?= $error ?? "" ?>
            <?= $success ?? "" ?>

            <h4> Choose Reservation Interval</h4>

            <div class="form-group">
                <label for="start_at" class="form-label">Start*</label>
                <div class="input-group date" id="id_startTime" data-target-input="nearest">
                    <input name="start_at" type="date" class="form-control datetimepicker-input" data-target="#id_startTime" value="<?= $validation->getOldValue('start_at') ?>" />
                    <div class="input-group-append" data-target="#id_startTime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa-solid fa-clock"></i></div>
                    </div>
                </div>
            </div>
            <?= $validation->getMessage('start_at') ?>

            <div class="form-group">
                <label for="end_at" class="form-label">End*</label>
                <div class="input-group date" id="id_endTime" data-target-input="nearest">
                    <input name="end_at" type="date" class="form-control datetimepicker-input" data-target="#id_endTime" value="<?= $validation->getOldValue('end_at') ?>" />
                    <div class="input-group-append" data-target="#id_endTime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa-solid fa-clock"></i></div>
                    </div>
                </div>
            </div>
            <?= $validation->getMessage('end_at') ?>

            <h4>Hotel Service Details</h4>

            <div class="mb-3">
                <label for="type_of_room" class="form-label">Type of Room*</label>
                <select class="form-control" name="type_of_room" aria-label=".form-select-lg example">
                    <option <?= $validation->getOldValue('type_of_room') == '0' ? 'selected' : '' ?> value="0">Single</option>
                    <option <?= $validation->getOldValue('type_of_room') == '1' ? 'selected' : '' ?> value="1">Double</option>
                </select>
            </div>
            <input type="hidden" name="se" value="1">
            <button type="submit" class="btn ok">OK</button>
        </form>

        <!-- Price section -->
        <?php if (isset($_POST['start_at']) && isset($_POST['end_at']) && isset($_POST['type_of_room'])) : ?>
            <form id="confirmForm" method="post">
                <?php
                $numberOfNights = calculateNumberOfNights($_POST['start_at'], $_POST['end_at']);
                $priceOfRoom = $_POST['type_of_room'] == 0 ? 600 : 1200;
                $totalPrice = $priceOfRoom * $numberOfNights;
                ?>
                <div class="price">
                    <p class="pone">Price Per Room:</p>
                    <p class="ptwo"><?= $priceOfRoom ?> LE</p>
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
    $(function() {
        $('#id_startTime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
        });

        $('#id_endTime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
        });
    });
</script>

<script src="https://kit.fontawesome.com/c442858b7c.js" crossorigin="anonymous"></script>
</body>

</html>