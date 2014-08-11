<?php
namespace Raidplan\Form;

use Zend\Filter\Null;
use Zend\Form\Form;

class UserForm extends Form
{

    public function __construct()
    {

    }

    public function getLoginForm() {
        $output = '';
        //$output  = '<div class="loginbox">';
        $output .= '<div action="/login" method="POST" class="navbar-form navbar-right" role="search" id="loginformbar">
                        <div class="form-group">
                            <input type="text" class="form-control" name="user" placeholder="Username" id="loginuser">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="passwd" placeholder="Passwort" id="loginpasswd">
                        </div>
                        <button type="submit" class="btn btn-default" id="loginbtn">Login</button>
                    </div>';
//            $output .= '<form action="/login" method="POST" class="form">';
//                $output .= '<label>Login:</label>';
//                $output .= '<input type="text" name="user" class="form-control logintext">';
//                $output .= '<label>Passwort:</label>';
//                $output .= '<input type="password" name="passwd" class="form-control loginpass">';
//                $output .= '<input type="submit" name="submit" value="Login" class="form-control loginbtn">';
//            $output .= '</form>';
        //$output .= '</div>';
        return $output;
    }

    public function getWelcomeBlock() {
        $output = '<p>Du bist erfolgreich eingeloggt.</p>';
        return $output;
    }

    public function getLoggedInBlock() {
        $output = '<ul class="nav navbar-nav" style="float: right;" id="loginformbar">
                        <li><a href="/logout">Ausloggen</a></li>
                    </ul>
                   ';
        return $output;
    }

    public function getLoginReminder() {
        $output = '<p>Bitte melde Dich zuerst oben rechts an.</p>';
        return $output;
    }

    public function getUserMatchForm ($userModel,$playerlist) {
        $output = '';
        $matchedPlayers = $this->fillPlayerlistWithBlankPlayers($userModel, 1);
        $output .= '<div class="usermatchform">';
            //$output .= '<table class="usermatchtable">';
//                $output .= '<tr>';
//                    $output .= '<td class="userdata">';
                        $output .= '<div class="ui-tabs-panel panel ui-corner-bottom" style="padding: 20px;">';
                            $output .= '<label for="view_titel">Username</label>';
                                $output .= '<div style="padding-left:20px;"><h1>'.$userModel->username.'</h1></div><br>';
                            $output .= '<label for="view_titel">Verknüpfter Player:</label>';
                                $output .= $this->rendermatchedPlayerlist($matchedPlayers);
                        $output .= '</div>';
//                    $output .= '</td>';
//                    $output .= '<td class="playerdata" style="width: 200px">';
//                        $output .= '<table class="table">';
                            $output .= $this->renderPlayerlist($playerlist);
//                        $output .= '</table>';
//                    $output .= '</td>';
//                $output .= '</tr>';
//            $output .= '</table>';
        $output .= '</div>';
        return $output;
    }

    private function fillPlayerlistWithBlankPlayers($userModel, $playercount) {
        if (is_array($userModel->matchedPlayers)) {
            $count = count($userModel->matchedPlayers);
            foreach ($userModel->matchedPlayers as $player) {
                $playerlist[] = $player;
            }
        }
        else {
            $count = 0;
        }
        for ($p = $count; $p < $playercount; $p++) {
            $playerlist[] = clone $userModel->getPlayerModel()->load(999);
        }
        return $playerlist;
    }

    private function renderPlayerlist($playerArray) {
        $output = '';
        if (is_array($playerArray)) {
            $output .= '<div class="playerlist" id="playerlist">';
                foreach ($playerArray as $player) {
                    if ($player->id == 999) {
                        $output .= $this->getEmptySpot();
                    }
                    else {
                        $output .= '<div class="ui-widget-content player" id="player_'.$player->id.'">';
                        $output .= '<p class="playername">'.$player->charname.'</p>';
                        $output .= '<div class="ui-widget-content joblist">';
                        foreach ($player->jobs as $job) {
                            $output .= '<div class="job" data-jobid="'.$job->id.'" data-roleid="'.$job->role->id.'">';
                            $output .= '<img src="/img/FFXIV/res/tumbnails/job_'.strtolower($job->jobshortname).'_24x24.png">';
                            $output .= $job->jobshortname.' ('.$job->ilvl.')';
                            $output .= '</div>';
                        }
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                }
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
        return '<p>keine</p>';
        return $output;
    }

    private function rendermatchedPlayerlist($playerArray) {
        $output = '';
        if (is_array($playerArray)) {
            $output .= '<div class="playerlist" id="playerlist">';
            foreach ($playerArray as $player) {
                if ($player->id == 999) {
                    $output .= $this->getEmptySpot();
                }
                else {
                    $output .= '<div class="ui-widget-content player" id="player_'.$player->id.'">';
                    $output .= '<p class="playername">'.$player->charname.'</p>';
                    $output .= '<div class="ui-widget-content joblist">';
                    foreach ($player->jobs as $job) {
                        $output .= '<div class="job" data-jobid="'.$job->id.'" data-roleid="'.$job->role->id.'">';
                            $output .= '<img src="/img/FFXIV/res/tumbnails/job_'.strtolower($job->jobshortname).'_24x24.png">';
                            $output .= $job->jobshortname.' ('.$job->ilvl.')';
                            $output .= '<div>Bearbeiten</div>';
                        $output .= '</div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                }
            }
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
        return '<p>keine</p>';
        return $output;
    }

    private function getEmptySpot() {
        $output = '';
        $output .= '<div class="empty" ">nicht vorahnden</div>';
        return $output;
    }
}