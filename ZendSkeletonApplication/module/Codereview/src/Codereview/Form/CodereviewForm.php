<?php
namespace Codereview\Form;

use Zend\Form\Form;

    class CodereviewForm extends Form
    {
        
        public function __construct($name = null)
        {
            // we want to ignore the name passed
            parent::__construct('codereview');

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
                'type' => 'Text',
                'options' => array(
                    'label' => 'Current state',
                ),
            ));
            $this->add(array(
                'name' => 'authorid',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Author',
                ),
            ));
            $this->add(array(
                'name' => 'reviewerid',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Reviewer',
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

