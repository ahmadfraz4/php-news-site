<?php 
ob_start();
include "header.php";
include "config.php";

$id = $_GET['id'];
// $query = "SELECT * FROM post where post_id = $id";
$query = "SELECT 
post_id,user_id, title, description, category_name as category, category_id , post_img
from post 
left join category  on post.category = category.category_id
left join user on post.author = user.user_id
where post.post_id = {$id} and post.author = user_id";




$result = mysqli_query($conn, $query) or die('error: ' . mysqli_error($conn));?>


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
                    $selected_image = $row['post_img'];    
                    $old_category = $row['category_id']    
                ?>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <input type="hidden" name="post_id" class="form-control" value="<?php echo $row['post_id'] ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputTile">Title</label>
                                <input type="text" name="post_title" class="form-control" id="exampleInputUsername" value="<?php echo $row['title'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"> Description</label>
                                <textarea name="postdesc"  class="form-control" required rows="5"><?php echo $row['description'] ?></textarea>
                            </div>
                            <?php
                            // echo '<pre>';
                            // print_r($row);
                            // echo '</pre>'
                            ?>
                            <div class="form-group">
                                <label for="exampleInputCategory">Category</label>
                                <select class="form-control" name="category">
                                    <?php
                                    $query2 = "SELECT * FROM category";
                                    $result2 = mysqli_query($conn, $query2);

                                    if (mysqli_num_rows($result2) > 0) {
                                        while ($row2 = mysqli_fetch_assoc($result2)) {
                                            $selected =  ($row['category_id'] == $row2['category_id']) ? 'selected' : '';
                                    ?>
                                        <option <?php echo $selected ?> value="<?php echo $row2['category_id'] ?>"> <?php echo $row2['category_name'] ?> </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Post image</label>
                               
                                <input id="post-img-input" onchange="handleFile()" type="file"  name="new-image">
                                <img id="post-img" src="./upload/<?php echo $row['post_img'] ?>" height="150px">
                                <input type="hidden" name="old-image" value="">
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </form>
                <?php }} 
                // start php save code
                if(isset($_POST['submit'])){
                    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
                    $title = mysqli_real_escape_string($conn, $_POST['post_title']);
                    $desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
                    $category = mysqli_real_escape_string($conn, $_POST['category']);
                    $date = date('d M, y');
                
                    if(isset($_FILES['new-image']) && $_FILES['new-image']['error'] != UPLOAD_ERR_NO_FILE){
                        print_r($_FILES['new-image']);
                        $file = $_FILES['new-image'];
                        $file_name = $file['name'];
                        $file_size = $file['size'];
                        $temp = $file['tmp_name'];
                        $error = array();
                        
                        $extract = explode('.',$file_name);
                        $file_ext = strtolower(end($extract));
                        // print_r($file);

                        $allowed_extensions = array('png', 'jpg', 'avif', 'avi', 'jpeg');

                        if(!in_array($file_ext, $allowed_extensions)){
                            // echo 'File type must be png or jpg';
                            $error[] = 'File type must be png or jpg';
                        }
                        if($file_size > 10 * 1024 * 1024){
                            $error[] = 'File size must less than 10 mb';
                        }

                        $new_name = time().'-'.basename($file_name);
                        $target = './upload/'.$new_name;
                        $img_name = $new_name;
                        if(empty($error) == true){
                            move_uploaded_file($temp,$target);
                        }else{
                            print_r($error);
                            die();
                        }
                    }else{
                        $file_name = $selected_image;
                    }
                   
                    $query_to_save = "UPDATE post set  title = '$title',
                    description = '$desc', category = $category, post_img = '$img_name', post_date = '$date' where post_id = $post_id;";
                    $query_to_save .= "UPDATE category set post = post - 1 where category_id  = $old_category;";
                    $query_to_save .= "UPDATE category set post = post + 1 where category_id  = $category;";
                    
                    // $query_to_save .= "UPDATE category SET post = post+1 where category_id = {$category}";
                    $saving = mysqli_multi_query($conn, $query_to_save);
                    if(!$saving){
                        echo "<div class='alert alert-danger'>Query Failed</div>";
                    }else{
                        header("Location: $hostname/admin/post.php");
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