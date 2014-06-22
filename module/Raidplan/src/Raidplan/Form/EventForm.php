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
                    'id' => 'fulldatetime',
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

    }