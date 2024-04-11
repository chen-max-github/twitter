<?php
include_once('../../models/search.class.php');
$username=$_POST['username'];
$class=new search;
$tweets=$class->displayTweets($username);
header('Content-Type: application/json');
echo json_encode($tweets);