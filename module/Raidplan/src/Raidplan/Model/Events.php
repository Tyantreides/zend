<?php
namespace Raidplan\Model;


class Events
{
    public $id;
    public $titel;
    public $beschreibung;
    public $datetime;
    public $status;
    public $activityid;
    public $invited;
    public $players;
    public $roles;
    public $spotstatus;

    private $eventsTable;
    private $playersTable;
    private $jobsTable;
    private $roleTable;
    private $usersTable;

    private $playerModel;
    private $jobModel;
    private $roleModel;

    public function initTables($eventsTable, $playersTable, $jobsTable, $roleTable, $usersTable) {
        $this->eventsTable = $eventsTable;
        $this->playersTable = $playersTable;
        $this->jobsTable = $jobsTable;
        $this->roleTable = $roleTable;
        $this->usersTable = $usersTable;
    }

    public function initModels($playerModel, $jobModel, $roleModel){
        $this->playerModel = $playerModel;
        $this->jobModel = $jobModel;
        $this->roleModel = $roleModel;
    }

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->titel = (isset($data['titel'])) ? $data['titel'] : null;
        $this->beschreibung  = (isset($data['beschreibung']))  ? $data['beschreibung']  : null;
        $this->datetime  = (isset($data['datetime']))  ? $data['datetime']  : null;
        $this->status  = (isset($data['status']))  ? $data['status']  : null;
        $this->activityid  = (isset($data['activityid']))  ? $data['activityid']  : null;
        $this->invited  = (isset($data['invited']))  ? $data['invited']  : null;
        $this->players = (isset($data['players']))  ? $data['players']  : null;
        $this->roles = (isset($data['roles']))  ? $data['roles']  : null;
        $this->spotstatus = (isset($data['spotstatus']))  ? $data['spotstatus']  : null;
    }

    public function loadEventResult($result) {
        $this->id     = (isset($result->id))     ? $result->id     : null;
        $this->titel = (isset($result->titel)) ? $result->titel : null;
        $this->beschreibung  = (isset($result->beschreibung))  ? $result->beschreibung  : null;
        $this->datetime  = (isset($result->datetime))  ? $result->datetime  : null;
        $this->status  = (isset($result->status))  ? $result->status  : null;
        $this->activityid  = (isset($result->activityid))  ? $result->activityid  : null;
        $this->invited  = (isset($result->invited))  ? $result->invited  : null;
        $this->players = (isset($result->players))  ? $result->players  : null;
        $this->roles = (isset($result->roles))  ? $result->roles  : null;
        $this->spotstatus = (isset($result->spotstatus))  ? $result->spotstatus  : null;
        if (isset($this->invited)) {
            $this->setPlayer();
            $this->setRoles();
        }
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setPlayer(){
        $playerdata = $this->playersTable->fetchProcessedPlayerData();
        $allEventData = json_decode($this->invited);
        $addedplayers = $allEventData->players;
        foreach($addedplayers as $addedplayer) {
            $playermodel = clone $this->playerModel->load($addedplayer->player);
            if (array_key_exists($addedplayer->player,$playerdata)) {
                //$playerlist[] = $playerdata[$addedplayer->player];
                $playerlist[] = $playermodel;
            }
            elseif ($addedplayer->player == 999) {
                $playerlist[] = array(
                    '0' => array(
                        'playerid' => 999,
                        'player_charname' => 'Random Player'
                    ),
                );
            }
        }
        $this->players = $playerlist;
    }

    public function setRoles() {

        $roledataarray = $this->roleTable->fetchProcessedRoleData();
        $allEventData = json_decode($this->invited);
        foreach($allEventData->roles as $role) {
            if (array_key_exists($role->role, $roledataarray)) {
                $roleModel = clone $this->roleModel->load($role->role);
                $eventroles[] = $roledataarray[$role->role];
            }
            elseif ($role->role == '999') {
                $roleModel = clone $this->roleModel;
                $roleModel->setId(999);
                $roleModel->setRolename('Random');
                $roleModel->setRoleshortname('Rand');
                $eventroles[] = $roleModel;
            }
            else{
                $roleModel = clone $this->roleModel;
                $roleModel->setId(999);
                $roleModel->setRolename('Random');
                $roleModel->setRoleshortname('Rand');
                $eventroles[] = $roleModel;
            }
        }
        $this->roles = $eventroles;
    }




}





?>