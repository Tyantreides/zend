<?php
namespace Raidplan\Model;


class Events
{
    public $id;
    public $titel;
    public $beschreibung;
    public $datetime;
    public $status;
    public $activityid;
    public $invited;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->titel = (isset($data['titel'])) ? $data['titel'] : null;
        $this->beschreibung  = (isset($data['beschreibung']))  ? $data['beschreibung']  : null;
        $this->datetime  = (isset($data['datetime']))  ? $data['datetime']  : null;
        $this->status  = (isset($data['status']))  ? $data['status']  : null;
        $this->activityid  = (isset($data['activityid']))  ? $data['activityid']  : null;
        $this->invited  = (isset($data['invited']))  ? $data['invited']  : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}





?>