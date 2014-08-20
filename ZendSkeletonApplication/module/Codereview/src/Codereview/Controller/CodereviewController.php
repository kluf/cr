<?php

namespace Codereview\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Codereview\Model\Codereview;
use Codereview\Model\CodereviewMapper;
use Codereview\Model\CodereviewEntity;
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
        $mapper = $this->getCodereviewMapper();
        return new ViewModel(array('codereviews' => $mapper->fetchCodereviewWithUsersAndStates(), 'message' => $this->dateCounter()));
    }
     
    public function getCodereviewMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('CodereviewMapper');
    }
    
    public function addAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new CodereviewForm(null, $dbAdapter);
        $codereview = new CodereviewEntity();
        $form->bind($codereview);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getCodereviewMapper()->saveCodereview($codereview);

                // Redirect to list of tasks
                return $this->redirect()->toRoute('codereview');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('codereview', array('action'=>'add'));
        }
        $codereview = $this->getCodereviewMapper()->getCodereview($id);
//        var_dump($codereview);exit;
        $form = new CodereviewForm(null, $dbAdapter, $options = array('reviewer' => $codereview->reviewerid, 'author' => $codereview->authorid, 'state' => $codereview->stateid));
        $form->bind($codereview);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getCodereviewMapper()->saveCodereview($codereview);

                return $this->redirect()->toRoute('codereview');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function findByUserAction()
    {
        $request = $this->getRequest();
//        var_dump($request->getQuery('userid'));
        if ($request->isGet()) {
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $sql       = "SELECT * FROM users";
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
            $selectData = array();
            foreach ($result as $res) {
                $selectData[] = array('id' => $res['id'], 'ldap' => $res['ldap']);
            }
            if ($request->getQuery('userid')) {
                $user = $request->getQuery('userid');
                $mapper = $this->getCodereviewMapper();
                $codereviews = $mapper->getCodereviewByUser((int)$user);
                return new ViewModel(array('users' => $selectData, 'codereviews' => $codereviews));
            }
            return new ViewModel(array('users' => $selectData));
        }
    }
    
    public function deleteAction()
    {
        $id = $this->params('id');
        $codereview = $this->getCodereviewMapper()->getCodereview($id);
        if (!$codereview) {
            return $this->redirect()->toRoute('codereview');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getCodereviewMapper()->deleteCodereview($id);
            }

            return $this->redirect()->toRoute('codereview');
        }

        return array(
            'id' => $id,
            'codereview' => $codereview
        );
    }

    public function isDayInWeekend() {
        $currentDate = date("N");
        $saturday = 6;
        $sunday = 7;
        return (boolean)$currentDate === $saturday || $currentDate === $sunday;
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