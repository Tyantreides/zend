<?php

namespace Raidplan\Model;

use Zend\Db\TableGateway\TableGateway;
use ZendTest\Code\Scanner\TestAsset\MapperExample\DbAdapter;

class PlayersTable
{
    protected $dbAdapter;

    public function __construct($defaultAdapter)
    {
        $this->dbAdapter = $defaultAdapter;
    }

    public function fetchAll()
    {

    }

    public function fetchPlayerData() {
       $statement = $this->dbAdapter->query('SELECT
                                                p.id as playerid,
                                                p.charname as player_charname,
                                                p.name as player_name,
                                                p.classes as player_classes,
                                                p.jobs as player_jobs,
                                                p.lodestoneid as player_lodestoneid,
                                                p.misc as player_misc,
                                                pxj.jobid as job_id,
                                                pxj.ilvl as job_ilvl,
                                                j.jobname as job_name,
                                                j.jobshortname as job_shortname,
                                                r.id as role_id,
                                                r.rolename as role_name,
                                                r.roleshortname as role_shortname
                                                FROM ep_players as p
                                                JOIN ep_players_jobs as pxj ON p.id = pxj.playerid
                                                JOIN ep_jobs as j ON pxj.jobid = j.id
                                                JOIN ep_roles as r on j.role = r.id
                                                ;');

        $result = $statement->execute();
        return $result;
    }

    public function fetchProcessedPlayerData(){
        $playerdata = $this->fetchPlayerData();
        foreach($playerdata as $player) {
            $allplayers[$player['playerid']][] = $player;
        }
        return $allplayers;
    }

    public function fetchPlayerDataById($playerid) {
        $statement = $this->dbAdapter->query('SELECT
                                                p.id as playerid,
                                                p.charname as player_charname,
                                                p.name as player_name,
                                                p.classes as player_classes,
                                                p.jobs as player_jobs,
                                                p.lodestoneid as player_lodestoneid,
                                                p.misc as player_misc,
                                                pxj.jobid as job_id,
                                                pxj.ilvl as job_ilvl,
                                                j.jobname as job_name,
                                                j.jobshortname as job_shortname,
                                                r.id as role_id,
                                                r.rolename as role_name,
                                                r.roleshortname as role_shortname
                                                FROM ep_players as p
                                                JOIN ep_players_jobs as pxj ON p.id = pxj.playerid
                                                JOIN ep_jobs as j ON pxj.jobid = j.id
                                                JOIN ep_roles as r on j.role = r.id
                                                WHERE playerid = '.$playerid.'
                                                ;');

        $result = $statement->execute();
        return $result;
    }

    public function fetchAllRoles () {
        $statement = $this->dbAdapter->query('SELECT * FROM ep_roles;');
        $result = $statement->execute();
        return $result;
    }

    public function getPlayers($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function savePlayers(Players $events)
    {

    }

    public function deletePlayers($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }


    public function isMatched() {

    }
    
}