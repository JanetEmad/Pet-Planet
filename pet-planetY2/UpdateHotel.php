<?php

use App\Http\Requests\Validation;
use App\Database\Models\Hotel;
use App\Database\Models\Address;

$title = "Update Hotel";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

$validation = new Validation;

if (isset($_GET['id'])) {
    $hotelId = $_GET['id'];

    $hotel = new Hotel;

    $hotelData = $hotel->fetchHotelDataFromDatabaseByHotelId($hotelId);

    if ($hotelData) {
        $_SESSION['hotelData'] = $hotelData;

        header('Location: UpdateHotel.php');
        exit();
    } else {
        echo "Hotel not found.";
    }
}

if (isset($_SESSION['hotelData'])) {
    $hotelData = $_SESSION['hotelData'];

    $name = $hotelData['name'];
    $phone = $hotelData['phone'];
    $address_id = $hotelData['address_id'];
    $user_id = $hotelData['user_id'];
    $rate = $hotelData['rate'];
    $image = $hotelData['image'];
    $id = $hotelData['id'];

    $address1 = new Address;
    $address1->setId($address_id);
    $hotelAddress = $address1->getAddressInfoById();
} else {
    echo "Hotel data not available.";
}



if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['name'] ?? "")->setInputValueName('name')->between(2, 32);

    $validation->setInputValue($_POST['star-rating'] ?? "")->setInputValueName('star-rating');


    $sessionPhone = $phone ?? ""; // Retrieve phone from the session
    $postPhone = $_POST['phone'] ?? ""; // Retrieve phone from the post data

    if ($sessionPhone !== $postPhone) {
        $validation->setInputValue($postPhone)
            ->setInputValueName('phone')
            ->regex('/^01[0125][0-9]{8}$/')
            ->unique('users', 'phone');
    } else {
        $validation->setInputValue($postPhone)
            ->setInputValueName('phone')
            ->regex('/^01[0125][0-9]{8}$/');
    }

    if (empty($validation->getErrors())) {

        $hotel = new Hotel;

        $hotel->setName($_POST['name'])
            ->setPhone($_POST['phone'])
            ->setRate($_POST['star-rating'])
            ->setId($id);

        // Handle file upload
        if (!empty($_FILES['update-image']['name'])) {
            $imageName = $_FILES['update-image']['name']; // Get the name of the uploaded image
            $imagePath = 'assets/img/UsersUploads/' . $imageName;
            move_uploaded_file($_FILES['update-image']['tmp_name'], $imagePath);
            $hotel->setImage($imageName); // Save only the image name to the user object
        } else {
            // No new image provided, use the existing image name
            $hotel->setImage($image);
        }


        $address = new Address;
        if ($hotel->update() && $address->updateById($address_id, isset($_POST['address']) ? $_POST['address'] : $hotelAddress->address)) {

            $databaseResult = $hotel->setPhone($_POST['phone'])->getHotelInfo();
            if ($databaseResult->num_rows == 1) {
                $databaseHotel = $databaseResult->fetch_object();
                $_SESSION['hotel'] = $databaseHotel;
            }
            $success = "<div class='alert alert-success text-center'> Hotel is updated successfully..</div>";
            header('refresh:3;url=HotelManagerProfile.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }
    }
}
?>


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
                        if ($image == 'default.jpg') {
                            $image = 'pethotelimg.jpg';
                        } else {
                            $image = $image;
                        }
                        ?>
                        <h1>Update Hotel Account</h1>
                        <div class="mb-3">
                            <label for="file">
                                <img style="cursor:pointer; border-radius: 50%; width: 189px; height: 180px; border: solid white 5px;" id="image" src="assets/img/UsersUploads/<?= isset($_POST['image']) ? $_POST['image'] : $image ?>" alt="">

                            </label>
                            <input type="file" name="update-image" id="file" onchange="loadFile(event)" value="<?= isset($_POST['image']) ? $_POST['image'] : $image ?> ">
                            <?= $validation->getMessage('image') ?>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="<?= isset($_POST['name']) ? $_POST['name'] : $name ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone*</label>
                            <input name="phone" type="text" class="form-control" id="phone" value="<?= isset($_POST['phone']) ? $_POST['phone'] : $phone ?>">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address*</label>
                            <input name="address" type="text" class="form-control" id="address" value="<?= isset($_POST['address']) ? $_POST['address'] : ($hotelAddress && isset($hotelAddress->address) ? $hotelAddress->address : '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="star-rating" class="form-label">Stars*</label>

                            <div class="ratecontainer-wrapper">
                                <div class="ratecontainer d-flex align-items-center justify-content-center">
                                    <div class="row justify-content-center">

                                        <div class="rating-wrapper">
                                            <!-- star 5 -->
                                            <input class="rating" type="radio" id="5-star-rating" name="star-rating" value="5" <?= $rate == 5 ? 'checked' : '' ?>>
                                            <label for="5-star-rating" class="star-rating">
                                                <i class="fas fa-star <?= $rate >= 5 ? 'filled' : '' ?>"></i>
                                            </label>

                                            <!-- star 4 -->
                                            <input class="rating" type="radio" id="4-star-rating" name="star-rating" value="4" <?= $rate == 4 ? 'checked' : '' ?>>
                                            <label for="4-star-rating" class="star-rating star">
                                                <i class="fas fa-star <?= $rate >= 4 ? 'filled' : '' ?>"></i>
                                            </label>

                                            <!-- star 3 -->
                                            <input class="rating" type="radio" id="3-star-rating" name="star-rating" value="3" <?= $rate == 3 ? 'checked' : '' ?>>
                                            <label for="3-star-rating" class="star-rating star">
                                                <i class="fas fa-star <?= $rate >= 3 ? 'filled' : '' ?>"></i>
                                            </label>

                                            <!-- star 2 -->
                                            <input class="rating" type="radio" id="2-star-rating" name="star-rating" value="2" <?= $rate == 2 ? 'checked' : '' ?>>
                                            <label for="2-star-rating" class="star-rating star">
                                                <i class="fas fa-star <?= $rate >= 2 ? 'filled' : '' ?>"></i>
                                            </label>

                                            <!-- star 1 -->
                                            <input class="rating" type="radio" id="1-star-rating" name="star-rating" value="1" <?= $rate == 1 ? 'checked' : '' ?>>
                                            <label for="1-star-rating" class="star-rating star">
                                                <i class="fas fa-star <?= $rate >= 1 ? 'filled' : '' ?>"></i>
                                            </label>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <?= $validation->getMessage('star-rating') ?>
                        </div>
                        <br><br>
                        <button type="submit" class="btn btn-primary btn-lg">Update</button>
                        <button type="button" class="btn btn-primary btn-lg"><a href="HotelManagerProfile.php">Cancel</a></button>

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

<script>
    var loadFile = function(event) {
        var output = document.getElementById('image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>
</body>

</html>