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
                     'route'    => '/codereview[/:action[/:id]][/:page]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'page' => '[0-9]+',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Codereview\Controller\Codereview',
                         'action'     => 'index',
                         'page' => 1,
                     ),
                 ),
             ),
            ),
        ),

     'view_manager' => array(
         'template_path_stack' => array(
             'codereview' => __DIR__ . '/../view',
         ),
         'template_map' => array( 
            'paginator-slide' => __DIR__ . '/../view/codereview/codereview/slidePaginator.phtml',
        ),
     ),
 );

