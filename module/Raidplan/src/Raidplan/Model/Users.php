<?php
namespace Raidplan\Model;


class Users
{
    public $id;
    public $username;
    public $email;
    public $status;

    private $table;

    public function __construct(){

    }

    public function exchangeArray($data)
    {

    }

    public function loadPlayerResult($result) {

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setTable($table){
        $this->table = $table;
    }


}

?>