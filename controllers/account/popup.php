<?php

require_once('../../models/users.class.php');

$id = $_POST['id'];
$at = $_POST['at'];
$username = $_POST['username'];


$users = new Users;

$userData = $users->getUserById($id);

if ($at == '' && $username == '') {
    return;
}

header('Content-Type: application/json');

if ($at == '' && $username != '') {
    $changeUsername = $users->changeUsername($id, $username);
    
    if ($changeUsername) {
        echo json_encode(array('message' => "Username changed successfully."));
        exit;
    }

    echo json_encode(array('message' => "Failed to change username"));
    exit;
}

if ($at != '' && $username == '') {

    $changeAt = $users->changeAtUserName($id, $at);

    if ($changeAt) {
        echo json_encode(array('message' => "@ changed successfully."));
        exit;
    }

    echo json_encode(array('message' => "Failed to change @"));
    exit;
}

$changeAt = $users->changeAtUserName($id, $at);
$changeUsername = $users->changeUsername($id, $username);

if ($changeAt && $changeUsername) {
    echo json_encode(array('message' => "Username and @ changed successfully."));
    exit;
}

echo json_encode(array('message' => "Failed to change username and @."));
exit;


