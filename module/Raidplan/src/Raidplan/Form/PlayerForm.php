<?php
namespace Raidplan\Form;

use Raidplan\Model\PlayersTable;
use Zend\Filter\Null;
use Zend\Form\Form;

class PlayerForm extends Form
{

    private $playerTable;

    public function __construct($table = null, $name = null)
    {
        // we want to ignore the name passed
        parent::__construct('player');

        if (isset($name) && $name != NULL && $table != null) {
            if (method_exists($this, $name)) {
                $this->$name($table);
            }
            else {
                $this->complete();
            }
        }
    }

    private function complete(){
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'charname',
            'type' => 'Text',
            'options' => array(
                'label' => 'Charakter Name',
            ),
            'attributes' => array(
                'id' => 'charname',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Spieler Name',
            ),
            'attributes' => array(
                'id' => 'name',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'classes',
            'type' => 'text',
            'options' => array(
                'label' => 'Klassen',
            ),
            'attributes' => array(
                'id' => 'classes',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'jobs',
            'type' => 'text',
            'options' => array(
                'label' => 'Jobs',
            ),
            'attributes' => array(
                'id' => 'jobs',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'lodestoneid',
            'type' => 'text',
            'options' => array(
                'label' => 'lodestoneid',
            ),
            'attributes' => array(
                'id' => 'lodestoneid',
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


    /**
    private function select(PlayersTable $table){
        $this->add(array(
            'name'    => 'players',
            'type'    => 'Zend\Form\Element\Select',
            'options' => array(
                'label'         => 'Spielerauswahl',
                'value_options' => $table->getPlayersDataForSelectElement(),
                'empty_option'  => '--- bitte waehlen ---'
            )
        ));
    }*/

}