<?php
include 'config.php';
$id = isset($_GET['id']) ?  $_GET['id'] : '';



    // $id = $_GET['id'];
    $query = "SELECT * FROM post where post_id = $id";
    $result = mysqli_query($conn, $query) or  die('Cant excecute query: '. mysqli_error($conn));;
   
    $row = mysqli_fetch_assoc($result);
    $image = $row['post_img'];
    if(file_exists('./upload/'.$image)){
        unlink('./upload/'.$image);
    }

    $cat = $row['category'];
   

    $query_to_delete = "DELETE from post where post_id = $id;";
    $query_to_delete .= "UPDATE category set post = post - 1 where category_id  = $cat";

    
    if(mysqli_multi_query($conn, $query_to_delete)){
        
        header("Location: $hostname/admin/post.php");
    }else{
        die('Cant excecute query: '. mysqli_error($conn));
    }
?>