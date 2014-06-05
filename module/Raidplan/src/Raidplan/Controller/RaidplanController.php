<?php

namespace Raidplan\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Raidplan\Model\Raidplan;          // <-- Add this import
use Raidplan\Form\RaidplanForm;       // <-- Add this import

class RaidplanController extends AbstractActionController
{

    public function indexAction()
    {
        $eventsjson = '{"success":1,"result":[{"id":"293","title":"This is warning class event with very long title to check how it fits to evet in day view","url":"http://www.example.com/","class":"event-warning","start":"1362938400000","end":"1363197686300"},{"id":"256","title":"Event that ends on timeline","url":"http://www.example.com/","class":"event-warning","start":"1363155300000","end":"1363227600000"},{"id":"276","title":"Short day event","url":"http://www.example.com/","class":"event-success","start":"1363245600000","end":"1363252200000"},{"id":"294","title":"This is information class ","url":"http://www.example.com/","class":"event-info","start":"1363111200000","end":"1363284086400"},{"id":"297","title":"This is success event","url":"http://www.example.com/","class":"event-success","start":"1363234500000","end":"1363284062400"},{"id":"54","title":"This is simple event","url":"http://www.example.com/","class":"","start":"1363712400000","end":"1363716086400"},{"id":"532","title":"This is inverse event","url":"http://www.example.com/","class":"event-inverse","start":"1364407200000","end":"1364493686400"},{"id":"548","title":"This is special event","url":"http://www.example.com/","class":"event-special","start":"1363197600000","end":"1363629686400"},{"id":"295","title":"Event 3","url":"http://www.example.com/","class":"event-important","start":"1364320800000","end":"1364407286400"}]}';
        return new ViewModel(array('eventsjson' => $eventsjson));
    }

    public function editAction() {
        //$id = (int) $this->params()->fromRoute('id', 0);
        //return new ViewModel();

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('raidplan', array(
                'action' => 'add'
            ));
        }

        // Get the Raidplan with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $raidplan = $this->getRaidplanTable()->getRaidplan($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('raidplan', array(
                'action' => 'index'
            ));
        }

        $form  = new RaidplanForm();
        $form->bind($raidplan);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($raidplan->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getRaidplanTable()->saveRaidplan($raidplan);

                // Redirect to list of raidplans
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function addAction()
    {
        $form = new RaidplanForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $Raidplan = new Raidplan();
            $form->setInputFilter($Raidplan->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $Raidplan->exchangeArray($form->getData());
                $this->getRaidplanTable()->saveRaidplan($Raidplan);

                // Redirect to list of Raidplans
                return $this->redirect()->toRoute('Raidplan');
            }
        }
        return array('form' => $form);
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

