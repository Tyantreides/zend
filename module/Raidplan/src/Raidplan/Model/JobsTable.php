<?php

namespace Raidplan\Model;

use Zend\Db\TableGateway\TableGateway;

class JobsTable
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

    public function getJobs($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveJobs(Jobs $jobs)
    {
        $data = array(
            'classid' => $events->titel,
            'jobname'  => $events->beschreibung,
            'jobshortname'  => $events->datetime,
            'role'  => $events->status,
        );

        $id = (int) $jobs->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getJobs($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Jobs id does not exist');
            }
        }
    }

    public function deleteJobs($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

}