<?php

 namespace Users\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Users\Model\Users;
 use Users\Form\UsersForm;  

 class UsersController extends AbstractActionController
 {
     
    protected $usersTable;
     public function indexAction()
     {
        return new ViewModel(array(
            'users' => $this->getUsersTable()->fetchAll(),
        ));
     }

    public function addAction()
    {
       $form = new UsersForm();
       $form->get('submit')->setValue('Add');

       $request = $this->getRequest();
       if ($request->isPost()) {
          $users = new Users();
          $form->setInputFilter($users->getInputFilter());
          $form->setData($request->getPost());

          if ($form->isValid()) {
              $users->exchangeArray($form->getData());
              $this->getUsersTable()->saveUsers($users);

              // Redirect to list of userss
              return $this->redirect()->toRoute('users');
          }
       }
       return array('form' => $form);

    }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('users', array(
                 'action' => 'add'
             ));
         }

         // Get the Users with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $users = $this->getUsersTable()->getUsers($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('users', array(
                 'action' => 'index'
             ));
         }

         $form  = new UsersForm();
         $form->bind($users);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();    
         if ($request->isPost()) {
             $form->setInputFilter($users->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getUsersTable()->saveUsers($users);

                 // Redirect to list of userss
                 return $this->redirect()->toRoute('users');
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
            return $this->redirect()->toRoute('users');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getUsersTable()->deleteUsers($id);
            }

            // Redirect to list of userss
            return $this->redirect()->toRoute('users');
        }

        return array(
            'id'    => $id,
            'users' => $this->getUsersTable()->getUsers($id)
        );
     }
     
    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('Users\Model\UsersTable');
        }
        return $this->usersTable;
    }
 }