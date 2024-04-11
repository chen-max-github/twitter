<?php

require_once('../../models/users.class.php');
require_once('../../models/tweets.class.php');

$user_id = $_GET['id'];

$users = new Users;
$tweets = new Tweets;

header('Content-Type: application/json');

$res = [];

$followers = $users->getFollowers($user_id);
$following = $users->getFollowing($user_id);
$user_info = $users->getUserById($user_id);
$user_tweets = $tweets->getTweets($user_id);

$res['user_info'] = $user_info;
$res['followers'] = $followers;
$res['following'] = $following;
$res['tweets'] = $user_tweets;


echo json_encode($res);
