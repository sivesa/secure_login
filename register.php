<?php
include 'config/db_connection.php';
session_start();
// check Register request
if (!empty($_POST['submitty'])) {
	//on button click, validate data field for registration
	if ($_POST['fname'] == "" || $_POST['lname'] == "" || $_POST['email'] == "" || $_POST['password2'] == "" 
				|| $_POST['password1'] == "") {
		header("Location: ./register.php?err=To register, please fill in all the fields");
		exit();
	}
	else if ($_POST['password1'] != $_POST['password2']) 
	{
		header("Location: register.php?err=Passwords don't match");
		$register_error_message = 'Passwords don\'t match!';
		exit();
	} 
	else if (strlen($_POST['password1']) < 6) 
	{
		$register_error_message = 'Password must be at least 6 characters!';
		echo $register_error_message . "<br>";
	} 
	else if (!preg_match('/[^a-zA-Z]+/',($_POST['password1']))) 
	{
		$register_error_message = 'Passwords must have at least one special character!';
		echo $register_error_message . "<br>";
	} 
	else {
		try {
			$fname = trim($_POST['fname']);
			$fname = strip_tags($fname);
			$fname = htmlspecialchars($fname);

			$lname = trim($_POST['lname']);
			$lname = strip_tags($lname);
			$lname = htmlspecialchars($lname);

			$email = trim($_POST['email']);
			$email = strip_tags($email);
			$email = htmlspecialchars($email);

			$password = trim($_POST['password1']);
			$password = strip_tags($password);
			$password = htmlspecialchars($password);
			$enc_password = hash('sha256', $password);

			// prepare sql and bind parameters
			$stmt = $conn->prepare("INSERT INTO abantu(fname, lname, email, password) 
			VALUES(:fname, :lname, :email, :password)");
			$stmt->bindParam(':fname', $fname);
			$stmt->bindParam(':lname', $lname);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $enc_password);

			$stmt1 = $conn->prepare("SELECT uid FROM abantu WHERE email=:email");
			$stmt1->bindParam(':email', $email);
			$stmt1->execute();
			if ($stmt1->rowCount() > 0) {
				header("Location: ../register.php?err=Email is already in use");
				echo "Email Is Already In Use! <br>";
			}
			else {
				$_SESSION[Username] = $email;
				if ($stmt->execute()) {
					header('Location: http://127.0.0.1:8080/secure_login/');
					echo "Email sent to you";
				}
				else {
					echo "Couldn't send email";
				}
			}
		}
		catch (PDOException $e) {
			echo "Error: " . $sql . "<br>" . $e->getMessage();
		}
		$conn = null;
	}
}	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create Account V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST">
					<span class="login100-form-title">
						Member Registration
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid name is required: e.g. Bob">
						<input class="input100" type="text" name="fname" placeholder="First Name">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Valid last name is required: e.g. Bobbler">
						<input class="input100" type="text" name="lname" placeholder="Last name">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password1" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password2" placeholder="Retype Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<input class="login100-form-btn" name="submitty" type="submit" value="Sign up">
					</div>

					<!-- <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div> -->

					<div class="text-center p-t-136">
						<a class="txt2" href="index.php">
							Login
							<i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>