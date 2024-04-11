<?php

require_once('db.class.php');

Class search extends DB
{
    public function searchUser($user)
    {
        $SQL = "SELECT * FROM user WHERE at_user_name='$user';";
        return $this->fetchAll($SQL);
    }
    public function displayTweet($user)
    {
        $SQL = "SELECT * FROM tweet INNER JOIN user ON tweet.id_user=user.id WHERE at_user_name='$user';";
        return $this->fetchAll($SQL);
    }
}
