<?php

namespace Raidplan\Model;

use Zend\Db\TableGateway\TableGateway;
use ZendTest\Code\Scanner\TestAsset\MapperExample\DbAdapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;

class UsersTable
{
    protected $dbAdapter;

    public function __construct($defaultAdapter)
    {
        $this->dbAdapter = $defaultAdapter;
    }

    public function fetchAll()
    {

    }

    public function fetchAllRoles () {
        $statement = $this->dbAdapter->query('SELECT * FROM ep_roles;');
        $result = $statement->execute();
        return $result;
    }

    public function getUserByLogin($login){
        $statement = $this->dbAdapter->query('SELECT * FROM smf_members WHERE member_name = "'.$login.'";');
        $result = $statement->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet;
            $resultSet->initialize($result);
            if ($resultSet->count() > 0) {
                foreach($resultSet as $row) {
                    return $row;
                }
            }
            return false;
        }
        return false;
    }

    public function getAuthUser($login, $pass){
        $statement = $this->dbAdapter->query('SELECT * FROM smf_members WHERE member_name = "'.$login.'";');
        $result = $statement->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet;
            $resultSet->initialize($result);
            if ($resultSet->count() > 0) {
                foreach($resultSet as $row) {
                    $userdata['member_name'] = $row->member_name;
                    $userdata['passwd'] = $row->passwd;
                    $userdata['password_salt'] = $row->password_salt;
                }

            }
            return false;
        }
        return false;
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