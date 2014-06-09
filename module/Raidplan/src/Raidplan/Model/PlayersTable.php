<?php

namespace Raidplan\Model;

use Zend\Db\TableGateway\TableGateway;

class PlayersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
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
        $data = array(
            'titel' => $events->titel,
            'beschreibung'  => $events->beschreibung,
            'datetime'  => $events->datetime,
            'status'  => $events->status,
            'activityid'  => $events->activityid,
            'invited'  => $events->invited,
            'accepted'  => $events->accepted,
            'declined'  => $events->declined,
        );

        $id = (int) $events->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getPlayers($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Players id does not exist');
            }
        }
    }

    public function deletePlayers($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }


    public function getPlayersDataForSelectElement()
    {
        $data = $this->fetchAll();
        $selectData = array();
        foreach ($data as $selectOption) {
            $selectData[$selectOption->id] = $selectOption->charname;
        }
        return $selectData;
    }
}