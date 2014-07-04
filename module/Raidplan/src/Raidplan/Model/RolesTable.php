<?php

namespace Raidplan\Model;

use Zend\Db\TableGateway\TableGateway;

class RolesTable
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

    public function fetchProcessedRoleData(){
        $roledata = $this->fetchAll();
        foreach($roledata as $role) {
            $allroles[$role->id] = $role;
        }
        return $allroles;
    }

    public function getRoles($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveRoles(Roles $jobs)
    {

    }

    public function deleteRoles($id)
    {

    }

}