<?php
	include("includes/config.php");
	include("includes/classes/ArtistAccount.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<html>
<head>
	<title>MUSIC | ARTIST</title>

	<link rel="stylesheet" type="text/css" href="assets/css/artistregister.css">

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>
	<?php

	if(isset($_POST['artistregisterButton'])) {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
				});
			</script>';
	}
	else {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").show();
					$("#registerForm").hide();
				});
			</script>';
	}

	?>
	

	<div id="background">

		<div id="loginContainer">

			<div id="inputContainer">
				<form id="loginForm" action="artistregister.php" method="POST">
					<h2>Login to your account</h2>
					<p>
						<?php echo $account->getError(Constants::$loginFailed); ?>
						<label for="email">Email</label>
						<input id="email" name="loginemail" type="text" placeholder="e.g. userail@mymail.com" value="<?php getInputValue('loginEmail') ?>" required>
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" required>
					</p>

					<button type="submit" name="artistloginButton">LOG IN</button>

					<div class="hasAccountText">
						<span id="hideLogin">Don't have an account yet? Signup here.</span>
					</div>
					
				</form>



				<form id="registerForm" action="artistregister.php" method="POST">
					<h2>Create your free account</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<label for="artistname">Artist Name</label>
						<input id="artistname" name="artistname" type="text" placeholder="e.g. artist Name" value="<?php getInputValue('username') ?>" required>
					</p>

					

					<p>
						<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<label for="email">Email</label>
						<input id="email" name="email" type="email" placeholder="e.g. user@mymail.com" value="<?php getInputValue('email') ?>" required>
					</p>

					<p>
						<label for="email2">Confirm email</label>
						<input id="email2" name="email2" type="email" placeholder="e.g. user@mymail.com" value="<?php getInputValue('email2') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
						<label for="password">Password</label>
						<input id="password" name="password" type="password" placeholder="Your password" required>
					</p>

					<p>
						<label for="password2">Confirm password</label>
						<input id="password2" name="password2" type="password" placeholder="Your password" required>
					</p>

					<button type="submit" name="artistregisterButton">SIGN UP</button>

					<div class="hasAccountText">
						<span id="hideRegister">Already have an account? Log in here.</span>
					</div>
					
					
				</form>


			</div>

			<div id="loginText">
				<h1>Upload great music, right now</h1>
				<h2>Release your own songs for free</h2>
				<ul>
					<li>Upload music and reach a global audience within seconds</li>
					<li>Create your own album</li>
					<li>View analytics</li>
				</ul>
			</div>
			<div class="hasAccountText">
						<a style="background-color:#019131; color:white; padding:14px 25px; text-allign:center; text-decoration:none; display:inline-block;" href="register.php">Listener? Click Here</a>
			</div>
		</div>
	</div>

</body>
</html>