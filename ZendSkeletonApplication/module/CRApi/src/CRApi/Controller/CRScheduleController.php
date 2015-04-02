<?php
namespace CRApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

use Schedule\Model\Schedule;
use Schedule\Model\ScheduleMapper;
use Schedule\Model\ScheduleEntity;


class CRScheduleController extends AbstractRestfulController
{
    
    public function getScheduleMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ScheduleMapper');
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
    
    public function create($data)
    {   // Action used for POST requests
        $result = $this->getScheduleMapper()->saveScheduleAPI($data['data']);
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