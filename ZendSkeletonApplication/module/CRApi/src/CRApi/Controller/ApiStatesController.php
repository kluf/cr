<?php
namespace CRApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

use State\Model\State;
use State\Model\StateMapper;
use State\Model\StateEntity;

class ApiStatesController extends AbstractRestfulController
{
    
    public function getStatesMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('StateMapper');
    }
    
    public function getList()
    {   // Action used for GET requests without resource Id
        $arr = $this->getStatesMapper()->fetchStatesForSelect();
        return new JsonModel($arr);
    }

}