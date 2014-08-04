<?php
namespace Users\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;
 class UsersForm extends Form
 {
     protected $adapter;
     public function __construct($name = null, AdapterInterface $dbAdapter)
     {
         // we want to ignore the name passed
         $this->adapter =$dbAdapter;
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
            'name' => 'usergroup',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Group of user',
                    'value_options' => $this->getOptionsForSelect(),
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
     
     public function getOptionsForSelect()
    {
        $dbAdapter = $this->adapter;
        $sql       = 'SELECT id,name  FROM usergroups';
        $statement = $dbAdapter->query($sql);
        $result    = $statement->execute();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['name'];
        }
        return $selectData;
    }
 }
