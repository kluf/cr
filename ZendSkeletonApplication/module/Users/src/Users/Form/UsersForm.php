<?php
namespace Users\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;
class UsersForm extends Form
{
    protected $adapter;
    public function __construct($name = null, $userGroups)
    {
        // we want to ignore the name passed
//        $this->adapter =$dbAdapter;
        parent::__construct('users');
        $this->setAttribute('method', 'post');
        $this->setInputFilter(new UsersFilter());
        $this->setHydrator(new ClassMethods());

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
            'type' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
        ));
       $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Type a password',
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
           'name' => 'groupid',
           'type' => 'Zend\Form\Element\Select',
           'options' => array(
                   'label' => 'Group of user',
                   'value_options' => $userGroups,
                   'empty_option' => 'Please select group for user'
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
