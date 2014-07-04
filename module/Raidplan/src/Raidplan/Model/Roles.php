<?php
namespace Raidplan\Model;


class Roles
{
    public $id;
    public $rolename;
    public $roleshortname;

    private $table;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->rolename = (isset($data['rolename'])) ? $data['rolename'] : null;
        $this->roleshortname  = (isset($data['roleshortname']))  ? $data['roleshortname']  : null;
    }

    public function loadRolesResult($result)
    {
        $this->id     = (isset($result->id))     ? $result->id     : null;
        $this->rolename = (isset($result->rolename)) ? $result->rolename : null;
        $this->roleshortname  = (isset($result->roleshortname))  ? $result->roleshortname  : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setTable($table){
        $this->table = $table;
    }


    public function load($id) {
        $roledata = $this->table->getRoles($id);
        $this->loadRolesResult($roledata);
        return $this;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $rolename
     */
    public function setRolename($rolename)
    {
        $this->rolename = $rolename;
    }

    /**
     * @return mixed
     */
    public function getRolename()
    {
        return $this->rolename;
    }

    /**
     * @param mixed $roleshortname
     */
    public function setRoleshortname($roleshortname)
    {
        $this->roleshortname = $roleshortname;
    }

    /**
     * @return mixed
     */
    public function getRoleshortname()
    {
        return $this->roleshortname;
    }


}