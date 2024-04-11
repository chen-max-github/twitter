<?php

include('../../models/message_bdd.php');

$class = new Send;

if (isset($_POST["pseudo"])) {
    $pseudo = $_POST["pseudo"];
    $request = $class->pseudo($pseudo);

    // Récupérer tous les messages de l'utilisateur

    header('Content-Type: application/json');

    if ($request) {
        echo json_encode($request); // Renvoyer les informations sur l'utilisateur
        exit;
    }

    echo json_encode(array('message' => 'Pseudo non existant'));
}


if (isset($_POST["send"])) {
    $conversation_id = $_POST['conversation_id'];
    $userId = $_POST['userId'];
    $sendMessage = $_POST["send"];

    $request = $class->sendMessage($sendMessage, $conversation_id, $userId);

    header('Content-Type: application/json');

    if ($request) {
        echo json_encode(array('success' => true, 'message' => $sendMessage));
        exit;
    } else {
        echo json_encode(array('success' => false, 'message' => "Erreur lors de l'envoi du message"));
        exit;
    }
}




if (isset($_POST["conversation_id"]) && isset($_POST["user_id"])) {
    $conversation_id = $_POST["conversation_id"];
    $user_id = $_POST["user_id"];
    $request = $class->createConversation($conversation_id, $user_id);

    header('Content-Type: application/json');

    if ($request) {
        echo json_encode(array('success' => true));
        exit;
    } else {
        echo json_encode(array('success' => false, 'message' => "Erreur lors de la création de la conversation"));
        exit;
    }
}
