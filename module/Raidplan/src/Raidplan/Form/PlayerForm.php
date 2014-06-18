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
        $output = '<div class="playerlist" id="playerlist">';
        //$output .= '<table>';
        foreach ($playerData as $playerentry) {
            $output .= $this->getPlayer($playerentry);
        }
        //$output .= '</table>';
        $output .= '</div>';
        $output .= '<script>';
        $output .= '$( "#playerlist .player" ).draggable({
                      appendTo: "body",
                      helper: "clone"
                    });
                    ';
        $output .= '</script>';
        return $output;
    }

    private function getPlayer($playerEntry){
        $output = '';
        $output .= '<div class="ui-widget-content player" id="player_'.$playerEntry[0]['playerid'].'">';
            $output .= $playerEntry[0]['player_charname'];
            $output .= '<div class="ui-widget-content joblist">';
            foreach ($playerEntry as $job) {
                $output .= $this->getJobForPlayer($job);
            }
            $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

    private function getJobForPlayer($job){
        $output = '';
        $output .= '<div class="job" data-jobid="'.$job['job_id'].'" data-roleid="'.$job['role_id'].'">';
        $output .= $this->getJobTumbnail($job['job_shortname']);
        $output .= $job['job_shortname'].' ('.$job['job_ilvl'].')';
//                foreach ($job as $value) {
//                    $output .= '<div style="display:inline;">'.$value.'</div>';
//                }
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

    public function getPartyAssembler($allRoles, $partysize=8) {
        $this->setRoles($allRoles);
        $output = '';
        $output .= '<table class="table" id="partyassembler">
                      <thead>
                        <tr>
                          <th>Setup</th>
                          <th>Eingeladen</th>
                          <th>Akzeptiert</th>
                          <th>Abgelehnt</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="pull-left roleselection">
                              '.$this->getRoleSelection($partysize).'
                            </div>
                          </td>
                          <td>
                            <div class="pull-left invited">
                              '.$this->getSpotlist($partysize,'invited').'
                            </div>
                          </td>
                          <td>
                            <div class="pull-left accepted">
                              '.$this->getSpotlist($partysize,'accepted').'
                            </div>
                          </td>
                          <td>
                            <div class="pull-left declined">
                              '.$this->getSpotlist($partysize,'declined').'
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>';
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

    public function getPartyAssemblerAdd($allRoles, $partysize=8) {
        $this->setRoles($allRoles);
        $output = '';
        $output .= '<table class="table" id="partyassembler">
                      <thead>
                        <tr>
                          <th>Setup</th>
                          <th>Einladen</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="pull-left roleselection">
                              '.$this->getRoleSelection($partysize).'
                            </div>
                          </td>
                          <td>
                            <div class="pull-left invited">
                              '.$this->getSpotlist($partysize,'invited').'
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>';
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
                    $( "#partyassembler .empty" ).droppable({
                      accept: ".player.ui-draggable",
                      hoverClass: "empty-hover",
                      drop: function( event, ui ) {
                        if (ui.draggable.data("spot")) {
                            if ($(this).data("player")) {
                                var newspotid = "#"+ui.draggable.data("spot");
                                $(this).find(".player").data("spot",ui.draggable.data("spot"));
                                $(newspotid).append($(this).find(".player"));
                                //$(this).find(".player").remove();
                            }
                            else{
                                var fromelementid = "#"+ui.draggable.data("spot");
                                $(fromelementid).removeClass("playerspot");
                                $(fromelementid).addClass("empty");
                                $(fromelementid).addClass("ui-droppable");
                                $(fromelementid).data("player",false);
                            }

                        }
                        //$( this ).find( ".placeholder" ).remove();
                        //ui.draggable.html().appendTo( this );
                        $(this).removeClass("ui-droppable");
                        $(this).removeClass("empty");
                        $(this).addClass("playerspot");
                        $(this).html("");
                        ui.draggable.data("spot",$(this).attr("id"));
                        $(this).data("player",ui.draggable.attr("id"));
                        $(this).append(ui.draggable);
                      }
                    });
                    $( "#partyassembler .empty" ).on("drop", function(event,ui){
                        //ui.draggable.addClass("disabled");
                        //ui.draggable.draggable("disable");
                    });
                    ';
        $output .= '</script>';
        return $output;
    }

    private function getRoleSelection($partySize) {
        $output = '';
        for ($m=0; $m<$partySize; $m++) {
            $output .= '<div class="roleselect">'.$this->getRoleSelect($m).'</div>';
        }
        return $output;
    }

    private function getRoleSelect($row) {
        $output = '';
        $output .= '<div class="btn-group" id="partyspot_'.$row.'" >
                            <button style="text-align:left; width:200px;" id="choosedrole_'.$row.'" data-roleid="99" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                Nicht festgelegt
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a data-for="'.$row.'" data-roleid="99" href="#">Nicht festgelegt</a></li>';
        foreach ($this->roleShortNames as $roleId => $roleShortname) {
            $output .= '<li style="width:210px;"><a data-for="'.$row.'" data-roleid="'.$roleId.'" href="#">'.$this->getRoleTumbnail($roleShortname).'&nbsp;'.$this->roleNames[$roleId].'</a></li>';
        }
        $output .= '<li>&nbsp;</li></ul></div>';
        return $output;
    }

    private function getSpotlist($partySize, $type) {
        $output = '';
        for ($m=0; $m<$partySize; $m++) {
            if (1==1) {
                $output .= '<div class="empty" id="'.$type.'_'.$m.'">'.$this->getEmptySpot().'</div>';
            }
        }
        return $output;
    }

    private function getEmptySpot(){
        $output = '';
        $output .= 'noch leer';
        return $output;
    }

    private function setRoles($allRoles) {
        foreach ($allRoles as $role) {
            $this->roleIds[] = $role['id'];
            $this->roleNames[] = $role['rolename'];
            $this->roleShortNames[] = $role['roleshortname'];
        }
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