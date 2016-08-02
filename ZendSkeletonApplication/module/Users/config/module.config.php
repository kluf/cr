<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Users\Controller\Users' => 'Users\Controller\UsersController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'users' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/users[/:action[/:id]][/:page]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'page' => '[0-9]+',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Users\Controller\Users',
                         'action'     => 'index',
                         'page' => 1,
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
        'template_path_stack' => array(
            'users' => __DIR__ . '/../view',
        ),
         'template_map' => array( 
            'paginator-slide-users' => __DIR__ . '/../view/users/users/slidePaginator.phtml',
        ),
     ),
 );

