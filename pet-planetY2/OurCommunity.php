<?php

$title = "Our Community";

use App\Http\Requests\Validation;
use App\Database\Models\Post;
use App\Database\Models\Comment;
use App\Database\Models\Reply;
use App\Services\Media;
use App\Database\Models\User;

include "layouts/header.php";
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->admin_status == 0) {
        if ($_SESSION['user']->service_provider_status == 0) {
            include "layouts/navbarRegisteredCustomer.php";
        } else {
            include "layouts/navbarRegisteredSP.php";
        }
    } else {
        include "layouts/navbarAdmin.php";
    }
}
include "App/Http/Middlewares/Auth.php";

$d_var = getdate();
$today_date = "$d_var[mday] $d_var[month]";

$validation = new Validation;

$media = new Media;

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {
    #if ( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["post_btn"]) ){
    $post = new Post;

    $validation->setOldValues($_POST);

    if (isset($_POST['post_content']) && !isset($_POST['post_image'])) {

        $validation->setInputValue($_POST['post_content'] ?? "")->setInputValueName('post content')->required();
    }
    if (empty($validation->getErrors())) {

        if (isset($_POST['post_image_btn'])) {

            if ($_FILES['post_image']['error'] == 0) {

                $media->setFile($_FILES['post_image'])->size(1000000)->extension(['png', 'jpg', 'jpeg']);
                if (empty($media->getErrors())) {
                    $media->upload('assets/img/users/posts/');
                    $post->setImage($media->getNewFileName());
                }
            }

            if (isset($_POST['post_content'])) {
                $post->setContent($_POST['post_content']);
            }

            $post->setDate($today_date)
                ->setUser_id($_SESSION['user']->id)
                ->setUsername($_SESSION['user']->first_name . " " . $_SESSION['user']->last_name);


            //$post->create();

            $user = new User;
            $userResult = $user->setEmail($_SESSION['user']->email)->getUserInfo();
            $userResult = $userResult->fetch_object();

            $user_status = $userResult->banned;

            if ($user_status == '0') {
                if ($post->create()) {
                    $success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> post added successfully </div>";
                    header('refresh:2;url=OurCommunity.php');
                } else {
                    $error = "<div class='alert alert-danger' > Something went wrong </div>";
                }
            } else {
                $error = "<div class='alert alert-danger' style='text-transform:capitalize'> Regarding to improper activity you are banned by the admin so you can't post</div>";
                header('refresh:2;url=OurCommunity.php');
            }
        }
    }
}

$post = new Post;
$posts = $post->readO()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Facebook-like Post</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .ComunityContent .comment .comment-header .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>

