<?php
namespace State\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

 class StateForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('state');
         $this->setAttribute('method', 'post');
         $this->setInputFilter(new StateFilter());
         $this->setHydrator(new ClassMethods());

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'State',
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
