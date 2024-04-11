<?php

require_once('db.class.php');

class Sign extends DB
{
    public function checkEmail($email)
    {
        $SQL = "SELECT * FROM user WHERE mail = '$email'";

        return $this->fetchAll($SQL);
    }

    public function signUp($username, $at, $email, $password, $birthdate)
    {
        $SQL = "INSERT INTO user (username, at_user_name, profile_picture, banner, mail, password, birthdate) VALUES ('$username', '$at', '../imgs/default.png', '../imgs/default_banner.jpg', '$email', '$password', '$birthdate')";

        return $this->execute($SQL);
    }

    public function signIn($email, $password)
    {
        $SQL = "SELECT * FROM user WHERE mail = '$email' AND password = '$password'";

        return $this->fetchAll($SQL);
    }
}