<body>
    <?= $error ?? "" ?>
    <?= $success ?? "" ?>
    <?= $validation->getMessage('post content') ?>
    <?= $media->getError('size') ?>
    <?= $media->getError('extension') ?>


    <div class="ComunityContent" style="text-align: center;width: 100%;height: 100%;font-family: Goudy Old Style; text-align: left;margin-top: 100px;">


        <!------------------------------------------- create my post ------------------------------------------------->
        <div class="createpost" style="border: 1px solid #ccc;
                                        padding: 10px;
                                        margin: 10px;
                                        max-width: 700px;
                                        background-color: #fff;
                                        border-radius: 20px;
                                        margin: auto;
                                        width: 50%;
                                        margin-top: 50px;
                                        position: relative;">
            <div class="createpost-header" style=" display: flex; align-items: center;color: #000;">
                <img src="https://via.placeholder.com/50" alt="User Avatar" style="width: 50px;height: 50px;border-radius: 50%;margin-right: 10px;">
                <h2><?= $_SESSION['user']->first_name . " " . $_SESSION['user']->last_name ?></h2>
            </div>

            <form action="" method="post" enctype="multipart/form-data">
                <!----- post image -->

                <div class="post-content">
                    <input type="text" name="post_content" class="inputpost" placeholder="What is in your mind?" style="margin-top: 20px;
                                                                                                                        width: 100%;
                                                                                                                        height: 50px;
                                                                                                                        background-color: gainsboro;
                                                                                                                        border: #b8b6b6 solid 1px;
                                                                                                                        border-radius: 60px;
                                                                                                                        padding: 10px;
                                                                                                                        color: #333;"><br><br>
                </div>
                <label for="file">
                    <a name="photo" class='btn btn-success' style='cursor:pointer; color:white'>photo</a>
                </label>

                <input type="file" name="post_image" id="file" class="d-none" onchange="loadFile(event)">

                <img id="image" style="width: 100%; height: 200px;" class="d-none">
                <!----- end of post image -->

                <div class="createpost-footer" style="margin-top: 10px;display: flex;justify-content: space-between;align-items: center;font-size: 1rem; color: #777;">
                    <button type="submit" class="btn btn-primary bt" name="post_image_btn" style="width: 100%;border-radius: 10px;font-size: 20px;">Post</button>
                </div>
            </form>
        </div>



        <!-------------------------------------------  post ------------------------------------------------->
        <?php foreach ($posts as $post) {  ?>
            <div class="post" style="border: 1px solid #ccc;
                                    padding: 20px;
                                    max-width: 700px;
                                    background-color: #fff;
                                    border-radius: 20px;
                                    margin: 5% auto;
                                    width: 50%;
                                    height: fit-content;
                                    margin-top: 50px;
                                    position: relative;
                                    font-family:Goudy Old Style;">
                <div class="post-header" style="display: flex;align-items: center;">
                    <img src="https://via.placeholder.com/50" alt="User Avatar" style="width: 50px;height: 50px;border-radius: 50%;margin-right: 10px;">
                    <h2 style="margin: 0; margin-top: -3%;font-size: 25px;font-weight: bolder;"><?= $post['username'] ?></h2>

                    <div class="dropdown" style="    margin-left: 60%;">
                        <i class="fa fa-ellipsis-h t" style="font-size:24px"></i>
                        <div class="dropdown-content" style="  right: 0;">
                            <?php if ($post['user_id'] == $_SESSION['user']->id) { ?>

                                <a href="editPost.php?post=<?= $post['id'] ?>" class="dropdown-item">Edit post</a>
                                <a href="postingDelete.php?post=<?= $post['id'] ?>" class="dropdown-item"> Move to trash</a>

                            <?php } else { ?>
                                <a href="postingReport.php?post=<?= $post['id'] ?>" class="dropdown-item"> Report</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="post-date" style=" margin-left: 60px;color: #707070;margin-top: -3%;color: #707070;">
                    <p><?= $post['date'] ?></p>
                </div>
                <div class="post-content" style="margin-top: 30px;margin-bottom: 30px;font-size: 1.2rem;line-height: 1.5;">
                    <p><?= $post['content'] ?></p>
                </div>

                <!-- image -->
                <?php if ($post['image'] != null) { ?>
                    <div>
                        <img src='assets/img/users/posts/<?= $post['image'] ?>'>
                    </div>
                <?php } ?>
                <!--end of image-->

                <hr>
                <div class="post-footer" style=" margin-top: 10px;display: flex; justify-content: space-between;align-items: center;font-size: 0.9rem;color: #777;">
                    <form method='post'>
                        <div onclick="myFunction()" id='like' class="likeicon">
                            <a class="press" href="#"><i class="fas fa-thumbs-up" style="margin-left: 100px;font-size: 18px;background-color: white;"> Like</i></a>
                        </div>
                    </form>
                    <div class="commenticon">
                        <a class="press" href="addComment.php?post=<?= $post['id'] ?>"><i class="fas fa-comment" style="margin-right: 100px;font-size: 18px;"> Comment</i></a><br>
                    </div>
                </div>
                <hr>




                <!------------------------------------------- comment ------------------------------------------------->
                <?php
                $comment = new Comment;
                $comment->setPost_id($post['id']);
                $comments = $comment->readO()->fetch_all(MYSQLI_ASSOC);

                foreach ($comments as $commentt) { ?>

                    <div class="comment" style=" width: 70%;
                                                min-height: 60%;
                                                height: fit-content;
                                                background-color: gainsboro;
                                                border: none;
                                                outline: none;
                                                border-radius: 30px;
                                                padding: 10px;
                                                color: #333;
                                                margin-left: 10%;">
                        <div class="comment-header" style="  display: flex;align-items: center;">
                            <img src="https://via.placeholder.com/50" alt="User Avatar" style=" width: 40px;height: 40px;border-radius: 50%;margin-right: 10px;">
                            <h2 style="margin: 0;font-size: 20px;font-weight: bolder;margin-top: -3%;"><?= $commentt['username'] ?? "" ?></h2>
                            <div class="dropdown" style=" position: relative; display: inline-block; margin-left: 50%;">
                                <i class="fa fa-ellipsis-h t" style="font-size:24px"></i>
                                <div class="dropdown-content" style=" right: 0; position: absolute; z-index: 1;">
                                    <?php if (($commentt['user_id'] == $_SESSION['user']->id) || ($_SESSION['user']->id == $post['user_id'] &&  $commentt['user_id'] == $post['user_id'])) { ?>

                                        <a href=" editComment.php?post=<?= $post['id'] ?>&comment=<?= $commentt['id'] ?>" class="dropdown-item">Edit comment</a>
                                        <a href="postingDelete.php?comment=<?= $commentt['id'] ?>" class="dropdown-item"> Delete comment</a>

                                    <?php } else if ($_SESSION['user']->id == $post['user_id']) { ?>
                                        <a href="postingDelete.php?comment=<?= $commentt['id'] ?>" class="dropdown-item"> Delete comment</a>
                                    <?php } else { ?>
                                        <a href="postingReport.php?post=<?= $post['id'] ?> &comment=<?= $commentt['id'] ?>" class="dropdown-item"> Report</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>


                        <div class="comment-date" style="margin-left: 50px; color: #707070; margin-top: -4%;">
                            <p><?= $commentt['date'] ?></p>
                        </div>
                        <div class="comment-content" style=" margin: 15px 0px 15px 20px; font-size: 18px;">
                            <p><?= $commentt['content'] ?? "" ?></p>
                        </div>

                        <hr style=" margin-bottom: 0px;margin-top: 2%;">
                        <div class="comment-footer" style="margin-top: 10px;display: flex;justify-content: space-between;align-items: center;font-size: 0.9rem; color: #777;">
                            <div class="likeicon">
                                <a class="press" href="#"><i class="fas fa-thumbs-up" style=" margin-left: 50px; font-size: 15px; background-color: transparent;"> Like</i></a><br>
                            </div>
                            <div class="commenticon">
                                <a class="press" href="addReply.php?post=<?= $post['id'] ?> &comment=<?= $commentt['id'] ?>"><i class="fas fa-comment" style=" margin-right: 50px;font-size: 15px;"> reply</i></a><br>
                            </div>
                        </div>
                        <hr style=" margin-bottom: 0px;margin-top: 2%;">
                    </div>



                    <!------------------------------------------- reply ------------------------------------------------->
                    <?php
                    $reply = new Reply;
                    if (isset($commentt['id'])) {
                        $reply->setComment_id($commentt['id']);
                        $replies = $reply->readO()->fetch_all(MYSQLI_ASSOC);

                        foreach ($replies as $reply) { ?>
                            <div class="reply" style=" background-color: gainsboro;
                                                        color: black;
                                                        margin-top: 14px;
                                                        margin-right: 100px;
                                                        border-radius: 30px;
                                                        margin-left: 30%;
                                                        width: 50%;
                                                        height: fit-content;">
                                <div class="reply-header" style="display: flex; align-items: center;">
                                    <img src="https://via.placeholder.com/50" alt="User Avatar" style=" width: 40px; height: 40px; border-radius: 50%; margin-left: 15px;">
                                    <p class="name" style=" margin-left: 20px;padding-top: 15px; font-weight: bold;"><?= $reply['username'] ?></p>
                                    <div class="dropdown" style=" position: relative; display: inline-block;margin-left: 35%;">
                                        <i class="fa fa-ellipsis-h t" style="font-size:24px"></i>
                                        <div class="dropdown-content" style="right: 0;">
                                            <?php if ($reply['user_id'] == $_SESSION['user']->id) { ?>

                                                <a href="editReply.php?post=<?= $post['id'] ?> & comment=<?= $commentt['id'] ?> &reply=<?= $reply['id'] ?>" class="dropdown-item">Edit</a>
                                                <a href="postingDelete.php?reply=<?= $reply['id'] ?>" class="dropdown-item"> Delete </a>

                                            <?php } else if ($post['user_id'] == $_SESSION['user']->id) { ?>
                                                <a href="postingDelete.php?reply=<?= $reply['id'] ?>" class="dropdown-item"> Delete </a>
                                            <?php } else { ?>
                                                <a href="postingReport.php?reply=<?= $reply['id'] ?>" class="dropdown-item"> Report</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>


                                <div>
                                    <p class="reply-date" style="margin-left: 75px; margin-top: -5%; color: #707070;"><?= $reply['date'] ?></p>
                                </div>
                                <div>
                                    <p class="reply-content" style="margin: 15px 0px 10px 40px; font-size: 18px;"><?= $reply['content'] ?? "" ?></p>
                                </div>
                            </div>
                    <?php }
                    } ?>
                <?php } ?>
                <!-- end of post section-->
            </div>
    </div>
<?php } ?>

<!-- js for post image-->
<script>
    var loadFile = function(event) {
        var output = document.getElementById('image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
            document.getElementById('image').classList.remove('d-none')
        }
    };

    function myFunction() {
        var x = document.getElementById("like");
        if (x.style.color === "gray") {
            x.style.color = "blue";

        } else {
            x.style.color = "gray";
        }
    }
</script>

</body>

</html>