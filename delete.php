<?php
	require_once "db_connect.php";
	$conn = DbHelper::db();
	$id = -1;
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
	}
	if(isset($_POST["btnYes"])) {
		
    DbHelper::db();
    global $link;
    $query = "DELETE FROM todo WHERE id = '$id'";
    $delete = mysqli_query($link, $query);
		header("Location: index.php");
	} else if(isset($_POST["btnNo"])) {
		header("Location: index.php");
	}
?>
<html>
	<head></head>
	<body>
		<form method="post">
			<input type="hidden" value="<?= $id ?>" />
			The selected task will be deleted. Do you wish to proceed?
			<input type="submit" name="btnYes" value="yes" />
			<input type="submit" name="btnNo" value="no" />
		</form>
	</body>
</html>


