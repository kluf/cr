<?php

 namespace Users\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Zend\Json\Json;
 use Users\Model\Users;
 use Users\Model\UsersMapper;
 use Users\Model\UsersEntity;
 use Users\Form\UsersForm;
 use Users\Form\UsersResetPassForm;
 use Users\Form\UsersLoginForm;

use Usergroups\Model\Usergroups;
use Usergroups\Model\UsergroupsMapper;
use Usergroups\Model\UsergroupsEntity;
 

class UsersController extends AbstractActionController
 {
     
    public function indexAction()
    {
        $mapper = $this->getUsersMapper();
        $temp = $mapper->fetchUsersWithGroupsPaginator();
        $tem = [];
        foreach ($temp as $key => $val) {
            $tem[$key] = $val;
        }
        $paginatorUsers = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($tem));
        $vm1 =  new ViewModel();
        $paginatorUsers->setCurrentPageNumber($this->params()->fromRoute('page'));
        $vm1->setVariable('paginatorUsers', $paginatorUsers);
        return $vm1;
    }
     
    public function getUsersMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UsersMapper');
    }
    
        public function getUserGroupsMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UserGroupsMapper');
    }
    
    public function addAction()
    {
        $UserGroupsMapper = $this->getUserGroupsMapper();
        $userGroups = $UserGroupsMapper->fetchUsergroupsForSelect();
        $form = new UsersLoginForm(null, $userGroups);
        $users = new UsersEntity();
        $form->bind($users);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getUsersMapper()->saveUsers($users);
                // Redirect to auth
                $form->customErrMessage = 'Probably username is already taken by someone else';
                return array('form' => $form);
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('users', array('action'=>'add'));
        }
        $users = $this->getUsersMapper()->getUsers($id);
        $UserGroupsMapper = $this->getUserGroupsMapper();
        $userGroups = $UserGroupsMapper->fetchUsergroupsForSelect($users->groupid);
        $form = new UsersForm(null, $userGroups);
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
    
    public function resetPasswordAction()
    {
        $usersNewPassword = '';
        $request = $this->getRequest();
        $users = $this->getUsersMapper()->fetchUsersForSelect();
        $form = new UsersResetPassForm(null, $users);
        if ($request->isPost() && $request->getPost('userid')) {
            $id = $request->getPost('userid');
            $userToUpdate = $this->getUsersMapper()->getUsers($id);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $usersNewPassword = $this->getUsersMapper()->resetPasswordForUser($userToUpdate);
//                return $this->redirect()->toRoute('users');
            }
        }
        $form->temporaryPassword = $usersNewPassword;
        return array(
           'form' => $form,
        );
    }
    
//    public function apiGetUsersForSelectAction() {
//        $users = $this->getUsersMapper()->fetchUsersForSelect();
//        echo \Zend\Json\Json::encode($users);exit;
//    }
    
    public function apiGetReviewersForSelect() {
        
    }
 }