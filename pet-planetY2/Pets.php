<?php

$title = " Pets ";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

if (isset($_POST['wantpet_btn'])) {
    header("location:Wantpet.php");
}
if (isset($_POST['offerpet_btn'])) {
    header("location:CustomerProfileY.php");
}

?>

<form method="post">
    <div class="petscontent">

        <h1>Pets</h1>
        <div class="options">
            <div class="row">

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="want">
                        <img src="assets/img/YImages/want.png">
                        <h3>Do You Need To
                            <br>Search For A Pet ?
                        </h3>
                        <button type="submit" class="btn btn-primary btn-lg" name='wantpet_btn'>Yes</button>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="offer">
                        <img src="assets/img/YImages/offer.png">
                        <h3>Do You Want To
                            <br>Offer Your Pet ?
                        </h3>
                        <button type="submit" class="btn btn-primary btn-lg" name='offerpet_btn'>Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</body>

</html>