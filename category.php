<?php include 'header.php'; 
include './admin/config.php';

$limit = 2;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$skip = ($page - 1) * $limit;

$cid = isset($_GET['cid']) ? $_GET['cid'] : 'all';

// Check if $cid is not equal to 'all'
if ($cid != 'all') {
    // Construct SQL query with WHERE clause
    $total_number = "SELECT *  from post  where post.category = $cid";

    $all_posts = "SELECT 
        post_id, title, description, post.category, category_name as category, user_id, username, post_img, post_date
        FROM post 
        LEFT JOIN category ON post.category = category.category_id
        LEFT JOIN user ON post.author = user.user_id
        WHERE category.category_id = $cid
        ORDER BY post_id DESC LIMIT $skip, $limit";

        
} else {
    // Construct SQL query without WHERE clause
    $total_number = "SELECT *  from post";
    $all_posts = "SELECT 
        post_id, title, description, post.category, category_name as category, user_id, username, post_img, post_date, category.category_id as cat_id
        FROM post 
        LEFT JOIN category ON post.category = category.category_id
        LEFT JOIN user ON post.author = user.user_id
        ORDER BY post_id DESC LIMIT $skip, $limit";

}

$get_total_number = mysqli_query($conn, $total_number); // geting number of record
$result = mysqli_query($conn, $all_posts); // getting results


?>
    <div id="main-content">
      <div class="container">
        <h1><?php echo $cid == 'all' ? 'All' : mysqli_fetch_assoc($result)['category']  ?></h1>
        <div class="row">
            <section class="col-md-8">
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
                                                <a href='category.php?cid=<?php echo $row['cat_id'] ?>'><?php echo $row['category'] ?></a>
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
                        if(mysqli_num_rows($get_total_number) > 0){
                           $total_records = mysqli_num_rows($get_total_number);     
                          $pag_number = ceil($total_records/$limit);
                       
                        for($i=1; $i <= $pag_number ; $i++){
                            $active = ($page == $i) ? 'active' : '';
                        ?>
                            <li class="<?php echo $active ?>"><a href="category.php?cid=<?php echo $cid ?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                        <?php }} ?>
                        </ul>
                </div><!-- /post-container -->
            </section>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
