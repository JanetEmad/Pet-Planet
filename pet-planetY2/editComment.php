<?php

$title = "Edit comment";

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

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_btn'])) {

	$validation->setInputValue($_POST['comment_input'] ?? "")->setInputValueName('comment content')->required();

	if (empty($validation->getErrors())) {

		$comment = new Comment;
		$comment->setContent($_POST['comment_input'])->setId($_GET['comment'])->setDate($today_date);

		$user = new User;
		$userResult = $user->setEmail($_SESSION['user']->email)->getUserInfo();
		$userResult = $userResult->fetch_object();

		$user_status = $userResult->banned;

		if ($user_status == '0') {
			if ($comment->updateCommentInfo()) {
				$success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> comment edited successfully </div>";
				header('refresh:1;url=OurCommunity.php');
			} else {
				$error = "<div class='alert alert-danger' > Something went wrong </div>";
			}
		} else {
			$error = "<div class='alert alert-danger' style='text-transform:capitalize'> Regarding to improper activity you are banned by the admin so you can't edit</div>";
			header('refresh:2;url=OurCommunity.php');
		}
	}
}

?>
<style>
	.editcomment {
		text-align: center;
		width: 100%;
		height: 100%;
		font-family: Goudy Old Style;
		text-align: left;
		margin-top: 200px;
	}

	.editcomment .post {
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

	.editcomment .post .post-header {
		display: flex;
		align-items: center;
	}

	.editcomment .post .dropdown {
		margin-left: 60%;
	}

	.editcomment .post .dropdown .dropdown-content {
		right: 0;
	}

	.editcomment .post .post-header img {
		width: 50px;
		height: 50px;
		border-radius: 50%;
		margin-right: 10px;
	}

	.editcomment .post .post-header h2 {
		margin: 0;
		margin-top: -3%;
		font-size: 1.5rem;
		font-weight: bolder;
	}

	.editcomment .post .post-date {
		margin-left: 60px;
		color: #707070;
		margin-top: -3%;
		color: #707070;
	}

	.editcomment .post .post-content {
		margin-top: 30px;
		margin-bottom: 30px;
		font-size: 1.2rem;
		line-height: 1.5;
	}

	.editcomment .post .post-footer {
		margin-top: 10px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 0.9rem;
		color: #777;
	}

	.editcomment .post .post-footer .commenticon i {
		margin-right: 100px;
		font-size: 18px;
	}

	.editcomment .post .post-footer .likeicon i {
		margin-left: 100px;
		font-size: 18px;
		background-color: white;
	}


	.editcomment form .inputpost {
		margin-top: 20px;
		width: 100%;
		min-height: 50px;
		height: fit-content;
		border: none;
		padding: 10px;
		color: #333;
		outline: none;
		background-color: transparent;
	}

	.editcomment .post .comment {
		background-color: gainsboro;
		border-radius: 20px;
		padding: 10px;
	}

	.bt {
		margin-left: 100px;
		width: 150px;
	}

	.bt1 {
		margin-right: 100px;
		width: 150px;
	}
</style>


<div class="editcomment">
	<?= $error ?? "" ?>
	<?= $success ?? "" ?>
	<div class="post">

		<div class="post-header">
			<img src="https://via.placeholder.com/50" alt="User Avatar">
			<h2><?= $post->username ?></h2>

		</div>
		<form method="post">
			<div class="post-content">
				<p class="inputt"><?= $post->content ?></p><br><br>
			</div>

			<!-- image -->
			<?php if ($post->image != null) { ?>
				<div>
					<img src='assets/img/users/posts/<?= $post->image ?>'>
				</div>
			<?php } ?>
			<!--end of image-->
		</form>


		<hr>

		<!--comment -->
		<?= $validation->getMessage('comment') ?>

		<div class="comment">
			<div class="post-header">
				<img src="https://via.placeholder.com/50" alt="User Avatar">
				<h2><?= $comment->username ?? "" ?></h2>
			</div>

			<div class="post-content">

				<form method="post">
					<input type="text" class="inputpost" name="comment_input" value="<?= $comment->content ?>"><br>
			</div>
			<div class="post-footer">
				<div>
					<button name='edit_btn' class=" btn btn-primary  bt">edit</button>
				</div>
				<div>
					<a name='cancel_btn' class=" btn btn-danger bt1" href='OurCommunity.php'>cancel</a>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>