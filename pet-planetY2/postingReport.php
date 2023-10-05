<?php

$title = "report comment";

use App\Database\Models\Post;
use App\Database\Models\Comment;
use App\Database\Models\Reply;

include "layouts/header.php";
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->service_provider_status == 0) {
        include "layouts/navbarRegisteredCustomer.php";
    } else {
        include "layouts/navbarRegisteredSP.php";
    }
} else {
    include "layouts/navbar.php";
}
include "App/Http/Middlewares/Auth.php";

if ($_GET && isset($_GET['post']) && is_numeric($_GET['post'])) {
    $postObj = new Post;
    $postObj->setId($_GET['post']);
    $postResult = $postObj->find();

    if ($postResult->num_rows != 1) {
        header("location:layouts/errors/404.php");
        die;
    } else {

        $postObj->reportPost();

        $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> post reported successfully  and sent to the admin to review </div>";
        header('refresh:2;url=OurCommunity.php');
    }
}
if (isset($_GET['comment']) && is_numeric($_GET['comment'])) {

    $commentObj = new Comment;
    $commentObj->setId($_GET['comment']);
    $commentResult = $commentObj->find();

    if ($commentResult->num_rows != 1) {
        header("location:layouts/errors/404.php");
        die;
    } else {

        $commentObj->reportComment();

        $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> comment reported successfully and sent to the admin to review </div>";
        header('refresh:2;url=OurCommunity.php');
    }
}

if (isset($_GET['reply']) && is_numeric($_GET['reply'])) {

    $replyObj = new Reply;
    $replyObj->setId($_GET['reply']);
    $replyResult = $replyObj->find();

    if ($replyResult->num_rows != 1) {
        header("location:layouts/errors/404.php");
        die;
    } else {

        $replyObj->reportReply();

        $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> reply reported successfully and sent to the admin to review </div>";
        header('refresh:2;url=OurCommunity.php');
    }
}
?>

<?= $error ?? "" ?>
<?= $success ?? "" ?>
