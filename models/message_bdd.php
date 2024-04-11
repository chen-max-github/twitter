<?php

include('db.class.php');
class Send extends DB
{

    public function pseudo($pseudo)
    {
        $SQL = "SELECT content, username, id_user from messages inner join user on user.id = messages.id_user where id_convo = '$pseudo' order by time desc";
        return $this->fetchAll($SQL);
    }
    public function createConversation($conversation_id, $userId)
    {
        $SQL = "INSERT INTO convo_users (id_convo, id_user) VALUES ('$conversation_id','$userId')";
        return $this->execute($SQL);
    }
    // public function getConversationD($conversationId)
    // {
    //     $SQL = "SELECT name FROM convo WHERE id = '$conversationId'";
    //     return $this->fetchAll($SQL);
    // }

    public function getMessage($idConvo)
    {
        $SQL = "SELECT content FROM messages WHERE id_convo = '$idConvo'";
        return $this->fetchAll($SQL);
    }

    public function sendMessage($sendMessage, $conversation_id, $userId)
    {
        $SQL = "INSERT INTO messages (id_convo, id_user, content) VALUES ('$conversation_id', '$userId', \"$sendMessage\")";
        return $this->execute($SQL);
    }
}
