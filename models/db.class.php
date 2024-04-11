<?php

class DB extends PDO
{
    protected $dbname = 'twitter';
    protected $username = 'Max';
    protected $password = 'root';
    protected $DB;

    public function __construct()
    {
        $this->DB = new PDO("mysql:host=localhost;dbname=$this->dbname", $this->username, $this->password);
    }

    public function fetchAll($SQL)
    {
        $prepare = $this->DB->prepare($SQL);
        $prepare->execute();

        return $prepare->fetchAll();
    }

    public function execute($SQL)
    {
        $prepare = $this->DB->prepare($SQL);
        return $prepare->execute();
    }
}
