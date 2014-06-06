<?php

 namespace Codereview\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Codereview\Model\Codereview;
 use Codereview\Form\CodereviewForm;
 
 class CodereviewController extends AbstractActionController
 {
    protected $codereviewTable;
     public function indexAction()
     {
         return new ViewModel(array(
             'codereviews' => $this->getCodereviewTable()->fetchAll(), 'title' => 'Codereview'
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

         // Get the Codereview with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $codereview = $this->getCodereviewTable()->getCodereview($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('codereview', array(
                 'action' => 'index'
             ));
         }

         $form  = new CodereviewForm();
         $form->bind($codereview);
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
     
 }

