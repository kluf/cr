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
 use Users\Model\Users;
 use Users\Model\UsersMapper;
 use Users\Model\UsersEntity;
 use Auth\Form\AuthForm;

use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
 
class AuthController extends AbstractActionController
{
    
    public function indexAction() {
        $params = array('ldap' => 'test', 'groupid' => '2', 'email' => 'some@go.com');
        $config = new StandardConfig();
        $config->setOptions(array(
            'remember_me_seconds' => 3600,
            'name'                => array('ldap' => $params->ldap, 'groupid' => $params->groupid, 'email' => $params->email),
            'use_cookies' => true,
            'cookie_httponly' => true
        ));
        $manager = new SessionManager($config);
        return new ViewModel(array('usersParams' => $parasms));
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
                $userExists = $userMapper->fetchUsersForLoginAction($request->getPost('ldap'), $request->getPost('password'));
                if ($userExists) {
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
    
    public function logoutAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->_redirect('index/index');
     }
}

?>
