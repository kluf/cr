<?php
namespace Auth\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class AuthForm extends Form
{
    protected $adapter;
    public function __construct($name = null)
    {
        // we want to ignore the name passed
//        $this->adapter =$dbAdapter;
        parent::__construct('auth');
        $this->setAttribute('method', 'post');
        $this->setInputFilter(new AuthFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'ldap',
            'type' => 'Text',
            'options' => array(
                'label' => 'LDAP',
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
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));

    }
}
