<?php

require_once('db.class.php');

class Users extends DB
{
    public function getFollowing($user_id)
    {
        $SQL = "SELECT * FROM follow INNER JOIN user ON follow.id_follow = user.id WHERE follow.id_user = $user_id";
        return $this->fetchAll($SQL);
    }

    public function getFollowers($user_id)
    {
        $SQL = "SELECT * FROM follow INNER JOIN user ON follow.id_user = user.id WHERE follow.id_follow = $user_id";
        return $this->fetchAll($SQL);
    }

    public function getUserById($user_id)
    {
        $SQL = "SELECT * FROM user WHERE id = $user_id";
        return $this->fetchAll($SQL);
    }

    public function changeUsername($id, $username)
    {
        $SQL = "UPDATE user SET username = \"$username\" WHERE id = $id";
        return $this->execute($SQL);
    }

    public function changeAtUserName($id, $at_user_name)
    {
        $SQL = "UPDATE user SET at_user_name = \"$at_user_name\" WHERE id = $id";
        return $this->execute($SQL);
    }

    public function getUsernames()
    {
        $SQL = "SELECT id, username FROM user";
        return $this->fetchAll($SQL);
    }
}
