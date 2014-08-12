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

    protected $userModel;

    public function indexAction()
    {
        if (!$this->getUsersTable()->isLoggedIn()) {
            return $this->redirect()->toRoute('login');
        }
        $this->userModel = $this->getUserModel();
        $this->userModel->initUser();
        if (!$this->getPlayersTable()->isUserMatched($this->userModel->id)) {
            //redirect zum Playermatch
            return $this->redirect()->toRoute('matchuser');
        }
        else {
            //übersicht der gematchten player des Users
            echo '';
        }

    }

    public function matchUserAction() {
        if (!$this->getUsersTable()->isLoggedIn()) {
            return $this->redirect()->toRoute('login');
        }
        $this->userModel = $this->getUserModel();
        $this->userModel->initUser();
        $playerlist = $this->getPlayersTable()->fetchNotMatchedPlayers();
        $playerObject = $this->getPlayerModel();
        $playerObjectList = $this->getPlayersTable()->rawPlayerDataToObject($playerlist, $playerObject);


        $userForm = new UserForm();
        $matchform = $userForm->getUserMatchForm($this->userModel, $playerObjectList);
        return array(
            'usermatchform' => $matchform,
        );
    }

    /**
     * Nur kurze Mitteilung das man sich einloggen soll
     * @return array
     */
    //WLTODO Schönere Meldung einbauen
    public function loginAction(){
        $userForm = new UserForm();
        $output = $userForm->getLoginReminder();
        return array(
            'output' => $output,
        );
    }


    /**
     * Eigentlicher Loginvorgang via Ajax Abfrage
     * Gibt Loginformular oder logged in meldung zurück
     * @return ViewModel
     */
    public function ajaxLoginAction(){
        $isAuth = false;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            if($this->getUsersTable()->getAuthUser($post['user'], $post['passwd'])) {
                $isAuth = true;
            }
        }
        else{
            if($this->getUsersTable()->isLoggedIn()){
                $isAuth = true;
            }
        }
        $userForm = new UserForm();
        if ($isAuth) {
            $output = $userForm->getLoggedInBlock();
        }
        else {
            $output = $userForm->getLoginForm();
        }
        $viewModel = new ViewModel(array('output' => $output,
            'output' => $output,
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * Loggt User aus und redirected auf Startseite
     * @return \Zend\Http\Response
     */
    public function logoutAction() {
        $this->getUsersTable()->logoutUser();
        return $this->redirect()->toRoute('home');
    }


    public function ajaxMatchPlayerAction () {

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $playerid = $post['playerid'];
            $output = $playerid;
        }
        else{
            $output = false;
        }
        $viewModel = new ViewModel(array('output' => $output,
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
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
        $model->initModels($this->getJobModel());
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
        $model->initTables($this->getPlayersTable(), $this->getUsersTable());
        $model->initModels($this->getPlayerModel());
        return $model;
    }

}