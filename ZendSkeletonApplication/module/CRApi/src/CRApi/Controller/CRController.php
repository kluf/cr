<?php
namespace CRApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

use Users\Model\Users;
use Users\Model\UsersMapper;
use Users\Model\UsersEntity;

use State\Model\State;
use State\Model\StateMapper;
use State\Model\StateEntity;

use Schedule\Model\Schedule;
use Schedule\Model\ScheduleMapper;
use Schedule\Model\ScheduleEntity;

class CRController extends AbstractRestfulController
{
    public function getList()
    {   // Action used for GET requests without resource Id
        return new JsonModel(
            array('data' =>
                array(
                    array('id'=> 1, 'name' => 'Mothership', 'band' => 'Led Zeppelin'),
                    array('id'=> 2, 'name' => 'Coda',       'band' => 'Led Zeppelin'),
                )
            )
        );
    }

    public function getUsersMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UsersMapper');
    }
    
    public function getStatesMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('StateMapper');
    }
    
    public function get($id)
    {   // Action used for GET requests with resource Id
        $arr = [];
        switch ($id) {
            case 'authors': $arr = $this->getAuthors();
                break;
            case 'reviewers': $arr = $this->getReviewers();
                break;
            case 'states': $arr = $this->getStates();
                break;
            default: $arr = array('err' => 'something goes wrong');
        }
        return new JsonModel($arr);
    }

    public function getAuthors()
    {
        return $this->getUsersMapper()->fetchUsersForSelect();
    }

    public function getReviewers()
    {
        return $this->getUsersMapper()->fetchUsersForSelect();
    }

    public function getStates()
    {
        return $this->getStatesMapper()->fetchStatesForSelect();
    }
    
    public function create($data)
    {   // Action used for POST requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New CR', 'band' => 'New Band')));
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'Updated CR', 'band' => 'Updated Band')));
    }

    public function delete($id)
    {   // Action used for DELETE requests
        return new JsonModel(array('data' => 'cr id 3 deleted'));
    }
}