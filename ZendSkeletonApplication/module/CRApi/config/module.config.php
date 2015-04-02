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
                'route'    => '/crapi/[:id]',
                    'constraints' => array(
                        'id'     => '[0-9a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\CR',
                    ),
                ),
            ),
            'cr1' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/crapi1[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9 a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\CR1',
                    ),
                ),
            ),
            'apiSchedule' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/apiSchedule',
//                    'constraints' => array(
//                        'id'     => '[0-9 a-zA-Z]+',
//                    ),
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\apiSchedule',
                    ),
                ),
            ),
            'apiTimeRef' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/apiTimeRef',
//                    'constraints' => array(
//                        'id'     => '[0-9 a-zA-Z]+',
//                    ),
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\apiTimeRef',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CRApi\Controller\Index' => 'CRApi\Controller\IndexController',
            'CRApi\Controller\CR' => 'CRApi\Controller\CRController',
            'CRApi\Controller\CR1' => 'CRApi\Controller\CR1Controller',
            'CRApi\Controller\apiSchedule' => 'CRApi\Controller\CRScheduleController',
            'CRApi\Controller\apiTimeRef' => 'CRApi\Controller\ApiTimeRefController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);