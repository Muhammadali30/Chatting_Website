<?php
require 'CLASSES/user.php';
session_start();
$response="";
if (isset($_POST['add'])) {
	$user=new user();
	$response = $user->signin($_POST['uname'],$_POST['password']);
}
if ($response!=0&&$response!="") {
	$_SESSION['USER_ID']=$response;
	header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Sign In – Swipe</title>
		<meta name="description" content="#">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap core CSS -->
		<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
		<!-- Swipe core CSS -->
		<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
		<!-- Favicon -->
		<link href="dist/img/favicon.png" type="image/png" rel="icon">
	</head>
	<body class="start">
		<main>
			<div class="layout">
				<!-- Start of Sign In -->
				<div class="main order-md-1">
					<div class="start">
						<div class="container">
							<div class="col-md-12">
								<div class="content">
									<h1>Sign in to Chat-Box</h1>
									<div class="third-party">
										<button class="btn item bg-blue">
											<i class="material-icons">pages</i>
										</button>
										<button class="btn item bg-teal">
											<i class="material-icons">party_mode</i>
										</button>
										<button class="btn item bg-purple">
											<i class="material-icons">whatshot</i>
										</button>
									</div>
									<?php if ($response==0) {
										?>
										<div class="alert alert-danger" role="alert">
										Invalid Username OR Password!
										</div>
									<?php }
									?>
									<p>or use your email account:</p>
									<!-- SIGn IN MYY -->
									<form action="sign-in.php" method="post">
										<div class="form-group" >
											<input type="text" id="inputEmail" class="form-control" placeholder="UserName" name="uname" required>
											<button class="btn icon"><i class="material-icons">mail_outline</i></button>
										</div>
										<div class="form-group">
											<input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
											<button class="btn icon"><i class="material-icons">lock_outline</i></button>
										</div>
										<button type="submit" class="btn button" name="add" style="background-color: black;">Sign In</button>
										<div class="callout">
											<span>Don't have account? <a href="sign-up.php">Create Account</a></span>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sign In -->
				<!-- Start of Sidebar -->
				<div class="aside order-md-2" style="background-image: linear-gradient(to left,black,white);">
					<div class="container" >
						<div class="col-md-12">
							<div class="preference" >
								<h2>Hello, </h2>
								<p>Enter your personal details and start your journey with Swipe today.</p>
								<a href="sign-up.php" class="btn button" style="color:black;">Sign Up</a>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sidebar -->
			</div> <!-- Layout -->
		</main>
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
		<script src="dist/js/vendor/popper.min.js"></script>
		<script src="dist/js/bootstrap.min.js"></script>
	</body>

</html>