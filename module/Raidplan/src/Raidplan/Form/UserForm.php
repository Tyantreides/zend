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
}