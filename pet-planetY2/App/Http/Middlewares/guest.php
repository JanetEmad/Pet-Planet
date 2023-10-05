<?php 

if(isset($_SESSION['user'])){
    header('location:CustomerHome.php');die;
}
?>