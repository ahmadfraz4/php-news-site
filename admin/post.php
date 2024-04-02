<?php include "header.php"; 
include 'config.php';

$limit = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$skip = ($page -1) * $limit;

if($_SESSION['user_role'] == 0){
    $user_id = $_SESSION['user_id'];

    $query = "SELECT 
    post_id, title, description, category_name as category, post_date, username as author, post_img, username 
    from post 
    left join category  on post.category = category.category_id
    left join user on post.author = user.user_id
    where post.author = $user_id
    order by post_id desc limit $skip, $limit  ";

}elseif($_SESSION['user_role'] == 1){
    $query = "SELECT 
    post_id, title, description, category_name as category, post_date, username as author, post_img, username 
    from post 
    left join category  on post.category = category.category_id
    left join user on post.author = user.user_id
    order by post_id desc limit $skip, $limit";
}

$query_for_total_post = "SELECT COUNT(*) as total FROM post";
$total_result = mysqli_query($conn, $query_for_total_post);

$get_total_record = mysqli_fetch_assoc($total_result)['total'];

$result = mysqli_query($conn, $query);


?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                         
                          <?php 
                                if(mysqli_num_rows($result) > 0){
                                    foreach($result as $row){
                                        // echo '<pre>';
                                        // print_r($row);
                                        // echo '</pre>'
                           ?>
                          <tr>
                              <td class='id'><?php echo $row['post_id'] ?></td>
                              <td><?php echo $row['title'] ?></td>
                              <td><?php echo $row['category'] ?></td>
                              <td><?php echo $row['post_date'] ?></td>
                              <td><?php echo $row['author'] ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id'] ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a onclick="return askToDelete()" href='deletePost.php?id=<?php echo $row['post_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php }} ?>
                      </tbody>
                  </table>

                  <ul class='pagination admin-pagination'>
                  <?php 
                    
                   
                   
                    $total_page = ceil($get_total_record / $limit);
                    
                    for($i = 1; $i <= $total_page; $i++){      
                    $active = ($i == $page) ? 'active' : '';
                    ?>    
                
                    <li class="<?php echo $active?>"><a href="post.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php }?>  
                    
                  </ul>
              </div>
              
          </div>
      </div>
  </div>
<script>
    function askToDelete(){
        let isConfirm =  confirm('Do you want to delete this post?');
        return isConfirm;
    }
</script>
<?php include "footer.php"; ?>
