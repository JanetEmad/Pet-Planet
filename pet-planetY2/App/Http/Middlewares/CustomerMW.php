<?php

if ($_SESSION['user']->service_provider_status == 0 && !strpos($_SERVER['REQUEST_URI'], 'CustomerProfileY.php')) {
    header('location:CustomerProfileY.php');
    exit;
}
