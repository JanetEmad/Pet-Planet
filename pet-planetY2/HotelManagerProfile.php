<?php

use App\Database\Models\HotelManager;

$title = "Hotel Manager Profile";
include "layouts/header.php";
include "layouts/navbarRegisteredSP.php";
include "App/Http/Middlewares/Auth.php";
// include "App/Http/Middlewares/HotelMW.php";

?>


<br>

<head>
    <link rel="stylesheet" href="assets/css/rate.css">
</head>
<div class="HotelManagerProfilecontent">
    <div class="container">
        <div class="ownerinfo">
            <a href="UpdateHotelManager.php?id=<?= $_SESSION['user']->id ?>">
                <img src="assets/img/YImages/edit.png">
            </a>
            <div class="ownerimg">
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
            <div class="aboutowner">
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

        <div class="myhotels">
            <h2>Related Hotels</h2>
            <?php
            $manager = new HotelManager;
            $manager->setUser_id($_SESSION['user']->id);
            $hotels = $manager->read();
            ?>
            <?php if (empty($hotels)) { ?>
                <h3 class="yet">No Hotels were added yet!</h3>
            <?php } else {
            ?>

                <?php foreach ($hotels as $hotel) { ?>
                    <div class="hotel">
                        <h4><?= $hotel['name'] ?></h4>
                        <div class="edit">
                            <a href="UpdateHotel.php?id=<?= $hotel['id'] ?>">
                                <img src="assets/img/YImages/edit.png">
                            </a>
                        </div>
                        <button style="background-color: #CF6262;
    border: solid #cf6262;
    border-radius: 40px;
    width: 25%;
    height: 25%;
    font-weight: bold;
    font-size: 15px;
    cursor: pointer;
    color: white;" type="button" class="btn btn-primary btn-lg"><a style="text-decoration: none; color: white;" href="ViewHotelAppointments.php?id=<?= $hotel['id'] ?>">View Reservations </a> </button>
                        <div class="all-1">
                            <div class="left-1">
                                <a href="#">
                                    <img src="assets/img/UsersUploads/<?= $hotel['image'] ?>">
                                </a>
                            </div>
                            <div class="right-1">
                                <div class="hotelinfo">
                                    <div class="all-2">
                                        <div class="left-2">
                                            <P> Name</P>
                                            <hr>
                                            <p>Phone</p>
                                            <hr>
                                            <p>Address</p>
                                            <hr>
                                            <p>Rate</p>
                                            <hr>
                                        </div>
                                        <div class="right-2">
                                            <p><?= $hotel['name'] . ' Hotel' ?> </p>
                                            <hr>
                                            <P><?= $hotel['phone'] ?></P>
                                            <hr>
                                            <p><?= $hotel['address'] ?></p>
                                            <hr>
                                            <div>
                                                <?php
                                                $rating = $hotel['rate']; // Replace with the actual rating value retrieved from the database
                                                $maxStars = 5; // Maximum number of stars

                                                // Loop through each star
                                                for ($i = 1; $i <= $maxStars; $i++) {
                                                    // Check if the current star should be filled or empty
                                                    if ($i <= $rating) {
                                                        $iconClass = "fas fa-star filled";
                                                    } else {
                                                        $iconClass = "fas fa-star empty";
                                                    }

                                                    // Output the star icon
                                                    echo '<span class="star"><i class="' . $iconClass . '"></i></span>';
                                                }
                                                ?>
                                            </div>
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
            <button type="button" class="btn btn-primary btn-lg"><a href="CreateHotel.php">Add New Hotel</a></button>
        </div>
    </div>
</div>
</body>

</html>