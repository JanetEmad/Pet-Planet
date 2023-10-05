<?php

use App\Http\Requests\Validation;
use App\Database\Models\Clinic;
use App\Database\Models\Address;

$title = "Update Clinic";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

$validation = new Validation;

if (isset($_GET['id'])) {
    $clinicId = $_GET['id'];

    $clinic = new Clinic;

    $clinicData = $clinic->fetchClinicDataFromDatabaseByClinicId($clinicId);

    if ($clinicData) {
        $_SESSION['clinicData'] = $clinicData;

        header('Location: UpdateClinic.php');
        exit();
    } else {
        echo "Clinic not found.";
    }
}

if (isset($_SESSION['clinicData'])) {
    $clinicData = $_SESSION['clinicData'];

    $name = $clinicData['name'];
    $phone = $clinicData['phone'];
    $address_id = $clinicData['address_id'];
    $work_days = $clinicData['work_days'];
    $opens_at = $clinicData['opens_at'];
    $closes_at = $clinicData['closes_at'];
    $price = $clinicData['price'];
    $image = $clinicData['image'];
    $id = $clinicData['id'];

    $address1 = new Address;
    $address1->setId($address_id);
    $clinicAddress = $address1->getAddressInfoById();
} else {
    echo "Clinic data not available.";
}



if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['name'] ?? "")->setInputValueName('name')->between(2, 32);

    $validation->setInputValue($_POST['work_days'] ?? "")->setInputValueName('work_days');


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

        $clinic = new Clinic;

        $clinic->setName($_POST['name'])
            ->setPhone($_POST['phone'])
            ->setPrice($_POST['price'])
            ->setOpens_at($_POST['open_at'])
            ->setCloses_at($_POST['close_at'])
            ->setWork_days($_POST['work_days'])
            ->setId($id);

        // Handle file upload
        if (!empty($_FILES['update-image']['name'])) {
            $imageName = $_FILES['update-image']['name']; // Get the name of the uploaded image
            $imagePath = 'assets/img/UsersUploads/' . $imageName;
            move_uploaded_file($_FILES['update-image']['tmp_name'], $imagePath);
            $clinic->setImage($imageName); // Save only the image name to the user object
        } else {
            // No new image provided, use the existing image name
            $clinic->setImage($image);
        }


        $address = new Address;
        if ($clinic->update() && $address->updateById($address_id, isset($_POST['address']) ? $_POST['address'] : $clinicAddress->address)) {

            $databaseResult = $clinic->setPhone($_POST['phone'])->getClinicInfo();
            if ($databaseResult->num_rows == 1) {
                $databaseClinic = $databaseResult->fetch_object();
                $_SESSION['clinic'] = $databaseClinic;
            }
            $success = "<div class='alert alert-success text-center'> Clinic is updated successfully..</div>";
            header('refresh:3;url=VetProfile.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }
    }
}
?>

<div class="createclininccontent">
    <div class="container">

        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="left">
                    <?= $error ?? "" ?>
                    <?= $success ?? "" ?>
                    <form method="post" enctype="multipart/form-data">
                        <?php
                        if ($image == 'default.jpg') {
                            $image = 'clinic.png';
                        } else {
                            $image = $image;
                        }
                        ?>
                        <h1>Update Clinic Account</h1>
                        <div class="mb-3">
                            <label for="file">
                                <img style="cursor:pointer; border-radius: 50%; width: 189px; height: 180px; border: solid white 5px;" id="image" src="assets/img/UsersUploads/<?= isset($_POST['image']) ? $_POST['image'] : $image ?>" alt="">

                            </label>
                            <input type="file" name="update-image" id="file" onchange="loadFile(event)" value="<?= isset($_POST['image']) ? $_POST['image'] : $image ?> ">
                            <?= $validation->getMessage('image') ?>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="<?= isset($_POST['name']) ? $_POST['name'] : $name ?>">
                            <?= $validation->getMessage('name') ?>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input name="phone" type="text" class="form-control" id="phone" value="<?= isset($_POST['phone']) ? $_POST['phone'] : $phone ?>">
                            <?= $validation->getMessage('phone') ?>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input name="address" type="text" class="form-control" id="address" value="<?= isset($_POST['address']) ? $_POST['address'] : ($clinicAddress && isset($clinicAddress->address) ? $clinicAddress->address : '') ?>">
                            <?= $validation->getMessage('address') ?>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input name="price" type="text" class="form-control" id="price" value="<?= isset($_POST['price']) ? $_POST['price'] : $price ?>">
                            <?= $validation->getMessage('price') ?>
                        </div>
                        <div class="mb-3">
                            <label for="work_days" class="form-label">Work Days</label>
                            <input name="work_days" type="text" class="form-control" id="work_days" value="<?= isset($_POST['work_days']) ? $_POST['work_days'] : $work_days ?>">
                            <?= $validation->getMessage('work_days') ?>
                        </div>
                        <div class="mb-3">
                            <label for="open_at" class="form-label">Open at</label>
                            <input name="open_at" type="time" class="form-control" id="open_at" value="<?= isset($_POST['open_at']) ? $_POST['open_at'] : $opens_at ?>">
                            <?= $validation->getMessage('open_at') ?>
                        </div>
                        <div class="mb-3">
                            <label for="close_at" class="form-label">Close at</label>
                            <input name="close_at" type="time" class="form-control" id="close_at" value="<?= isset($_POST['close_at']) ? $_POST['close_at'] : $closes_at ?>">
                            <?= $validation->getMessage('close_at') ?>
                        </div>

                        <br><br>
                        <button type="submit" class="btn btn-primary btn-lg">Update </button>
                        <button type="button" class="btn btn-primary btn-lg"><a href="VetProfile.php">Cancel</a></button>

                    </form>
                </div>
            </div>


            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="right">
                    <img src="assets/img/YImages/clinic.png">
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