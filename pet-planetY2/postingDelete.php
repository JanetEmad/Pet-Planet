<?php

$title = "Delete";

use App\Database\Models\Post;
use App\Database\Models\Comment;
use App\Database\Models\Reply;
use App\Services\Media;

include "layouts/header.php";
include "layouts/navbarRegistered.php";
include "App/Http/Middlewares/Auth.php";

if ($_GET && isset($_GET['post']) && is_numeric($_GET['post'])) {

    $post = new Post;
    $post->setId($_GET['post']);
    $postResult = $post->find();

    if ($postResult->num_rows != 1) {
        header("location:layouts/errors/404.php");
        die;
    } else {
        $postt = $postResult->fetch_object();
        if ($postt->image !== NULL) {
            $media = new Media;
            $path = 'assets/img/users/posts/' . $postt->image;
            $media->delete($path);
        }
        $post->deletePost();

        if ($post->deletePost()) {
            $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> post deleted successfully </div>";
            header('refresh:1;url=OurCommunity.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }
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

        $commentObj->deleteComment();

        if ($commentObj->deleteComment()) {
            $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> comment deleted successfully </div>";
            header('refresh:1;url=OurCommunity.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }
    }
}

if ($_GET && isset($_GET['reply']) && is_numeric($_GET['reply'])) {

    $replyObj = new Reply;

    $replyObj->setId($_GET['reply']);

    $replyResult = $replyObj->find();

    if ($replyResult->num_rows != 1) {
        header("location:layouts/errors/404.php");
        die;
    } else {

        $replyObj->deleteReply();

        if ($replyObj->deleteReply()) {
            $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> reply deleted successfully </div>";
            header('refresh:1;url=OurCommunity.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }
    }
}


?>

<?= $error ?? "" ?>
<?= $success ?? "" ?>