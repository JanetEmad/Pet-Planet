<?php
$title = "Rate";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Rate;

use App\Database\Models\Sitter;
use App\Database\Models\Trainer;
use App\Database\Models\Clinic;
use App\Database\Models\Hotel;

if (isset($_POST['star-rating'])) {
    $rate = new Rate;

    $rate->setService_provider_id($_GET['id'])->setUser_id($_SESSION['user']->id)->setRate($_POST['star-rating']);
    if ($rate->create()) {
        $success = "<div class='alert alert-success text-center'> Thank you for your time.</div>";
        header('refresh:3;url=PetServices.php');
    } else {
        $error = "<div class='alert alert-danger' > Something went wrong </div>";
    }
    if ($_GET['type'] === "Sitter") {
        $sitterid = ($_GET['id']);
        $sitter = new Sitter;
        $sitter->setUser_id($sitterid);

        $rate->setService_provider_id($_GET['id']);
        $overallRate = ceil(($rate->rateSum()) / ($rate->rateCount()));
        if ($overallRate > 5) {
            $overallRate = 5;
        }
        $sitter->setRate($overallRate);
        $sitter->updateRate();
    } else if ($_GET['type'] === "Trainer") {
        $trainerid = ($_GET['id']);
        $trainer = new Trainer;
        $trainer->setUser_id($trainerid);

        $rate->setService_provider_id($_GET['id']);
        $overallRate = ceil(($rate->rateSum()) / ($rate->rateCount()));
        if ($overallRate > 5) {
            $overallRate = 5;
        }
        $trainer->setRate($overallRate);
        $trainer->updateRate();
    } else if ($_GET['type'] === "Vet") {
        $clinicAddId = ($_GET['id']);
        $clinic = new Clinic;
        $clinic->setAddress_id($clinicAddId);

        $rate->setService_provider_id($_GET['id']);
        $overallRate = ceil(($rate->rateSum()) / ($rate->rateCount()));
        if ($overallRate > 5) {
            $overallRate = 5;
        }
        $clinic->setRate($overallRate);
        $clinic->updateRate();
    } else {
        $hotelid = ($_GET['id']);
        $hotel = new Hotel;
        $hotel->setUser_id($hotelid);

        $rate->setService_provider_id($_GET['id']);
        $overallRate = ceil(($rate->rateSum()) / ($rate->rateCount()));
        if ($overallRate > 5) {
            $overallRate = 5;
        }
        $hotel->setRate($overallRate);
        $hotelid->updateRate();
    }
}
?>

<head>
    <link rel="stylesheet" href="assets/css/rate.css">
</head>
<div class="ratecontent">

    <?= $error ?? "" ?>
    <?= $success ?? "" ?>
    <div class="container">

        <div class="ratebox">

            <h1>Please Rate This <?= $_GET['type'] ?></h1>

            <form action="" method="POST" id="ratingForm">
                <div class="ratestars ">

                    <div class="ratecontainer-wrapper">
                        <div class="ratecontainer d-flex align-items-center justify-content-center">
                            <div class="row justify-content-center">

                                <!-- star rating -->
                                <div class="rating-wrapper">

                                    <!-- star 5 -->
                                    <input class="rating" type="radio" id="5-star-rating" name="star-rating" value="5">
                                    <label for="5-star-rating" class="star-rating">
                                        <i class="fas fa-star d-inline-block"></i>
                                    </label>

                                    <!-- star 4 -->
                                    <input class="rating" type="radio" id="4-star-rating" name="star-rating" value="4">
                                    <label for="4-star-rating" class="star-rating star">
                                        <i class="fas fa-star d-inline-block"></i>
                                    </label>

                                    <!-- star 3 -->
                                    <input class="rating" type="radio" id="3-star-rating" name="star-rating" value="3">
                                    <label for="3-star-rating" class="star-rating star">
                                        <i class="fas fa-star d-inline-block"></i>
                                    </label>

                                    <!-- star 2 -->
                                    <input class="rating" type="radio" id="2-star-rating" name="star-rating" value="2">
                                    <label for="2-star-rating" class="star-rating star">
                                        <i class="fas fa-star d-inline-block"></i>
                                    </label>

                                    <!-- star 1 -->
                                    <input class="rating" type="radio" id="1-star-rating" name="star-rating" value="1">
                                    <label for="1-star-rating" class="star-rating star">
                                        <i class="fas fa-star d-inline-block"></i>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="ratingInput" name="rating" value="">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>
        </form>

    </div>
</div>
</body>

</html>