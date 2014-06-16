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
        $output .= '<form action="/addevent" method="POST" name="event" id="event">
                        <input type="hidden" name="preid" value="">
                        <label for="pretitel">Titel</label>
                        <input type="text" name="pretitel" id="titel" class="form-control" value="">
                        <label for="prebeschreibung">Beschreibung</label>
                        <textarea name="prebeschreibung" id="beschreibung" class="form-control"></textarea>
                        <label>Datum:</label>
                        <input name="predate" type="text" id="datepicker" class="form-control hasDatepicker">
                        <label>Uhrzeit:</label>
                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                            <input name="pretime" type="text" class="form-control">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </form>';
        $output .= '</div>';
        $output .= '<script>';
        $output .= '$(".eventaddform input").each(function(){
                        $( this ).change(function() {
                            alert( "change" );
                        });
                    });
                    $(".eventaddform #datepicker").datepicker()
                        .on("changeDate", function(ev){
                            alert( "change" );
                            $(this).datepicker("hide");
                        });';
        $output .= '</script>';
        return $output;
    }

    }