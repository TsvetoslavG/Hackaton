<?php
	session_start();
	//Db Config Import
	include("../php/dbconfig.php");
	//Check if there is active session available
	if(isset($_SESSION['user'])){
		header("location: home.php");
	}
	
	if(isset($_POST['regon'])){
		//Error Msg Holder
		$errMsg = "";
		$err = 0;
		//Getting Inputs Values
		$username = $_POST['username'];
		$username = htmlspecialchars($username);
		$username = strip_tags($username);
		$username = mysql_real_escape_string($username);
		/* Password */
		$pass = $_POST['pass'];
		$pass = htmlspecialchars($pass);
		$pass = strip_tags($pass);
		$pass =  mysql_real_escape_string($pass);
		/* Email */
		$email = $_POST['email'];
		$email = htmlspecialchars($email);
		$email = strip_tags($email);
		$email = mysql_real_escape_string($email);
		/* Gender */
		$gender = $_POST['gender'];
		
		if(empty($username) || empty($email) || empty($pass)){
			//Check if empty values module
			$err++;
			$errMsg = "Попълни всички полета";
		}elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
			//Email Module
			$err++;
			$errMsg = "Попълни валидна електронна поща!";
		}elseif(!isset($_POST['rules'])){
			//Rules agree module
			$err++;
			$errMsg = "Съгласи се с правилата на играта!";
		}
		
		if(!$err){
			//Database Check Module
			$select_query = mysqli_query($conn, "SELECT * FROM `secretscripts` WHERE `email`='$email'");
		
			if(mysqli_num_rows($select_query) > 0){
				$err++;
				$errMsg = "Вече съществува такава Електронна поща!";
			}else{
				//Get the date of registration
				$now = date("Y-m-d");
				//Insert Query
				$insert_query = mysqli_query($conn, "INSERT INTO `secretscripts`(`username`, `pass`, `email`, `gender`, `reg_date`) VALUES ('$username', '$pass', '$email', '$gender', '$now')");
			}
		}
	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>SuperScript || Home Page</title>
		<!-- CSS Import -->
		<link rel="stylesheet" type="text/css" href="styles/home.css">
		<!-- Viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<form action="#no-js" method="POST" id="form" class="register-form">
			<fieldset>
				<label class="input-holder">
					<input type="text" name="username" placeholder="Име на играча" value="<?php if(isset($username)){ echo $username; } ?>">
				</label>
				<label class="input-holder">
					<input type="email" name="email" placeholder="Електронна поща" value="<?php if(isset($email)){ echo $email; }?>">
				</label>
				<label class="input-holder">
					<input type="password" name="pass" placeholder="Парола" value="<?php if(isset($pass)){ echo $pass; } ?>">
				</label>
			</fieldset>
			<fieldset>
				<input type="radio" name="gender" value="male" checked>
				<input type="radio" name="gender" value="female">
			</fieldset>
			<fieldset>
				<input type="checkbox" name="rules">
			</fieldset>
			<input type="submit" name="regon" value="Регистрирай ме">
			<!-- Error Message Here -->
			<?php if(isset($errMsg)){ ?>
				<p><?php echo $errMsg ?></p>
			<?php } ?>
		</form>
		<script>
			var form = document.getElementById("form");
			
			/*
			form.addEventListener("submit", function(event){ Submit();  event.preventDefault(); });
			*/
			
			function Submit(){
				var err = 0;
				
				for(var i = 0; i < form.length; i++){
			
					if(form[i].type == "text" || form[i].type == "email" || form[i].type == "password"){
						if(form[i].value == ""){
							err++;
						}
					}else if(form[i].type == "checkbox" && form[i].name == "rules"){
						if(!form[i].checked){
							err++;
						}
					}
				}
				
				if(err > 0){
					alert("Fill all the fields");
				}else{
					form.submit();
				}
			}
			
		</script>
	</body>
</html>
