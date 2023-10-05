<?php

use App\Http\Requests\Validation;
use App\Database\Models\User;
use App\Database\Models\Sitter;
use App\Database\Models\Address;


$title = "Update Sitter";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

$validation = new Validation;

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $user = new User;
    $sitter = new Sitter;

    $userData = $user->getUserInfoById($userId);
    $sitterData = $sitter->fetchSitterDataFromDatabaseByUserId($userId);
    if ($userData && $sitterData) {
        $_SESSION['userData'] = $userData;
        $_SESSION['sitterData'] = $sitterData;

        header('Location: UpdateSitter.php');
        exit();
    }
}

if (isset($_SESSION['userData']) && isset($_SESSION['sitterData'])) {
    $userData = $_SESSION['userData'];
    $sitterData = $_SESSION['sitterData'];

    $first_name = $userData['first_name'];
    $last_name = $userData['last_name'];
    $phone = $userData['phone'];
    $gender = $userData['gender'];
    $email = $userData['email'];
    $image = $userData['image'];
    $user_id = $userData['id'];


    $address_id = $sitterData['address_id'];
    $work_days = $sitterData['work_days'];
    $price_per_hour = $sitterData['price_per_hour'];
    $sitter_id = $sitterData['id'];


    $address1 = new Address;
    $address1->setId($address_id);
    $sitterAddress = $address1->getAddressInfoById();
} else {
    echo "sitter data not available.";
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['first_name'] ?? "")->setInputValueName('first name')->between(2, 32);

    $validation->setInputValue($_POST['last_name'] ?? "")->setInputValueName('last name')->between(2, 32);


    $sessionEmail = $email ?? "";
    $postEmail = $_POST['email'] ?? "";

    if ($sessionEmail !== $postEmail) {
        $validation->setInputValue($postEmail)
            ->setInputValueName('email')
            ->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')
            ->unique('users', 'email');
    } else {
        $validation->setInputValue($postEmail)
            ->setInputValueName('email')
            ->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/');
    }

    $sessionAddress = $sitterAddress->address ?? "";
    $postAddress = $_POST['address'] ?? "";

    if ($sessionAddress !== $postAddress) {
        $validation->setInputValue($postAddress ?? "")->setInputValueName('address')->required()->validateAddress($postAddress)->unique('addresses', 'address');
    } else {
        $validation->setInputValue($postAddress ?? "")->setInputValueName('address')->required()->validateAddress($postAddress);
    }


    $sessionPhone = $phone ?? "";
    $postPhone = $_POST['phone'] ?? "";

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


    $validation->setInputValue($_POST['gender'] ?? "")->setInputValueName('gender')->in(['m', 'f']);


    $validation->setInputValue($_POST['work_days'] ?? "")->setInputValueName('work_days')->required();
    $validation->setInputValue($_POST['price_per_hour'] ?? "")->setInputValueName('price_per_hour')->required();

    if (empty($validation->getErrors())) {

        $user = new User;

        $user->setFirst_name($_POST['first_name'])
            ->setLast_name($_POST['last_name'])
            ->setEmail($_POST['email'])
            ->setGender($_POST['gender'])
            ->setPhone($_POST['phone'])
            ->setId($user_id);

        // Handle file upload
        if (!empty($_FILES['update-image']['name'])) {
            $imageName = $_FILES['update-image']['name']; // Get the name of the uploaded image
            $imagePath = 'assets/img/UsersUploads/' . $imageName;
            move_uploaded_file($_FILES['update-image']['tmp_name'], $imagePath);
            $user->setImage($imageName); // Save only the image name to the user object
        } else {
            // No new image provided, use the existing image name
            $user->setImage($image);
        }

        $sitter = new Sitter;

        $sitter->setWork_days($_POST['work_days'])
            ->setPrice_per_hour($_POST['price_per_hour'])
            ->setAddress_id($address_id)
            ->setUser_id($user_id)
            ->setId($sitter_id);



        $address = new Address;
        $address->setId($address_id)->setAddress(isset($_POST['address']) ? $_POST['address'] : $sitterAddress->address);
        if ($user->update() && $sitter->update() && $address->updateById($address_id, isset($_POST['address']) ? $_POST['address'] : $sitterAddress->address)) {

            $databaseResult = $user->setEmail($_POST['email'])->getUserInfo();
            if ($databaseResult->num_rows == 1) {
                $databaseUser = $databaseResult->fetch_object();
                $_SESSION['user'] = $databaseUser;
            }
            $success = "<div class='alert alert-success text-center'> Profile is updated successfully..</div>";
            header('refresh:3;url=SitterProfile.php');
        }
    } else {
        $error = "<div class='alert alert-danger' > Something went wrong </div>";
    }
}


