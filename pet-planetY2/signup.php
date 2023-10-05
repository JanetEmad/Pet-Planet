<?php

use App\Http\Requests\Validation;
use App\Database\Models\User;
use App\Database\Models\Trainer;
use App\Database\Models\Sitter;
use App\Database\Models\Address;
use App\Database\Models\Serviceprovider;
use App\Mail\VerificationCodeMail;



$title = "Signup";

include "layouts/header.php";
include "layouts/navbar.php";
include "App/Http/Middlewares/guest.php";

$validation = new Validation;

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['user'] ?? "")->setInputValueName('user')->required()->in(['Customer', 'Service provider']);

    $validation->setInputValue($_POST['first_name'] ?? "")->setInputValueName('first name')->required()->between(2, 32);

    $validation->setInputValue($_POST['last_name'] ?? "")->setInputValueName('last name')->required()->between(2, 32);

    $validation->setInputValue($_POST['email'] ?? "")->setInputValueName('email')->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->unique('users', 'email');

    $validation->setInputValue($_POST['phone'] ?? "")->setInputValueName('phone')->required()->regex('/^01[0125][0-9]{8}$/')->unique('users', 'phone');

    $validation->setInputValue($_POST['password'] ?? "")->setInputValueName('password')->required()->regex("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/", "Minimum 8 and maximum 32 characters, at least one uppercase letter, one lowercase letter, one number and one special character.")->confirmed($_POST['password_confirmation']);

    $validation->setInputValue($_POST['password_confirmation'] ?? "")->setInputValueName('password confirmation')->required();

    $validation->setInputValue($_POST['gender'] ?? "")->setInputValueName('gender')->required()->in(['m', 'f']);


    if (isset($_POST['interest']) && ($_POST['interest'] == "trainer" || $_POST['interest'] == "sitter")) {
        $validation->setInputValue($_POST['address'] ?? "")->setInputValueName('address')->required()->validateAddress($_POST['address'])->unique('addresses', 'address');
        $validation->setInputValue($_POST['work_days'] ?? "")->setInputValueName('work_days')->required();
        $validation->setInputValue($_POST['price_per_hour'] ?? "")->setInputValueName('price_per_hour')->required();
    }

    if (empty($validation->getErrors())) {

        $verification_code = rand(100000, 999999);

        $user = new User;

        $user->setFirst_name($_POST['first_name'])
            ->setLast_name($_POST['last_name'])
            ->setEmail($_POST['email'])
            ->setPassword($_POST['password'])
            ->setGender($_POST['gender'])
            ->setPhone($_POST['phone'])
            ->setVerification_code($verification_code)
            ->SetAdmin_status(0)
            ->setImage("default.jpg")
            ->setBanned(0);;

        if ($_POST['user'] == 'Customer') {
            $user->setService_provider_status(0);
        } else {
            $user->setService_provider_status(1);
        }

        if (isset($_POST['interest'])) {
            if ($_POST['interest'] == 'vet') {
                $user->setService_provider_type(0);
            } else if ($_POST['interest'] == 'trainer') {
                $user->setService_provider_type(1);
            } else if ($_POST['interest'] == 'sitter') {
                $user->setService_provider_type(2);
            } else {
                $user->setService_provider_type(3);
            }
        }


        if ($user->create()) {

            $subject = "Verification Mail";
            $body = "<p> Hello {$_POST['first_name']} {$_POST['last_name']}.</p>
            <p> In order to use pet planet, you must confirm your email<br> address. Your
            Verification Code:<b style='color:blue;'> {$verification_code} </b></p>
            <p> Thank You!</p>";

            // $verificationMail = new VerificationCodeMail;

            // if ($verificationMail->send($_POST['email'], $subject, $body)) {

            //     $_SESSION['verification_email'] = $_POST['email'];
            //     header('location:verification-code.php');
            //     die;
            // } else {
            //     $error = "<div class='alert alert-danger' > Please Try Again Later </div>";
            // }

            $databaseResult = $user->setEmail($_POST['email'])->getUserInfo();
            if ($databaseResult->num_rows == 1) {
                $databaseUser = $databaseResult->fetch_object();
                $_SESSION['user'] = $databaseUser;
            }

            //----------------------------------------------------------------------------
            // delete this part when the email verification part work
            if ($_SESSION['user']->service_provider_status == 0) {
                header('location:CustomerHome.php');
            } else {
                header('location:ServiceProviderHome.php');
            }
            //----------------------------------------------------------------------------

        }


        if ($_SESSION['user']->service_provider_status == 1) {
            $serviceprovider = new Serviceprovider;
            $serviceprovider->setUser_id($_SESSION['user']->id)->setService_provider_type($_SESSION['user']->service_provider_type);
            $serviceprovider->create();
        }

        if (isset($_POST['interest']) && isset($_POST['address']) && $_POST['interest'] != "vet") {
            $address = new Address;
            $address->setAddress($_POST['address'])->setUser_id($_SESSION['user']->id)->setLat($_POST['latitude'])->setLng($_POST['longitude']);
            $address->create();

            $databaseResult2 = $address->setAddress($_POST['address'])->getAddressInfo();
            if ($databaseResult2->num_rows == 1) {
                $databaseAddress = $databaseResult2->fetch_object();
                $_SESSION['address'] = $databaseAddress;
            }
            if ($_POST['interest'] == 'trainer') {
                $trainer = new Trainer;
                $trainer->setWork_days($_POST['work_days'])->setPrice_per_hour($_POST['price_per_hour'])->setAddress_id($_SESSION['address']->id)->setUser_id($_SESSION['user']->id);
                $trainer->create();
            } else if ($_POST['interest'] == 'sitter') {
                $sitter = new Sitter;
                $sitter->setWork_days($_POST['work_days'])->setPrice_per_hour($_POST['price_per_hour'])->setAddress_id($_SESSION['address']->id)->setUser_id($_SESSION['user']->id);
                $sitter->create();
            }
        }
    } else {
        $error = "<div class='alert alert-danger' > Something went wrong </div>";
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign-up Form</title>
    <style>
        .hidden {
            display: none;
        }
    </style>

    <head>
        <link rel="stylesheet" href="assets/css/forSignn.css">
    </head>
</head>

<body>
    <div class="signup-container">
        <div class="signup-page">

            <div class="form">
                <div class="signup">
                    <div class="signup-header">
                        <h3 class="header2" style="text-align:center;">Sign up</h3>
                    </div>
                </div>
                <?= $error ?? "" ?>
                <form id="signup-form" class="signup-form" action="#" method="post">

                    <label class="as">As</label><br>
                    <select name="user" class="form-control my-2" id="user-select" onchange="handleUserSelectChange()">
                        <option <?= $validation->getOldValue('user') == 'Customer' ? 'selected' : '' ?> value="Customer">Customer</option>
                        <option <?= $validation->getOldValue('user') == 'Service provider' ? 'selected' : '' ?> value="Service provider">Service Provider</option>
                    </select>
                    <?= $validation->getMessage('user') ?>

                    <label>First Name*</label>
                    <input class="i2" id="fn" type="text" placeholder="Enter your First Name..." name="first_name" value="<?= $validation->getOldValue('first_name') ?>" />
                    <?= $validation->getMessage('first name') ?>

                    <label>Last Name*</label>
                    <input class="i2" id="ln" type="text" placeholder="Enter your Last Name..." name="last_name" value="<?= $validation->getOldValue('last_name') ?>" />
                    <?= $validation->getMessage('last name') ?>

                    <label for="email">Email*</label>
                    <input class="i2" id="email" type="text" placeholder="Enter your email..." name="email" value="<?= $validation->getOldValue('email') ?>" />
                    <?= $validation->getMessage('email') ?>

                    <label>Phone*</label>
                    <input class="i2" id="phone" type="phone" placeholder="Enter your phone..." name="phone" value="<?= $validation->getOldValue('phone') ?>" />
                    <?= $validation->getMessage('phone') ?>

                    <label for="password">Password*</label>
                    <input class="i2" id="password" type="password" placeholder="Enter your password..." name="password" />
                    <?= $validation->getMessage('password') ?>

                    <label>Confirm Password*</label>
                    <input class="i2" id="password_confirmation" type="password" placeholder="Confirm your password..." name="password_confirmation" />
                    <?= $validation->getMessage('password_confirmation') ?>

                    <label>Gender*</label><br>
                    <select name="gender" class="form-control my-2" id="gender-select">
                        <option <?= $validation->getOldValue('gender') == 'm' ? 'selected' : '' ?> value="m">Male</option>
                        <option <?= $validation->getOldValue('gender') == 'f' ? 'selected' : '' ?> value="f">Female</option>
                    </select>
                    <?= $validation->getMessage('gender') ?>

                    <div id="service-provider-type-section">
                        <label>Service Provider Type:</label><br>
                        <div style="margin-top:20px; display: inline-flex; width: 100%; justify-content: space-around;">
                            <label>
                                Vet<input id="interest1" type="radio" name="interest" value="vet" onchange="handleRadioButtonChange('vet')"><br></label>
                            <label>
                                Trainer<input id="interest2" type="radio" name="interest" value="trainer" onchange="handleRadioButtonChange('trainer')"><br></label>
                            <label>
                                Sitter<input id="interest3" type="radio" name="interest" value="sitter" onchange="handleRadioButtonChange('sitter')"><br></label>
                            <label>
                                Hotel Manager<input id="interest4" type="radio" name="interest" value="hotel" onchange="handleRadioButtonChange('hotel')"><br></label>
                        </div>
                    </div>

                    <div id="dynamic-fields">
                        <!-- Dynamic fields for each radio button -->
                        <div id="dynamic-fields-vet" class="dynamic-fields hidden"></div>


                        <div id="dynamic-fields-trainer" class="dynamic-fields hidden">
                            <label for="field2a">Work Days*</label>
                            <input type="text" id="field2a" name="work_days"><br><br>
                            <label for="field2b">Price per hour*</label>
                            <input type="number" id="field2b" name="price_per_hour" min="0" step="1"><br><br>
                            <label for="field2c">Address*</label>
                            <input type="text" id="field2c" name="address"><br><br>
                        </div>

                        <div id="dynamic-fields-sitter" class="dynamic-fields hidden">
                            <label for="field3a">Work Days*</label>
                            <input type="text" id="field3a" name="work_days"><br><br>
                            <label for="field3b">Price per hour*</label>
                            <input type="number" id="field3b" name="price_per_hour" min="0" step="1"><br><br>
                            <label for="field3c">Address*</label>
                            <input type="text" id="field3c" name="address"><br><br>
                        </div>

                        <div id="dynamic-fields-hotel" class="dynamic-fields hidden"></div>
                    </div>

                    <input type="hidden" id="latitudeInput" name="latitude">
                    <input type="hidden" id="longitudeInput" name="longitude">

                    <button class="b2" type="submit">Sign up</button>
                    <p style="text-align:center ;" class="message2">Already a user? <a href="signin.php">Sign in</a></p>
                </form>
            </div>

        </div>

        <div class="images">
            <img class="signupimage" src="assets/img/other/signupPhoto.png" alt="">
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Get the dynamic fields container
        var dynamicFieldsContainer = document.getElementById("dynamic-fields");

        // Get the service provider type section
        var serviceProviderTypeSection = document.getElementById("service-provider-type-section");

        // Hide the dynamic fields and service provider type section initially
        dynamicFieldsContainer.classList.add("hidden");
        serviceProviderTypeSection.style.display = "none";

        // Handle user select box change event
        function handleUserSelectChange() {
            var userSelect = document.getElementById("user-select");

            if (userSelect.value === "Service provider") {
                serviceProviderTypeSection.style.display = "block";
            } else {
                serviceProviderTypeSection.style.display = "none";
            }
        }

        function handleRadioButtonChange(interest) {
            resetDynamicFields();
            var dynamicFields = document.getElementById("dynamic-fields-" + interest);
            dynamicFields.classList.remove("hidden");
            dynamicFieldsContainer.style.display = "block";
        }

        function resetDynamicFields() {
            var dynamicFields = document.getElementsByClassName("dynamic-fields");
            for (var i = 0; i < dynamicFields.length; i++) {
                dynamicFields[i].classList.add("hidden");
            }
        }

        $(document).ready(function() {
            var dynamicFieldsContainer = $("#dynamic-fields");
            dynamicFieldsContainer.addClass("hidden");

            $("#user-select").on("change", function() {
                var userSelect = $(this).val();
                var serviceProviderTypeSection = $("#service-provider-type-section");

                if (userSelect === "Service provider") {
                    serviceProviderTypeSection.show();
                } else {
                    serviceProviderTypeSection.hide();
                    resetDynamicFields();
                }
            });

            $("input[name='interest']").on("change", function() {
                resetDynamicFields();
                var interest = $(this).val();
                $("#dynamic-fields-" + interest).removeClass("hidden");
                dynamicFieldsContainer.show();
            });
        });

        $(document).ready(function() {
            $("#signup-form").on("submit", function(event) {

                var selectedInterest = $("input[name='interest']:checked").val();

                if (selectedInterest) {
                    if (selectedInterest == "sitter" || selectedInterest == "trainer") {
                        event.preventDefault();
                    }
                    var dynamicFields = $("#dynamic-fields-" + selectedInterest + " input");
                    dynamicFields.each(function() {
                        var inputName = $(this).attr("name");
                        var inputValue = $(this).val();
                        $("<input>")
                            .attr("type", "hidden")
                            .attr("name", inputName)
                            .val(inputValue)
                            .appendTo("#signup-form");
                        if (inputName == "address") {
                            var address = inputValue;
                            getLatLng(address);
                        }
                    });

                }

                return true;
            });
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
                $("#signup-form").off("submit").submit();
            });
        }
    </script>
</body>

</html>