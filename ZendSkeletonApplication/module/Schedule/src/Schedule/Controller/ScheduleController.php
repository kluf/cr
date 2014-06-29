<?php

 namespace Schedule\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Schedule\Model\Schedule;
 use Schedule\Form\ScheduleForm;  

 class ScheduleController extends AbstractActionController
 {
     
    protected $scheduleTable;
     public function indexAction()
     {
        return new ViewModel(array(
            'schedule' => $this->getScheduleTable()->fetchAll(),
        ));
     }

    public function addAction()
    {
       $form = new ScheduleForm();
       $form->get('submit')->setValue('Add');

       $request = $this->getRequest();
       if ($request->isPost()) {
          $schedule = new Schedule();
          $form->setInputFilter($schedule->getInputFilter());
          $form->setData($request->getPost());

          if ($form->isValid()) {
              $schedule->exchangeArray($form->getData());
              $this->getScheduleTable()->saveSchedule($schedule);

              // Redirect to list of schedules
              return $this->redirect()->toRoute('schedule');
          }
       }
       return array('form' => $form);

    }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('schedule', array(
                 'action' => 'add'
             ));
         }

         // Get the Schedule with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $schedule = $this->getScheduleTable()->getSchedule($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('schedule', array(
                 'action' => 'index'
             ));
         }

         $form  = new ScheduleForm();
         $form->bind($schedule);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();    
         if ($request->isPost()) {
             $form->setInputFilter($schedule->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getScheduleTable()->saveSchedule($schedule);

                 // Redirect to list of schedules
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
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('schedule');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getScheduleTable()->deleteSchedule($id);
            }

            // Redirect to list of schedules
            return $this->redirect()->toRoute('schedule');
        }

        return array(
            'id'    => $id,
            'schedule' => $this->getScheduleTable()->getSchedule($id)
        );
     }
     
    public function getScheduleTable()
    {
        if (!$this->scheduleTable) {
            $sm = $this->getServiceLocator();
            $this->scheduleTable = $sm->get('Schedule\Model\ScheduleTable');
        }
        return $this->scheduleTable;
    }
 }