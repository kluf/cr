<?php
namespace Usergroups\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

 class UsergroupsForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('usergroups');
         $this->setAttribute('method', 'post');
         $this->setInputFilter(new UsergroupsFilter());
         $this->setHydrator(new ClassMethods());

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Name',
             ),
         ));
          $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
         
     }
 }
