<?php include 'header.php'; 
include './admin/config.php';


$limit = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$skip = ($page - 1) * $limit;



$all_posts = "SELECT 
post_id, title, description, post.category ,category_name as category, user_id ,username, post_img, post_date
FROM post 
left join category  on post.category = category.category_id
left join user on post.author = user.user_id
order by post_id desc limit $skip, $limit";
$result = mysqli_query($conn, $all_posts);

$total_number = "SELECT count(*) as total from post";
$get_total_number = mysqli_query($conn, $total_number);
$total_result = mysqli_fetch_assoc($get_total_number)['total'];


?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <div class="post-container">
                        <?php 
                        if(mysqli_num_rows($result) > 0){
                            foreach($result as $row){
                                // echo '<pre>';
                                // print_r($row);
                                // echo '</pre>';
                        ?>
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row['post_id']?>"><img src="./admin/upload/<?php echo $row['post_img']?>" alt="<?php echo $row['title']?>"/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $row['post_id']?>'><?php echo $row['title']?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php'><?php echo $row['category'] ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?aid=<?php echo $row['user_id'] ?>'><?php echo $row['username'] ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date'] ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($row['description'],0,200).'...'?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }}?>
                                    
                        <ul class='pagination'>
                        <?php 
                        $pag_number = ceil(($total_result)/$limit);
                       
                        for($i=1; $i <= $pag_number ; $i++){
                            $active = ($page == $i) ? 'active' : '';
                        ?>
                            <li class="<?php echo $active ?>"><a href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                        <?php } ?>
                        </ul>
                    </div><!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
