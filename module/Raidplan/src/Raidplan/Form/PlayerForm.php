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

    public function getPlayerJobs($playerid, $playerData) {

        foreach ($playerData as $playerEntry) {
            if ($playerid == $playerEntry['playerid']) {
                $jobs[] = array('jobname' => $playerEntry['jobname'],
                                'jobshortname' => $playerEntry['jobshortname'],
                                'ilvl' => $playerEntry['ilvl'],
                );
            }
        }
    }

    public function getPlayerList($playerData) {
        $playerData = $this->groupPlayerData($playerData);
        $output = '<div>';
        $output .= '<table>';
        foreach ($playerData as $playerentry) {
            $output .= '<tr class="ui-widget-content">';
                $output .= '<td colspan="'.count($playerentry).'">'.$playerentry[0]['player_charname'].'</td>';
            $output .= '</tr>';
            $output .= '<tr class="ui-widget-content">';
            foreach ($playerentry as $job) {
                $output .= '<td>';
                foreach ($job as $value) {
                    $output .= '<div style="display:inline;">'.$value.'</div>';
                }
                $output .= '</td>';
            }
            $output .= '</tr>';
        }
        $output .= '</table>';
        $output .= '</div>';
        return $output;
    }

    public function getAddPlayerForm($playerData) {
        $output = '<div>';
        $output .= '<table>';
        foreach ($playerData as $playerentry) {
            $output .= '<tr class="ui-widget-content">';
            foreach ($playerentry as $playerfield) {
                $output .= '<td>';
                $output .= $playerfield;
                $output .= '</td>';
            }
            $output .= '</tr>';
        }
        $output .= '</table>';
        $output .= '</div>';
        return $output;
    }

    public function printData($method, $playerData) {
        $methodname = 'get'.$method;
        if (method_exists($this, $methodname)) {
            return $this->$methodname($playerData);
        }
    }

    private function groupPlayerData($playerData) {
        foreach ($playerData as $player) {
            $groupedPlayerData[$player['playerid']][] = $player;
        }
        return $groupedPlayerData;
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