<?php

include('../../models/sign.class.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$birthdate = $_POST['birthdate'];

$class = new Sign;

$userExists = $class->checkEmail($email);

header('Content-Type: application/json');

if ($userExists) {
    echo json_encode(array('message' => 'This email is already used by another user.'));
    exit;
}

$salt = 'vive le projet tweet_academy';
$hashedPassword = hash('ripemd160', "$password . $salt");

$signup = $class->signUp($username, $username, $email, $hashedPassword, $birthdate);

if ($signup) {
    echo json_encode(array('email' => $email, 'password' => $password, 'success' => true));
    exit;
}
