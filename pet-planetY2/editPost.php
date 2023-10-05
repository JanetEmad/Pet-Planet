<?php

$title = "Edit post";

use App\Http\Requests\Validation;
use App\Database\Models\Post;
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

if ($_GET && isset($_GET['post']) && is_numeric($_GET['post'])) {

	$postObj = new Post;
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

#if( isset($_POST['edit_btn']) ){
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

	$validation->setInputValue($_POST['post_content'] ?? "")->setInputValueName('post content')->required();

	if (empty($validation->getErrors())) {

		$post = new Post;
		$post->setContent($_POST['post_content'])->setId($_GET['post'])->setDate($today_date);

		$user = new User;
		$userResult = $user->setEmail($_SESSION['user']->email)->getUserInfo();
		$userResult = $userResult->fetch_object();

		$user_status = $userResult->banned;

		if ($user_status == '0') {
			if ($post->updatePostInfo()) {
				$success = "<div class='alert alert-success text-center' style='margin:auto;width:700px'> post edited successfully </div>";
				header('refresh:1;url=OurCommunity.php');
			} else {
				$error = "<div class='alert alert-danger' > Something went wrong </div>";
			}
		} else {
			$error = "<div class='alert alert-danger' style='text-transform:capitalize'> Regarding to improper activity you are banned by the admin so you can't edit </div>";
			header('refresh:2;url=OurCommunity.php');
		}
	}
}

?>
<style>
	.editpost {
		text-align: center;
		width: 100%;
		height: 100%;
		font-family: Goudy Old Style;
		text-align: left;
		margin-top: 200px;
	}

	.editpost .post {
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

	.editpost .post .post-header {
		display: flex;
		align-items: center;
	}

	.editpost .post .dropdown {
		margin-left: 70%;
	}

	.editpost .post .dropdown .dropdown-content {
		right: 0;
	}

	.editpost .post .post-header img {
		width: 50px;
		height: 50px;
		border-radius: 50%;
		margin-right: 10px;
	}

	.editpost .post .post-header h2 {
		margin: 0;
		margin-top: -3%;
		font-size: 1.5rem;
		font-weight: bolder;
	}

	.editpost .post .post-date {
		margin-left: 60px;
		color: #707070;
		margin-top: -3%;
		color: #707070;
	}

	.editpost .post .post-content {
		margin-top: 30px;
		margin-bottom: 30px;
		font-size: 1.2rem;
		line-height: 1.5;
	}


	.post-footer {
		margin-top: 10px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 0.9rem;
		color: #777;
	}

	.inputt {
		outline: none;
		width: 100%;
		height: 70%;
		background: rgba(255, 255, 255, 0.4);
		border: none;
		padding: 10px;
		color: #333;
	}

	.post-footer {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 0.9rem;
		color: #777;
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


<?= $validation->getMessage('post content') ?>

<div class="editpost">
	<?= $error ?? "" ?>
	<?= $success ?? "" ?>
	<div class="post">
		<div class="post-header">
			<img src="https://via.placeholder.com/50" alt="User Avatar">
			<h2><?= $_SESSION['user']->first_name . " " . $_SESSION['user']->last_name ?></h2>

		</div>
		<form method="post">
			<div class="post-content">
				<input type="text" name="post_content" class="inputt" value="<?= $post->content ?>"><br><br>
			</div>

			<!-- image -->
			<?php if ($post->image != null) { ?>
				<div>
					<img src='assets/img/users/posts/<?= $post->image ?>'>
				</div>
			<?php } ?>
			<!--end of image-->
			<div class="post-footer">
				<div>
					<button type="submit" class="btn btn-primary bt" name="edit_btn">Edit</button>
				</div>
		</form>
		<div>
			<a name='cancel_btn' class='btn btn-danger bt1' href='OurCommunity.php'>cancel</a>
		</div>
	</div>
</div>