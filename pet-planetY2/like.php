<?php

$title = "like";

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

$userrid = $_SESSION['user']->id;
// connect to the database
$dbName = 'pet_planet';
$hostName = 'localhost';
$username = 'root';
$password = '';
$DBport = 3307;

$con = new \mysqli($hostName, $username, $password, $dbName, $DBport);

if (isset($_POST['liked'])) {
	$postid = $_POST['postid'];
	$result = mysqli_query($con, "SELECT * FROM posts WHERE id=$postid");
	$row = mysqli_fetch_array($result);
	$n = $row['likes'];

	mysqli_query($con, "INSERT INTO likes (user_id, post_id) VALUES ($userrid , $postid)");
	mysqli_query($con, "UPDATE posts SET likes=$n+1 WHERE id=$postid");

	echo $n + 1;
	exit();
}
if (isset($_POST['unliked'])) {
	$postid = $_POST['postid'];
	$result = mysqli_query($con, "SELECT * FROM posts WHERE id=$postid");
	$row = mysqli_fetch_array($result);
	$n = $row['likes'];

	mysqli_query($con, "DELETE FROM likes WHERE post_id=$postid AND user_id=$userrid");
	mysqli_query($con, "UPDATE posts SET likes=$n-1 WHERE id=$postid");

	echo $n - 1;
	exit();
}

// Retrieve posts from the database
$posts = mysqli_query($con, "SELECT * FROM posts");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="styles.css">
	<style>
		.post {
			width: 30%;
			margin: 10px auto;
			border: 1px solid #cbcbcb;
			padding: 5px 10px 0px 10px;
		}

		.like,
		.unlike,
		.likes_count {
			color: blue;
		}

		.hide {
			display: none;
		}

		.fa-thumbs-up,
		.fa-thumbs-o-up {
			transform: rotateY(-180deg);
			font-size: 1.3em;
		}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
	<!-- display posts gotten from the database  -->
	<?php while ($row = mysqli_fetch_array($posts)) { ?>

		<div class="post">
			<?php echo $row['content']; ?>

			<div style="padding: 2px; margin-top: 5px;">
				<?php
				// determine if user has already liked this post
				$results = mysqli_query($con, "SELECT * FROM likes Where post_id=" . $row['id'] . "");

				if (mysqli_num_rows($results) == 1) : ?>
					<!-- user already likes post -->
					<span class="unlike fa fa-thumbs-up" data-id="<?php echo $row['id']; ?>"></span>
					<span class="like hide fa fa-thumbs-o-up" data-id="<?php echo $row['id']; ?>"></span>
				<?php else : ?>
					<!-- user has not yet liked post -->
					<span class="like fa fa-thumbs-o-up" data-id="<?php echo $row['id']; ?>"></span>
					<span class="unlike hide fa fa-thumbs-up" data-id="<?php echo $row['id']; ?>"></span>
				<?php endif ?>

				<span class="likes_count"><?php
											if (!str_contains($row['likes'], '</nav>')) {
												echo $row['likes'];
											} else {
												$string = $row['likes'];
												$prefix = "</nav>";
												$index = strpos($string, $prefix) + strlen($prefix);
												$result = substr($string, $index);
												echo $result;
												die;
											}
											?> likes</span>
			</div>
		</div>

	<?php } ?>
	<!-- Add Jquery to page -->
	<script>
		$(document).ready(function() {
			// when the user clicks on like
			$('.like').on('click', function() {
				var postid = $(this).data('id');
				$post = $(this);

				$.ajax({
					url: 'like.php',
					type: 'post',
					data: {
						'liked': 1,
						'postid': postid
					},
					success: function(response) {
						$post.parent().find('span.likes_count').text(response + " likes");
						$post.addClass('hide');
						$post.siblings().removeClass('hide');
					}
				});
			});

			// when the user clicks on unlike
			$('.unlike').on('click', function() {
				var postid = $(this).data('id');
				$post = $(this);

				$.ajax({
					url: 'like.php',
					type: 'post',
					data: {
						'unliked': 1,
						'postid': postid
					},
					success: function(response) {
						$post.parent().find('span.likes_count').text(response + " likes");
						$post.addClass('hide');
						$post.siblings().removeClass('hide');
					}
				});
			});
		});
	</script>
</body>

</html>