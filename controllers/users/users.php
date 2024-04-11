<?php
include_once('../../models/search.class.php');

$username = $_POST['username'];

$search = new search;
$userExists = $search->searchUser($username);


header('Content-Type: application/json');
echo json_encode(array("exists" => $userExists));
?>