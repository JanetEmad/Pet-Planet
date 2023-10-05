<?php

$title = "review reports ";

include "layouts/header.php";
include "layouts/navbarAdmin.php";



#include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Post;
use App\Database\Models\Comment;
use App\Database\Models\Reply;
use App\Database\Models\User;

//if(isset($_GET['user'])){
$post = new Post;
$postReports = $post->getPostReports()->fetch_all(MYSQLI_ASSOC);

$comment = new Comment;
$commentReports = $comment->getCommentReports()->fetch_all(MYSQLI_ASSOC);

$reply = new Reply;
$replyReports = $reply->getReplyReports()->fetch_all(MYSQLI_ASSOC);
//}

//post
if (isset($_GET['user']) && isset($_GET['post'])) {
  $user = new User;
  $user->setId($_GET['user']);
  $user->banUserAccount();
  $post = new Post;
  $post->setId($_GET['post']);
  $post->deletePost();
  header("location:ReviewReportingForAdmin.php");
}

if (isset($_GET['remove_post'])) {
  $post = new Post;
  $post->setId($_GET['remove_post']);
  $post->removeReport();
  header("location:ReviewReportingForAdmin.php");
}

//comment
if (isset($_GET['user']) && isset($_GET['comment'])) {
  $user = new User;
  $user->setId($_GET['user']);
  $user->banUserAccount();
  $comment = new Comment;
  $comment->setId($_GET['comment']);
  $comment->deleteComment();
  header("location:ReviewReportingForAdmin.php");
}

if (isset($_GET['remove_comment'])) {
  $comment = new Comment;
  $comment->setId($_GET['remove_comment']);
  $comment->removeReport();
  header("location:ReviewReportingForAdmin.php");
}

//reply
if (isset($_GET['user']) && isset($_GET['reply'])) {
  $user = new User;
  $user->setId($_GET['user']);
  $user->banUserAccount();
  $reply = new Reply;
  $reply->setId($_GET['reply']);
  $reply->deleteReply();
  header("location:ReviewReportingForAdmin.php");
}

if (isset($_GET['remove_reply'])) {
  $reply = new Reply;
  $reply->setId($_GET['remove_reply']);
  $reply->removeReport();
  header("location:ReviewReportingForAdmin.php");
}


?>
<style>
  a,
  a:hover {
    text-decoration: none;
    color: white;
  }

  body {
    font-size: larger;
  }

  .card {
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2);
    transition: 0.3s;
  }

  .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
  }

  .report_post {
    margin: 60px 360px 20px 360px;
    padding: 30px;
    padding-left: 0px;
  }

  .space {
    margin-top: 110px;
  }

  .bt_danger {
    float: right;
    margin: 30px 360px 0px 10px;
    width: 200px;
  }

  .di {
    display: inline-block;
    font-size: large;
  }

  .icon {
    width: 50px;
  }

  .sa {
    padding-left: 10px;
    font-weight: bold;
  }

  .btns {
    position: relative;
    margin: auto;
    margin-top: 50px;
  }

  .s_btn {
    margin-left: 100px;
  }
</style>


<div class="userreportscontent">

  <h1>List Of Post Reports</h1>
  <div class="userreportlist">
    <?php if (!empty($postReports)) { ?>
      <?php foreach ($postReports as $postReport) { ?>
        <div class="postreport">
          <div class="aboutpost">
            <div class="postimg">
              <?php if ($postReport['image'] !== NULL) { ?>
                <p><b>image:</b></p>
                <img src="assets/img/users/posts/<?= $postReport['image'] ?>">
              <?php } ?>
            </div>
            <div class="ND">
              <p class="date"> <?= $postReport['date'] ?></p>
              <p class="name"> <?= $postReport['username'] ?></p>
            </div>
          </div>
          <p class="postcontent"><?= $postReport['content'] ?></p>

          <div class="twobuttons">
            <a href="ReviewReportingForAdmin.php?user=<?= $postReport['user_id'] ?> & post=<?= $postReport['id'] ?>" class="btn ">Ban</a>
            <a href="ReviewReportingForAdmin.php?remove_post=<?= $postReport['id'] ?>" class="btn btn-danger s_btn">Discard</a>
          </div>

        </div><br>
        <hr>

  </div>
<?php }
    } ?>

<h1 class="comm">List Of Comment Reports</h1>
<div class="userreportlist">
  <?php if (!empty($commentReports)) { ?>
    <?php foreach ($commentReports as $commentReport) { ?>
      <div class="postreport">
        <div class="aboutpost">
          <div class="ND">
            <p class="date"><?= $commentReport['date'] ?></p>
            <p class="name"><?= $commentReport['username'] ?></p>
          </div>
        </div>
        <p class="postcontent"><?= $commentReport['content'] ?></p>

        <div class="twobuttons">
          <a href="ReviewReportingForAdmin.php?user=<?= $commentReport['user_id'] ?> & comment=<?= $commentReport['id'] ?>" class="btn btn-primary">Ban</a>
          <a href="ReviewReportingForAdmin.php?remove_comment=<?= $commentReport['id'] ?>" class="btn btn-danger s_btn" style='margin-left:100px;'>Discard</a>
        </div>
      </div><br>
      <hr>
</div>

<?php }
  } ?>

<h1 class="rep">List Of Reply Reports</h1>
<div class="userreportlist">
  <?php if (!empty($replyReports)) { ?>
    <?php foreach ($replyReports as $replyReport) { ?>
      <div class="postreport">
        <div class="aboutpost">
          <div class="ND">
            <p class="date"><?= $replyReport['date'] ?></p>
            <p class="name"><?= $replyReport['username'] ?></p>
          </div>
        </div>
        <p class="postcontent"><?= $replyReport['content'] ?></p>

        <div class="twobuttons">
          <a href="ReviewReportingForAdmin.php?user=<?= $replyReport['user_id'] ?> & reply=<?= $replyReport['id'] ?>" class="btn btn-primary">Ban user account</a>
          <a href="ReviewReportingForAdmin.php?remove_reply=<?= $replyReport['id'] ?>" class="btn btn-danger s_btn" style='margin-left:100px;'>Remove from reports</a>
        </div>
      </div><br>
      <hr>
</div>

<?php }
  } ?>