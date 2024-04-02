<?php
include './admin/config.php';

$limit = 5;

$query = "SELECT 
post_id, title, description, post.category, category_name as category, category_id,  post_img, post_date
 FROM post
LEFT JOIN category ON post.category = category.category_id
order by post_id desc limit  $limit";

$result = mysqli_query($conn, $query);

// echo '<pre>';
// print_r($result);
// echo '</pre>';

?>
<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <?php
            if(mysqli_num_rows($result) > 0){
                foreach(($result) as $row){
                    // echo '<pre>';
                    // print_r($row);
                    // echo '</pre>';
                

        ?>
        <div class="recent-post">
            <a class="post-img" href="">
                <img src="./admin/upload/<?php echo $row['post_img'] ?>" alt=""/>
            </a>
            <div class="post-content">
                <h5><a href="single.php?id=<?php echo $row['post_id'] ?>"><?php echo $row['title'] ?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href='category.php?cid=<?php echo $row['category_id'] ?>'><?php echo $row['category'] ?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <?php echo $row['post_date'] ?>
                </span>
                <a class="read-more" href="single.php?id=<?php echo $row['post_id'] ?>">read more</a>
            </div>
        </div>
        <?php }}?>
       
    </div>
    <!-- /recent posts box -->
</div>
