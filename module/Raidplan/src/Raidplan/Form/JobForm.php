<?php
namespace Raidplan\Form;

use Raidplan\Model\PlayersTable;
use Raidplan\Model\JobsTable;
use Zend\Filter\Null;
use Zend\Form\Form;

class JobForm extends Form
{

    private $jobTable;
    private $playerTable;

    public function __construct($playerId = null, PlayersTable $playersTable = null, JobsTable $jobsTable = null)
    {
        // we want to ignore the name passed
        parent::__construct('job');

        if (isset($playerId) && $playerId != NULL) {
            $this->setJobTable($jobsTable);
            $this->setPlayerTable($playersTable);
            return $this->getJobListByPlayerId($playerId);
        }
    }

    private function getJobListByPlayerId($playerId){
        $player = $this->getPlayerTable()->getPlayers($playerId);
        $jobs = $this->getJobTable()->fetchAll();

        $jobData = array();
        foreach ($jobs as $selectOption) {
            $jobData[$player->id] = $selectOption->jobname;
        }
        return $jobData;
    }

    private function setJobTable(JobsTable $table) {
        $this->jobTable = $table;
    }

    private function setPlayerTable(PlayersTable $table) {
        $this->playerTable = $table;
    }

    private function getPlayerTable() {
        return $this->playerTable;
    }

    private function getJobTable() {
        return $this->jobTable;
    }

}