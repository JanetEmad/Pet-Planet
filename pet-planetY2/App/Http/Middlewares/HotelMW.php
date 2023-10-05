<?php

if ($_SESSION['user']->service_provider_type == 3 && !strpos($_SERVER['REQUEST_URI'], 'HotelManagerProfile.php')) {
    header('location:HotelManagerProfile.php');
    die;
}
