<?php
include('db_connect.php');
?>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="post" action="login.php">
		<label>User<input type="text" name="user" value=""></label>
		<br>
		<label>Password<input type="password" name="password" value=""></label>
		<br>
		<input type="submit" name="login" value="Log in">
		<input type="submit" name="reg" value="Registration">
		<?php
		if (isset($_POST['login'])) {
			$user=$_POST['user'];
			$password=$_POST['password'];
			$select_query = "SELECT * FROM `secretscripts` WHERE `user`='$user' AND `password`='$password'";
			$result = mysqli_query($conn, $select_query);
			if (mysqli_num_rows($result)>0) {
				$_SESSION['user']=$user;

				header('Location:test.php');
			} else {
				echo "<font color='red'>Incorrect input</font>";
			}
		}
		if (isset($_POST['reg'])) {
			header('Location:test.php');
		}

		?>
	</form>
</body>
</html>