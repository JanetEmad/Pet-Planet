<?php

$title = "Report Pet";

use App\Http\Requests\Validation;
use App\Database\Models\Petreport;

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
$today_date = date("Y-m-d");

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['location'] ?? "")->setInputValueName('Location')->required();

    $validation->setInputValue($_POST['situation_desc'] ?? "")->setInputValueName('situation description')->required();

    if (empty($validation->getErrors())) {

        $report = new Petreport;

        $report->setDate($today_date)
            ->setLocation($_POST['location'])
            ->setSituation_description($_POST['situation_desc']);

        if ($report->create()) {
            header('location:PetReports.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }
    }
}
?>


<br>

<div class="Petreportcontent">
    <div class="container">

        <div class="row">

            <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="left">
                    <?= $error ?? "" ?>
                    <form method="post">
                        <h1 style="    font-size:45px; margin-bottom:15%;">Pet Report</h1>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label" style="font-size: 25px;">Location*</label>
                            <input name="location" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small><?= $validation->getMessage('Location') ?></small>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label" style="font-size: 25px;">Situation Description*</label>
                            <input name="situation_desc" type="text" class="form-control bigger" id="exampleInputPassword1">
                            <small><?= $validation->getMessage('situation description') ?></small>
                        </div>

                        <br><br>
                        <button type="submit" class="btn btn-primary btn-lg">Report</button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</body>

</html>