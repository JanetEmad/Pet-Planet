<?php
if ($_SESSION['user']->service_provider_type == 1 && !strpos($_SERVER['REQUEST_URI'], 'TrainerProfile.php')) {
    if (
        strpos($_SERVER['REQUEST_URI'], 'SitterProfile.php') !== false ||
        strpos($_SERVER['REQUEST_URI'], 'VetProfile.php') !== false ||
        strpos($_SERVER['REQUEST_URI'], 'HotelManagerProfile.php') !== false
    ) {
        header('Location: TrainerProfile.php');
        exit;
    }
}
