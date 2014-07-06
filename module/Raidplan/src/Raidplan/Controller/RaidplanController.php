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

class RaidplanController extends AbstractActionController
{

    protected $eventsTable;
    protected $playersTable;
    protected $jobsTable;
    protected $rolesTable;
    protected $usersTable;

    public function indexAction()
    {

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

    /**
     * Läd nur das Template für den Calender Die Daten werden über ajax geladen
     * @return \Zend\Http\Response|ViewModel
     */
    public function calendarAction() {
        if (!$this->getUsersTable()->isLoggedIn()) {
            return $this->redirect()->toRoute('login');
        }
        $events = $this->getEventsTable()->fetchAll();
        return new ViewModel(array(
                'events' => $events,
            )
        );
    }

    /**
     * Zeigt den Event zur übergebenen Eventid an
     * @return array|\Zend\Http\Response
     */
    public function viewEventAction(){
        if (!$this->getUsersTable()->isLoggedIn()) {
            return $this->redirect()->toRoute('login');
        }
        $isAdmin = $this->getUsersTable()->isAdmin();
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('events');
        }
        $eventForm  = new EventForm();
        $playerForm = new PlayerForm();
        $eventdata = $this->getEventsTable()->getEvents($id);
        $eventsModel = $this->getEventModel();
        $eventsModel->loadEventResult($eventdata);
        return array(
            'isadmin' => $isAdmin,
            //'eventdata' => $eventdata,
            'eventform' => $eventForm,
            'playerform' => $playerForm,
            //'playerdata' => $playersData,
            //'roledata' => $allRoles,
            //'activitydata' => $allActivities,
            'eventsmodel' => $eventsModel,

        );
    }

