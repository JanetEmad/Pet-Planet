<?php

$title = "Add Reply";

use App\Http\Requests\Validation;
use App\Database\Models\Post;
use App\Database\Models\Comment;
use App\Database\Models\Reply;
use App\Database\Models\User;

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

$validation = new Validation;
$comment = new Comment;
$postObj = new Post;
$reply = new Reply;

$d_var = getdate();
$today_date = "$d_var[mday] $d_var[month]";

if ($_GET && isset($_GET['comment']) && is_numeric($_GET['comment']) && isset($_GET['post']) && is_numeric($_GET['post'])) {
	$postObj = new Post;
	$commentObj = new Comment;
	$postObj->setId($_GET['post']);
	$commentObj->setId($_GET['comment']);
	$postResult = $postObj->find();
	$commentResult = $commentObj->find();

	if ($postResult->num_rows != 1 && $commentResult->num_rows != 1) {
		header("location:layouts/errors/404.php");
		die;
	} else {
		$post = $postResult->fetch_object();
		$comment = $commentResult->fetch_object();
	}
} else {
	header("location:layouts/errors/404.php");
	die;
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {
	#if ( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["post_btn"]) ){

	if (isset($_POST['reply_content'])) {
		$validation->setInputValue($_POST['reply_content'] ?? "")->setInputValueName('reply')->required();
	}


	if (empty($validation->getErrors())) {

		$reply->setUser_id($_SESSION['user']->id)
			->setUsername($_SESSION['user']->first_name . " " . $_SESSION['user']->last_name)
			->setContent($_POST['reply_content'])
			->setDate($today_date)
			->setComment_id($comment->id);

		# $reply->create();
		$user = new User;
		$userResult = $user->setEmail($_SESSION['user']->email)->getUserInfo();
		$userResult = $userResult->fetch_object();

		$user_status = $userResult->banned;

		if ($user_status == '0') {

			if ($reply->create()) {
				$success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> reply added successfully </div>";
				header('refresh:2;url=OurCommunity.php');
			} else {
				$error = "<div class='alert alert-danger' > Something went wrong </div>";
			}
		} else {
			$error = "<div class='alert alert-danger' style='text-transform:capitalize'> Regarding to improper activity you are banned by the admin so you can't reply</div>";
			header('refresh:2;url=OurCommunity.php');
		}
	}
}

if (isset($_POST['cancel_btn'])) {
	header('location:url=OurCommunity.php');
}
?>
<style>
	.createreply {
		text-align: center;
		width: 100%;
		height: 100%;
		font-family: Goudy Old Style;
		text-align: left;
		margin-top: 150px;
	}

	.createreply .post {
		border: 1px solid #ccc;
		padding: 20px;
		margin: 10px;
		max-width: 700px;
		background-color: #fff;
		border-radius: 20px;
		margin: auto;
		width: 50%;
		min-height: 200px;
		height: fit-content;
		margin-top: 50px;
		position: relative;
	}

	.createreply .post .post-header {
		display: flex;
		align-items: center;
	}

	.createreply .post .dropdown {
		margin-left: 60%;
	}

	.createreply .post .dropdown .dropdown-content {
		right: 0;
	}

	.createreply .post .post-header img {
		width: 50px;
		height: 50px;
		border-radius: 50%;
		margin-right: 10px;
	}

	.createreply .post .post-header h2 {
		margin: 0;
		margin-top: -3%;
		font-size: 1.5rem;
		font-weight: bolder;
	}

	.createreply .post .post-date {
		margin-left: 60px;
		color: #707070;
		margin-top: -3%;
		color: #707070;
	}

	.createreply .post .post-content {
		margin-top: 30px;
		margin-bottom: 30px;
		font-size: 1.2rem;
		line-height: 1.5;
	}

	.createreply .post .post-footer {
		margin-top: 10px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 0.9rem;
		color: #777;
	}

	.createreply .post .post-footer .commenticon i {
		margin-right: 100px;
		font-size: 18px;
	}

	.createreply .post .post-footer .likeicon i {
		margin-left: 100px;
		font-size: 18px;
		background-color: white;
	}

	.createreply .comment {
		width: 70%;
		min-height: 60%;
		height: fit-content;
		background-color: gainsboro;
		border: none;
		outline: none;
		border-radius: 30px;
		padding: 10px;
		color: #333;
		margin-left: 10%;
	}

	.createreply .comment .comment-header {
		display: flex;
		align-items: center;
	}

	.createreply .comment .comment-header h2 {
		margin: 0;
		font-size: 20px;
		font-weight: bolder;
		margin-top: -3%;
	}

	.createreply .comment .comment-header img {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		margin-right: 10px;
	}

	.createreply .comment .comment-header .dropdown {
		position: relative;
		display: inline-block;
		margin-left: 45%;
	}

	.createreply .comment .comment-header .dropdown-content {
		display: none;
		position: absolute;
		z-index: 1;
	}

	.createreply .comment .comment-header .dropdown:hover .dropdown-content {
		display: block;
	}

	.createreply .comment .comment-header .dropdown-item {
		display: block;
		padding: 10px;
		background-color: #f1f1f1;
		color: #333;
		text-decoration: none;
	}

	.createreply .comment .comment-date {
		margin-left: 50px;
		color: #707070;
		margin-top: -4%;
	}

	.createreply .comment .comment-content {
		margin: 15px 0px 15px 20px;
		font-size: 18px;
	}

	.createreply .comment hr {
		margin-bottom: 0px;
		margin-top: 2%;
	}

	.createreply .comment .post-footer .commenticon i {
		margin-right: 50px;
		font-size: 15px;
	}

	.createreply .comment .post-footer .likeicon i {
		margin-left: 50px;
		font-size: 15px;
		background-color: transparent;
	}

	.createreply .post .inputpost {
		margin-top: 20px;
		width: 70%;
		height: 50px;
		background-color: gainsboro;
		border: #b8b6b6 solid 1px;
		border-radius: 60px;
		padding: 10px;
		color: #333;
		position: relative;
		margin-left: 10%;
	}

	.createreply .bt {
		background-color: transparent;
		border: none;
		color: blue;
		position: absolute;
		right: 22%;
		bottom: 6%;
		font-size: 30px;
	}

	.createreply .bt:focus {
		border: none;
		outline: none;
	}
</style>



<div class="createreply">
	<?= $error ?? "" ?>
	<?= $success ?? "" ?>
	<div class="post">
		<div class="post-header">
			<img src="https://via.placeholder.com/50" alt="User Avatar">
			<h2><?= $post->username ?></h2>

			<div class="dropdown">
				<i class="fa fa-ellipsis-h t" style="font-size:24px"></i>
				<div class="dropdown-content">
					<? if ($_SESSION['user']->id == $post->user_id) { ?>

						<a href="editPost.php?post=<?= $post->id ?>" class="dropdown-item">Edit post</a>
						<a href="ok.php?post=<?= $post->id ?>" class="dropdown-item"> Move to trash</a>
					<? } ?>
				</div>
			</div>

		</div>
		<div>
			<p class="post-date"><?= $post->date ?></p>
		</div>
		<div class="post-content">
			<p><?= $post->content ?></p>
		</div>

		<!-- image -->
		<?php if ($post->image != null) { ?>
			<div>
				<img src='assets/img/users/posts/<?= $post->image ?>'>
			</div>
		<?php } ?>
		<!--end of image-->
		<hr>
		<div class="post-footer">

			<div class="likeicon">
				<a class="press" href="#"><i class="fas fa-thumbs-up"> Like</i></a>
			</div>
			<div class="commenticon">
				<a class="press" href="addComment.php?post=<?= $post->id ?>"><i class="fas fa-comment"> Comment</i></a><br>
			</div>

		</div>
		<hr>

		<!-- comment -->
		<div class="comment">
			<?= $validation->getMessage('reply') ?>
			<div class="comment-header">
				<img src="https://via.placeholder.com/50" alt="User Avatar">
				<h2><?= $comment->username ?></h2>


			</div>
			<div class="comment-content">
				<form method="post">
					<p><?= $comment->content ?></p>
				</form>
			</div>

			<hr>
			<div class="post-footer">
				<div class="likeicon">
					<a class="press" href="#"><i class="fas fa-thumbs-up"> Like</i></a><br>
				</div>
				<div class="commenticon">
					<a class="press" href="addReply.php?post=<?= $post->id ?>"><i class="fas fa-comment"> Reply</i></a><br>
				</div>
			</div>
			<hr>

		</div>

		<form method="post">
			<input class="inputpost" name="reply_content" placeholder="Write your reply...">
			<div class="post-footer">
				<div>
					<button class="bt" name="reply_btn"><i class="ri-send-plane-2-fill"></i></button>
				</div>
			</div>
		</form>
	</div>