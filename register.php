<?php
	require_once('db1.php');
	$conn = DbHelper::GetConnection();
	$id = -1;
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
?>
<html>
<head>
</head>
<body>
	<?php
		$errors = array();
		if(isset($_POST['btnSubmit'])) {
			if(!isset($_POST['tbUsername']) || strlen($_POST['tbUsername']) < 4 || strlen($_POST['tbUsername']) > 50) {
				$errors[] = "Username is invalid!";
			}
			if(!isset($_POST['tbPassword']) || strlen($_POST['tbPassword']) < 8 || strlen($_POST['tbPassword']) > 50 || !isset($_POST['tbPasswordAgain']) || $_POST['tbPasswordAgain'] != $_POST['tbPassword']) {
				$errors[] = "Invalid password or passwords dont match!";
			}
			if(!isset($_POST['tbEmail']) || strlen($_POST['tbEmail']) < 8 || strlen($_POST['tbEmail']) > 100) {
				$errors[] = "Invalid E-mail!";
			}
			
			if(count($errors) == 0 && $user == null) {				
				$stm = $conn->prepare('INSERT INTO users(username, password, email) VALUES(?, ?, ?)');
				$stm->execute(array($_POST['tbUsername'], $_POST['tbPassword'], $_POST['tbEmail']));
				
				header("Location: login.php");
			} elseif(count($errors) == 0) {
				$stm = $conn->prepare('UPDATE users SET username = ?, password = ?, email = ? WHERE id = ?');
				$stm->execute(array($_POST['tbUsername'], $_POST['tbPassword'], $_POST['tbEmail'], $id));
				
				header("Location: login.php");
			}
		}
		
		if(count($errors) > 0) {
		?>
			<ul style="color: red;">
				<?php
					foreach($errors as $e) {
						echo "<li>$e</li>";
					}
				?>
			</ul>
		<?php
		}
	?>
	<form method="post">
		<p>
			<label for="tbUsername">Username:</label>
			<input type="text" id="tbUsername" name="tbUsername" value="<?=($user != null) ? $user["username"] : ""?>" />
		</p>
		<p>
			<label for="tbPassword">Password:</label>
			<input type="password" id="tbPassword" name="tbPassword" />
		</p>
		<p>
			<label for="tbPasswordAgain">Password(again):</label>
			<input type="password" id="tbPasswordAgain" name="tbPasswordAgain" />
		</p>
		<p>
			<label for="tbEmail">E-mail:</label>
			<input type="text" id="tbEmail" name="tbEmail" value="<?=($user != null) ? $user["email"] : ""?>" />
		</p>
		<p>
			<input type="submit" value="Register" name="btnSubmit" />
			<a href="login.php"><input type="button" value="Back" /></a>
		</p>
	</form>
</body>
</html>