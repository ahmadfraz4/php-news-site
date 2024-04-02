<?php

// ==============================================================================
// redirecting if not admin

include 'config.php';

$user_role = $_SESSION['user_role'];

if($user_role != 1){
    header("Location: {$hostname}/admin/post.php");
}

// ===============================================================================



include 'config.php';
$id = $_GET['id'];
$query = "DELETE from user where user_id={$id}";
if(mysqli_query($conn, $query)){
    header("Location: {$hostname}/admin/users.php");
}else{
    echo 'SomeThing went wrong';
}
mysqli_close($conn)

?>