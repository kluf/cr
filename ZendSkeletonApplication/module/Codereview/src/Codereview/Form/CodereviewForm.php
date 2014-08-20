<?php
namespace Codereview\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class CodereviewForm extends Form
{
    public function __construct($name = null, AdapterInterface $dbAdapter, $options = array("reviewer" => 0, "author" => 0, "state" => 0))
    {
//        var_dump($options);exit;
        $this->adapter =$dbAdapter;
        // we want to ignore the name passed
        parent::__construct('codereview');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new CodereviewFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'creationdate',
            'type' => 'Text',
            'options' => array(
                'label' => 'Date of creating',
            ),
        ));
        $this->add(array(
            'name' => 'changeset',
            'type' => 'Text',
            'options' => array(
                'label' => 'Changeset',
            ),
        ));
        $this->add(array(
            'name' => 'jiraticket',
            'type' => 'Text',
            'options' => array(
                'label' => 'JIRA ticket',
            ),
        ));
        $this->add(array(
            'name' => 'authorcomments',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Author\'s comment',
            ),
        ));
        $this->add(array(
            'name' => 'reviewercomments',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Reviewer\'s comment',
            ),
        ));
        $this->add(array(
             'name' => 'stateid',
             'type' => 'Zend\Form\Element\Select',
             'options' => array(
                     'label' => 'State',
                     'value_options' => $this->getOptionsForSelect($options["state"], 'state', 'name'),
                     'empty_option' => 'Please select state'
             ),
        ));
        $this->add(array(
            'name' => 'authorid',
            'type' => 'Zend\Form\Element\Select',
             'options' => array(
                     'label' => 'State',
                     'value_options' => $this->getOptionsForSelect($options["author"], 'users', 'ldap'),
                     'empty_option' => 'Please select user'
             ),
        ));
        
        $this->add(array(
            'name' => 'reviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                     'label' => 'State',
                     'value_options' => $this->getOptionsForSelect($options["reviewer"], 'users', 'ldap'),
                     'empty_option' => 'Please select reviewer'
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
    
    public function getOptionsForSelect($selectedOption = 0, $tableName, $fieldName)
    {
        $dbAdapter = $this->adapter;
        $sql       = "SELECT id,{$fieldName} FROM $tableName";
        $statement = $dbAdapter->query($sql);
        $result    = $statement->execute();
        $selectData = array();
        foreach ($result as $res) {
            $selectData[$res['id']] = $res[$fieldName];
            if ($res['id'] == $selectedOption) {
                $selectData[$res['id']] = array('value' => $res['id'], 'label' => $res[$fieldName], 'selected' => true);
            }
        }
        return $selectData;
    }
 }

