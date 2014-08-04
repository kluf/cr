<?php

 namespace Schedule\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Schedule\Model\Schedule;
 use Schedule\Model\ScheduleMapper;
 use Schedule\Model\ScheduleEntity;
 use Schedule\Form\ScheduleForm;

 class ScheduleController extends AbstractActionController
 {
     
     public function indexAction()
     {
         $mapper = $this->getScheduleMapper();
         return new ViewModel(array('schedule' => $mapper->fetchScheduleWithUsers()));
     }
     
    public function getScheduleMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('ScheduleMapper');
    }
    
    public function addAction()
    {
        $form = new ScheduleForm();
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

        $form = new ScheduleForm();
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