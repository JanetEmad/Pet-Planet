<?php

use App\Database\Models\Petreport;

$title = "Reports";
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
$report = new Petreport;
$reports = $report->read();

?>
<style>
    a,
    a:hover {
        text-decoration: none;
        color: white;
    }

    body {
        font-size: larger;
    }

    .card {
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .report_post {
        margin: 60px 360px 20px 360px;
        padding: 30px;
        padding-left: 0px;
    }

    .space {
        margin-top: 110px;
    }

    .bt_danger {
        float: right;
        margin: 0px 360px 0px 10px;
        width: 200px;
    }

    .di {
        display: inline-block;
        font-size: large;
    }

    .icon {
        width: 50px;
    }

    .sa {
        padding-left: 10px;
        font-weight: bold;
    }

    .reportButton {
        width: 100%;
        height: 15px;

    }
</style>
<div class="petreportscontent">

    <h1>Pet Reports</h1>
    <div class="reportButton">
        <div class="bt_danger btn btn-danger ">
            <img src="assets/img/YImages/speaker.png" class="di icon">
            <a href="PetReport.php" class="di sa"> Report pet</a>
        </div>
    </div>
    <div class="reportlist">
        <?php foreach ($reports as $report) { ?>
            <div class="onereport">
                <p class="date"> <?= $report['date'] ?></p>
                <p class="description"><?= $report['situation_description'] ?></p>
                <p class="location"><b>Location:</b> <?= $report['location'] ?></p>
            </div><br>
            <hr>
        <?php } ?>

    </div>


    </body>

    </html>