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
                'attributes' => array(
                    'id' => 'titel',
                    'class' => 'form-control',
                ),
                ));
            $this->add(array(
                'name' => 'beschreibung',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Beschreibung',
                    ),
                'attributes' => array(
                    'id' => 'beschreibung',
                    'class' => 'form-control',
                ),
                ));
            $this->add(array(
                'name' => 'datetime',
                'type' => 'text',
                'options' => array(
                    'label' => 'Datum',
                ),
                'attributes' => array(
                    'id' => 'datetime',
                    'class' => 'form-control',
                ),
            ));
            $this->add(array(
                'name' => 'status',
                'type' => 'text',
                'options' => array(
                    'label' => 'Status',
                ),
                'attributes' => array(
                    'id' => 'status',
                    'class' => 'form-control',
                ),
            ));
            $this->add(array(
                'name' => 'activityid',
                'type' => 'text',
                'options' => array(
                    'label' => 'Activityid',
                ),
                'attributes' => array(
                    'id' => 'activityid',
                    'class' => 'form-control',
                ),
            ));
            $this->add(array(
                'name' => 'invited',
                'type' => 'text',
                'options' => array(
                    'label' => 'Invited',
                ),
                'attributes' => array(
                    'id' => 'invited',
                    'class' => 'form-control',
                ),
            ));
            $this->add(array(
                'name' => 'accepted',
                'type' => 'text',
                'options' => array(
                    'label' => 'accepted',
                ),
                'attributes' => array(
                    'id' => 'accepted',
                    'class' => 'form-control',
                ),
            ));
            $this->add(array(
                'name' => 'declined',
                'type' => 'text',
                'options' => array(
                    'label' => 'declined',
                ),
                'attributes' => array(
                    'id' => 'declined',
                    'class' => 'form-control',
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