<?php

 namespace Usergroups\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Usergroups\Model\Usergroups;
 use Usergroups\Model\UsergroupsMapper;
 use Usergroups\Model\UsergroupsEntity;
 use Usergroups\Form\UsergroupsForm;

 class UsergroupsController extends AbstractActionController
 {
     
    public function indexAction()
     {
         $mapper = $this->getUsergroupsMapper();
         return new ViewModel(array('usergroups' => $mapper->fetchAll()));
     }
     
    public function getUsergroupsMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UsergroupsMapper');
    }
    
    public function addAction()
    {
        $form = new UsergroupsForm();
        $usergroups = new UsergroupsEntity();
        $form->bind($usergroups);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getUsergroupsMapper()->saveUsergroups($usergroups);

                // Redirect to list of tasks
                return $this->redirect()->toRoute('usergroups');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('usergroups', array('action'=>'add'));
        }
        $usergroups = $this->getUsergroupsMapper()->getUsergroups($id);

        $form = new UsergroupsForm();
        $form->bind($usergroups);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getUsergroupsMapper()->saveUsergroups($usergroups);

                return $this->redirect()->toRoute('usergroups');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function deleteAction()
    {
        $id = $this->params('id');
        $usergroups = $this->getUsergroupsMapper()->getUsergroups($id);
        if (!$usergroups) {
            return $this->redirect()->toRoute('usergroups');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getUsergroupsMapper()->deleteUsergroups($id);
            }

            return $this->redirect()->toRoute('usergroups');
        }

        return array(
            'id' => $id,
            'usergroups' => $usergroups
        );
    }
 }