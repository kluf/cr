<?php

 namespace Reviewerstime\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Reviewerstime\Model\Reviewerstime;
 use Reviewerstime\Model\ReviewerstimeMapper;
 use Reviewerstime\Model\ReviewerstimeEntity;
 use Reviewerstime\Form\ReviewerstimeForm;

use Usergroups\Model\Usergroups;
use Usergroups\Model\UsergroupsMapper;
use Usergroups\Model\UsergroupsEntity;
 
 class ReviewerstimeController extends AbstractActionController
 {
     
        public function indexAction()
     {
         $mapper = $this->getReviewerstimeMapper();
         return new ViewModel(array('reviewerstime' => $mapper->fetchReviewerstimeWithGroups()));
     }
     
    public function getReviewerstimeMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ReviewerstimeMapper');
    }
    
        public function getUserGroupsMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserGroupsMapper');
    }
    
    public function addAction()
    {
//        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $UserGroupsMapper = $this->getUserGroupsMapper();
        $userGroups = $UserGroupsMapper->fetchUsergroupsForSelect();
        $form = new ReviewerstimeForm(null, $userGroups);
        $reviewerstime = new ReviewerstimeEntity();
        $form->bind($reviewerstime);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getReviewerstimeMapper()->saveReviewerstime($reviewerstime);

                // Redirect to list of tasks
                return $this->redirect()->toRoute('reviewerstime');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('reviewerstime', array('action'=>'add'));
        }
        $reviewerstime = $this->getReviewerstimeMapper()->getReviewerstime($id);
        $UserGroupsMapper = $this->getUserGroupsMapper();
        $userGroups = $UserGroupsMapper->fetchUsergroupsForSelect($reviewerstime->groupid);
        $form = new ReviewerstimeForm(null, $userGroups);
        $form->bind($reviewerstime);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getReviewerstimeMapper()->saveReviewerstime($reviewerstime);

                return $this->redirect()->toRoute('reviewerstime');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function deleteAction()
    {
        $id = (int)$this->params('id');
        $reviewerstime = $this->getReviewerstimeMapper()->getReviewerstime($id);
        if (!$reviewerstime) {
            return $this->redirect()->toRoute('reviewerstime');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getReviewerstimeMapper()->deleteReviewerstime($id);
            }

            return $this->redirect()->toRoute('reviewerstime');
        }

        return array(
            'id' => $id,
            'reviewerstime' => $reviewerstime
        );
    }
 }