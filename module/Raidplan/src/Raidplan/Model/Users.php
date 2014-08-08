<?php
namespace Raidplan\Model;


class Users
{
    public $id;
    public $username;
    public $email;
    public $status;
    public $groupid;

    public $matchedPlayers;

    private $table;

    private $playersTable;
    private $usersTable;

    private $playersModel;

    public function __construct(){

    }

    public function initTables($playersTable, $usersTable){
        $this->playersTable = $playersTable;
        $this->usersTable = $usersTable;
    }

    public function initModels($playersModel){

        $this->playersModel = $playersModel;
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

    public function initUser($uid = null) {
        if (isset($uid)) {
            $userData = $this->usersTable->getUserData($uid);
        }
        else {
            $userData = $this->usersTable->getUserData();
        }
        if (!$userData) {
            return false;
        }
        $this->id = $userData['id_member'];
        $this->username = $userData['member_name'];
        $this->groupid = $userData['id_group'];
        $this->email = $userData['email_address'];

        $playerIdData = $this->playersTable->getPlayerIdsByUserId($this->id);

        foreach ($playerIdData as $user) {
            foreach ($user as $playerId) {
                $this->matchedPlayers[$playerId] = clone $this->playersModel->load($playerId);
            }
        }

        echo '';
    }


}

?>