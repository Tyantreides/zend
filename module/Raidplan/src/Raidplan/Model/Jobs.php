<?php
namespace Raidplan\Model;


class Jobs
{
    public $id;
    public $classid;
    public $jobname;
    public $jobshortname;
    public $role;

    public $ilvl;

    private $jobTable;
    private $roleTable;

    private $roleModel;

    public function initTables($jobTable, $roleTable) {
        $this->jobTable = $jobTable;
        $this->roleTable = $roleTable;
    }

    public function initModels($roleModel) {
        $this->roleModel = $roleModel;
    }

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->classid = (isset($data['classid'])) ? $data['classid'] : null;
        $this->jobname  = (isset($data['jobname']))  ? $data['jobname']  : null;
        $this->jobshortname  = (isset($data['jobshortname']))  ? $data['jobshortname']  : null;
        $this->role  = (isset($data['role']))  ? $data['role']  : null;
    }

    public function loadJobsResult($result)
    {
        $this->id     = (isset($result->id))     ? $result->id     : null;
        $this->classid = (isset($result->classid)) ? $result->classid : null;
        $this->jobname  = (isset($result->jobname))  ? $result->jobname  : null;
        $this->jobshortname  = (isset($result->jobshortname))  ? $result->jobshortname  : null;
        $this->role  = (isset($result->role))  ? clone $this->roleModel->load($result->role)  : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function load($id) {
        $jobdata = $this->jobTable->getJobs($id);
        $this->loadJobsResult($jobdata);
        return $this;
    }

    /**
     * @param mixed $classid
     */
    public function setClassid($classid)
    {
        $this->classid = $classid;
    }

    /**
     * @return mixed
     */
    public function getClassid()
    {
        return $this->classid;
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
     * @param mixed $ilvl
     */
    public function setIlvl($ilvl)
    {
        $this->ilvl = $ilvl;
    }

    /**
     * @return mixed
     */
    public function getIlvl()
    {
        return $this->ilvl;
    }

    /**
     * @param mixed $jobname
     */
    public function setJobname($jobname)
    {
        $this->jobname = $jobname;
    }

    /**
     * @return mixed
     */
    public function getJobname()
    {
        return $this->jobname;
    }

    /**
     * @param mixed $jobshortname
     */
    public function setJobshortname($jobshortname)
    {
        $this->jobshortname = $jobshortname;
    }

    /**
     * @return mixed
     */
    public function getJobshortname()
    {
        return $this->jobshortname;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }



}





?>