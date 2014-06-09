<?php
namespace Raidplan\Model;


class Players
{
    public $id;
    public $charname;
    public $name;
    public $classes;
    public $jobs;
    public $lodestoneid;
    public $misc;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->charname = (isset($data['charname'])) ? $data['charname'] : null;
        $this->name  = (isset($data['name']))  ? $data['name']  : null;
        $this->classes  = (isset($data['classes']))  ? $data['classes']  : null;
        $this->jobs  = (isset($data['jobs']))  ? $data['jobs']  : null;
        $this->lodestoneid  = (isset($data['lodestoneid']))  ? $data['lodestoneid']  : null;
        $this->misc  = (isset($data['misc']))  ? $data['misc']  : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}





?>