<?php

$title = "Create Clinic";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

use App\Http\Requests\Validation;
use App\Database\Models\Clinic;
use App\Database\Models\Address;
use App\Database\Models\Veterinary;

$validation = new Validation;

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['name'] ?? "")->setInputValueName('name')->required()->between(2, 32);

    $validation->setInputValue($_POST['phone'] ?? "")->setInputValueName('phone')->required()->regex('/^01[0125][0-9]{8}$/')->unique('users', 'phone');

    $validation->setInputValue($_POST['address'] ?? "")->setInputValueName('address')->required()->validateAddress($_POST['address'])->unique('addresses', 'address');

    $validation->setInputValue($_POST['price'] ?? "")->setInputValueName('price')->required();

    $string = isset($_POST['work_days']) ? implode(', ', $_POST['work_days']) : "";

    $validation->setInputValue($string ?? "")->setInputValueName('work_days')->required();

    $validation->setInputValue($_POST['open_at'] ?? "")->setInputValueName('open_at')->required();

    $validation->setInputValue($_POST['close_at'] ?? "")->setInputValueName('close_at')->required();

    $validation->setInputValue($_FILES['image']['name'] ?? "")->setInputValueName('image')->required();

    if (empty($validation->getErrors())) {

        $clinic = new Clinic;

        $clinic->setName($_POST['name'])
            ->setPhone($_POST['phone'])
            ->setPrice($_POST['price'])
            ->setWork_days($string)
            ->setOpens_at($_POST['open_at'])
            ->setCloses_at($_POST['close_at']);


        if (!empty($_FILES['image']['name'])) {
            $imageName = $_FILES['image']['name']; // Get the name of the uploaded image
            $imagePath = 'assets/img/UsersUploads/' . $imageName;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $clinic->setImage($imageName); // Save only the image name to the user object
        } else {
            // No new image provided, use the existing image name
            $clinic->setImage('clinic.png');
        }


        $address = new Address;
        $address->setAddress($_POST['address'])->setUser_id($_SESSION['user']->id)->setLat($_POST['latitude'])->setLng($_POST['longitude']);
        $address->create();

        $databaseResult2 = $address->setAddress($_POST['address'])->getAddressInfo();
        if ($databaseResult2->num_rows == 1) {
            $databaseAddress = $databaseResult2->fetch_object();
            $_SESSION['address'] = $databaseAddress;
            $clinic->setAddress_id($_SESSION['address']->id);
        }

        if ($clinic->create()) {
            $success = "<div class='alert alert-success text-center'> Clinic account is created successfully..</div>";
            header('refresh:3;url=VetProfile.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }

        $databaseResult3 = $clinic->setPhone($_POST['phone'])->getClinicInfo();
        if ($databaseResult3->num_rows == 1) {
            $databaseClinic = $databaseResult3->fetch_object();
            $_SESSION['clinic'] = $databaseClinic;
        }

        $vet = new veterinary;
        $vet->setClinic_id($_SESSION['clinic']->id)->setUser_id($_SESSION['user']->id);
        $vet->create();
    }
}
?>

<br>

<div class="createclininccontent">
    <div class="container">

        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="left">
                    <?= $error ?? "" ?>
                    <?= $success ?? "" ?>
                    <form id="createclinicform" method="post" enctype="multipart/form-data">
                        <?php
                        if (isset($_SESSION['clinic']) && $_SESSION['clinic']->image == 'default.jpg') {
                            $image = 'clinic.png';
                        } elseif (isset($_SESSION['clinic'])) {
                            $image = $_SESSION['clinic']->image;
                        } else {
                            $image = 'clinic.png';
                        }
                        ?>
                        <h1>Create Clinic Account</h1>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp " value="<?= $validation->getOldValue('name') ?>">
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
                            <label for="price" class="form-label">Price*</label>
                            <input name="price" type="text" class="form-control" id="price" value="<?= $validation->getOldValue('price') ?>">
                            <?= $validation->getMessage('price') ?>
                        </div>
                        <div class="mb-3">
                            <label for="work_days" class="form-label">Work Days*</label><br>
                            <label><input type="checkbox" name="work_days[]" value="Monday"> Monday</label><br>
                            <label><input type="checkbox" name="work_days[]" value="Tuesday"> Tuesday</label><br>
                            <label><input type="checkbox" name="work_days[]" value="Wednesday"> Wednesday</label><br>
                            <label><input type="checkbox" name="work_days[]" value="Thursday"> Thursday</label><br>
                            <label><input type="checkbox" name="work_days[]" value="Friday"> Friday</label><br>
                            <label><input type="checkbox" name="work_days[]" value="Saturday"> Saturday</label><br>
                            <label><input type="checkbox" name="work_days[]" value="Sunday"> Sunday</label><br>
                            <?= $validation->getMessage('work_days') ?>
                        </div>
                        <div class="mb-3">
                            <label for="open_at" class="form-label">Open at*</label>
                            <input name="open_at" type="time" class="form-control" id="open_at" value="<?= $validation->getOldValue('open_at') ?>">
                            <?= $validation->getMessage('open_at') ?>
                        </div>
                        <div class="mb-3">
                            <label for="close_at" class="form-label">Close at*</label>
                            <input name="close_at" type="time" class="form-control" id="close_at" value="<?= $validation->getOldValue('close_at') ?>">
                            <?= $validation->getMessage('close_at') ?>
                        </div>
                        <br><br>
                        <div class="mb-3">
                            <label for="file">
                                Upload Clinic Image*
                            </label>
                            <input type="file" name="image" id="file" onchange="loadFile(event)" value="<?= isset($_FILES['image']['name']) ? $_FILES['image']['name'] : $image ?> ">
                            <?= $validation->getMessage('image') ?>
                        </div>
                        <br><br>
                        <button type="submit" class="btn btn-primary btn-lg">Create</button>
                        <button type="button" class="btn btn-primary btn-lg"> <a href="VetProfile.php">Cancel</a></button>

                        <input type="hidden" id="latitudeInput" name="latitude">
                        <input type="hidden" id="longitudeInput" name="longitude">
                    </form>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="right">
                    <img id="preview-image" src="assets/img/YImages/clinic.png">
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