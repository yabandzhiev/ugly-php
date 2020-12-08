<?php
require_once("db_connect.php");
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<html>
<head>
    <title>my todos</title>
</head>
<body>
<h2>
    Next on my agenda
</h2>
<p><a href="create.php">add todo</a></p>
<?php
DbHelper::db();
global $link;
$query  = "SELECT id, todoTitle, todoDescription, date FROM todo";
$result = mysqli_query($link, $query);
//check if there's any data inside the table
if(mysqli_num_rows($result) >= 1){
    while($row = mysqli_fetch_array($result)){
        $id = $row['id'];
        $title = $row['todoTitle'];
        $date = $row['date'];

        ?>

    <ul>
        <li><a href="detail.php?id=<?php echo $id?>"><?php echo $title ?></a></li> <?php echo "[[$date]]";?>
        <button type="button"><a href="edit.php?id=<?php echo $id?>">Edit</a></button>
        <button type="button"><a href="delete.php?id=<?php echo $id?>">Delete</a></button>
    </ul>
<?php
    }
}

?>


</body>
</html>