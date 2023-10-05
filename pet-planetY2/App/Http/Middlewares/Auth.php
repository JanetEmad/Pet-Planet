<?php

if (!isset($_SESSION['user'])) {
    header('location:Signin.php');
    die;
}
