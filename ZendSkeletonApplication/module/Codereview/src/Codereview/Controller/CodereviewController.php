<?php

namespace Codereview\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Codereview\Model\Codereview;
use Codereview\Model\CodereviewMapper;
use Codereview\Model\CodereviewEntity;
use Codereview\Form\CodereviewForm;

use Users\Model\Users;
use Users\Model\UsersMapper;
use Users\Model\UsersEntity;

use State\Model\State;
use State\Model\StateMapper;
use State\Model\StateEntity;

class CodereviewController extends AbstractActionController
{
   protected $codereviewTable;
   public $titleIndex = 'Codereview index page';
   public $titleAdd = 'Add new row to codereview';
   public $titleEdit = 'Edit row of codereview';
   public $titleRemove = 'Remove row from codereview';

   public function indexAction()
    {
        $mapper = $this->getCodereviewMapper();
        return new ViewModel(array('codereviews' => $mapper->fetchCodereviewWithUsersAndStates(), 'message' => $mapper->dateCounter()));
    }
     
    public function getCodereviewMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('CodereviewMapper');
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
    
    public function addAction()
    {
        $newState = 1;
//        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $usersMapper = $this->getUsersMapper();
        $statesMapper = $this->getStatesMapper();
        $users = $usersMapper->fetchUsersForSelect();
        $states = $statesMapper->fetchStatesForSelect($newState);
        $form = new CodereviewForm(null, $users, $states, $reviewers = $usersMapper->fetchUsersForSelect());
        $codereview = new CodereviewEntity();
        $form->bind($codereview);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getCodereviewMapper()->saveCodereview($codereview);

                // Redirect to list of tasks
                return $this->redirect()->toRoute('codereview');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('codereview', array('action'=>'add'));
        }
        $codereview = $this->getCodereviewMapper()->getCodereview($id);
        $usersMapper = $this->getUsersMapper();
        $statesMapper = $this->getStatesMapper($codereview->stateid);
        $states = $statesMapper->fetchStatesForSelect();
        $users = $usersMapper->fetchUsersForSelect($codereview->authorid);
        $reviewers = $usersMapper->fetchUsersForSelect($codereview->reviewerid);
        $form = new CodereviewForm(null, $users, $states, $reviewers);
        $form->bind($codereview);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getCodereviewMapper()->saveCodereview($codereview);

                return $this->redirect()->toRoute('codereview');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function findByUserAction()
    {
        $request = $this->getRequest();
        if ($request->isGet()) {
            $usersMapper = $this->getUsersMapper();
            $users = $usersMapper->fetchUsersForSelect();
//            var_dump($users);exit;
            if ($request->getQuery('userid')) {
                $user = $request->getQuery('userid');
                $mapper = $this->getCodereviewMapper();
                $codereviews = $mapper->getCodereviewByUser((int)$user);
                return new ViewModel(array('users' => $users, 'codereviews' => $codereviews));
            }
            return new ViewModel(array('users' => $users));
        }
    }
    
        public function findByTicketAction()
    {
        $request = $this->getRequest();
//        var_dump($request->getQuery('userid'));
        if ($request->isGet()) {
            if ($request->getQuery('jiraticket')) {
                $user = $request->getQuery('jiraticket');
                $mapper = $this->getCodereviewMapper();
                $codereviews = $mapper->getCodereviewByTicket($request->getQuery('jiraticket'));
                return new ViewModel(array('codereviews' => $codereviews));
            }
//            return new ViewModel(array('users' => $selectData));
        }
    }
    
    public function deleteAction()
    {
        $id = $this->params('id');
        $codereview = $this->getCodereviewMapper()->getCodereview($id);
        if (!$codereview) {
            return $this->redirect()->toRoute('codereview');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getCodereviewMapper()->deleteCodereview($id);
            }

            return $this->redirect()->toRoute('codereview');
        }

        return array(
            'id' => $id,
            'codereview' => $codereview
        );
    }
}