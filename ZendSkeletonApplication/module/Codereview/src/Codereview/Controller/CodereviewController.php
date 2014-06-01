<?php

 namespace Codereview\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

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
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
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

