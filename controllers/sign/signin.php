<?php

include('../../models/sign.class.php');

$class = new Sign;

list($email, $password) = [$_POST['email'], $_POST['password']];

$userExists = $class->checkEmail($email);

header('Content-Type: Application/json');

if (!$userExists) {
    echo json_encode(array('message' => 'User with this email does not exist.'));
    exit;
}

$salt = 'vive le projet tweet_academy';
$hashedPassword = hash('ripemd160', "$password . $salt");

$connect = $class->signIn($email, $hashedPassword);

if (!$connect) {
    echo json_encode(array('message' => 'Password is incorrect.'));
    exit;
}

echo json_encode(array('id' => $connect[0]['id']));
