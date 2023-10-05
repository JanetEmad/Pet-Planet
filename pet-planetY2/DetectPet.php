<?php

use App\Http\Requests\Validation;

$title = "Pet Type Detection";
include "layouts/header.php";
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->admin_status == 0) {
        if ($_SESSION['user']->service_provider_status == 0) {
            include "layouts/navbarRegisteredCustomer.php";
        } else {
            include "layouts/navbarRegisteredSP.php";
        }
    } else {
        include "layouts/navbarAdmin.php";
    }
}
include "App/Http/Middlewares/Auth.php";

$validation = new Validation;
$showResult = false;
$class_name = "";

if (isset($_GET['result'])) {
    $result = $_GET['result'];
    $image = $_GET['image'];
    $showResult = true;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {
    $validation->setOldValues($_POST);
    $validation->setInputValue($_FILES['images']['name'] ?? "")->setInputValueName('images')->required();

    if (!empty($_FILES['images']['name'])) {
        $imageName = $_FILES['images']['name']; // Get the name of the uploaded image
        $imagePath = 'assets/img/UsersUploads/' . $imageName;
        move_uploaded_file($_FILES['images']['tmp_name'], $imagePath);
        $image = $imagePath;
    }
}

?>

<br>

<div class="detectpetcontent">
    <div class="detectabout">
        <h1>Want to Know more about your pet?</h1>
        <p>Here, we produce for you a useful and strong feature to use which is pet type detection to make you more aware of your pet. So we hope that you will make use of it with pleasure and ease.</p>
    </div>

    <form method="post" enctype="multipart/form-data" action="Process.php">
        <div class="detect">
            <h1>Choose Pet Image</h1>
            <label for="images" class="drop-container">
                <input type="file" name="images" id="file" onchange="loadFile(event)" value="<?= isset($_FILES['images']['name']) ? $_FILES['images']['name'] : "" ?> ">
                <?= $validation->getMessage('images') ?>
            </label>

            <label for="file">
                <img style="margin-left: 600px; cursor:pointer; border-radius: 50%; width: 189px; height: 180px; border: solid white 5px;" id="image" src="<?= isset($image) ? $image : "" ?>" alt="">
            </label>
        </div>
        <button name="go" type="submit">GO</button>
    </form>

    <!-- result appear after detection -->
    <div class="detectresult" id="detectresult" style="display: <?= $showResult ? 'block' : 'none' ?>;">
        <p style="margin: auto; font-size: 60px;"><?= $result ?> </p>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var loadFile = function(event) {
            var output = document.getElementById('image');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src); // free memory
            };

        };

        // Listen for change event on file input
        $('#file').on('change', function(event) {
            loadFile(event);
        });
    </script>
</div>