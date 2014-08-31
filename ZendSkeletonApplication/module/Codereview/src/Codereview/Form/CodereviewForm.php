<?php
namespace Codereview\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class CodereviewForm extends Form
{
    public function __construct($name = null, $users, $states, $reviewers)
    {
        
//        $this->adapter =$dbAdapter;
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
                     'value_options' => $states,
                     'empty_option' => 'Please select state'
             ),
        ));
        $this->add(array(
            'name' => 'authorid',
            'type' => 'Zend\Form\Element\Select',
             'options' => array(
                     'label' => 'User',
                     'value_options' => $users,
                     'empty_option' => 'Please select user'
             ),
        ));
        
        $this->add(array(
            'name' => 'reviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                     'label' => 'Reviewer',
                     'value_options' => $reviewers,
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
 }

