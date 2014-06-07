<?php
namespace Raidplan\Form;

use Zend\Form\Form;

class EventForm extends Form
    {
    public function __construct($name = null)
        {
            // we want to ignore the name passed
            parent::__construct('event');

            $this->add(array(
                'name' => 'id',
                'type' => 'Hidden',
                ));
            $this->add(array(
                'name' => 'titel',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Titel',
                    ),
                ));
            $this->add(array(
                'name' => 'beschreibung',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Beschreibung',
                    ),
                ));
            $this->add(array(
                'name' => 'submit',
                'type' => 'Submit',
                'attributes' => array(
                    'value' => 'Go',
                    'id' => 'submitbutton',
                    ),
                ));
        }
    }