?>

<br>

<div class="updateprofilecontent">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="left">
                    <?= $error ?? "" ?>
                    <?= $success ?? "" ?>
                    <form method="post" enctype="multipart/form-data">
                        <?php
                        if ($image == 'default.jpg') {
                            if ($gender == 'm') {
                                $Nimage = 'Male.jpeg';
                            } else {
                                $Nimage = 'Female.jpg';
                            }
                        } else {
                            $Nimage = $image;
                        }
                        ?>
                        <h1>Update Profile</h1>
                        <div class="mb-3">
                            <label for="file">
                                <img style="cursor:pointer; border-radius: 50%; width: 189px; height: 180px; border: solid white 5px;" id="image" src="assets/img/UsersUploads/<?= $Nimage ?>" alt="">
                            </label>
                            <input type="file" name="update-image" id="file" onchange="loadFile(event)" value="<?= isset($_POST['image']) ? $_POST['image'] : $Nimage ?> ">
                            <?= $validation->getMessage('image') ?>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input name="first_name" type="text" class="form-control" id="first_name" aria-describedby="emailHelp" value="<?= isset($_POST['first_name']) ? $_POST['first_name'] : $first_name ?>">
                            <?= $validation->getMessage('first_name') ?>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input name="last_name" type="text" class="form-control" id="last_name" value="<?= isset($_POST['last_name']) ? $_POST['last_name'] : $last_name ?>">
                            <?= $validation->getMessage('last_name') ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="text" class="form-control" id="email" value="<?= isset($_POST['email']) ? $_POST['email'] : $email ?>">
                            <?= $validation->getMessage('email') ?>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input name="phone" type="text" class="form-control" id="phone" value="<?= isset($_POST['phone']) ? $_POST['phone'] : $phone ?>">
                            <?= $validation->getMessage('phone') ?>
                        </div>
                        <label for="gender" class="form-label">Gender</label><br>
                        <select name="gender" class="form-control my-2" id="gender">
                            <option <?= isset($_POST['gender']) && $_POST['gender'] === 'm' ? 'selected' : ($gender === 'm' ? 'selected' : '') ?> value="m">Male</option>
                            <option <?= isset($_POST['gender']) && $_POST['gender'] === 'f' ? 'selected' : ($gender === 'f' ? 'selected' : '') ?> value="f">Female</option>
                        </select>
                        <?= $validation->getMessage('gender') ?>
                        <div class="mb-3">
                            <label for="field2a" class="form-label">Work Days</label>
                            <input type="text" id="field2a" class="form-control" name="work_days" value="<?= isset($_POST['work_days']) ? $_POST['work_days'] : $work_days ?>">
                            <?= $validation->getMessage('work_days') ?>
                        </div>
                        <div class="mb-3">
                            <label for="field2b" class="form-label">Price per hour</label>
                            <input type="number" id="field2b" class="form-control" name="price_per_hour" min="0" step="1" value="<?= isset($_POST['price_per_hour']) ? $_POST['price_per_hour'] : $price_per_hour ?>">
                            <?= $validation->getMessage('price_per_hour') ?>
                        </div>
                        <div class="mb-3">
                            <label for="field2c" class="form-label">Address</label>
                            <input type="text" id="field2c" class="form-control" name="address" value="<?= isset($_POST['address']) ? $_POST['address'] : ($sitterAddress && isset($sitterAddress->address) ? $sitterAddress->address : '') ?>">
                            <?= $validation->getMessage('address') ?>
                        </div>
                        <br><br>
                        <button type="submit" name="update-image" class="btn btn-primary btn-lg">Update</button>
                        <button type="button" class="btn btn-primary btn-lg"><a href="SitterProfile.php">Cancel</a></button>
                    </form>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="right">
                    <img src="assets/img/YImages/pets.png" style="height: 1000px;">
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script>
    var loadFile = function(event) {
        var output = document.getElementById('image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>

</html>