<?php
namespace Codereview\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class CodereviewForm extends Form
{
    public function __construct($name = null, $users, $states, $reviewers)
    {

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
            'type' => 'datetime',
            'options' => array(
                'label' => 'Date of creating',
            ),
            'attributes' => array(
                'readonly' => 'true',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'changeset',
            'type' => 'url',
            'options' => array(
                'label' => 'Changeset',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'jiraticket',
            'type' => 'url',
            'options' => array(
                'label' => 'JIRA ticket',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'authorcomments',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Author\'s comment',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'reviewercomments',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Reviewer\'s comment',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
             'name' => 'stateid',
             'type' => 'Zend\Form\Element\Select',
            'disabled' => 'true',
             'options' => array(
                     'label' => 'State',
                     'value_options' => $states,
                     'empty_option' => 'Please select state'
             ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'authorid',
            'type' => 'Zend\Form\Element\Select',
             'options' => array(
                     'label' => 'User',
                     'value_options' => $users,
                     'empty_option' => 'Please select user'
             ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        
        $this->add(array(
            'name' => 'reviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                     'label' => 'Reviewer',
                     'value_options' => $reviewers,
                     'empty_option' => 'Please select reviewer'
             ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-warning'
            ),
        ));
        $this->get('creationdate')->setFormat('m-d-Y H:i');
    }
 }

