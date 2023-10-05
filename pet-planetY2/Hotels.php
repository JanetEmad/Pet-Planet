<?php


$title = "Hotels";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Hotel;


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

    $hotelObj = new Hotel;
    $addresses = $hotelObj->retrieveHotelsAddresses();

    $nearestHotels = [];

    $maxDistance = 100;
    foreach ($addresses as $address) {
        $hotelLat = $address['lat']; // Replace with the actual column name for latitude
        $hotelLon = $address['lng']; // Replace with the actual column name for longitude
        $addressId = $address['id']; // Add the address ID to the array

        $distance = calculateDistance($userLat, $userLon, $hotelLat, $hotelLon);

        if ($distance <= $maxDistance) {
            $nearestHotels[] = [
                'addressId' => $addressId,
                'address' => $address['address'],
                'distance' => $distance
            ];
        }
    }
    $_SESSION['nearest_hotels'] = $nearestHotels;
} ?>
<br>

<div class="spcontent">
    <div class="row">
        <div class="spimage">
            <img src="assets/img/YImages/hotels.png">
        </div>
    </div>
    <h2>A Hotel That Hosts You And Your Pet</h2>
    <div class="section2">
        <div class="row">
            <h1>Find Nearest Hotel</h1><br>
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
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['nearest_hotels'])) {
                $nearestHotels = $_SESSION['nearest_hotels'];

                // Sort the hotels array based on distance
                usort($nearestClinics, function ($a, $b) {
                    return $a['distance'] <=> $b['distance'];
                });
                foreach ($nearestHotels as $hotel) {
            ?>
                    <?php
                    // Retrieve the hotel information using the address ID
                    $hotelInfo = $hotelObj->retrieveHotelInfoByAddressId($hotel['addressId']);
                    ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                        <a href="VetBooking.php?id=<?= $hotelInfo['address_id'] ?>">
                            <div class="circle">
                                <div class="pimage">
                                    <img src="assets/img/UsersUploads/<?= $hotelInfo['image'] != "default.jpg" ? $hotelInfo['image'] : "defaultClinic.png" ?>">
                                </div>
                                <p> <?= $hotelInfo['name'] ?></p>
                            </div>
                        </a>
                    </div>
                <?php
                }
                echo '</div>';
            } else {
                ?>
                <?php
                $hotelObj2 = new Hotel;
                $allHotels = $hotelObj2->read();
                foreach ($allHotels as $hotel) {
                ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                        <a href="HotelBooking.php?id=<?= $hotel['address_id'] ?>">
                            <div class="circle">
                                <div class="pimage">
                                    <img src="assets/img/UsersUploads/<?= $hotel['image'] != "default.jpg" ? $hotel['image'] : "defaultHotel.png" ?>">
                                </div>
                                <p><?= $hotel['name']  . " Hotel" ?></p>
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