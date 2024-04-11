<?php
require_once('../../models/follow.class.php');
$tweet_id= $_POST['username'];
$class= new follow;
$follow=$class->followUser();
header('Content-Type: application/json');
echo json_encode($follow);