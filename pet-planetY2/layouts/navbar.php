<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container" style="padding:0px 50px;">
        <a class="navbar-brand" href="#">
            <img src="assets/img/YImages/logo.png" alt="">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if ($currentPage === 'index.php') echo 'active'; ?> ">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'About.php') echo 'active'; ?> ">
                    <a class="nav-link" href="About.php">About <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'ContactUs.php') echo 'active'; ?>">
                    <a class="nav-link" href="ContactUs.php">Contact us <span class="sr-only">(current)</span></a>
                </li>
            </ul>

        </div>
    </div>
</nav>