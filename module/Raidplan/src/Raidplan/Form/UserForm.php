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
        $output = '<form action="/login" method="POST">';
        $output .= '<input type="text" name="user">';
        $output .= '<input type="password" name="passwd">';
        $output .= '<input type="submit" name="submit" value="Login">';
        $output .= '</form>';
        return $output;
    }

    public function getWelcomeBlock() {
        $output = '<p>Du bist erfolgreich eingeloggt.</p>';
        return $output;
    }

    public function getLoggedInBlock() {
        $output = '<p>Du bist eingeloggt.</p>';
        return $output;
    }
}