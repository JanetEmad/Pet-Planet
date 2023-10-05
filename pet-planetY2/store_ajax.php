<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_image'])) {
    $_SESSION['selected_image'] = $_POST['selected_image'];
}
