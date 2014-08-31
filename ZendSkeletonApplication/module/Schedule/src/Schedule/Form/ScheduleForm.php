<?php
namespace Schedule\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

 class ScheduleForm extends Form
 {
     public function __construct($name = null, $reviewer, $reviewerTrainee, $replacement, $original, $designReviewer, $designReviewerTrainee, $timeReference)
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
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Reviewer*: ',
                    'value_options' => $reviewer,
                    'empty_option' => 'Please select reviewer'
            ),
        ));
        $this->add(array(
            'name' => 'traineebackupid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Trainee backup',
                    'value_options' => $reviewerTrainee,
                    'empty_option' => 'Please select trainee',
                    'disable_inarray_validator' => true,
            ),
        ));
        $this->add(array(
            'name' => 'replacementreviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Replacement',
                    'value_options' => $replacement,
                    'empty_option' => 'Please select who will replace the original',
                    'disable_inarray_validator' => true,
            ),
        ));
        $this->add(array(
            'name' => 'originalreviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Original',
                    'value_options' => $original,
                    'empty_option' => 'Please select original who is going to be replaced',
                    'disable_inarray_validator' => true,
            ),
        ));
        $this->add(array(
            'name' => 'designreviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Design reviewer',
                    'value_options' => $designReviewer,
                    'empty_option' => 'Please select design reviewer',
            ),
        ));
        $this->add(array(
            'name' => 'designtraineereviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Design reviewer trainee',
                    'value_options' => $designReviewerTrainee,
                    'empty_option' => 'Please select Design trainee',
                    'disable_inarray_validator' => true,
            ),
        ));
         $this->add(array(
             'name' => 'timereference',
             'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                    'label' => 'Time period *',
                    'value_options' => $timeReference,
                    'empty_option' => 'Please select Design trainee'
            ),
         ));
        $this->add(array(
             'name' => 'dateofschedule',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Date *',
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
