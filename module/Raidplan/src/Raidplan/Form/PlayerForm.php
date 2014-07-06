<?php
namespace Raidplan\Form;

use Raidplan\Model\Jobs;
use Raidplan\Model\Players;
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

    public function processPlayerdata($playerdata){
        foreach($playerdata as $player) {
            $allplayers[$player['playerid']][] = $player;
        }
        return $allplayers;
    }

    public function getTeilnehmerList($playerdata, $eventdata){
        $allEventData = json_decode($eventdata->invited);
        $addedplayers = $allEventData->players;
        foreach($addedplayers as $addedplayer) {
            if (array_key_exists($addedplayer->player,$playerdata)) {
                $playerlist[] = $playerdata[$addedplayer->player];
            }
            elseif ($addedplayer->player == 999) {
                $playerlist[] = array(
                    '0' => array(
                        'playerid' => 999,
                        'player_charname' => 'Random Player'
                    ),
                );
            }
        }
        return $playerlist;
    }

    private function getPlayer($playerEntry){
        $output = '';
        $output .= '<div class="ui-widget-content player" id="player_'.$playerEntry[0]['playerid'].'">';
            $output .= '<p class="playername">'.$playerEntry[0]['player_charname'].'</p>';
            $output .= '<div class="ui-widget-content joblist">';
            foreach ($playerEntry as $job) {
                $output .= $this->getJobForPlayer($job);
            }
            $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

    private function getJobForPlayer($job){
        if($job instanceof Jobs) {
            $jobarray['job_id'] = $job->id;
            $jobarray['role_id'] = $job->role->id;
            $jobarray['job_shortname'] = $job->jobshortname;
            $jobarray['job_ilvl'] = $job->ilvl;
            $job = $jobarray;
        }
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
                          <td>
                            <div class="pull-left buttons">
                              '.$this->getSpotlist($partysize,'buttons').'
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>';
        $output .= '<script>';
        $output .= '';
        $output .= '</script>';
        return $output;
    }

    public function getPartyAssemblerEdit($allRoles, $eventmodel) {
        $partysize = 8;
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
                              '.$this->getRoleSelection($partysize, $eventmodel->roles).'
                            </div>
                          </td>
                          <td>
                            <div class="pull-left invited">
                              '.$this->getSpotlist($partysize,'invited', $eventmodel->players).'
                            </div>
                          </td>
                          <td>
                            <div class="pull-left buttons">
                              '.$this->getSpotlist($partysize,'buttons').'
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>';
        $output .= '<script>';
        $output .= '';
        $output .= '</script>';
        return $output;
    }

    private function getRoleSelection($partySize, $roles = null) {
        $output = '';
        if (!$roles == null) {
            foreach ($roles as $key => $role) {
                $output .= '<div class="roleselect">'.$this->getRoleSelect($key, $role->id).'</div>';
            }
        }
        else {
            for ($m=0; $m<$partySize; $m++) {
                $output .= '<div class="roleselect">'.$this->getRoleSelect($m).'</div>';
            }
        }

        return $output;
    }

    private function getRoleSelect($row, $roleid = null) {
        $output = '';

        foreach($this->roleIds as $rolekey => $roleindexid) {
            if ($roleindexid == $roleid) {
                $roleid = $rolekey;
            }
        }
        if (isset($roleid) && $roleid != 999) {
            $defaultelement = '<button style="text-align:left; width:200px;" id="choosedrole_'.$row.'" data-roleid="'.$this->roleIds[$roleid].'" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    '.$this->getRoleTumbnail($this->roleShortNames[$roleid]).'&nbsp;'.$this->roleNames[$roleid].'
                                    <span class="caret"></span>
                               </button>';
        }
        elseif(isset($roleid) && $roleid == 999){
            $defaultelement = '<button style="text-align:left; width:200px;" id="choosedrole_'.$row.'" data-roleid="999" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                Nicht festgelegt
                                <span class="caret"></span>
                            </button>';
        }
        else{
            $defaultelement = '<button style="text-align:left; width:200px;" id="choosedrole_'.$row.'" data-roleid="999" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                Nicht festgelegt
                                <span class="caret"></span>
                            </button>';
        }
        $output .= '<div class="btn-group" id="partyspot_'.$row.'" >';
        $output .= $defaultelement;
        $output .= '<ul class="dropdown-menu">
                                <li><a data-for="'.$row.'" data-roleid="999" href="#">Nicht festgelegt</a></li>';
        foreach ($this->roleShortNames as $key => $roleShortname) {
            $output .= '<li style="width:210px;"><a data-for="'.$row.'" data-roleid="'.$this->roleIds[$key].'" href="#">'.$this->getRoleTumbnail($roleShortname).'&nbsp;'.$this->roleNames[$key].'</a></li>';
        }
        $output .= '<li>&nbsp;</li></ul></div>';
        return $output;
    }

    private function getSpotlist($partySize, $type, $spotsset = null) {
        $output = '';
        for ($m=0; $m<$partySize; $m++) {
            if (isset($spotsset) && $spotsset[$m] instanceof Players) {
                $output .= '<div class="empty" id="'.$type.'_'.$m.'" data-filled="player_'.$spotsset[$m]->id.'">'.$this->getEmptySpot().'</div>';
            }
            else {
                $output .= '<div class="empty" id="'.$type.'_'.$m.'">'.$this->getEmptySpot().'</div>';
            }
        }
        return $output;
    }

    private function getEmptySpot(){
        $output = '';
        $output .= '&nbsp;';
        return $output;
    }

    private function getFilledSpot($player){
        $output = '';
        $output .= '<div class="ui-widget-content player" id="player_'.$player->id.'">';
        $output .= '<p class="playername">'.$player->charname.'</p>';
        $output .= '<div class="ui-widget-content joblist">';
        foreach ($player->jobs as $job) {
            $output .= $this->getJobForPlayer($job);
        }
        $output .= '</div>';
        $output .= '</div>';
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