<?php

namespace Raidplan\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RaidplanController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

