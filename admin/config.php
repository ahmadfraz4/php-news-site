<!-- all common code goes here -->


<?php
$hostname = 'http://localhost/01_php/03_php%20with%20sql/02_news-site';
$conn = mysqli_connect('localhost', 'root', '', 'news-app') or die("connection failed : ". mysqli_connect_error());

?>