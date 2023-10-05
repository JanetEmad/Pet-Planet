<?php

if ($_SESSION['user']->service_provider_type == 2 && !strpos($_SERVER['REQUEST_URI'], 'SitterProfile.php')) {
    header('location:SitterProfile.php');
    die;
}
