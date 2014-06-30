<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Usergroups\Controller\Usergroups' => 'Usergroups\Controller\UsergroupsController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'usergroups' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/usergroups[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Usergroups\Controller\Usergroups',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'usergroups' => __DIR__ . '/../view',
         ),
     ),
 );

