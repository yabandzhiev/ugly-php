<?php
require_once 'db_connect.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    DbHelper::db();
    global $link;
    $query = "SELECT todoTitle, todoDescription FROM todo WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_array($result);
        if($row){
            $title = $row['todoTitle'];
            $description = $row['todoDescription'];
			?>
			<a href="index.php">Go back</a>
			<?php
            echo "
                <h2>Edit Todo</h2>
                
            <form action='edit.php?id=$id' method='post'>
            <p>Title</p>
             <input type='text' name='title' value='$title'>
             <p>Description</p>
             <input type='text' name='description' value='$description'>
             <br>
             <input type='submit' name='submit' value='edit'>
            </form>
            ";
        }
    }else{
        echo "no todo";
    }


    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        DbHelper::db();
        $query = "UPDATE todo SET todoTitle = '$title', todoDescription = '$description'  WHERE id = '$id'";
        $insertEdited = mysqli_query($link, $query);
        if($insertEdited){
            echo "successfully updated";
        }
        else{
            echo mysqli_error($link);
        }
    }


}