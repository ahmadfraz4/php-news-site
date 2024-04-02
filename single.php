<?php include 'header.php'; 
include "./admin/config.php";

$id = $_GET['id'];
$query = "SELECT  
post_id, title, description, category_name as category, post_date, post_img, user_id, username
FROM post
left join user on post.author = user.user_id
left join category on post.category = category.category_id

where post_id = {$id}";
$result = mysqli_query($conn, $query);
?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                  <?php 
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            // echo '<pre>';
                            // print_r($row);
                            // echo "</pre>"
                  ?>
                    <div class="post-container">
                        <div class="post-content single-post">
                            <h3><?php echo $row['title'] ?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <?php echo $row['category'] ?>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href='author.php'><?php echo $row['username'] ?></a>
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo $row['post_date'] ?>
                                </span>
                            </div>
                            <img class="single-feature-image" src="./admin/upload/<?php echo $row['post_img'] ?>" alt="<?php echo $row['title'] ?>"/>
                            <p class="description">
                              <?php echo $row['description'] ?>
                            </p>
                        </div>
                    </div>
                    <?php }} ?>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
