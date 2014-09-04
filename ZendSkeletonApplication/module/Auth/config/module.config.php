<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Auth\Controller\Auth' => 'Auth\Controller\AuthController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'auth' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/auth[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Auth\Controller\Auth',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'auth' => __DIR__ . '/../view',
         ),
     ),
 );

