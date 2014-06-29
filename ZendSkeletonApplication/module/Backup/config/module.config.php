<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Backup\Controller\Backup' => 'Backup\Controller\BackupController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'backup' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/backup[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Backup\Controller\Backup',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'backup' => __DIR__ . '/../view',
         ),
     ),
 );

