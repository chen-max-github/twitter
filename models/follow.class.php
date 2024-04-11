<?php
require_once('db.class.php');
class follow extends DB
{
    public function followUser($follower_id, $id_user)
    {
        $SQL = "INSERT INTO follow(id_user,id_follow) VALUES($id_user,$follower_id);";
        return $this->execute($SQL);
    }
    public function unfollowUser($follower_id, $id_user)
    {
        $SQL = "DELETE FROM follow WHERE id_follow = '$follower_id' AND id_user = '$id_user'";
        return $this->execute($SQL);
    }
    public function getUserid($id_user)
    {
        $SQL = " select tweet.id,follow.id_user,follow.id_follow,follow.time from tweet inner join follow on tweet.id_user=follow.id_user WHERE follow.id_user=$id_user;";
        return $this->fetchAll($SQL);
    }
}
