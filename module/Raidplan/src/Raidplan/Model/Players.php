<?php
namespace Raidplan\Model;


class Players
{
    public $id;
    public $charname;
    public $name;
    public $classes;
    public $jobs;
    public $roles;
    public $lodestoneid;
    public $misc;
    public $user;

    private $playersTable;
    private $jobsTable;
    private $rolesTable;
    private $usersTable;

    private $jobModel;
    private $userModel;

    public function __construct(){

    }

    public function initTables($playersTable, $jobsTable, $usersTable){
        $this->playersTable = $playersTable;
        $this->jobsTable = $jobsTable;
        $this->usersTable = $usersTable;
    }

    public function initModels($jobModel){
        $this->jobModel = $jobModel;
    }

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->charname = (isset($data['charname'])) ? $data['charname'] : null;
        $this->name  = (isset($data['name']))  ? $data['name']  : null;
        $this->classes  = (isset($data['classes']))  ? $data['classes']  : null;
        $this->jobs  = (isset($data['jobs']))  ? $data['jobs']  : null;
        $this->lodestoneid  = (isset($data['lodestoneid']))  ? $data['lodestoneid']  : null;
        $this->misc  = (isset($data['misc']))  ? $data['misc']  : null;
    }

    public function loadPlayerResult($result) {
        $this->id     = (isset($result->id))     ? $result->id     : null;
        $this->charname = (isset($result->charname)) ? $result->charname : null;
        $this->name  = (isset($result->name))  ? $result->name  : null;
        $this->classes  = (isset($result->classes))  ? $result->classes  : null;
        $this->jobs  = (isset($result->jobs))  ? $result->jobs  : null;
        $this->lodestoneid  = (isset($result->lodestoneid))  ? $result->lodestoneid  : null;
        $this->misc  = (isset($result->misc))  ? $result->misc  : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setTable($table){
        $this->table = $table;
    }

    public function load($id) {
        unset($this->jobs);
        $playerdata = $this->playersTable->fetchPlayerDataById($id);
        foreach ($playerdata as $playerrow) {

            $this->setId($playerrow['playerid']);
            $this->setCharname($playerrow['player_charname']);
            $this->setName($playerrow['player_name']);
            $this->setLodestoneid($playerrow['player_lodestoneid']);
            $jobModel = clone $this->jobModel->load($playerrow['job_id']);
            $jobModel->setIlvl($playerrow['job_ilvl']);
            $this->addJob($jobModel);

        }
        return $this;
    }

    public function addJob($job){
        $this->jobs[] = $job;
    }

    public function addRole($role){
        $this->roles[] = $role;
    }

    /**
     * @param mixed $charname
     */
    public function setCharname($charname)
    {
        $this->charname = $charname;
    }

    /**
     * @return mixed
     */
    public function getCharname()
    {
        return $this->charname;
    }

    /**
     * @param mixed $classes
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
    }

    /**
     * @return mixed
     */
    public function getClasses()
    {
        return $this->classes;
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
     * @param mixed $jobs
     */
    public function setJobs($jobs)
    {
        $this->jobs = $jobs;
    }

    /**
     * @return mixed
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * @param mixed $lodestoneid
     */
    public function setLodestoneid($lodestoneid)
    {
        $this->lodestoneid = $lodestoneid;
    }

    /**
     * @return mixed
     */
    public function getLodestoneid()
    {
        return $this->lodestoneid;
    }

    /**
     * @param mixed $misc
     */
    public function setMisc($misc)
    {
        $this->misc = $misc;
    }

    /**
     * @return mixed
     */
    public function getMisc()
    {
        return $this->misc;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }




}





?>