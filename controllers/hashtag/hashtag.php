<?php
include_once('../../models/hashtag.class.php');

$hashtag_link = $_POST['hashtag'];
$class= new hashtag;
$hashtag = $class->displayTweets($hashtag_link);
header('Content-Type: application/json');
echo json_encode($hashtag);
?>