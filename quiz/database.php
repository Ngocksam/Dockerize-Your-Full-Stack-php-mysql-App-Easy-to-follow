<?php
$cn = mysqli_connect("localhost", "root", "") or die("Could not Connect to MySQL");
mysqli_select_db($cn, "quiz") or die("Could not connect to Database");
?>
