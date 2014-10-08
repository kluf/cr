<?php

namespace Auth\Model;

use Zend\Db\Adapter\Adapter;
use Auth\Model\AuthEntity;

//use Zend\Session\Config\StandardConfig;
//use Zend\Session\SessionManager;
//use Zend\Session\Container;
//
//use Zend\Session\Storage\ArrayStorage;
//use Zend\Session\SessionManager;

use Zend\Session\Container;

class AuthMapper
{
    public function setUsersSesstion($user) 
    {
//        var_dump($user);exit;
        $container = new Container('currentUser');
        $container->id = $user['id'];
        $container->ldap = $user['ldap'];
        $container->email = $user['email'];
        $container->groupid = $user['groupid'];
        $container->groupname = $user['groupname'];
//        var_dump($_SESSION);exit;
//        var_dump($container);exit;
        
//        $populateStorage = [];
//        foreach($userExists as $key => $value) {
//            $populateStorage[$key] = $value;
//        }
//        $populateStorage = array(
//            "id" => $userExists->id,
//            "ldap" => $userExists->ldap,
//            "groupid" => $userExists->groupid
//        );
//        $storage         = new ArrayStorage($populateStorage);
//        $manager         = new SessionManager();
//        $manager->setStorage($storage);
//        $config = new StandardConfig();
//        $config->setOptions(array(
//            'remember_me_seconds' => 1800,
//            'name'                => 'zf2',
//        ));
//        $manager = new SessionManager($config);
//        $manager->setName('test');
//        $container = new Container('auth');
//        $container->item = 'id';
//        $container->item = 'ldap';
//        $container->item = 'groupid';
//        Container::setDefaultManager($manager);
//        return $manager;
    }
}