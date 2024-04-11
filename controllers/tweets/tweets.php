<?php

require('../../models/tweets.class.php');
require('../../models/users.class.php');

$users = new Users;
$tweets = new Tweets;

$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method == "POST") {
    $user_id = $_POST['user_id'];
    $tweet_id = $_POST['tweet_id'];
    $functionality = $_POST['functionality'];
} else {
    $user_id = $_GET['user_id'];
    $functionality = $_GET['functionality'];
}

header('Content-Type: application/json');

switch ($functionality) {
    case 'like':
        like($user_id, $tweet_id, $tweets);
        break;

    case 'retweet':
        retweet($user_id, $tweet_id, $tweets);
        break;

    case 'comment':
        comment($user_id, $_POST['id_response'], $_POST['content'], $tweets);
        break;

    case 'getTweets':
        getTweets($user_id, $tweets, $users);
        break;

    case 'autocomplete':
        autocomplete($users);
        break;
}

function like($user_id, $tweet_id, $tweets)
{
    $liked = $tweets->checkLiked($user_id, $tweet_id);

    if ($liked) {
        $tweets->deleteLike($user_id, $tweet_id);
        echo json_encode(array('success' => true));
        exit;
    }


    $addLike = $tweets->like($user_id, $tweet_id);

    if ($addLike) {
        echo json_encode(array('success' => true));
        return;
    }

    echo json_encode(array('success' => false));
    return;
}

function comment($user_id, $tweet_id, $content, $tweets)
{
    if (strlen($content) == 0) {
        exit;
    }

    $time = date("Y-m-d H:i:s");


    if ($_POST['tweet_id']) {
        $tweet_id = $_POST['tweet_id'];
        $comment = $tweets->addComment($user_id, $content, $tweet_id);

        if ($comment) {
            echo json_encode(array('success' => true));
            exit;
        }

        echo json_encode(array('success' => false));
        exit;
    }


    $create_tweet = $tweets->createTweet($user_id, $content, $time);

    if ($create_tweet) {
        echo json_encode(array('success' => true));
        exit;
    }

    echo json_encode(array('success' => false));
    exit;
}

function retweet($user_id, $tweet_id, $tweets)
{
    $retweetExists = $tweets->checkRetweeted($user_id, $tweet_id);

    if ($retweetExists) {
        $tweets->deleteRetweet($user_id, $tweet_id);
        echo json_encode(array('success' => true, 'action' => $retweetExists));
        return;
    }

    $addRetweet = $tweets->retweet($user_id, $tweet_id);

    if ($addRetweet) {
        echo json_encode(array('success' => true, 'action' => 'success'));
        return;
    }

    echo json_encode(array('success' => false, 'action' => 'failed'));
    return;
}

function getTweets($user_id, $tweets, $users)
{
    $res = [];

    $followed_users = $users->getFollowers($user_id);

    foreach ($followed_users as $followed_user) {

        $id_followed = $followed_user['id_follow'];
        $followed_user = $users->getUserById($id_followed);
        $followed_user_tweets = $tweets->getTweets($id_followed);

        foreach ($followed_user_tweets as $tweet) {
            array_push($res, [...$followed_user[0], ...$tweet]);
        }
    }

    echo json_encode(array('tweets' => $res));
}

function autocomplete($users)
{
    $res = [];
    $usernames = $users->getUsernames();

    foreach ($usernames as $username) {
        array_push($res, $username['username']);
    }

    echo json_encode(array('usernames' => $res));
}
