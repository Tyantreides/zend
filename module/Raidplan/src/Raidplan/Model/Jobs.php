<?php
namespace Raidplan\Model;


class Jobs
{
    public $id;
    public $classid;
    public $jobname;
    public $jobshortname;
    public $role;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->classid = (isset($data['classid'])) ? $data['classid'] : null;
        $this->jobname  = (isset($data['jobname']))  ? $data['jobname']  : null;
        $this->jobshortname  = (isset($data['jobshortname']))  ? $data['jobshortname']  : null;
        $this->role  = (isset($data['role']))  ? $data['role']  : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}





?>