    /**
     * depricated Edit wird über ajax geladen
     * @return array|\Zend\Http\Response
     */
    public function editAction() {
        if (!$this->getUsersTable()->isLoggedIn()) {
            return $this->redirect()->toRoute('login');
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('addevent');
        }
        try {
            $events = $this->getEventsTable()->getEvents($id);
            $playersTable = $this->getPlayersTable();
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('events', array(
                'action' => 'index'
            ));
        }
        $eventdata = $this->getEventsTable()->getEvents($id);
        $playersData = $this->getPlayersTable()->fetchPlayerData();
        $eventmodel = $this->getEventModel();
        $eventmodel->loadEventResult($eventdata);
        $form  = new EventForm();
        $form->bind($events);
        $playerForm = new PlayerForm();
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
//            $form->setInputFilter($events->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEventsTable()->saveEvents($events);

                // Redirect to list of raidplans
                return $this->redirect()->toRoute('events');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'playerForm' => $playerForm,
            'eventData' => $eventdata,
            'eventmodel' => $eventmodel,
        );
    }


    /**
     * Läd übertragene eventid ins eventadd formular und gibt es zurück.
     * es wird dann anstatt des viewformulars angezeigt
     * funktioniert nur wenn man admin ist
     * @return ViewModel
     */
    //WLTODO falsche Eventid abfangen
    public function ajaxeditAction() {
        if (!$this->getUsersTable()->isLoggedIn()) {
            return $this->redirect()->toRoute('login');
        }
        if(!$this->getUsersTable()->isAdmin()){
            return $this->redirect()->toRoute('home');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $send = $request->getPost();
            $id = $send['eventid'];
        }
        else{
            $id = 24;
        }

        try {
            $eventdata = $this->getEventsTable()->getEvents($id);
            $playersTable = $this->getPlayersTable();
            $playersData = $this->getPlayersTable()->fetchPlayerData();
            $allRoles = $this->getPlayersTable()->fetchAllRoles();
            $allActivities = $this->getEventsTable()->fetchActivities();
            $playerForm = new PlayerForm();
            $form = new EventForm();
        }
        catch (\Exception $ex) {

        }
        $eventmodel = $this->getEventModel();
        $eventmodel->loadEventResult($eventdata);
        $viewModel = new ViewModel(array(
            'id' => $id,
            'eventData' => $eventdata,
            'eventmodel' => $eventmodel,
            '$playerstable' => $playersTable,
            'playersdata' => $playersData,
            'allroles' => $allRoles,
            'allactivities' => $allActivities,
            'playerform' => $playerForm,
            'form' => $form,
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
    }


    /**
     * depricated
     * @return ViewModel
     */
    public function ajaxGetEventsAction() {
        $request = $this->getRequest();
        if($request->isPost()){
            $send = $request->getPost();
            $eventsResult = $this->getEventsTable()->fetchEventsOfDateRange($send['datefrom'], $send['dateto']);
            $events = $this->getEventsTable()->getJsonEvents($eventsResult);
        }
        else{
            $send = false;
        }

        $output = 'ajaxgetEvents';
        $viewModel = new ViewModel(array('output' => $output,
        'send' => $send,
        'result' => $events,
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * Speichert event ab
     * @return ViewModel
     */
    public function ajaxSaveEventAction(){
        $form = new EventForm();
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        //if form was send
        if ($request->isPost()) {

            $events = new Events();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $events->exchangeArray($form->getData());
                $this->getEventsTable()->saveEvents($events);
            }
            //$output = $request->getPost();
            $output = array('msg' => $form->getEventAddSuccessMsg());
        }
        else {
            $output = false;
        }
        $viewModel = new ViewModel(array('output' => $output));
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * depricated
     * @return ViewModel
     */
    public function ajaxUpdateEventAction() {
        $form = new EventForm();
        $request = $this->getRequest();
        $output = 'updateevent';
        if ($request->isPost()) {
            $events = new Events();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $events->exchangeArray($form->getData());
                $this->getEventsTable()->saveEvents($events);
            }
            $output = array('msg' => $form->getEventAddSuccessMsg());
        }
        else {
            $output = false;
        }
        $viewModel = new ViewModel(array('output' => $output));
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * zeigt formular für das hinzufügen von events an
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {
        if (!$this->getUsersTable()->isLoggedIn()) {
            return $this->redirect()->toRoute('login');
        }
        $form = new EventForm();
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $events = new Events();
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $events->exchangeArray($form->getData());
                $this->getEventsTable()->saveEvents($events);
                return $this->redirect()->toRoute('events');
            }
        }
        else {
            try {
                $playersData = $this->getPlayersTable()->fetchPlayerData();
                $allRoles = $this->getPlayersTable()->fetchAllRoles();
                $allActivities = $this->getEventsTable()->fetchActivities();
                $playerForm = new PlayerForm();
            }
            catch (\Exception $ex) {
                $playersData = false;
                $playerForm = false;
                $allRoles = false;
            }
        }
        return array('form' => $form,
        'playersData' => $playersData,
        'playerForm' => $playerForm,
        'allRoles' => $allRoles,
        'allActivities' => $allActivities);
    }


    /**
     * liefert eventtable model zurück
     * @return array|object
     */
    public function getEventsTable()
    {
        if (!$this->eventsTable) {
            $sm = $this->getServiceLocator();
            $this->eventsTable = $sm->get('Raidplan\Model\EventsTable');
        }
        return $this->eventsTable;
    }

    /**
     * liefert playerstable model zurück
     * @return array|object
     */
    public function getPlayersTable()
    {
        if (!$this->playersTable) {
            $sm = $this->getServiceLocator();
            $this->playersTable = $sm->get('Raidplan\Model\PlayersTable');
        }
        return $this->playersTable;
    }

    /**
     * liefert jobtable model zurück
     * @return array|object
     */
    public function getJobsTable()
    {
        if (!$this->jobsTable) {
            $sm = $this->getServiceLocator();
            $this->jobsTable = $sm->get('Raidplan\Model\JobsTable');
        }
        return $this->jobsTable;
    }

    /**
     * liefert rolestable model zurück
     * @return array|object
     */
    public function getRolesTable()
    {
        if (!$this->rolesTable) {
            $sm = $this->getServiceLocator();
            $this->rolesTable = $sm->get('Raidplan\Model\RolesTable');
        }
        return $this->rolesTable;
    }

    /**
     * liefert userstable model zurück
     * @return array|object
     */
    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('Raidplan\Model\UsersTable');
        }
        return $this->usersTable;
    }

    /**
     * leifert eventmodel zurück
     * es wird mit den benötigten tables und models initialisiert
     * @return Events
     */
    public function getEventModel() {
        $model = new Events();
        $model->initTables($this->getEventsTable(),$this->getPlayersTable(),$this->getJobsTable(),$this->getRolesTable(),$this->getUsersTable());
        $model->initModels($this->getPlayerModel(),$this->getJobModel(),$this->getRoleModel(),$this->getUserModel());
        return $model;
    }

    /**
     * leifert playermodel zurück
     * es wird mit den benötigten tables und models initialisiert
     * @return Events
     */
    public function getPlayerModel() {
        $model = new Players();
        $model->initTables($this->getPlayersTable(),$this->getJobsTable(),$this->getUsersTable());
        $model->initModels($this->getJobModel(),$this->getUserModel());
        return $model;
    }

    /**
     * leifert jobmodel zurück
     * es wird mit den benötigten tables und models initialisiert
     * @return Events
     */
    public function getJobModel() {
        $model = new Jobs();
        $model->initTables($this->getJobsTable(),$this->getRolesTable());
        $model->initModels($this->getRoleModel());
        return $model;
    }

    /**
     * leifert rolemodel zurück
     * es wird mit den benötigten tables initialisiert
     * @return Events
     */
    public function getRoleModel() {
        $model = new Roles();
        $model->setTable($this->getRolesTable());
        return $model;
    }

    /**
     * liefert usermodel zurück
     * @return Users
     */
    public function getUserModel() {
        $model = new Users();
        return $model;
    }
}

