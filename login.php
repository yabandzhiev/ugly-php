<!DOCTYPE html>
<html>
<head>
	<title>Forms</title>
	<style>
		label {
			display: block;
		}
		.error {
			border: 1px solid red;
			padding: 5px;
			width: 400px;
			color: red;
		}
	</style>
</head>
<body>

	<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: create.php");
    exit;
}

		require_once "db1.php";
		$conn = DbHelper::GetConnection();
		$user = null;
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			$stm = $conn->prepare("SELECT * FROM users WHERE id = ?");
			$stm->execute(array($id));
			$users = $stm->fetchAll(PDO::FETCH_ASSOC);
			if(count($users)) {
				$user = $users[0];
			}
		}
		
		$errors = array();
		$username = "";
		if(isset($_POST['btnSubmit'])) {
			$username = $_POST['tbUsername'];
			$password = $_POST['tbPassword'];
			
			
			
			if(strlen($username) <= 0) {
				$errors[] = "You must fill username";
			}
			
			
			if(strlen($password) <= 0) {
				$errors[] = "You must fill password";
			}
			
			
		}
		
		if(count($errors) > 0) {
			echo '<div class="error"><ul>';
			foreach($errors as $error) {
				echo "<li>$error</li>";
			}
			echo '</ul></div>';
		}
		
		if(isset($_POST['btnSubmit']) && count($errors) <= 0) {
			$statement = $conn->prepare('SELECT * FROM users WHERE username = :tbUsername');
			$statement->execute([':tbUsername' => $username]);
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			if(empty($result)){
				echo('No such user with this username!');
				echo '<a href="login.php"> Try again.</a> ';
				die();
			}
			
			$user = array_shift($result);
			
			if($user['username'] === $username && $user['password'] === $password){
				$_SESSION["loggedin"] = true;

				echo 'You have successfully logged in!' . "<br />";
				echo '<a href="create.php"> Go to </a> Todo.';
				
			}
		if($user['password'] !== $password || $user['username'] !== $username){
				echo 'Wrong username or password!';
				echo '<a href="login.php"> Try again.</a> ';
			}
		}
			else {
				
			
	?>
	<form action="login.php" method="post">
		<label for="tbUsername">Username:</label>
		<input type="text" name="tbUsername" id="tbUsername" value="<?php echo $username; ?>" />
		
		<label for="tbPassword">Password:</label>
		<input type="password" name="tbPassword" id="tbPassword" />
		
		
		
		<input type="submit" name="btnSubmit" value="Login" />
		<a href="register.php"><input type="button"  value="Registration">  </input> </a> 
	</form>
	<?php } ?>
</body>
</html>