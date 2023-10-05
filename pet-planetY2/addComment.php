<?php

$title = "Add comment";

use App\Http\Requests\Validation;
use App\Database\Models\Post;
use App\Database\Models\Comment;
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

$d_var = getdate();
$today_date = "$d_var[mday] $d_var[month]";

if ($_GET && isset($_GET['post']) && is_numeric($_GET['post'])) {

	$postObj->setId($_GET['post']);
	$postResult = $postObj->find();

	if ($postResult->num_rows != 1) {
		header("location:layouts/errors/404.php");
		die;
	} else {
		$post = $postResult->fetch_object();
	}
} else {
	header("location:layouts/errors/404.php");
	die;
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {
	#if ( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["post_btn"]) ){

	if (isset($_POST['comment_input'])) {
		$validation->setInputValue($_POST['comment_input'] ?? "")->setInputValueName('comment')->required();
		$comment->setContent($_POST['comment_input']);
	}


	if (empty($validation->getErrors())) {

		$comment->setUser_id($_SESSION['user']->id)
			->setUsername($_SESSION['user']->first_name . " " . $_SESSION['user']->last_name)
			->setContent($_POST['comment_input'])
			->setDate($today_date)
			->setPost_id($post->id);

		# $comment->create();
		$user = new User;
		$userResult = $user->setEmail($_SESSION['user']->email)->getUserInfo();
		$userResult = $userResult->fetch_object();

		$user_status = $userResult->banned;

		if ($user_status == '0') {

			if ($comment->create()) {
				$success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> comment added successfully </div>";
				header('refresh:0;url=OurCommunity.php');
			} else {
				$error = "<div class='alert alert-danger' > Something went wrong </div>";
			}
		} else {
			$error = "<div class='alert alert-danger' style='text-transform:capitalize'> Regarding to improper activity you are banned by the admin so you can't comment</div>";
			header('refresh:2;url=OurCommunity.php');
		}
	}
}


?>
<!DOCTYPE html>
<html>

<head>
	<style>
		.createcomment {
			text-align: center;
			width: 100%;
			height: 100%;
			font-family: Goudy Old Style;
			text-align: left;
			margin-top: 200px;
		}

		.createcomment .post {
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

		.createcomment .post .post-header {
			display: flex;
			align-items: center;
		}

		.createcomment .post .dropdown {
			margin-left: 60%;
		}

		.createcomment .post .dropdown .dropdown-content {
			right: 0;
		}

		.createcomment .post .post-header img {
			width: 50px;
			height: 50px;
			border-radius: 50%;
			margin-right: 10px;
		}

		.createcomment .post .post-header h2 {
			margin: 0;
			margin-top: -3%;
			font-size: 1.5rem;
			font-weight: bolder;
		}

		.createcomment .post .post-date {
			margin-left: 60px;
			color: #707070;
			margin-top: -3%;
			color: #707070;
		}

		.createcomment .post .post-content {
			margin-top: 30px;
			margin-bottom: 30px;
			font-size: 1.2rem;
			line-height: 1.5;
		}

		.createcomment .post .post-footer {
			margin-top: 10px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			font-size: 0.9rem;
			color: #777;
		}

		.createcomment .post .post-footer .commenticon i {
			margin-right: 100px;
			font-size: 18px;
		}

		.createcomment .post .post-footer .likeicon i {
			margin-left: 100px;
			font-size: 18px;
			background-color: white;
		}


		.createcomment form .inputpsot {
			margin-top: 20px;
			width: 100%;
			height: 50px;
			background-color: gainsboro;
			border: #b8b6b6 solid 1px;
			border-radius: 60px;
			padding: 10px;
			color: #333;
			position: relative;
		}

		.createcomment .bt {
			background-color: transparent;
			border: none;
			color: blue;
			position: absolute;
			right: 5%;
			bottom: 6%;
			font-size: 30px;
		}

		.createcomment .bt:focus {
			border: none;
			outline: none;
		}
	</style>
</head>

<body>



	<div class="createcomment">
		<?= $error ?? "" ?>
		<?= $success ?? "" ?>
		<div class="post">
			<div class="post-header">
				<img src="https://via.placeholder.com/50" alt="User Avatar">
				<h2><?= $post->username ?></h2>

				<div class="dropdown">
					<i class="fa fa-ellipsis-h t" style="font-size:24px"></i>
					<div class="dropdown-content">
						<?php if ($_SESSION['user']->id == $post->user_id) { ?>

							<a href="editPost.php?post=<?= $post->id ?>" class="dropdown-item">Edit post</a>
							<a href="ok.php?post=<?= $post->id ?>" class="dropdown-item"> Move to trash</a>
						<?php } ?>
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
					<a class="press" href="#"><i class="fas fa-thumbs-up"> Like</i></a><br>
				</div>
				<div class="commenticon">
					<a class="press" href="addComment.php?post=<?= $post->id ?>"><i class="fas fa-comment"> Comment</i></a><br>
				</div>
			</div>
			<hr>

			<form method="post">
				<?= $validation->getMessage('comment') ?>
				<input type="text" placeholder="Write your comment..." class="inputpsot" name="comment_input">
				<div>
					<button class="bt" name="reply_btn"><i class="ri-send-plane-2-fill"></i></button>
				</div>
			</form>

		</div>
	</div>


</body>

</html>