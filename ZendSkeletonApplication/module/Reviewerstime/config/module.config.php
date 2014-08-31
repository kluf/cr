<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Reviewerstime\Controller\Reviewerstime' => 'Reviewerstime\Controller\ReviewerstimeController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'reviewerstime' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/reviewerstime[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Reviewerstime\Controller\Reviewerstime',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'reviewerstime' => __DIR__ . '/../view',
         ),
     ),
 );

