<?php

$title = "Pet profile for buying ";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Pet;
use App\Database\Models\Notification;

$d_var = getdate();
$today_date = "$d_var[mday] $d_var[month]";

if ($_GET) {
    if (isset($_GET['buy'])) {
        $data = $_GET['buy'];
    } else if (isset($_GET['adopt'])) {
        $data = $_GET['adopt'];
    } else if (isset($_GET['mate'])) {
        $data = $_GET['mate'];
    }
}

$petObj = new Pet;
$petObj->setId($data);
$pet = $petObj->getPetInfo()->fetch_object();

if (isset($_POST['buy_btn']) || isset($_POST['adopt_btn']) || isset($_POST['mate_btn'])) {

    $petObj->setUser_id_for_operation($_SESSION['user']->id);
}

if (isset($_POST['buy_btn']) && $_POST) {
    $petObj->updatePetStatus('buy');
    $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px;text-transform:capitalize'> Pet buying operation is successfully done and sent to pet owner </div>";
    $notification = new Notification;
    $notification->setContent($_SESSION['user']->first_name . ' ' . $_SESSION['user']->last_name . ' wants to buy your pet: ' . $pet->name . ' , If you want to communicate here is the email: ' . $_SESSION['user']->email);
    $notification->setUser_id($pet->user_id)->setDate($today_date);
    $notification->create();
    header('refresh:3;url=CustomerProfileY.php');
}

if (isset($_POST['adopt_btn']) && $_POST) {
    $petObj->updatePetStatus('adopt');
    $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px;text-transform:capitalize'> Pet adoption is successfully done and sent to pet owner  </div>";
    $notification = new Notification;
    $notification->setContent($_SESSION['user']->first_name . ' ' . $_SESSION['user']->last_name . ' wants to adopt your pet: ' . $pet->name . ' , If you want to communicate here is the email: ' . $_SESSION['user']->email);
    $notification->setUser_id($pet->user_id)->setDate($today_date);
    $notification->create();
    header('refresh:3;url=CustomerProfileY.php');
}
if (isset($_POST['mate_btn']) && $_POST) {
    $petObj->setUser_id_for_operation($_SESSION['user']->id);
    $petObj->updatePetStatus('mate');
    $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px;text-transform:capitalize'> Pet selection for mating is successfully done and sent to pet owner  </div>";
    $notification = new Notification;
    $notification->setContent($_SESSION['user']->first_name . ' ' . $_SESSION['user']->last_name . ' wants your pet ' . $pet->name . ' for mating , If you want to communicate here is the email: ' . $_SESSION['user']->email);
    $notification->setUser_id($pet->user_id)->setDate($today_date);
    $notification->create();
    header('refresh:3;url=CustomerProfileY.php');
}

?>

<form method="post">

    <div class="petprofilecontent">
        <?= $error ?? "" ?>
        <?= $success ?? "" ?>
        <div class="container">
            <div class="petinfo">
                <div class="petimg">
                    <img src="assets/img/UsersUploads/<?= $pet->image ?>">
                </div>
                <h2><?= $pet->name ?></h2>
                <div class="aboutpet">
                    <div class="allp">
                        <div class="leftp">
                            <P>Name</P>
                            <hr>
                            <p>Gender</p>
                            <hr>
                            <p>Age</p>
                            <hr>
                            <P>Type</P>
                            <hr>
                            <p>Family</p>
                            <hr>
                        </div>
                        <div class="rightp">
                            <p><?= $pet->name ?></p>
                            <hr>
                            <?php if ($pet->gender == 'm') { ?>
                                <p>male</p>
                                <hr>
                            <?php } else if ($pet->gender == 'f') { ?>
                                <p>female</p>
                                <hr>
                            <?php } ?>
                            <p><?= $pet->age ?></p>
                            <hr>
                            <p><?= $pet->type ?></p>
                            <hr>
                            <p>
                                <?php
                                $family = $pet->family;
                                $petType = ($family == '1') ? 'Dog' : (($family == '2') ? 'Cat' : (($family == '3') ? 'Bird' : (($family == '4') ? 'Hamster' : 'Turtle')));
                                echo $petType;
                                ?>
                            </p>
                            <hr>
                        </div>
                    </div>


                </div>
                <div class="buttonsnew">
                    <div>
                        <?php if (isset($_GET['buy'])) { ?>
                            <button type='submit' class="btn " name='buy_btn'>Buy</button>
                        <?php } else if (isset($_GET['adopt'])) { ?>
                            <button type='submit' class="btn " name='adopt_btn'>Adopt</button>
                        <?php } else if (isset($_GET['mate'])) { ?>
                            <button type='submit' class="btn " name='mate_btn'>Select</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</body>

</html>