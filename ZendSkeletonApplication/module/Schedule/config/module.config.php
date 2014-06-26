<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Schedule\Controller\Schedule' => 'Schedule\Controller\ScheduleController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'schedule' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/schedule[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Schedule\Controller\Schedule',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'schedule' => __DIR__ . '/../view',
         ),
     ),
 );

