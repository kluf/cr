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
                        'id'     => '[0-9 a-zA-Z]+',
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
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\apiSchedule',
                    ),
                ),
            ),
            'apiTimeRef' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/apiTimeRef',
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\apiTimeRef',
                    ),
                ),
            ),
            'apiAuthors' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/apiAuthors',
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\apiAuthors',
                    ),
                ),
            ),
            'apiStates' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/apiStates',
                    'defaults' => array(
                        'controller' => 'CRApi\Controller\apiStates',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CRApi\Controller\Index' => 'CRApi\Controller\IndexController',
            'CRApi\Controller\CR' => 'CRApi\Controller\CRController',
            'CRApi\Controller\apiSchedule' => 'CRApi\Controller\CRScheduleController',
            'CRApi\Controller\apiTimeRef' => 'CRApi\Controller\ApiTimeRefController',
            'CRApi\Controller\apiAuthors' => 'CRApi\Controller\ApiAuthorsController',
            'CRApi\Controller\apiStates' => 'CRApi\Controller\ApiStatesController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);