<?php

$title = "Sitters";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Sitter;

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

    $sitterObj = new Sitter;
    $addresses = $sitterObj->retrieveSittersAddresses();

    // Create an array to store sitters with distances
    $nearestSitters = [];

    $maxDistance = 100;
    foreach ($addresses as $address) {
        $sitterLat = $address['lat'];
        $sitterLon = $address['lng'];
        $addressId = $address['id'];

        $distance = calculateDistance($userLat, $userLon, $sitterLat, $sitterLon);

        // Store the sitter details along with the distance in the array
        if ($distance <= $maxDistance) {
            $nearestSitters[] = [
                'addressId' => $addressId,
                'address' => $address['address'],
                'distance' => $distance
            ];
        }
    }
    $_SESSION['nearest_sitters'] = $nearestSitters;
} ?>

<br>

<div class="spcontent">
    <div class="row">
        <div class="spimage">
            <img src="assets/img/YImages/sitters.png">
        </div>
    </div>
    <h2>Find A Best Sitter For Your Pet</h2>
    <div class="section2">
        <div class="row">
            <h1>Find Nearest Sitter</h1><br>
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
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['nearest_sitters'])) {
                $nearestSitters = $_SESSION['nearest_sitters'];

                // Sort the sitters array based on distance
                usort($nearestSitters, function ($a, $b) {
                    return $a['distance'] <=> $b['distance'];
                });
                foreach ($nearestSitters as $sitter) {
            ?>
                    <?php
                    // Retrieve the sitter information using the address ID
                    $sitterInfo = $sitterObj->retrieveSitterInfoByAddressId($sitter['addressId']);

                    ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                        <a href="SitterBooking.php?id=<?= $sitterInfo['address_id'] ?>">
                            <div class="circle">
                                <div class="pimage">
                                    <img src="assets/img/UsersUploads/<?= $sitterInfo['image'] != "default.jpg" ? $sitterInfo['image'] : "defaultSitter.jpeg" ?>">
                                </div>
                                <p> <?= $sitterInfo['first_name'] . " " . $sitterInfo['last_name'] ?></p>
                            </div>
                        </a>
                    </div>
                <?php
                }
                echo '</div>';
            } else {
                ?>
                <?php
                $sitterObj2 = new Sitter;
                $allSitters = $sitterObj2->read();
                foreach ($allSitters as $sitter) {
                ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                        <a href="SitterBooking.php?id=<?= $sitter['address_id'] ?>">
                            <div class="circle">
                                <div class="pimage">
                                    <img src="assets/img/UsersUploads/<?= $sitter['image'] != "default.jpg" ? $sitter['image'] : "defaultSitter.jpeg" ?>">
                                </div>
                                <p><?= $sitter['first_name'] . ' ' . $sitter['last_name'] ?></p>
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