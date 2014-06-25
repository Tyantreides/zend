<?php

namespace Raidplan\Model;

use Zend\Db\TableGateway\TableGateway;

class EventsTable
{
    protected $tableGateway;
    protected $defaultDbAdapter;

    public function __construct(TableGateway $tableGateway, $defaultDbAdapter)
    {
        $this->tableGateway = $tableGateway;
        $this->defaultDbAdapter = $defaultDbAdapter;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function fetchEventsOfDateRangeAsJson($datefrom, $dateto){
        $datefrom = htmlentities($datefrom);
        $dateto = htmlentities($dateto);
        $statement = $this->defaultDbAdapter->query("SELECT * FROM ep_events WHERE datetime > '".$datefrom."' AND datetime < '".$dateto."';");
        $result = $statement->execute();
        return $result;
    }

    public function getEvents($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveEvents(Events $events)
    {
        $data = array(
            'titel' => $events->titel,
            'beschreibung'  => $events->beschreibung,
            'datetime'  => $events->datetime,
            'status'  => $events->status,
            'activityid'  => $events->activityid,
            'invited'  => $events->invited,
        );

        $id = (int) $events->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getEvents($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Events id does not exist');
            }
        }
    }

    public function deleteEvents($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

    public function fetchActivities(){
        $statement = $this->defaultDbAdapter->query('SELECT * FROM ep_activities;');
        $result = $statement->execute();
        return $result;
    }
}