<!DOCTYPE html>

<!-- initial PHP code to reset session -->
<?php
		session_start();
		if(isset($_SESSION["errorMessage"])) {
			echo '<script>alert("'.$_SESSION["errorMessage"].'")</script>'; 
			unset($_SESSION["errorMessage"]);
		}
		if (isset ($_SESSION["loggedUser"])) {
			unset($_SESSION["loggedUser"]);
		}

		if (isset ($_SESSION["loggedPassword"])) {
			unset($_SESSION["loggedPassword"]);
		}

?>

<html lang="en">
<head>
	<title>PME & Refresher Tracking Application, Eastern Railway, Sealdah Division</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/Login.css">
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merienda">
<!--===============================================================================================-->

</head>
<body>

<div class="login-header">
	
		<div class="login-header-label">
            PME & Refresher Tracking App, Eastern Railway, Sealdah
        </div>
</div>

<div class="login-wrap">
	<div class="login-html">
	
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
		<div class="login-form">
			
			<div class="sign-in-htm">

				<!-- Sign In form -->
				<form name="signInForm" action="ListEmployees.php" method="post">
					<div class="group">
						<label for="user" class="label">Username</label>
						<input name="user" id="user" type="text" class="input">
					</div>
					<div class="group">
						<label for="pass" class="label">Password</label>
						<input name="pass" id="pass" type="password" class="input" data-type="password">
					</div>
					<div class="group">
						<input name="check" id="check" type="checkbox" class="check" checked>
						<label for="check"><span class="icon"></span> Keep me Signed in</label>
					</div>
					<div class="group">
						<button type="submit" class="button-sign"><span>Submit </span></button>                
					</div>
				</form>

				<div class="hr"></div>
				<div class="foot-lnk">
					<a href="ListEmployees.html" >Forgot Password?</a>
				</div>
			</div>
			<div class="sign-up-htm">

			<!-- Sign Up form -->
				<form name="signUpForm" action="updateSignUp.php" method="get">
					<div class="group">
						<label for="user" class="label">Username</label>
						<input id="user" type="text" class="input">
					</div>
					<div class="group">
						<label for="pass" class="label">Password</label>
						<input id="pass" type="password" class="input" data-type="password">
					</div>
					<div class="group">
						<label for="pass" class="label">Repeat Password</label>
						<input id="pass-repeat" type="password" class="input" data-type="password">
					</div>
					<div class="group">
						<label for="pass" class="label">Security Question: Your mother's maiden name?</label>
						<input id="pass" type="text" class="input">
					</div>
					<div class="group">
						<label for="pass" class="label">Choose your TI Unit/admin for Approval</label>
						<select name="unitapprove" id="unitapproval" class="input-dropdown" >
							<option value="TIMBT1" class="input-option">TI (M) / BT - I</option>
							<option value="TIMBT2" class="input-option">TI (M) / BT - II</option>
							<option value="TIMSPR1" class="input-option">TI (M) / SPR - I</option>
							<option value="TIMSPR2" class="input-option">TI (M) / SPR - II</option>
							<option value="ADMIN" class="input-option">Other Administrator</option>
						</select>
					</div>
					<div class="group">
						<button class="button-sign"><span>Register </span></button>
					</div>
				</form>
				<div class="foot-link-member">
					<label for="tab-1">Already Member?</a>
				</div>
			</div>
		</div>		
		
	</div>
	
</div>

</body>