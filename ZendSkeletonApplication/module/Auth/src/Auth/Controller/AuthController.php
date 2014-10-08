<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthController
 *
 * @author vklyuf
 */
namespace Auth\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Auth\Model\Auth;
use Auth\Model\AuthMapper;
use Auth\Model\AuthEntity;
use Auth\Form\AuthForm;

use Users\Model\Users;
use Users\Model\UsersMapper;
use Users\Model\UsersEntity;

use Zend\Session\Storage\ArrayStorage;
use Zend\Session\SessionManager;
Use Zend\Session\Container;

class AuthController extends AbstractActionController
{
    public function indexAction() {
        return new ViewModel();
    }
    
    public function loginAction()
    {
        $form = new AuthForm(null);
        $auth = new AuthEntity();
        $form->bind($auth);
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $userMapper = $this->getUsersMapper();
                $userExists = $userMapper->fetchUserForLoginAction($request->getPost('ldap'), $request->getPost('password'));
                if ($userExists) {
                    $auth = $this->getAuthMapper();
                    $auth->setUsersSesstion($userExists);
//                    $session = new Container('currentUser');
//                    var_dump($session->getManager()->getStorage());exit;
                    
                    return $this->redirect()->toRoute('auth', array('action'=>'index'));
                } else {
                    $errorMessage = 'User or password don\'t match';
                    return $this->redirect()->toRoute('auth', array('action'=>'login'));
                }   
//                return $this->redirect()->toRoute('users');
            } else {
                $error = 'Wrong username or password';
                return array('form' => $form, 'error' => $error);
            }
        }
        return array('form' => $form);
    }
 
    public function getUsersMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('UsersMapper');
    }
    
    public function getAuthMapper()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('AuthMapper');
    }
    
    public function logoutAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->_redirect('index/index');
     }
}

?>
