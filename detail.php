<?php
require_once "db_connect.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    DbHelper::db();
    global $link;
    $query = "SELECT todoTitle, todoDescription, date FROM todo WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    if(mysqli_num_rows($result)==1){
        $row = mysqli_fetch_array($result);
        if($row){
            $title = $row['todoTitle'];
            $description = $row['todoDescription'];
            $date = $row['date'];
			?>
			<a href="index.php">Go back</a>
			<?php

            echo "
            <h2>$title</h2>
            <h3>description</h3>
            <p>$description</p>
            <small>$date</small>
            ";
        }
    }else{
        echo 'no todo';
    }
}