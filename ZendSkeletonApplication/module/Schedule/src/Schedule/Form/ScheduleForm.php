<?php
namespace Schedule\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

 class ScheduleForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('schedule');
         
         $this->setAttribute('method', 'post');
         $this->setInputFilter(new ScheduleFilter());
         $this->setHydrator(new ClassMethods());
         
         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'Reviewer',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Reviewer',
             ),
         ));
         $this->add(array(
             'name' => 'datetimebegin',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Begin of schedule',
             ),
         ));
         $this->add(array(
             'name' => 'datetimeend',
             'type' => 'Text',
             'options' => array(
                 'label' => 'End of schedule',
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
