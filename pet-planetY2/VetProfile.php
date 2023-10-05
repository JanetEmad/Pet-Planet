<?php

$title = "Vet Profile";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Clinic;
use App\Database\Models\Veterinary;


?>

<div class="vetprofilecontent">
    <div class="container">

        <div class="vetinfo">
            <a href="UpdateVet.php?id=<?= $_SESSION['user']->id ?>">
                <img src="assets/img/YImages/edit.png">
            </a>
            <div class="vetimg">
                <?php
                if ($_SESSION['user']->image == 'default.jpg') {
                    if ($_SESSION['user']->gender == 'm') {
                        $image = 'Male.jpeg';
                    } else {
                        $image = 'Female.jpg';
                    }
                } else {
                    $image = $_SESSION['user']->image;
                }
                ?>
                <img src="assets/img/UsersUploads/<?= $image ?>">
            </div>
            <h2><?= $_SESSION['user']->first_name . " " . $_SESSION['user']->last_name ?></h2>
            <div class="aboutvet">
                <div class="head">
                    <img src="assets/img/YImages/user.png">
                    <h3>About</h3>
                </div>
                <div class="all">
                    <div class="left">
                        <P>Full Name</P>
                        <hr>
                        <p>Gender</p>
                        <hr>
                        <p>Email</p>
                        <hr>
                        <P>Phone</P>
                        <hr>
                    </div>
                    <div class="right">
                        <p><?= $_SESSION['user']->first_name . " " . $_SESSION['user']->last_name ?></p>
                        <hr>
                        <p><?= $_SESSION['user']->gender == 'm' ? 'Male' : 'Female' ?></p>
                        <hr>
                        <p><u><?= $_SESSION['user']->email ?></u></p>
                        <hr>
                        <p><?= $_SESSION['user']->phone ?></p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <div class="myclinics">
            <h2>Related Clinics</h2>

            <?php
            $vet = new Veterinary;
            $vet->setUser_id($_SESSION['user']->id);
            $clinics = $vet->read();
            ?>
            <?php if (empty($clinics)) { ?>
                <h3 class="yet">No Clinics were added yet!</h3>
            <?php } else {
            ?>

                <?php foreach ($clinics as $clinic) { ?>
                    <div class="clinic">
                        <h4><?= $clinic['name'] ?></h4>
                        <div class="edit">
                            <a href="UpdateClinic.php?id=<?= $clinic['id'] ?>">
                                <img src="assets/img/YImages/edit.png">
                            </a>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg"><a href="ViewVetAppointments.php?id=<?= $clinic['id'] ?>">View Appointments </a> </button>
                        <div class="all-1">
                            <div class="left-1">
                                <a href="#">
                                    <img src="assets/img/UsersUploads/<?= $clinic['image'] ?>">
                                </a>
                            </div>
                            <div class="right-1">
                                <div class="clinicinfo">
                                    <div class="all-2">
                                        <div class="left-2">
                                            <P> Name</P>
                                            <hr>
                                            <p>Phone</p>
                                            <hr>
                                            <p>Address</p>
                                            <hr>
                                            <p>Open at</p>
                                            <hr>
                                            <p>Close at</p>
                                            <hr>
                                            <P>Works Days</P>
                                            <hr>
                                            <p>Price</p>
                                            <hr>
                                        </div>
                                        <div class="right-2">
                                            <p><?= $clinic['name'] . ' Clinic' ?></p>
                                            <hr>
                                            <P><?= $clinic['phone'] ?></P>
                                            <hr>
                                            <p><?= $clinic['address'] ?></p>
                                            <hr>
                                            <p><?= $clinic['opens_at'] ?></p>
                                            <hr>
                                            <p><?= $clinic['closes_at'] ?></p>
                                            <hr>
                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;<?= $clinic['work_days'] ?></p>
                                            <hr>
                                            <p><?= $clinic['price'] ?>&nbsp;LE</p>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
            <?php }
            } ?>
            <button type="button" class="btn btn-primary btn-lg"><a href="CreateClinic.php">Add New Clinic</a></button>
        </div>
    </div>
</div>
</body>

</html>