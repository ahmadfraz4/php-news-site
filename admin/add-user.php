<?php 
include "header.php"; 
include 'config.php';


if(isset($_POST['save'])){

// to protect these values from spam or script entering we 'll use real escape string

    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $user = mysqli_real_escape_string($conn,$_POST['user']);
    $password = mysqli_real_escape_string($conn,md5($_POST['password'])); // encrypting password
    $role = mysqli_real_escape_string($conn,$_POST['role']);

    // now only plain text can b enter here

    $findUser = "SELECT username FROM user where username = '{$user}' " ;
    
    $isUserExist = mysqli_query($conn, $findUser);
    if(mysqli_num_rows($isUserExist) > 0){
        echo "<p class='message fail'>User Already Exist</p>";
        return;
    }
    
    $query = "INSERT INTO user (first_name, last_name, username,password, role) values ('{$fname}','{$lname}','{$user}', '{$password}','{$role}' )";
    if(mysqli_query($conn, $query)){
        header("Location: {$hostname}/admin/users.php");
    }

}
// ==============================================================================
// redirecting if not admin

$user_role = $_SESSION['user_role'];

if($user_role != 1){
    header("Location: {$hostname}/admin/post.php");
}

// ===============================================================================

?>




<div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF']?>" method ="POST" autocomplete="on">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin</option>
                          </select>
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php"; ?>
