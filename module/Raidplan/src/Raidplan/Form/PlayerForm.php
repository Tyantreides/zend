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
                $output .= $this->getJobTumbnail($job['job_shortname']);
                $output .= $job['job_shortname'].' ('.$job['job_ilvl'].')';
//                foreach ($job as $value) {
//                    $output .= '<div style="display:inline;">'.$value.'</div>';
//                }
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

    private function getRoleTumbnail ($roleShortName) {
        $output = '<img style="float:left;" src="/img/FFXIV/res/tumbnails/role_'.strtolower($roleShortName).'_24x24.png">';
        return $output;
    }

    private function getJobTumbnail ($jobshortname) {
        $output = '<img src="/img/FFXIV/res/tumbnails/job_'.strtolower($jobshortname).'_24x24.png">';
        return $output;
    }

    public function getBlankPartyAssembler($partysize, $allRoles) {

        foreach ($allRoles as $role) {
            $roleIds[] = $role['id'];
            $roleNames[] = $role['rolename'];
            $roleShortNames[] = $role['roleshortname'];
        }
        $output = '<table>';
        $output .= '<tr>';
        $output .= '<td>';
        $output .= '<div class="btn-group-vertical" id="partyassembler" style="width:210px;">';
        for ($m=0; $m<$partysize; $m++) {
            $output .= '<div class="btn-group" id="partyspot_'.$m.'" style="margin-bottom:5px">
                            <button style="text-align:left;" id="choosedrole_'.$m.'" data-roleid="99" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                Nicht festgelegt
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a data-for="'.$m.'" data-roleid="99" href="#">Nicht festgelegt</a></li>';
                                foreach ($roleShortNames as $roleId => $roleShortname) {
                                    $output .= '<li style="width:210px;"><a data-for="'.$m.'" data-roleid="'.$roleId.'" href="#">'.$this->getRoleTumbnail($roleShortname).'&nbsp;'.$roleNames[$roleId].'</a></li>';
                                }
            $output .= '<li>&nbsp;</li>    </ul>
                        </div>

                        ';
        }
        $output .= '</div>';
        $output .= '</td>';
        $output .= '<td>';
        $output .= '<div style="width: 200px;">';
        for ($m=0; $m<$partysize; $m++) {
            $output .= '<div style="height: 34px">Spot</div>';
        }
        $output .= '</div>';
        $output .= '</td>';
        $output .= '</tr>';
        $output .= '</table>';
        $output .= '<script>';
        $output .= '$("#partyassembler a").each(function(){
                        $( this ).click(function() {
                            //alert( "click" );
                            var choosedroleelement = "#choosedrole_"+$(this).data("for");
                            var pfeilspan = "&nbsp;<span class=\"caret\"></span>";
                            $(choosedroleelement).data("roleid", $(this).data("roleid"));
                            $(choosedroleelement).html($(this).html()+pfeilspan);
                        });
                    });
                    ';
        $output .= '</script>';
        return $output;
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