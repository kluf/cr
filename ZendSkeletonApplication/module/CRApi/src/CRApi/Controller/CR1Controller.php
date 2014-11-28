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

use Codereview\Model\Codereview;
use Codereview\Model\CodereviewMapper;
use Codereview\Model\CodereviewEntity;

class CR1Controller extends AbstractRestfulController
{
    
    public function getCodereviewMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('CodereviewMapper');
    }
    
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
//        echo $this->params('id');exit;
//        $arr = [];
        if ((int)$id > 0) {
            $arr = $this->getCodereviewMapper()->getCodereviewApi($id);
        }
        return new JsonModel(array('result' => $arr));
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
        $result = $this->getCodereviewMapper()->saveCodereviewAPI($data['data']);
        if ($result > 0) {
            return new JsonModel(
                array('result' => $result)
            );
        } else {
            return new JsonModel(
                array('result' => 'error')
            );
        }
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