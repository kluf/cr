<?php
namespace CRApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

use Users\Model\Users;
use Users\Model\UsersMapper;
use Users\Model\UsersEntity;

class ApiAuthorsController extends AbstractRestfulController
{
    
    public function getUsersMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UsersMapper');
    }
    
    public function getList()
    {   // Action used for GET requests without resource Id
        $arr = $this->getUsersMapper()->fetchUsersForSelect();
        return new JsonModel($arr);
    }

}