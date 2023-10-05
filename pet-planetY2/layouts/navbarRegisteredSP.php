<?php
$currentPage = basename($_SERVER['PHP_SELF']);
if ($_SESSION['user']->service_provider_type == 0) {
    $SPN = "VetProfile";
} else if ($_SESSION['user']->service_provider_type == 1) {
    $SPN = "TrainerProfile";
} else if ($_SESSION['user']->service_provider_type == 2) {
    $SPN = "SitterProfile";
} else {
    $SPN = "HotelManagerProfile";
}

?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container" style="padding-right: 50px;">
        <a class="navbar-brand" href="#">
            <img src="assets/img/YImages/logo.png" alt="">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if ($currentPage === 'ServiceProviderHome.php') echo 'active'; ?> ">
                    <a class="nav-link" href="ServiceProviderHome.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'Store.php') echo 'active'; ?> ">
                    <a class="nav-link" href="Store.php">Store <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php if ($currentPage === "$SPN.php") echo 'active'; ?>">
                    <a class="nav-link" href="<?= $SPN ?>.php">Profile <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'About.php') echo 'active'; ?> ">
                    <a class="nav-link" href="About.php">About <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'ContactUs.php') echo 'active'; ?> ">
                    <a class="nav-link" href="ContactUs.php">Contact us <span class="sr-only">(current)</span></a>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn"><i class="fa fa-bars"></i></button>
                        <div class="dropdown-content" style="right:0%;">
                            <a href="OurCommunity.php">Our Community</a>
                            <a href="DetectPet.php">Pets Types</a>
                            <a href="PetReports.php">Reports</a>
                            <a href="index.php">Sign out</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>