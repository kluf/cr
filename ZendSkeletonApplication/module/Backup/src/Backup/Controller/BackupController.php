<?php

 namespace Backup\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Backup\Model\Backup;
 use Backup\Form\BackupForm;  

 class BackupController extends AbstractActionController
 {
     
    protected $backupTable;
     public function indexAction()
     {
        return new ViewModel(array(
            'backup' => $this->getBackupTable()->fetchAll(),
        ));
     }

    public function addAction()
    {
       $form = new BackupForm();
       $form->get('submit')->setValue('Add');

       $request = $this->getRequest();
       if ($request->isPost()) {
          $backup = new Backup();
          $form->setInputFilter($backup->getInputFilter());
          $form->setData($request->getPost());

          if ($form->isValid()) {
              $backup->exchangeArray($form->getData());
              $this->getBackupTable()->saveBackup($backup);

              // Redirect to list of backups
              return $this->redirect()->toRoute('backup');
          }
       }
       return array('form' => $form);

    }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('backup', array(
                 'action' => 'add'
             ));
         }

         // Get the Backup with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $backup = $this->getBackupTable()->getBackup($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('backup', array(
                 'action' => 'index'
             ));
         }

         $form  = new BackupForm();
         $form->bind($backup);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();    
         if ($request->isPost()) {
             $form->setInputFilter($backup->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getBackupTable()->saveBackup($backup);

                 // Redirect to list of backups
                 return $this->redirect()->toRoute('backup');
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
            return $this->redirect()->toRoute('backup');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getBackupTable()->deleteBackup($id);
            }

            // Redirect to list of backups
            return $this->redirect()->toRoute('backup');
        }

        return array(
            'id'    => $id,
            'backup' => $this->getBackupTable()->getBackup($id)
        );
     }
     
    public function getBackupTable()
    {
        if (!$this->backupTable) {
            $sm = $this->getServiceLocator();
            $this->backupTable = $sm->get('Backup\Model\BackupTable');
        }
        return $this->backupTable;
    }
 }