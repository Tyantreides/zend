<?php
namespace Raidplan\Form;

use Raidplan\Model\Players;
use Raidplan\Model\Roles;
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
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'titel',
                    'class' => 'form-control',
                ),
                ));
            $this->add(array(
                'name' => 'beschreibung',
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'beschreibung',
                    'class' => 'form-control',
                ),
                ));
            $this->add(array(
                'name' => 'datetime',
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'datetime',
                    'class' => 'hasDatepicker',
                ),
            ));
            $this->add(array(
                'name' => 'status',
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'status',
                    'class' => 'form-control',
                ),
            ));
            $this->add(array(
                'name' => 'activityid',
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'activityid',
                    'class' => 'form-control',
                ),
            ));
            $this->add(array(
                'name' => 'invited',
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'invited',
                    'class' => 'form-control',
                ),
            ));
            $this->add(array(
                'name' => 'accepted',
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'accepted',
                    'class' => 'form-control',
                ),
            ));
            $this->add(array(
                'name' => 'declined',
                'type' => 'hidden',
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

    public function getEventAddForm() {
        $output = '';
        $output .= '<div class="eventaddform">';
        $output .= '<form action="/addevent" method="POST" name="preevent" id="preevent">
                    <table class="eventaddtable">
                        <tr>
                            <td class="left">
                                <input type="hidden" name="pre_id" id="pre_id" value="">
                                <input type="hidden" name="pre_status" id="pre_status" value="1">
                                <label for="pretitel">Titel</label>
                                <input type="text" name="pre_titel" id="pre_titel" class="form-control" value="">
                                <label for="prebeschreibung">Beschreibung</label>
                                <textarea name="pre_beschreibung" id="pre_beschreibung" class="form-control"></textarea>
                            </td>
                            <td class="right">
                                <label>Datum:</label>
                                <input name="pre_date" type="text" id="pre_date" class="form-control hasDatepicker">
                                <label>Uhrzeit:</label>
                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                    <input name="pre_time" id="pre_time" type="text" class="form-control">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </td>
                        </tr>


                    </table>
                    </form>';
        $output .= '</div>';
        $output .= '<script>';
        $output .= '';
        $output .= '</script>';
        return $output;
    }

    public function getActivityDropdown($allActivities) {
        $output = '';
        $output .= '<label>Event Vorauswahl:</label>';
        $output .= '<select class="form-control" id="pre_activityid">';
        $output .= '<option value="999">Leeres Template (8 Teilnehmer)</option>';
        foreach ($allActivities as $key => $activity) {
            $output .= '<option value="'.$activity["id"].'">'.$activity["titel"].' ('.$activity["membercount"].' Teilnehmer)</option>';
        }
        $output .= '</select>';
        return $output;
    }

    public function getEventAddSuccessMsg(){
        return '<div class="raidplan-msg-box"><div class="raidplan-msg-success" id="raidplan-msg">Event erfolgreich gespeichert. <br>Du wirst weitergeleitet....</div></div>';
    }

    public function getViewEventForm($eventsModel){
        $output = '';
        list($date, $time) = explode(" ",$eventsModel->datetime);
        $output .= '<div class="eventviewform" data-eventid="'.$eventsModel->id.'">';
            $output .= '<table class="eventviewtable">';
                $output .= '<tr>';
                    $output .= '<td class="eventdata">';
                        $output .= '<table class="table">';
                            $output .= '<tr>';
                                $output .= '<td>';
                                    $output .= '<label for="view_titel">Titel</label>';
                                    $output .= '<input type="text" name="pre_titel" id="view_titel" class="form-control" value="'.$eventsModel->titel.'" disabled>';
                                $output .= '</td>';
                            $output .= '</tr>';
                            $output .= '<tr>';
                                $output .= '<td>';
                                    $output .= '<label for="view_beschreibung">Beschreibung</label>';
                                    $output .= '<textarea name="view_beschreibung" id="view_beschreibung" class="form-control" disabled>'.$eventsModel->beschreibung.'</textarea>';
                                $output .= '</td>';
                            $output .= '</tr>';
                            $output .= '<tr>';
                                $output .= '<td>';
                                    $output .= '<label>Datum:</label>';
                                    $output .= '<input name="view_date" type="text" id="view_date" class="form-control" value="'.$date.'" disabled>';
                                $output .= '</td>';
                            $output .= '</tr>';
                            $output .= '<tr>';
                                $output .= '<td>';
                                    $output .= '<label>Uhrzeit:</label>';
                                    $output .= '<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">';
                                        $output .= '<input name="view_time" id="view_time" type="text" class="form-control" value="'.$time.'" disabled>';
                                        $output .= '<span class="input-group-addon">';
                                            $output .= '<span class="glyphicon glyphicon-time"></span>';
                                        $output .= '</span>';
                                    $output .= '</div>';
                                $output .= '</td>';
                            $output .= '</tr>';
                        $output .= '</table>';
                    $output .= '</td>';
                    $output .= '<td class="roledata">';
                        $output .= '<table class="table">';
                            $output .= $this->renderRoleList($eventsModel->roles);
                        $output .= '</table>';
                    $output .= '</td>';
                    $output .= '<td class="teilnehmerdata">';
                    $output .= '<table class="table">';
                        $output .= $this->renderTeilnehmerList($eventsModel->players);
                    $output .= '</table>';
                    $output .= '</td>';
                $output .= '</tr>';
            $output .= '</table>';
        $output .= '</div>';
        return $output;
    }

    public function renderTeilnehmerList($playerlist) {
        $output = '';
        foreach($playerlist as $player) {
            if ($player instanceof Players) {
                $output .= '<tr><td class="active">'.$player->charname.'</td><td class="success">status</td></tr>';
            }
            else{
                $output .= '<tr><td class="active">'.$player[0]['player_charname'].'</td><td class="success">status</td></tr>';
            }
        }
        return $output;
    }

    public function renderRoleList($rolelist) {
        $output = '';
        foreach($rolelist as $role) {
            if ($role instanceof Roles) {
                $output .= '<tr><td class="active">'.$this->getRoleTumbnail($role->roleshortname).'</td></tr>';
            }
            else{
                $output .= '<tr><td class="active">'.$role[0]['role_shortname'].'</td></tr>';
            }
        }
        return $output;
    }

    private function getRoleTumbnail ($roleShortName) {
        $output = '<img style="float:left;" src="/img/FFXIV/res/tumbnails/role_'.strtolower($roleShortName).'_24x24.png">';
        return $output;
    }

    public function getEventRoles($eventData, $allroles){
        $allEventData = json_decode($eventData->invited);
        foreach($allroles as $roledata) {
            $roledataarray[$roledata['id']] = $roledata;
        }
        foreach($allEventData->roles as $role) {
            if (array_key_exists($role->role, $roledataarray)) {
                $eventroles[] = $roledataarray[$role->role];
            }
            elseif ($role->role == '999') {
                $eventroles[] = array(
                    'id' => 999,
                    'rolename' => 'Random',
                    'roleshortname' => 'Rand'
                );
            }
            else{
                $eventroles[] = array(
                    'id' => 999,
                    'rolename' => 'Random',
                    'roleshortname' => 'Rand'
                );
            }
        }
        return $eventroles;
    }

    public function getPlayerDiv($player) {

    }

    }