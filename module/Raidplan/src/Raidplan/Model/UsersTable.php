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
                    $userdata['id_member'] = $row->id_member;
                    $userdata['member_name'] = $row->member_name;
                    $userdata['passwd'] = $row->passwd;
                    $userdata['password_salt'] = $row->password_salt;
                }
                $hash = sha1(strtolower($login) . $pass);
                if ($hash == $userdata['passwd']) {
                    $this->setUserCookie($userdata['id_member'], sha1($userdata['passwd'].$userdata['password_salt']));
                    return true;
                }
            }
            return false;
        }
        return false;
    }


    public function logoutUser(){
        $this->deleteUserCookie();
    }

    public function deleteUserCookie() {
        $cookiename = 'wlevents';
        setcookie($cookiename,"",time()-1);
    }

    public function setUserCookie($userid, $passwdhash){
        $userdata = array('uid' => $userid,
            'hash' => $passwdhash,
        );
        $cookiename = 'wlevents';
        setcookie($cookiename, serialize($userdata), time()+3600);
    }

    public function getUserCookie(){
        $cookiename = 'wlevents';
        if (isset($_COOKIE[$cookiename])) {

            return unserialize($_COOKIE['wlevents']);
        }
        return false;
    }

    public function getSmfUserCookieData(){
        //geht so nicht weil die domain noch anders ist
        $cookiename = 'wlevents';
        if (isset($_COOKIE[$cookiename])) {
            list ($userid, $password) = @unserialize($_COOKIE[$cookiename]);
            return array('userid' => $userid,
                'password' => $password,
            );
        }
        return false;
    }

    public function isLoggedIn() {
        if($cookiedata = $this->getUserCookie()) {
            $statement = $this->dbAdapter->query('SELECT * FROM smf_members WHERE id_member = "'.$cookiedata['uid'].'";');
            $result = $statement->execute();
            if ($result instanceof ResultInterface && $result->isQueryResult()) {
                $resultSet = new ResultSet;
                $resultSet->initialize($result);
                if ($resultSet->count() > 0) {
                    foreach($resultSet as $row) {
                        $userdata['id_member'] = $row->id_member;
                        $userdata['member_name'] = $row->member_name;
                        $userdata['passwd'] = $row->passwd;
                        $userdata['password_salt'] = $row->password_salt;
                    }
                    $hash = sha1($userdata['passwd'] . $userdata['password_salt']);
                    if ($hash == $cookiedata['hash']) {
                        return true;
                    }
                }
                return false;
            }
        }
        return false;
    }

    public function isAdmin() {
        if($cookiedata = $this->getUserCookie()) {
            $statement = $this->dbAdapter->query('SELECT * FROM smf_members WHERE id_member = "'.$cookiedata['uid'].'";');
            $result = $statement->execute();
            if ($result instanceof ResultInterface && $result->isQueryResult()) {
                $resultSet = new ResultSet;
                $resultSet->initialize($result);
                if ($resultSet->count() > 0) {
                    foreach($resultSet as $row) {
                        $userdata['id_member'] = $row->id_member;
                        $userdata['member_name'] = $row->member_name;
                        $userdata['passwd'] = $row->passwd;
                        $userdata['password_salt'] = $row->password_salt;
                        $userdata['id_group'] = $row->id_group;
                    }
                    if ($userdata['id_group'] == 1 || $userdata['id_group'] == 11) {
                        return true;
                    }
                }
                return false;
            }
        }
        return false;
    }

    public function getUserData() {
        if($cookiedata = $this->getUserCookie()) {
            $statement = $this->dbAdapter->query('SELECT * FROM smf_members WHERE id_member = "'.$cookiedata['uid'].'";');
            $result = $statement->execute();
            if ($result instanceof ResultInterface && $result->isQueryResult()) {
                $resultSet = new ResultSet;
                $resultSet->initialize($result);
                if ($resultSet->count() > 0) {
                    foreach($resultSet as $row) {
                        $userdata['id_member'] = $row->id_member;
                        $userdata['member_name'] = $row->member_name;
                        $userdata['passwd'] = $row->passwd;
                        $userdata['password_salt'] = $row->password_salt;
                        $userdata['id_group'] = $row->id_group;
                    }
                    if ($userdata['id_group'] == 1 || $userdata['id_group'] == 11) {
                        return true;
                    }
                }
                return false;
            }
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