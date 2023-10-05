<?php

if ($_SESSION['user']->service_provider_type == 0 && !strpos($_SERVER['REQUEST_URI'], 'VetProfile.php')) {
    header('location:VetProfile.php');
    die;
}
