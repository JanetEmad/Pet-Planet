<?php

$title = "Trainers";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Trainer;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userLat = isset($_POST['lats']) ? $_POST['lats'] : null;
    $userLon = isset($_POST['longs']) ? $_POST['longs'] : null;

    function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius of the earth in kilometers

        $lat1RadF = floatval($lat1);
        $lon1RadF = floatval($lon1);
        $lat2RadF = floatval($lat2);
        $lon2RadF = floatval($lon2);

        $lat1Rad = deg2rad($lat1RadF);
        $lon1Rad = deg2rad($lon1RadF);
        $lat2Rad = deg2rad($lat2RadF);
        $lon2Rad = deg2rad($lon2RadF);

        $lonDelta = $lon2Rad - $lon1Rad;

        $x = cos($lat2Rad) * sin($lonDelta);
        $y = cos($lat1Rad) * sin($lat2Rad) - sin($lat1Rad) * cos($lat2Rad) * cos($lonDelta);

        $distance = atan2(sqrt($x * $x + $y * $y), sin($lat1Rad) * sin($lat2Rad) + cos($lat1Rad) * cos($lat2Rad) * cos($lonDelta));
        $distance = $distance * $earthRadius; // Distance in kilometers

        return $distance;
    }

    $trainerObj = new Trainer;
    $addresses = $trainerObj->retrieveTrainersAddresses();

    // Create an array to store trainers with distances
    $nearestTrainers = [];

    $maxDistance = 100;
    foreach ($addresses as $address) {
        $trainerLat = $address['lat'];
        $trainerLon = $address['lng'];
        $addressId = $address['id'];

        $distance = calculateDistance($userLat, $userLon, $trainerLat, $trainerLon);

        // Store the trainer details along with the distance in the array
        if ($distance <= $maxDistance) {
            $nearestTrainers[] = [
                'addressId' => $addressId,
                'address' => $address['address'],
                'distance' => $distance
            ];
        }
    }
    $_SESSION['nearest_trainers'] = $nearestTrainers;
} ?>

<br>

<div class="spcontent">
    <div class="row">
        <div class="spimage">
            <img src="assets/img/YImages/trainers.png">
        </div>
    </div>
    <h2>Find A Best Trainer For Your Pet</h2>
    <div class="section2">
        <div class="row">
            <h1>Find Nearest Trainer</h1><br>
            <form method="post" action="" id="searchForm">
                <input type="hidden" name="lats" id="lats">
                <input type="hidden" name="longs" id="longs">
                <button type="button" id="findButton" class="searchButton"><i class="ri-search-line"></i></button>
            </form>
        </div>
    </div>

    <div class="section3">
        <div class="row">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['nearest_trainers'])) {
                $nearestTrainers = $_SESSION['nearest_trainers'];

                // Sort the trainers array based on distance
                usort($nearestTrainers, function ($a, $b) {
                    return $a['distance'] <=> $b['distance'];
                });
                foreach ($nearestTrainers as $trainer) {
            ?>
                    <?php
                    // Retrieve the trainer information using the address ID
                    $trainerInfo = $trainerObj->retrieveTrainerInfoByAddressId($trainer['addressId']);

                    ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                        <a href="TrainerBooking.php?id=<?= $trainerInfo['address_id'] ?>">
                            <div class="circle">
                                <div class="pimage">
                                    <img src="assets/img/UsersUploads/<?= $trainerInfo['image'] != "default.jpg" ? $trainerInfo['image'] : "defaultTrainer.jpeg" ?>">
                                </div>
                                <p> <?= $trainerInfo['first_name'] . " " . $trainerInfo['last_name'] ?></p>
                            </div>
                        </a>
                    </div>
                <?php
                }
                echo '</div>';
            } else {
                ?>
                <?php
                $trainerObj2 = new Trainer;
                $allTrainers = $trainerObj2->read();
                foreach ($allTrainers as $trainer) {
                ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                        <a href="TrainerBooking.php?id=<?= $trainer['address_id'] ?>">
                            <div class="circle">
                                <div class="pimage">
                                    <img src="assets/img/UsersUploads/<?= $trainer['image'] != "default.jpg" ? $trainer['image'] : "defaultTrainer.jpeg" ?>">
                                </div>
                                <p> <?= $trainer['first_name'] . ' ' . $trainer['last_name'] ?></p>
                            </div>
                        </a>
                    </div>
            <?php
                }
            }
            ?>

        </div>
    </div>

</div>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            document.getElementById("lats").value = position.coords.latitude;
            document.getElementById("longs").value = position.coords.longitude;

            // Submit the form when the location is obtained
            document.getElementById('searchForm').submit();
        }

        document.getElementById('findButton').addEventListener('click', function() {
            getLocation();
        });
    });
</script>
</body>

</html>