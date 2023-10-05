<?php

$title = "Reciet";
include "layouts/header.php";
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->service_provider_status == 0) {
        include "layouts/navbarRegisteredCustomer.php";
    } else {
        include "layouts/navbarRegisteredSP.php";
    }
} else {
    include "layouts/navbar.php";
}
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Cart;
use App\Database\Models\Order;
use App\Database\Models\Order_Product;
use App\Database\Models\Address;




if ($_GET && isset($_GET["P"])) {
    $totalPrice = $_GET["P"];
}

$userLat = isset($_POST['lats']) ? $_POST['lats'] : null;
$userLon = isset($_POST['longs']) ? $_POST['longs'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['longs'])) {

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

    $ourPlaceLat = 30.038527;
    $ourPlaceLon = 31.212299;
    $distance = calculateDistance($userLat, $userLon, $ourPlaceLat, $ourPlaceLon);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flexRadioDefault'])) {

    $address = new Address;
    $address->setLat($_POST['lats2'])->setLng($_POST['longs2'])->setAddress($_POST['address2'])->setUser_id($_SESSION['user']->id);
    $address->create();


    $Taddress = $address->getAddressInfoByUserId($_SESSION['user']->id);

    $order = new Order;
    if ($Taddress) {
        $address_id = $Taddress->id;

        $Ndistance = isset($_POST['distance2']) ? floatval($_POST['distance2']) : 0;
        $shippingFee = 6 * $Ndistance;
        $totalPriceWithShipping = $totalPrice + $shippingFee;
        $order->setTotal_price(round($totalPriceWithShipping))->setStatus(1)->setAddress_id($address_id);

        $order->create();
    }


    $orders = $order->read();
    foreach ($orders as $Torder) {
        $order_id = $Torder['id'];
    }

    $cartObj = new Cart;
    $cartObj->setUser_id($_SESSION['user']->id);
    $carts = $cartObj->read();

    $order_product = new Order_Product;
    foreach ($carts as $cart) {

        $order_product->setProduct_id($cart['product_id'])->setQuantity($cart['quantity_needed'])->setOrder_id($order_id);
        if ($order_product->create()) {

            $cartObj->deleteCart();
            $success = "<div class='alert alert-success text-center'> Order is created successfully.</div>";
            header('refresh:3;url=Confirmation.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }
    }
}


?>

<br>


<div class="recietcontent">
    <div class="row">
        <div class="storeimage">
            <img src="assets/img/YImages/store.png">
        </div>
    </div>

    <?= $error ?? "" ?>
    <?= $success ?? "" ?>
    <div class="locationbox">
        <div class="row">

            <h1>Shipping Location</h1>
            <br>
            <form method="post" action="" id="searchForm" style="width: 100%;">
                <div class="mb-3" style=" width: 100%; display: flex;">
                    <!-- <input type="text" placeholder="Enter The Shipping Location" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"> -->

                    <input type="hidden" name="lats" id="lats" value="<?= isset($_POST['lats']) ? $_POST['lats'] : '' ?>">
                    <input type="hidden" name="longs" id="longs" value="<?= isset($_POST['longs']) ? $_POST['longs'] : '' ?>">
                    <input type="hidden" name="address" id="address" value="<?= isset($_POST['address']) ? $_POST['address'] : '' ?>">

                    <input type="hidden" name="distance" id="distance" value="<?= isset($distance) ? $distance : 0 ?>">

                    <p style=" font-size: 20px;">we need your location clearly for shipping so we need to use the location.</p>
                    <button style=" width: 20%; margin-left: 2%; margin-top: -9px;" type="button" id="findButton" class="searchButton">Allow <i class="ri-search-line"></i></button>

                </div>
            </form>
        </div>
    </div>

    <form action="" method="POST">
        <div class="recietbox">

            <h1>Reciet</h1>

            <br>

            <p>SubTotal: <?= $totalPrice . " LE" ?></p>
            <p>Shipping Fee: <?= (6 * (isset($distance) ? $distance : 0)) . " LE" ?> </p>
            <hr>
            <?php $FinalPrice = round(($totalPrice +  (6 * (isset($distance) ? $distance : 0)))) ?>
            <p>Total: <?= $FinalPrice . " LE" ?></p>
        </div>


        <input type="hidden" name="address2" id="addressHidden">
        <input type="hidden" name="longs2" id="longsHidden">
        <input type="hidden" name="lats2" id="latsHidden">
        <input type="hidden" name="distance2" id="distanceHidden">

        <div class="paymentbox">

            <h1>Payment Method</h1>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">Cash on Delivery</label>
            </div>

        </div>

        <div class="row">
            <button type="submit" id="proceedButton">Confirm Order</button>
            <button><a href="ShoppingCart.php">Cancel</a></button>
        </div>

    </form>
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
        // ...

        function getLocationAddress(lat, long, callback) {
            const apiKey = "00Fym3GhTRmEXjth4EMBSuDeUbLjnqG8";
            const url = `https://www.mapquestapi.com/geocoding/v1/reverse?key=${apiKey}&location=${lat},${long}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.info.statuscode === 0) {
                        const addressData = data.results[0].locations[0];
                        let address = '';

                        if (addressData.street) {
                            address += addressData.street + ', ';
                        }
                        if (addressData.adminArea6) {
                            address += addressData.adminArea6 + ', ';
                        }
                        if (addressData.adminArea5) {
                            address += addressData.adminArea5 + ', ';
                        }
                        if (addressData.adminArea4) {
                            address += addressData.adminArea4 + ', ';
                        }
                        if (addressData.adminArea3) {
                            address += addressData.adminArea3 + ', ';
                        }
                        if (addressData.adminArea1) {
                            address += addressData.adminArea1;
                        }

                        callback(address); // Pass the address to the callback function
                    } else {
                        console.log("Address not found");
                    }
                })
                .catch(error => {
                    console.log("Error:", error);
                });
        }

        document.getElementById('latsHidden').value = document.getElementById('lats').value;
        document.getElementById('longsHidden').value = document.getElementById('longs').value;
        document.getElementById('distanceHidden').value = document.getElementById('distance').value;

        document.getElementById('findButton').addEventListener('click', function() {
            getLocation();
        });

        document.getElementById('proceedButton').addEventListener('click', function(event) {
            if (document.getElementById("distance").value == 0) {
                event.preventDefault();
                alert("Please allow access to your location.");
                return;
            }
            window.location.href = "confirmation.php";
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            const lat = position.coords.latitude;
            const long = position.coords.longitude;

            document.getElementById("lats").value = lat;
            document.getElementById("longs").value = long;

            getLocationAddress(lat, long, function(address) {
                document.getElementById("address").value = address;
                document.getElementById("addressHidden").value = address;
                document.getElementById('searchForm').submit();
            });
        }
    });
</script>

</body>

</html>