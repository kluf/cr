<?php

 namespace Codereview\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Codereview\Model\Codereview;
 use Codereview\Form\CodereviewForm;
 
 class CodereviewController extends AbstractActionController
 {
    protected $codereviewTable;
    public $daysInWeek = 6;
    public $titleIndex = 'Codereview index page';
    public $titleAdd = 'Add new row to codereview';
    public $titleEdit = 'Edit row of codereview';
    public $titleRemove = 'Remove row from codereview';
    
    public function indexAction()
    {
        $message = $this->dateCounter();
        return new ViewModel(array(
            'codereviews' => $this->getCodereviewTable()->fetchFromCodereviewUsersState(), 'title' => $this->titleIndex, 'message' => $message
        ));
    }

     public function addAction()
     {
         $form = new CodereviewForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $codereview = new Codereview();
             $form->setInputFilter($codereview->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $codereview->exchangeArray($form->getData());
                 $this->getCodereviewTable()->saveCodereview($codereview);

                 // Redirect to list of codereviews
                 return $this->redirect()->toRoute('codereview');
             }
         }
//         var_dump($form);exit;
         return array('form' => $form);

     }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('codereview', array(
                 'action' => 'add'
             ));
         }
         try {
             $codereview = $this->getCodereviewTable()->getCodereviewForEdit($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('codereview', array(
                 'action' => 'index'
             ));
         }
         $form  = new CodereviewForm();
         $form->bind($codereview);
//         var_dump($codereview);exit;
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($codereview->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getCodereviewTable()->saveCodereview($codereview);

                 // Redirect to list of codereviews
                 return $this->redirect()->toRoute('codereview');
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
             return $this->redirect()->toRoute('codereview');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getCodereviewTable()->deleteCodereview($id);
             }

             // Redirect to list of codereviews
             return $this->redirect()->toRoute('codereview');
         }

         return array(
             'id'    => $id,
             'codereview' => $this->getCodereviewTable()->getCodereview($id)
         );
     }
     public function getCodereviewTable()
     {
         if (!$this->codereviewTable) {
             $sm = $this->getServiceLocator();
             $this->codereviewTable = $sm->get('Codereview\Model\CodereviewTable');
         }
         return $this->codereviewTable;
     }
     
     public function isDayInWeekend() {
         $currentDate = date("N");
         return (boolean)$currentDate === 6 || $currentDate === 7;
     }
     
     public function dateCounter() {
        date_default_timezone_set('Europe/Helsinki');
        $currentDate = date("N");
        $currentDateTextual = date('l');
        $daysLeftToWeekend;
        if ($this->isDayInWeekend()) {
            $daysLeftToWeekend = 0;
            $daysLeftToWeekend = ' thus now is Weekend, so none';
        }
        elseif ($currentDate < $this->daysInWeek) {
            $daysLeftToWeekend = $this->daysInWeek - $currentDate;
        }
        $message = "Today is ".$currentDateTextual." ".$daysLeftToWeekend." days left to weekend";
        return $message;
     }
     
 }

