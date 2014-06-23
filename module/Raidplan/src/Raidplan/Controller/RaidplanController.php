<?php

namespace Raidplan\Controller;

use Raidplan\Form\EventForm;
use Raidplan\Form\PlayerForm;
use Raidplan\Form\JobForm;
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

    public function indexAction()
    {

    }

    public function calendarAction() {
        $events = $this->getEventsTable()->fetchAll();
        $eventsjson = '{"success":1,"result":[{"id":"293","title":"This is warning class event with very long title to check how it fits to evet in day view","url":"http://www.example.com/","class":"event-warning","start":"1362938400000","end":"1363197686300"},{"id":"256","title":"Event that ends on timeline","url":"http://www.example.com/","class":"event-warning","start":"1363155300000","end":"1363227600000"},{"id":"276","title":"Short day event","url":"http://www.example.com/","class":"event-success","start":"1363245600000","end":"1363252200000"},{"id":"294","title":"This is information class ","url":"http://www.example.com/","class":"event-info","start":"1363111200000","end":"1363284086400"},{"id":"297","title":"This is success event","url":"http://www.example.com/","class":"event-success","start":"1363234500000","end":"1363284062400"},{"id":"54","title":"This is simple event","url":"http://www.example.com/","class":"","start":"1363712400000","end":"1363716086400"},{"id":"532","title":"This is inverse event","url":"http://www.example.com/","class":"event-inverse","start":"1364407200000","end":"1364493686400"},{"id":"548","title":"This is special event","url":"http://www.example.com/","class":"event-special","start":"1363197600000","end":"1363629686400"},{"id":"295","title":"Event 3","url":"http://www.example.com/","class":"event-important","start":"1364320800000","end":"1364407286400"}]}';
        return new ViewModel(array('eventsjson' => $eventsjson,
                'events' => $events,
            )
        );
    }

    public function editAction() {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('addevent');
        }

        // Get the Raidplan with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
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

        foreach ($playersData as $playerDataRow) {
            $playerRowDataArray[] =  $playerDataRow;
        }


        $form  = new EventForm();
        $form->bind($events);
        $playerForm = new PlayerForm();
/**
        foreach ($allPlayers as $player ) {
            $jobForm = new JobForm($player->id, $playersTable, $jobsTable);
        }
*/

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
            'playerdata' => $playerRowDataArray,
            'eventData' => $eventdata,
        );
    }

    public function ajaxAction(){
        $form = new EventForm();
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        //if form was send
        if ($request->isPost()) {

//            $events = new Events();
//            $form->setData($request->getPost());
//            if ($form->isValid()) {
//                $events->exchangeArray($form->getData());
//                $this->getEventsTable()->saveEvents($events);
//            }
            $output = $request->getPost();
        }
        else {
            $output = false;
        }
        $viewModel = new ViewModel(array('output' => $output));
        $viewModel->setTerminal(true);
        return $viewModel;
        //return array('output' => $output);
    }

    public function addAction()
    {
        $form = new EventForm();
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        //if form was send
        if ($request->isPost()) {
            $events = new Events();
//            $form->setInputFilter($Raidplan->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $events->exchangeArray($form->getData());
                $this->getEventsTable()->saveEvents($events);

                // Redirect to list of Raidplans
                return $this->redirect()->toRoute('events');
            }
        }
        //if new
        else {
            try {

                $playersTable = $this->getPlayersTable();
                $playersData = $this->getPlayersTable()->fetchPlayerData();
                $allRoles = $this->getPlayersTable()->fetchAllRoles();
                $allActivities = $this->getEventsTable()->fetchActivities();
                $playerForm = new PlayerForm();
            }
            catch (\Exception $ex) {
                $playerstable = false;
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

    public function listEventsJsonAction(){
        echo  '{
	            "success": 1,
	            "result": [
                        {
                            "id": "293",
                            "title": "This is warning class event with very long title to check how it fits to evet in day view",
                            "url": "http://www.example.com/",
                            "class": "event-warning",
                            "start": "1362938400000",
                            "end":   "1363197686300"
                        },
                        {
                        "id": "256",
                        "title": "Event that ends on timeline",
                        "url": "http://www.example.com/",
                        "class": "event-warning",
                        "start": "1363155300000",
                        "end":   "1363227600000"
                        },
                        {
                            "id": "276",
                                "title": "Short day event",
                                "url": "http://www.example.com/",
                                "class": "event-success",
                                "start": "1363245600000",
                                "end":   "1363252200000"
                            },
                                {
                        "id": "294",
                            "title": "This is information class ",
                            "url": "http://www.example.com/",
                            "class": "event-info",
                            "start": "1363111200000",
                            "end":   "1363284086400"
                        },
                    {
                        "id": "297",
                            "title": "This is success event",
                            "url": "http://www.example.com/",
                            "class": "event-success",
                            "start": "1363234500000",
                            "end":   "1363284062400"
                        },
                    {
                        "id": "54",
                            "title": "This is simple event",
                            "url": "http://www.example.com/",
                            "class": "",
                            "start": "1363712400000",
                            "end":   "1363716086400"
                        },
                    {
                        "id": "532",
                            "title": "This is inverse event",
                            "url": "http://www.example.com/",
                            "class": "event-inverse",
                            "start": "1364407200000",
                            "end":   "1364493686400"
                        },
                    {
                        "id": "548",
                            "title": "This is special event",
                            "url": "http://www.example.com/",
                            "class": "event-special",
                            "start": "1363197600000",
                            "end":   "1363629686400"
                        },
                    {
                        "id": "295",
                            "title": "Event 3",
                            "url": "http://www.example.com/",
                            "class": "event-important",
                            "start": "1364320800000",
                            "end":   "1364407286400"
                        }
                ]
                }';
        //return new ViewModel(array('jsonstring' => $eventsjson));
    }


}

