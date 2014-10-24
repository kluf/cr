<?php
namespace Users\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class UsersResetPassForm extends Form
{
    public function __construct($name = null, $users)
    {
        // we want to ignore the name passed
        //        $this->adapter =$dbAdapter;
        parent::__construct('users');
        $this->setAttribute('method', 'post');
        $this->setInputFilter(new UsersResetPassFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'userid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Users',
                    'value_options' => $users,
                    'empty_option' => 'Please select user'
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