<?php
namespace Schedule\Form;

 use Zend\Form\Form;

 class ScheduleForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('schedule');

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
             'name' => 'DateTimeBegin',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Begin of schedule',
             ),
         ));
         $this->add(array(
             'name' => 'DateTimeEnd',
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
