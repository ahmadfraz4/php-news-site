<?php

include 'config.php';
session_start();
$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$date = date("d M, Y");
$author = $_SESSION['user_id'];

if(isset($_FILES['fileToUpload'])){
    $error = array(); // creating custom array of errors 
    $file = $_FILES['fileToUpload'];
    // print_r($file); die();
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_type = $file['type'];
    // extracting extension
    $file_parts = explode('.', $file_name); // Split the file name into parts
    $file_ext = strtolower(end($file_parts));
    
    $temp_name = $file['tmp_name'];
    $extenstions = array('jpeg', 'jpg', 'png','avif'); // allowed extensions

    $new_name = time() . '-' . basename($file_name);
   
    
    $target = './upload/'.$new_name;
    $img_name = $new_name;

    if(in_array($file_ext, $extenstions) === false){
        $error[] = 'You can select only jpg, or png';
      
    }
    if($file_size > 1024 * 1024 * 10){ // 2 mb
        $error[] = 'file size must less than 2mb';
    }
    if(empty($error) == true){
        move_uploaded_file($temp_name, $target);
    }else{
        print_r($error);
        die();
    }

    $query = "INSERT INTO post (title, description, category, post_date, author, post_img) 
    values ('$title', '$desc', $category, '$date', $author, '$img_name');";

    $query .= "UPDATE category SET post = post+1 where category_id = {$category}";

    //

    if(mysqli_multi_query($conn, $query)){
        header("Location: $hostname/admin/post.php");
    }else{
        echo "<div class='alert alert-danger'>Query Failed</div>";
    }

}
















?>