<?php include "header.php";

if (!isset($_GET['id'])) {
    echo 'Id not found';
    return;
}
$id = $_GET['id'];

include 'config.php';

// ==============================================================================
// redirecting if not admin

$user_role = $_SESSION['user_role'];

if($user_role != 1){
    header("Location: {$hostname}/admin/post.php");
}

// ===============================================================================

$query = "SELECT * FROM user where user_id = '{$id}' ";
$result = mysqli_query($conn, $query)  or die('Cant execute query') ;


// php user update code


if(isset($_POST['submit'])){
    $userId = mysqli_real_escape_string($conn,$_POST['user_id']);
    $fname = mysqli_real_escape_string($conn,$_POST['f_name']);
    $lname = mysqli_real_escape_string($conn,$_POST['l_name']);
    $user = mysqli_real_escape_string($conn,$_POST['username']);
    $role = mysqli_real_escape_string($conn,$_POST['role']);

    include 'config.php';
    $user_update_query = "UPDATE user SET first_name = '{$fname}', last_name = '{$lname}', username = '{$user}', role = '{$role}' where user_id = {$userId}";
    if(mysqli_query($conn, $user_update_query)){
        echo 'User updated successfully';
        header("Location: {$hostname}/admin/users.php");
    } else{
        echo 'Cant Update User';
    }
}




?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <!-- Form Start -->
                <?php 
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                ?>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="user_id" class="form-control" value="<?php echo $row['user_id'] ?>" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'] ?>" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'] ?>" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="role" value="<?php echo $row['role']; ?>">

                            <option <?php echo $row['role'] == 0 ? 'selected' : '' ?> value="0">User</option>
                            <option <?php echo $row['role'] == 1 ? 'selected' : '' ?> value="1">Admin</option>
                        </select>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                </form>
                <?php }
                    }?>
                <!-- /Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>