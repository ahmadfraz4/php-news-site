<?php 
ob_start();
include "header.php";
include "config.php";


// $query = "SELECT * FROM post where post_id = $id";
$query = "SELECT * FROM web_setting";
$result = mysqli_query($conn, $query) or die('error: ' . mysqli_error($conn));

?>



<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form for show edit-->
                <?php
                if (mysqli_num_rows($result) > 0) {
                    foreach ($result as $row) {
                    $selected_image = $row['website_img'];    

                ?>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                           
                            <div class="form-group">
                                <label for="exampleInputTile">Title</label>
                                <input type="text" name="website_name" class="form-control" id="exampleInputUsername" value="<?php echo $row['website_name'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"> Description</label>
                                <textarea name="website_details"  class="form-control" required rows="5"><?php echo $row['website_details'] ?></textarea>
                            </div>
                            <?php
                            // echo '<pre>';
                            // print_r($row);
                            // echo '</pre>'
                            ?>
                          
                            <div class="form-group">
                                <label for="">Post image</label>
                               
                                <input id="post-img-input" onchange="handleFile()" type="file"  name="new-image">
                                <img id="post-img" src="./images/<?php echo $row['website_img'] ?>" height="60px" width="250px">
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </form>
                <?php }} 
                // start php save code
                if(isset($_POST['submit'])){
                    
                    $website_name = mysqli_real_escape_string($conn, $_POST['website_name']);
                    $website_details = mysqli_real_escape_string($conn, $_POST['website_details']);
                  
                    if(isset($_FILES['new-image']) && $_FILES['new-image']['error'] != UPLOAD_ERR_NO_FILE){
                        // print_r($_FILES['new-image']);
                        $file = $_FILES['new-image'];
                        $file_name = $file['name'];
                        $file_size = $file['size'];
                        $temp = $file['tmp_name'];
                        $error = array();
                        
                        $extract = explode('.',$file_name);
                        $file_ext = strtolower(end($extract));
                        // print_r($file);

                        $allowed_extensions = array('png', 'jpg', 'avif', 'avi', 'jpeg');
                          $new_name = time() . '-' . basename($file_name);
                          $target = './images/'.$new_name;
                          $img_name = $new_name;

                        if(!in_array($file_ext, $allowed_extensions)){
                            // echo 'File type must be png or jpg';
                            $error[] = 'File type must be png or jpg';
                        }
                        if($file_size > 10 * 1024 * 1024){
                            $error[] = 'File size must less than 10 mb';
                        }


                        if(empty($error) == true){
                            move_uploaded_file($temp,$target);
                        }else{
                            print_r($error);
                            die();
                        }
                    }else{
                        $file_name = $selected_image;
                    }
                   
                    $query_to_save = "UPDATE web_setting set  website_name = '$website_name',
                    website_details = '$website_details', website_img = '$img_name'";
                   
                    
                    // $query_to_save .= "UPDATE category SET post = post+1 where category_id = {$category}";
                    $saving = mysqli_query($conn, $query_to_save);
                    if(!$saving){
                        echo "<div class='alert alert-danger'>Query Failed</div>";
                    }else{
                        header("Location: $hostname/admin");
                        exit;
                    }
                    ob_end_flush();
                }
                ?>
                <!-- Form End -->
            </div>
        </div>
    </div>
</div>
<script>
    let postImg = document.getElementById('post-img');
    let postImgInput = document.getElementById('post-img-input');
    function handleFile(e){
        if(postImgInput.files && postImgInput.files[0]){
            let imgUrl = URL.createObjectURL(postImgInput.files[0]);
            postImg.src = imgUrl;
        }
    }
</script>
<?php include "footer.php"; ?>