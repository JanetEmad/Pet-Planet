<?php

$title = "Edit Reply";

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

$d_var = getdate();
$today_date = "$d_var[mday] $d_var[month]";

if ($_GET && isset($_GET['comment']) && is_numeric($_GET['comment']) && isset($_GET['post']) && is_numeric($_GET['post']) && isset($_GET['comment']) && is_numeric($_GET['comment'])) {

	$postObj = new Post;
	$commentObj = new Comment;
	$replyObj = new Reply;

	$postObj->setId($_GET['post']);
	$commentObj->setId($_GET['comment']);
	$replyObj->setId($_GET['reply']);

	$postResult = $postObj->find();
	$commentResult = $commentObj->find();
	$replyResult = $replyObj->find();

	if ($postResult->num_rows != 1 && $commentResult->num_rows != 1 && $replyResult->num_rows != 1) {
		header("location:layouts/errors/404.php");
		die;
	} else {
		$post = $postResult->fetch_object();
		$comment = $commentResult->fetch_object();
		$reply = $replyResult->fetch_object();
	}
} else {
	header("location:layouts/errors/404.php");
	die;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_btn'])) {

	$validation->setInputValue($_POST['reply_input'] ?? "")->setInputValueName('reply content')->required();

	if (empty($validation->getErrors())) {

		$reply = new Reply;
		$reply->setContent($_POST['reply_input'])->setId($_GET['reply'])->setDate($today_date);

		$user = new User;
		$userResult = $user->setEmail($_SESSION['user']->email)->getUserInfo();
		$userResult = $userResult->fetch_object();

		$user_status = $userResult->banned;

		if ($user_status == '0') {

			if ($reply->updateReplyInfo()) {
				$success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> reply edited successfully </div>";
				header('refresh:4;url=OurCommunity.php');
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
	.editreply {
		text-align: center;
		width: 100%;
		height: 100%;
		font-family: Goudy Old Style;
		text-align: left;
		margin-top: 150px;
	}

	.editreply .post {
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

	.editreply .post .post-header {
		display: flex;
		align-items: center;
	}

	.editreply .post .dropdown {
		margin-left: 60%;
	}

	.editreply .post .dropdown .dropdown-content {
		right: 0;
	}

	.editreply .post .post-header img {
		width: 50px;
		height: 50px;
		border-radius: 50%;
		margin-right: 10px;
	}

	.editreply .post .post-header h2 {
		margin: 0;
		margin-top: -3%;
		font-size: 1.5rem;
		font-weight: bolder;
	}

	.editreply .post .post-date {
		margin-left: 60px;
		color: #707070;
		margin-top: -3%;
		color: #707070;
	}

	.editreply .post .post-content {
		margin-top: 30px;
		margin-bottom: 30px;
		font-size: 1.2rem;
		line-height: 1.5;
	}

	.editreply .post .post-footer {
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

	.editreply .post .post-footer .likeicon i {
		margin-left: 100px;
		font-size: 18px;
		background-color: transparent;
	}

	.editreply .comment {
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

	.editreply .comment .comment-header {
		display: flex;
		align-items: center;
	}

	.editreply .comment .comment-header h2 {
		margin: 0;
		font-size: 20px;
		font-weight: bolder;
		margin-top: -3%;
	}

	.editreply .comment .comment-header img {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		margin-right: 10px;
	}

	.editreply .comment .comment-header .dropdown {
		position: relative;
		display: inline-block;
		margin-left: 45%;
	}

	.editreply .comment .comment-header .dropdown-content {
		display: none;
		position: absolute;
		z-index: 1;
	}

	.editreply .comment .comment-header .dropdown:hover .dropdown-content {
		display: block;
	}

	.editreply .comment .comment-header .dropdown-item {
		display: block;
		padding: 10px;
		background-color: #f1f1f1;
		color: #333;
		text-decoration: none;
	}

	.editreply .comment .comment-date {
		margin-left: 50px;
		color: #707070;
		margin-top: -3%;
	}

	.editreply .comment .comment-content {
		margin: 15px 0px 15px 20px;
		font-size: 18px;
	}

	.editreply .comment hr {
		margin-bottom: 0px;
		margin-top: 2%;
	}

	.editreply .comment .post-footer .commenticon i {
		margin-right: 50px;
		font-size: 15px;
	}

	.editreply .comment .post-footer .likeicon i {
		margin-left: 50px;
		font-size: 15px;
		background-color: transparent;
	}

	.editreply .reply {
		margin-top: 20px;
		width: 70%;
		min-height: 60%;
		height: fit-content;
		background-color: gainsboro;
		border: none;
		outline: none;
		border-radius: 30px;
		padding: 10px;
		color: #333;
		margin-left: 20%;
	}

	.editreply .reply .reply-header {
		display: flex;
		align-items: center;
	}

	.editreply .reply .reply-header p {
		margin: 0;
		font-size: 20px;
		font-weight: bolder;
		margin-top: -3%;
	}

	.editreply .reply .reply-header img {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		margin-right: 10px;
	}

	.editreply .reply .reply-date {
		margin-left: 50px;
		color: #707070;
		margin-top: -3%;
	}

	.editreply .reply .inputpost {
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

	.bt {
		margin-left: 50px;
		width: 100px;
	}

	.bt1 {
		margin-right: 50px;
		width: 100px;
	}
</style>



<div class="editreply">
	<?= $error ?? "" ?>
	<?= $success ?? "" ?>
	<div class="post">
		<div class="post-header">
			<img src="https://via.placeholder.com/50" alt="User Avatar">
			<h2><?= $post->username ?></h2>

		</div>
		<form method="post">
			<div class="post-content">
				<p class="post-content"><?= $post->content ?></p><br><br>
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
		<div class="post-footer">

			<div class="likeicon">
				<a class="press" href="#"><i class="fas fa-thumbs-up"> Like</i></a>
			</div>
			<div class="commenticon" style="margin-right: 100px;font-size: 18px;">
				<a class="press" href="addComment.php?post=<?= $post->id ?>"><i class="fas fa-comment"> Comment</i></a><br>
			</div>

		</div>
		<hr>
		<!--comment -->
		<?= $validation->getMessage('reply') ?>

		<div class="comment">

			<div class="comment-header">
				<img src="https://via.placeholder.com/50" alt="User Avatar">
				<h2><?= $comment->username ?? "" ?></h2>
			</div>

			<div>
				<p class="comment-date"><?= $comment->date ?></p>
			</div>

			<div class="comment-content">

				<form method="post">
					<p><?= $comment->content ?></p>
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




		<div class="reply">
			<div class="reply-header">
				<img src="https://via.placeholder.com/50" alt="User Avatar">
				<p><?= $reply->username ?? "" ?></p>
			</div>

			<div>
				<p class="reply-date"><?= $reply->date ?? "" ?></p>
			</div>
			<div>
				<input name="reply_input" class="inputpost" value="<?= $reply->content ?? "" ?>">
			</div>

			<div class="post-footer">
				<div>
					<button name='edit_btn' class='btn btn-primary bt'>edit</button>
				</div>
				<div>
					<a name='cancel_btn' class='btn btn-danger bt1' href='OurCommunity.php'>cancel</a>
				</div>
			</div>
		</div>

		</form>
	</div>
</div>