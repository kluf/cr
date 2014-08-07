<?php

 namespace Users\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Users\Model\Users;
 use Users\Model\UsersMapper;
 use Users\Model\UsersEntity;
 use Users\Form\UsersForm;

 class UsersController extends AbstractActionController
 {
     
        public function indexAction()
     {
         $mapper = $this->getUsersMapper();
         return new ViewModel(array('users' => $mapper->fetchUsersWithGroups()));
     }
     
    public function getUsersMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UsersMapper');
    }
    
    public function addAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new UsersForm(null, $dbAdapter);
        $users = new UsersEntity();
        $form->bind($users);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getUsersMapper()->saveUsers($users);

                // Redirect to list of tasks
                return $this->redirect()->toRoute('users');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('users', array('action'=>'add'));
        }
        $users = $this->getUsersMapper()->getUsers($id);
        $form = new UsersForm(null, $dbAdapter, $users->groupid);
        $form->bind($users);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getUsersMapper()->saveUsers($users);

                return $this->redirect()->toRoute('users');
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
        $users = $this->getUsersMapper()->getUsers($id);
        if (!$users) {
            return $this->redirect()->toRoute('users');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getUsersMapper()->deleteUsers($id);
            }

            return $this->redirect()->toRoute('users');
        }

        return array(
            'id' => $id,
            'users' => $users
        );
    }
 }