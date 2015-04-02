<?php
namespace CRApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

use Reviewerstime\Model\Reviewerstime;
use Reviewerstime\Model\ReviewerstimeMapper;
use Reviewerstime\Model\ReviewerstimeEntity;


class ApiTimeRefController extends AbstractRestfulController
{
    
    public function getTimeRefMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ReviewerstimeMapper');
    }
    
    public function getList()
    {   // Action used for GET requests without resource Id
        $arr = $this->getTimeRefMapper()->fetchReviewerstimeForSelect();
        return new JsonModel(array($arr));
    }
    
    public function create($data)
    {   
//        $result = $this->getScheduleMapper()->saveScheduleAPI($data['data']);
//        if ($result > 0) {
//            return new JsonModel(
//                array('result' => $result)
//            );
//        } else {
//            return new JsonModel(
//                array('result' => 'error')
//            );
//        }
    }

    public function update($id, $data)
    {   // Action used for PUT requests
//        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'Updated CR', 'band' => 'Updated Band')));
    }

    public function delete($id)
    {   // Action used for DELETE requests
//        return new JsonModel(array('data' => 'cr id 3 deleted'));
    }
}