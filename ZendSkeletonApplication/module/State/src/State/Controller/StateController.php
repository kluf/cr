<?php

namespace State\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use State\Model\State;
use State\Model\StateMapper;
use State\Model\StateEntity;
use State\Form\StateForm;

 class StateController extends AbstractActionController
 {
     
public function indexAction()
     {
         $mapper = $this->getStateMapper();
         return new ViewModel(array('state' => $mapper->fetchAll()));
     }
     
    public function getStateMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('StateMapper');
    }
    
    public function addAction()
    {
        $form = new StateForm();
        $state = new StateEntity();
        $form->bind($state);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getStateMapper()->saveState($state);

                // Redirect to list of tasks
                return $this->redirect()->toRoute('state');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('state', array('action'=>'add'));
        }
        $state = $this->getStateMapper()->getState($id);

        $form = new StateForm();
        $form->bind($state);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getStateMapper()->saveState($state);

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
        $id = $this->params('id');
        $state = $this->getStateMapper()->getState($id);
        if (!$state) {
            return $this->redirect()->toRoute('state');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getStateMapper()->deleteState($id);
            }

            return $this->redirect()->toRoute('state');
        }

        return array(
            'id' => $id,
            'state' => $state
        );
    }
 }