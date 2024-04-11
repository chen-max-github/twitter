<?php
include_once('../../models/hashtag.class.php');

$hashtag_link = $_POST['hashtag'];
$class= new hashtag;
$hashtag = $class->addHashtag($hashtag_link);