<?php

use App\Http\Requests\Validation;
use App\Database\Models\Pet;

$title = "Add New Pet";

include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

$validation = new Validation;



if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['name'] ?? "")->setInputValueName('name')->required();

    $validation->setInputValue($_POST['type'] ?? "")->setInputValueName('type')->required();

    $validation->setInputValue($_POST['family'] ?? "")->setInputValueName('family')->required();

    $validation->setInputValue($_POST['age'] ?? "")->setInputValueName('age')->required();

    $validation->setInputValue($_FILES['image']['name'] ?? "")->setInputValueName('image')->required();

    $validation->setInputValue($_POST['gender'] ?? "")->setInputValueName('gender')->required()->in(['m', 'f']);

    if (empty($validation->getErrors())) {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['imagepath'] = 'assets/img/UsersUploads/' . $_FILES['image']['name'];
        $_SESSION['image'] = $_FILES['image']['name'];
        header("Location: AddPetProcess.php");
        exit();

        if (!empty($_FILES['image']['name'])) {
            $imageName = $_FILES['image']['name']; // Get the name of the uploaded image
            $imagePath = 'assets/img/UsersUploads/' . $imageName;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }
    }
}

if (isset($_GET['result'])) {
    if ($_GET['result'] == 1) {
        $success = "<div class='alert alert-success text-center'> Pet is added successfully to your pets..</div>";
        header('refresh:3;url=CustomerProfileY.php');
    } else {
        $error = "<div class='alert alert-danger' > The image of pet is not compatible with pet family you have chosen </div>";
    }
}

?>

<div class="addpetcontent">
    <div class="container">

        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="left">
                    <?= $error ?? "" ?>
                    <?= $success ?? "" ?>
                    <form method="post" enctype="multipart/form-data" action="">
                        <h1>Add New Pet</h1>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter your Pet's name..." name="name" value="<?= $validation->getOldValue('name') ?>">
                            <?= $validation->getMessage('name') ?>
                        </div>
                        <div class="mb-3">
                            <label for="family" class="form-label">Family*</label>
                            <select name="family" class="form-control my-2">
                                <option <?= $validation->getOldValue('family') == '1' ? 'selected' : '' ?> value="1">Dog</option>
                                <option <?= $validation->getOldValue('family') == '2' ? 'selected' : '' ?> value="2">Cat</option>
                                <option <?= $validation->getOldValue('family') == '3' ? 'selected' : '' ?> value="3">Bird</option>
                                <option <?= $validation->getOldValue('family') == '4' ? 'selected' : '' ?> value="4">Hamster</option>
                                <option <?= $validation->getOldValue('family') == '5' ? 'selected' : '' ?> value="5">Turtle</option>
                            </select>
                            <?= $validation->getMessage('family') ?>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type*</label>
                            <input type="text" class="form-control" id="type" placeholder="Enter your Pet's type..." name="type" value="<?= $validation->getOldValue('type') ?>">
                            <?= $validation->getMessage('type') ?>
                        </div>

                        <div class="mb-3">
                            <label for="age" class="form-label">Age*</label>
                            <input type="text" class="form-control" id="age" placeholder="Enter your Pet's age..." name="age" value="<?= $validation->getOldValue('age') ?>">
                            <?= $validation->getMessage('age') ?>
                        </div>
                        <label for="gender" class="form-label">Gender*</label><br>
                        <select name="gender" class="form-control my-2" id="">
                            <option <?= $validation->getOldValue('gender') == 'm' ? 'selected' : '' ?> value="m">Male</option>
                            <option <?= $validation->getOldValue('gender') == 'f' ? 'selected' : '' ?> value="f">Female</option>
                        </select>
                        <?= $validation->getMessage('gender') ?>
                        <br>
                        <label for="image" class="form-label">Upload Pet Image*</label>
                        <input type="file" name="image" id="file" onchange="loadFile(event)" value="<?= isset($_FILES['image']['name']) ? $_FILES['image']['name'] : "petdefault.webp" ?> ">
                        <?= $validation->getMessage('image') ?>
                        <br><br>
                        <button name="submit" type="submit" class="btn btn-primary btn-lg">Add</button>
                        <button class="btn btn-primary btn-lg"><a href="CustomerProfileY.php">Cancel</a></button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('file');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src); // free memory
        };
    };
</script>
</body>

</html>