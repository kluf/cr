<?php
namespace Users\Form;

 use Zend\Form\Form;

 class UsersForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('users');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'ldap',
             'type' => 'Text',
             'options' => array(
                 'label' => 'LDAP',
             ),
         ));
        $this->add(array(
             'name' => 'email',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Email',
             ),
         ));
        $this->add(array(
             'name' => 'password',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Type a password',
             ),
         ));
        $this->add(array(
             'name' => 'groupid',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Group',
             ),
         ));
        $this->add(array(
             'name' => 'name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Group',
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
