<?php

$title = "Profile";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Pet;
use App\Database\Models\Notification;

$notification = new Notification;
$notification->setUser_id($_SESSION['user']->id);
$notifications = $notification->readO()->fetch_all(MYSQLI_ASSOC);

?>
<style>
    .notifications {
        margin-top: 60px;
        border-radius: 10%;
        padding-bottom: 80px;
    }

    .notification_message {
        margin: 20px;
        padding: 20px;
        background-color: #B9D9EB;
        color: white;
        border-radius: 20px;
        opacity: 0.8;
    }

    .notification_message h3 {
        color: black;
    }

    .notifications h2 {
        color: #d45959;
        margin-left: 50px;
        margin-top: 30px;
    }
</style>
?>
<br>

<div class="profilecontent">
    <div class="container">

        <div class="userinfo">
            <a href="UpdateProfile.php">
                <img src='assets/img/YImages/edit.png'>
            </a>

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
            <div class="userimg">
                <img src="assets/img/UsersUploads/<?= $image ?>" alt="">
            </div>
            <h2><?= $_SESSION['user']->first_name . " " . $_SESSION['user']->last_name ?></h2>
            <div class="aboutuser">

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

        <div class="mypets">
            <h2>My Pets</h2>
            <?php
            $petObj = new Pet;
            $petObj->setUser_id($_SESSION['user']->id);
            $pets = $petObj->get()->fetch_all(MYSQLI_ASSOC);
            ?>
            <!-- without pets -->
            <?php if (empty($pets)) { ?>
                <h3 class="yet">No Pets were added yet!</h3>
            <?php } else {
            ?>
                <!-- with pets -->
                <?php foreach ($pets as $pet) { ?>
                    <div class="pet">
                        <a href="petProfile.php?data=<?= $pet['id'] ?>" style="cursor:pointer">
                            <img src="assets/img/UsersUploads/<?= $pet['image'] ?>">
                        </a>
                        <h3 class="r"><?= $pet['name'] ?></h3>
                    </div>
            <?php }
            } ?>
            <input class="add" type="button" onclick="location.href='AddPet.php'" value="Add New Pet">
        </div>
    </div>
</div>

<?php if (!empty($notifications)) { ?>
    <div class="notifications addpetinprofile">
        <h2>Notifications</h2>
        <?php if (empty($notifications)) { ?>
            <h3 class="yet">No notifications yet!</h3>
        <?php } else {
        ?>
            <div class="pets">
                <?php foreach ($notifications as $notification) { ?>
                    <div class="pet">
                        <div class="contentt notification_message">
                            <h3><?= $notification['content'] ?></h3>
                            <h3 id='message_date'><b><?= $notification['date'] ?></b></h3>
                        </div>
                    </div>
            <?php }
            } ?>
            </div>

    </div>
<?php } ?>

</body>

</html>