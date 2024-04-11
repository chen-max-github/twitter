<?php 
require_once('db.class.php');
Class hashtag extends DB{
    public function checkHashtag($hashtag){
        $SQL = "SELECT * FROM hashtag_list WHERE hashtag = '$hashtag'";
        return $this->fetchAll($SQL);
}
    public function addHashtag($hashtag){
        $SQL = "INSERT INTO hashtag_list (hashtag) VALUES ('$hashtag')";
        return $this->execute($SQL);
    }
    public function displayTweets($hashtag){
        $SQL = "SELECT tweet.content, tweet.time,tweet.id_user,user.at_user_name,user.profile_picture,user.username FROM user INNER JOIN tweet ON user.id = tweet.id_user WHERE content LIKE '%$hashtag%';";
        return $this->fetchAll($SQL);
    }
}
?>