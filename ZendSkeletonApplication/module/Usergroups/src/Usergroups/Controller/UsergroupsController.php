<?php

 namespace Usergroups\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Usergroups\Model\Usergroups;
 use Usergroups\Form\UsergroupsForm;  

 class UsergroupsController extends AbstractActionController
 {
     
    protected $usergroupsTable;
     public function indexAction()
     {
        return new ViewModel(array(
            'usergroups' => $this->getUsergroupsTable()->fetchAll(),
        ));
     }

    public function addAction()
    {
       $form = new UsergroupsForm();
       $form->get('submit')->setValue('Add');

       $request = $this->getRequest();
       if ($request->isPost()) {
          $usergroups = new Usergroups();
          $form->setInputFilter($usergroups->getInputFilter());
          $form->setData($request->getPost());

          if ($form->isValid()) {
              $usergroups->exchangeArray($form->getData());
              $this->getUsergroupsTable()->saveUsergroups($usergroups);

              // Redirect to list of usergroupss
              return $this->redirect()->toRoute('usergroups');
          }
       }
       return array('form' => $form);

    }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('usergroups', array(
                 'action' => 'add'
             ));
         }

         // Get the Usergroups with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $usergroups = $this->getUsergroupsTable()->getUsergroups($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('usergroups', array(
                 'action' => 'index'
             ));
         }

         $form  = new UsergroupsForm();
         $form->bind($usergroups);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();    
         if ($request->isPost()) {
             $form->setInputFilter($usergroups->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getUsergroupsTable()->saveUsergroups($usergroups);

                 // Redirect to list of usergroupss
                 return $this->redirect()->toRoute('usergroups');
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
            return $this->redirect()->toRoute('usergroups');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getUsergroupsTable()->deleteUsergroups($id);
            }

            // Redirect to list of usergroupss
            return $this->redirect()->toRoute('usergroups');
        }

        return array(
            'id'    => $id,
            'usergroups' => $this->getUsergroupsTable()->getUsergroups($id)
        );
     }
     
    public function getUsergroupsTable()
    {
        if (!$this->usergroupsTable) {
            $sm = $this->getServiceLocator();
            $this->usergroupsTable = $sm->get('Usergroups\Model\UsergroupsTable');
        }
        return $this->usergroupsTable;
    }
 }