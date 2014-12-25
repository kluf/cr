<?php
namespace Codereview\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class CodereviewFindByUserForm extends Form
{
    public function __construct($name = null, $users)
    {

        // we want to ignore the name passed
        parent::__construct('codereview');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new CodereviewFindByUserFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'authorid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'User',
                    'value_options' => $users,
                    'empty_option' => 'Please select user'
            ),
            'attributes' => array(
                'class' => 'authorid form-control'
            ),
        ));
        
        $this->add(array(
            'name' => 'startdate',
            'type' => 'date',
            'options' => array(
                'label' => 'Start date',
            ),
            'attributes' => array(
                'class' => 'startdate form-control'
            ),
        ));
       
        $this->add(array(
            'name' => 'enddate',
            'type' => 'date',
            'options' => array(
                'label' => 'End date',
            ),
            'attributes' => array(
                'class' => 'enddate form-control'
            ),
        ));
       
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Find',
                'id' => 'submitbutton',
                'class' => 'btn btn-info'
            ),
        ));
        $this->get('startdate')->setFormat('m-d-Y');
        $this->get('enddate')->setFormat('m-d-Y');
    }
 }

