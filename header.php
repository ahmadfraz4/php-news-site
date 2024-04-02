<?php

session_start();
include 'admin/config.php';
if (!isset($_SESSION['username'])) {
    header("Location: {$hostname}/admin/");
}
$cid = isset($_GET['cid']) ? $_GET['cid'] : 'all';
$query = "SELECT * FROM category where post != 0";
$result = mysqli_query($conn, $query);
// echo '<pre>';
// print_r(basename($_SERVER['PHP_SELF']));
// echo '</pre>';

switch(basename($_SERVER['PHP_SELF'])){
    case 'single.php':
        $page_title = 'Single Post';
        break;
    case 'category.php':
        $page_title = 'category page';
        break;
    default : $page_title = 'Blog news';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <a href="index.php" id="logo"><img src="images/news.jpg"></a>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class='menu'>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                        ?>
                        <li><a class="<?php echo $cid == 'all' ? 'active' : '' ?>" href='category.php?cid=all'>All</a></li>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $active = ($row['category_id'] == $cid) ? 'active' : '';
                        ?>
                            <li><a class="<?php echo $active ?>" href='category.php?cid=<?php echo $row['category_id'] ?>'><?php echo $row['category_name'] ?></a></li>
                        <?php  } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->