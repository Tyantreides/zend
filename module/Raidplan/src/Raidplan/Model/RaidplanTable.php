<?php

namespace Raidplan\Model;

use Zend\Db\TableGateway\TableGateway;

class RaidplanTable
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

    public function getRaidplan($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveRaidplan(Raidplan $raidplan)
    {
        $data = array(
            'artist' => $raidplan->artist,
            'title'  => $raidplan->title,
        );

        $id = (int) $raidplan->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getRaidplan($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Raidplan id does not exist');
            }
        }
    }

    public function deleteRaidplan($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}