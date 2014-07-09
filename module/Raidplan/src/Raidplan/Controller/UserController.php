<?php

namespace Raidplan\Controller;

use Raidplan\Form\EventForm;
use Raidplan\Form\PlayerForm;
use Raidplan\Form\JobForm;
use Raidplan\Form\UserForm;
use Raidplan\Model\Roles;
use Raidplan\Model\Users;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Raidplan\Model\Events;
use Raidplan\Model\Players;
use Raidplan\Model\Jobs;

class UserController extends AbstractActionController
{

    protected $eventsTable;
    protected $playersTable;
    protected $jobsTable;
    protected $rolesTable;
    protected $usersTable;

    public function indexAction()
    {

    }





    public function getEventsTable()
    {
        if (!$this->eventsTable) {
            $sm = $this->getServiceLocator();
            $this->eventsTable = $sm->get('Raidplan\Model\EventsTable');
        }
        return $this->eventsTable;
    }

    public function getPlayersTable()
    {
        if (!$this->playersTable) {
            $sm = $this->getServiceLocator();
            $this->playersTable = $sm->get('Raidplan\Model\PlayersTable');
        }
        return $this->playersTable;
    }

    public function getJobsTable()
    {
        if (!$this->jobsTable) {
            $sm = $this->getServiceLocator();
            $this->jobsTable = $sm->get('Raidplan\Model\JobsTable');
        }
        return $this->jobsTable;
    }

    public function getRolesTable()
    {
        if (!$this->rolesTable) {
            $sm = $this->getServiceLocator();
            $this->rolesTable = $sm->get('Raidplan\Model\RolesTable');
        }
        return $this->rolesTable;
    }

    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('Raidplan\Model\UsersTable');
        }
        return $this->usersTable;
    }

    public function getEventModel() {
        $model = new Events();
        $model->initTables($this->getEventsTable(),$this->getPlayersTable(),$this->getJobsTable(),$this->getRolesTable(),$this->getUsersTable());
        $model->initModels($this->getPlayerModel(),$this->getJobModel(),$this->getRoleModel(),$this->getUserModel());
        return $model;
    }

    public function getPlayerModel() {
        $model = new Players();
        $model->initTables($this->getPlayersTable(),$this->getJobsTable(),$this->getUsersTable());
        $model->initModels($this->getJobModel(),$this->getUserModel());
        return $model;
    }

    public function getJobModel() {
        $model = new Jobs();
        $model->initTables($this->getJobsTable(),$this->getRolesTable());
        $model->initModels($this->getRoleModel());
        return $model;
    }

    public function getRoleModel() {
        $model = new Roles();
        $model->setTable($this->getRolesTable());
        return $model;
    }

    public function getUserModel() {
        $model = new Users();
        return $model;
    }

}