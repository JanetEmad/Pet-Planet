<?php

$title = "Create Hotel";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

use App\Http\Requests\Validation;
use App\Database\Models\Hotel;
use App\Database\Models\Address;
use App\Database\Models\HotelManager;

$validation = new Validation;

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['name'] ?? "")->setInputValueName('name')->required()->between(2, 32);

    $validation->setInputValue($_POST['phone'] ?? "")->setInputValueName('phone')->required()->regex('/^01[0125][0-9]{8}$/')->unique('users', 'phone');

    $validation->setInputValue($_POST['address'] ?? "")->setInputValueName('address')->required()->validateAddress($_POST['address'])->unique('addresses', 'address');

    $validation->setInputValue($_POST['star-rating'] ?? "")->setInputValueName('star-rating')->required();

    $validation->setInputValue($_FILES['image']['name'] ?? "")->setInputValueName('image')->required();

    if (empty($validation->getErrors())) {

        $hotel = new Hotel;

        $hotel->setName($_POST['name'])
            ->setPhone($_POST['phone'])
            ->setRate($_POST['star-rating'])
            ->setUser_id($_SESSION['user']->id);


        if (!empty($_FILES['image']['name'])) {
            $imageName = $_FILES['image']['name']; // Get the name of the uploaded image
            $imagePath = 'assets/img/UsersUploads/' . $imageName;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $hotel->setImage($imageName); // Save only the image name to the user object
        } else {
            // No new image provided, use the existing image name
            $hotel->setImage('pethotelimg.jpg');
        }


        $address = new Address;
        $address->setAddress($_POST['address'])->setUser_id($_SESSION['user']->id)->setLat($_POST['latitude'])->setLng($_POST['longitude']);
        $address->create();

        $databaseResult2 = $address->setAddress($_POST['address'])->getAddressInfo();
        if ($databaseResult2->num_rows == 1) {
            $databaseAddress = $databaseResult2->fetch_object();
            $_SESSION['address'] = $databaseAddress;
            $hotel->setAddress_id($_SESSION['address']->id);
        }

        if ($hotel->create()) {
            $success = "<div class='alert alert-success text-center'> Hotel account is created successfully..</div>";
            header('refresh:3;url=HotelManagerProfile.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }

        $databaseResult3 = $hotel->setPhone($_POST['phone'])->getHotelInfo();
        if ($databaseResult3->num_rows == 1) {
            $databaseHotel = $databaseResult3->fetch_object();
            $_SESSION['hotel'] = $databaseHotel;
        }

        $hotelmanager = new HotelManager;
        $hotelmanager->setHotel_id($_SESSION['hotel']->id)->setUser_id($_SESSION['user']->id);
        $hotelmanager->create();
    }
}
?>

<br>

<head>
    <link rel="stylesheet" href="assets/css/rate.css">
</head>

<div class="createhotelcontent">
    <div class="container">

        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="left">
                    <?= $error ?? "" ?>
                    <?= $success ?? "" ?>
                    <form method="post" enctype="multipart/form-data">
                        <?php
                        if (isset($_SESSION['hotel']) && $_SESSION['hotel']->image == 'default.jpg') {
                            $image = 'pethotelimg.jpg';
                        } elseif (isset($_SESSION['hotel'])) {
                            $image = $_SESSION['hotel']->image;
                        } else {
                            $image = 'pethotelimg.jpg';
                        }
                        ?>
                        <h1>Create Hotel Account</h1>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="<?= $validation->getOldValue('name') ?>">
                            <?= $validation->getMessage('name') ?>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone*</label>
                            <input name="phone" type="text" class="form-control" id="phone" value="<?= $validation->getOldValue('phone') ?>">
                            <?= $validation->getMessage('phone') ?>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address*</label>
                            <input name="address" type="text" class="form-control" id="address" value="<?= $validation->getOldValue('address') ?>">
                            <?= $validation->getMessage('address') ?>
                        </div>
                        <div class="mb-3">
                            <label for="star-rating" class="form-label">Stars*</label>

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
                            <?= $validation->getMessage('star-rating') ?>
                        </div>
                        <br><br>
                        <div class="mb-3">
                        <label for="image" class="form-label">Upload Hotel Image*</label>
                        <input type="file" name="image" id="file" onchange="loadFile(event)" value="<?= isset($_FILES['image']['name']) ? $_FILES['image']['name'] : $image ?> ">
                        <?= $validation->getMessage('image') ?>
                        </div>
                        <br><br>
                        <button type="submit" class="btn btn-primary btn-lg">Create</button>
                        <button type="button" class="btn btn-primary btn-lg"><a href="HotelManagerProfile.php">Cancel</a></button>

                        <input type="hidden" id="latitudeInput" name="latitude">
                        <input type="hidden" id="longitudeInput" name="longitude">
                    </form>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="right">
                    <img src="assets/img/YImages/pethotelimgg.jpg">
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('file');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src); // free memory
        };
    };

    $("#createclinicform").on("submit", function(event) {
        event.preventDefault();
        var addressInput = $("input[name='address']");
        var addressValue = addressInput.val();

        if (addressValue) {
            getLatLng(addressValue);
        }

        return true;
    });

    function getLatLng(address) {
        var apiKey = "00Fym3GhTRmEXjth4EMBSuDeUbLjnqG8";
        var geocodingURL = "https://www.mapquestapi.com/geocoding/v1/address";
        var requestURL = `${geocodingURL}?key=${apiKey}&location=${encodeURIComponent(address)}`;

        $.getJSON(requestURL, function(data) {
            var latLng = data.results[0].locations[0].latLng;
            var latitudeInput = document.getElementById("latitudeInput");
            var longitudeInput = document.getElementById("longitudeInput");
            latitudeInput.value = latLng.lat;
            longitudeInput.value = latLng.lng;

            // Update hidden inputs for latitude and longitude
            $("input[name='latitude']").val(latitudeInput.value);
            $("input[name='longitude']").val(longitudeInput.value);

            // Submit the form
            $("#createclinicform").off("submit").submit();
        });
    }
</script>
</body>

</html>