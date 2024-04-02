<?php include "header.php";

include 'config.php';


// ==============================================================================
// redirecting if not admin

$user_role = $_SESSION['user_role'];

if($user_role != 1){
    header("Location: {$hostname}/admin/post.php");
}

// ===============================================================================

$limit = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($page - 1) * $limit;
$total = "SELECT count(*) as total FROM user";
$getAll = "SELECT * from user order by user_id desc LIMIT {$offset},{$limit}";

$result = mysqli_query($conn, $getAll);
$total_query = mysqli_query($conn, $total);

$totalRecord = mysqli_fetch_assoc($total_query)['total'];



?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                          <tr>
                            <?php 
                                if(mysqli_num_rows($result) > 0){
                                    foreach($result as $row){  
                            ?>
                              <td class='id'><?php echo $row['user_id'] ?></td>
                              <td><?php echo $row['first_name']." ".$row['last_name']  ?></td>
                              <td><?php echo $row['username'] ?></td>
                              <td><?php echo $row['role'] == 0 ? 'User' : 'Admin' ?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $row['user_id'] ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-user.php?id=<?php echo $row['user_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php } } ?>         
                      </tbody>
                  </table>
                
                  <ul class='pagination admin-pagination'>
                  <?php 
              
                  $total_page = ceil($totalRecord/$limit);

                        for($i = 1; $i <= $total_page; $i++){
                           $active = ($i == $page) ?  'active' : '';
                            echo "<li class='$active'><a href='users.php?page=" . ($i) . "'>" . ($i) . "</a></li>";
                        }
                  ?>
                      <!-- <li class="active"><a>1</a></li>
                      <li><a>2</a></li>
                      <li><a>3</a></li> -->
                  </ul>
              </div>
          </div>
      </div>
  </div>
