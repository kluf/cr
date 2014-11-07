<?php

return array(
    'router' => array(
        'routes' => array(
            'crapi' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/CRApi',
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\Index',
                    ),
                ),
            ),
            'cr' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/crapi[/:id]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\CR',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CRApi\Controller\Index' => 'CRApi\Controller\IndexController',
            'CRApi\Controller\CR' => 'CRApi\Controller\CRController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);