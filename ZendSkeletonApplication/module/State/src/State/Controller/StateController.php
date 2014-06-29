<?php

 namespace State\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use State\Model\State;
 use State\Form\StateForm;  

 class StateController extends AbstractActionController
 {
     
    protected $stateTable;
     public function indexAction()
     {
        return new ViewModel(array(
            'state' => $this->getStateTable()->fetchAll(),
        ));
     }

    public function addAction()
    {
       $form = new StateForm();
       $form->get('submit')->setValue('Add');

       $request = $this->getRequest();
       if ($request->isPost()) {
          $state = new State();
          $form->setInputFilter($state->getInputFilter());
          $form->setData($request->getPost());

          if ($form->isValid()) {
              $state->exchangeArray($form->getData());
              $this->getStateTable()->saveState($state);

              // Redirect to list of states
              return $this->redirect()->toRoute('state');
          }
       }
       return array('form' => $form);

    }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('state', array(
                 'action' => 'add'
             ));
         }

         // Get the State with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $state = $this->getStateTable()->getState($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('state', array(
                 'action' => 'index'
             ));
         }

         $form  = new StateForm();
         $form->bind($state);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();    
         if ($request->isPost()) {
             $form->setInputFilter($state->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getStateTable()->saveState($state);

                 // Redirect to list of states
                 return $this->redirect()->toRoute('state');
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
            return $this->redirect()->toRoute('state');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getStateTable()->deleteState($id);
            }

            // Redirect to list of states
            return $this->redirect()->toRoute('state');
        }

        return array(
            'id'    => $id,
            'state' => $this->getStateTable()->getState($id)
        );
     }
     
    public function getStateTable()
    {
        if (!$this->stateTable) {
            $sm = $this->getServiceLocator();
            $this->stateTable = $sm->get('State\Model\StateTable');
        }
        return $this->stateTable;
    }
 }