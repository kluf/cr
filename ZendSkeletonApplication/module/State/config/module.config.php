<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'State\Controller\State' => 'State\Controller\StateController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'state' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/state[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'State\Controller\State',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'state' => __DIR__ . '/../view',
         ),
     ),
 );

