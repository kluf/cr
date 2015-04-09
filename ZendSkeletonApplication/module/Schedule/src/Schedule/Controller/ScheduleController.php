<?php

namespace Schedule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Schedule\Model\Schedule;
use Schedule\Model\ScheduleMapper;
use Schedule\Model\ScheduleEntity;
use Schedule\Form\ScheduleForm;

use Reviewerstime\Model\Reviewerstime;
use Reviewerstime\Model\ReviewerstimeMapper;
use Reviewerstime\Model\ReviewerstimeEntity;

 use Users\Model\UsersMapper;
 use Users\Model\UsersEntity;
 use Users\Form\UsersForm;

 class ScheduleController extends AbstractActionController
 {
     
    public function indexAction()
    {
        $mapper = $this->getScheduleMapper();
//        var_dump($mapper->fetchScheduleWithUsers());exit;
        return new ViewModel(array('schedule' => $mapper->fetchScheduleWithUsers()));
    }
     
    public function getScheduleMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ScheduleMapper');
    }
    
    public function getUsersMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UsersMapper');
    }
    
    public function getReviewerstimeMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ReviewerstimeMapper');
    }
    
    public function addAction()
    {
        $UsersMapper = $this->getUsersMapper();
        $timeReferenceMapper = $this->getReviewerstimeMapper();
        $timeReference = $timeReferenceMapper->fetchReviewerstimeForSelect();
        $reviewer = $UsersMapper->fetchUsersForSelect();
        $traineebackupid = $UsersMapper->fetchUsersForSelect();
        $replacement = $UsersMapper->fetchUsersForSelect();
        $original = $UsersMapper->fetchUsersForSelect();
        $designReviewer = $UsersMapper->fetchUsersForSelect();
        $designReviewerTrainee = $UsersMapper->fetchUsersForSelect();
        
        $form = new ScheduleForm(null, $reviewer, $traineebackupid, $replacement, $original, $designReviewer, $designReviewerTrainee, $timeReference);
        $schedule = new ScheduleEntity();
        $form->bind($schedule);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getScheduleMapper()->saveSchedule($schedule);

                // Redirect to list of tasks
                return $this->redirect()->toRoute('schedule');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('schedule', array('action'=>'add'));
        }
        
        $schedule = $this->getScheduleMapper()->getSchedule($id);
        $UsersMapper = $this->getUsersMapper();
        $timeReferenceMapper = $this->getReviewerstimeMapper();
        $timeReference = $timeReferenceMapper->fetchReviewerstimeForSelect();
        $reviewer = $UsersMapper->fetchUsersForSelect($schedule->reviewer);
        $traineebackupid = $UsersMapper->fetchUsersForSelect($schedule->traineebackupid);
        $replacement = $UsersMapper->fetchUsersForSelect($schedule->replacementreviewerid);
        $original = $UsersMapper->fetchUsersForSelect($schedule->originalreviewerid);
        $designReviewer = $UsersMapper->fetchUsersForSelect($schedule->designreviewerid);
        $designReviewerTrainee = $UsersMapper->fetchUsersForSelect($schedule->designtraineereviewerid);
        
        $form = new ScheduleForm(null, $reviewer, $traineebackupid, $replacement, $original, $designReviewer, $designReviewerTrainee, $timeReference);
        
        
        $form->bind($schedule);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getScheduleMapper()->saveSchedule($schedule);

                return $this->redirect()->toRoute('schedule');
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
        $schedule = $this->getScheduleMapper()->getSchedule($id);
        if (!$schedule) {
            return $this->redirect()->toRoute('schedule');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getScheduleMapper()->deleteSchedule($id);
            }

            return $this->redirect()->toRoute('schedule');
        }

        return array(
            'id' => $id,
            'schedule' => $schedule
        );
    }
 }