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
       $statement = $this->dbAdapter->query('SELECT *
                                    FROM ep_players as p
                                    JOIN ep_players_jobs as pxj ON p.id = pxj.playerid
                                    JOIN ep_jobs as j ON pxj.jobid = j.id
                                    JOIN ep_roles as r on j.role = r.id;');

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


    
}