<?php

namespace Codereview\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Codereview\Model\Codereview;
use Codereview\Model\CodereviewMapper;
use Codereview\Model\CodereviewEntity;

use Codereview\Form\CodereviewForm;
use Codereview\Form\CodereviewFindByTicketForm;
use Codereview\Form\CodereviewFindByUserForm;

use Users\Model\Users;
use Users\Model\UsersMapper;
use Users\Model\UsersEntity;

use State\Model\State;
use State\Model\StateMapper;
use State\Model\StateEntity;

use Schedule\Model\Schedule;
use Schedule\Model\ScheduleMapper;
use Schedule\Model\ScheduleEntity;

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
        $temp = $mapper->fetchCodereviewWithUsersAndStatesForPaginator();
        $tem = [];
        foreach ($temp as $key => $val) {
            $tem[$key] = $val;
        }
//        var_dump($tem);exit;
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($tem));
//        $paginator->setCurrentPageNumber($page);
//        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));   
        $sch = $this->getScheduleMapper();
        $vm =  new ViewModel(array(/*'codereviews' => $mapper->fetchCodereviewWithUsersAndStates(),*/ 'message' => $mapper->dateCounter(),
                'schedule' => $sch->fetchScheduleForCurrentDay()));
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $vm->setVariable('paginator', $paginator);
        return $vm;
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
    
    public function getScheduleMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ScheduleMapper');
    }
    
    public function addAction()
    {
        $newState = 1;
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
        $users = $this->getUsersMapper()->fetchUsersForSelect();
        $form = new CodereviewFindByUserForm(null, $users);
        if ($request->isPost() && $request->getPost('authorid')) {
            $authorid = $request->getPost('authorid');
            $startdate = $request->getPost('startdate');
            $enddate = $request->getPost('enddate');
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $codereview = $this->getCodereviewMapper()->getCodereviewByUser((int)$authorid, $startdate, $enddate);
                return new ViewModel(array('codereviews' => $codereview, 'form' => $form));
            }
            
        }
        return array(
           'form' => $form,
            'post' => $request->isPost(),
        );
    }
    
    public function findByTicketAction()
    {   
        $request = $this->getRequest();
        $jiraticket = $request->getPost('jiraticket');
        $form = new CodereviewFindByTicketForm(null);
        if ($request->isPost() && $request->getPost('jiraticket')) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $codereview = $this->getCodereviewMapper()->getCodereviewByTicket($jiraticket);
                return new ViewModel(array('codereviews' => $codereview, 'form' => $form));
            }
        }
        return array(
            'jiraticket' => $jiraticket,
            'form' => $form,
            'post' => $request->isPost()
        );
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