<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Codereview\Controller\Codereview' => 'Codereview\Controller\CodereviewController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'codereview' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/codereview[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Codereview\Controller\Codereview',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'codereview' => __DIR__ . '/../view',
         ),
     ),
 );

