<?php

require_once('db.class.php');

class Tweets extends DB
{
    public function getTweets($user_id)
    {
        $SQL = "SELECT tweet.id AS 'tweet_id', tweet.content, tweet.time, user.username, user.at_user_name, user.creation_time, user.profile_picture FROM user INNER JOIN tweet ON user.id = tweet.id_user WHERE user.id = $user_id";
        return $this->fetchAll($SQL);
    }

    public function getTweetById($tweet_id)
    {
        $SQL = "SELECT * FROM tweet WHERE id = $tweet_id";
        return $this->fetchAll($SQL);
    }

    public function getTweetByTime($user_id, $time)
    {
        $SQL = "SELECT * FROM tweet WHERE id_user = $user_id AND time = '$time'";
        return $this->fetchAll($SQL);
    }

    public function createTweet($user_id, $content, $time)
    {
        $SQL = "INSERT INTO tweet (id_user, time, content) VALUES ('$user_id', '$time', '$content')";
        return $this->execute($SQL);
    }

    public function addComment($user_id, $content, $original_tweet_id)
    {
        $time = date("Y-m-d H:i:s");
        $SQL = "INSERT INTO tweet (id_user, id_response, time, content) VALUES ('$user_id', '$original_tweet_id', '$time', '$content')";
        return $this->execute($SQL);
    }
    public function displayComments($original_tweet_id)
    {
    }

    public function getResponseId($tweet_id)
    {
        $SQL = "SELECT id_response FROM tweet WHERE id = $tweet_id";
        return $this->fetchAll($SQL);
    }

    public function checkLiked($user_id, $tweet_id)
    {
        $SQL = "SELECT * FROM likes WHERE id_user = $user_id AND id_tweet = $tweet_id";
        return $this->fetchAll($SQL);
    }

    public function like($user_id, $tweet_id)
    {
        $SQL = "INSERT INTO likes (id_user, id_tweet) VALUES ('$user_id', '$tweet_id')";
        return $this->execute($SQL);
    }

    public function deleteLike($user_id, $tweet_id)
    {
        $SQL = "DELETE FROM likes WHERE id_user = $user_id AND id_tweet = $tweet_id";
        return $this->execute($SQL);
    }

    public function checkRetweeted($user_id, $tweet_id)
    {
        $SQL = "SELECT * FROM retweet WHERE id_user = $user_id AND id_tweet = $tweet_id";
        return $this->fetchAll($SQL);
    }

    public function retweet($user_id, $tweet_id)
    {
        $SQL = "INSERT INTO retweet (id_user, id_tweet) VALUES ($user_id, $tweet_id)";
        return $this->execute($SQL);
    }

    public function deleteRetweet($user_id, $tweet_id)
    {
        $SQL = "DELETE FROM retweet WHERE id_user = $user_id AND id_tweet = $tweet_id";
        return $this->execute($SQL);
    }
}
