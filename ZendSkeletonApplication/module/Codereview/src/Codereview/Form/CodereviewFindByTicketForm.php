<?php
namespace Codereview\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class CodereviewFindByTicketForm extends Form
{
    public function __construct($name = null)
    {

        // we want to ignore the name passed
        parent::__construct('codereviewfindbyticket');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new CodereviewFindByTicketFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'jiraticket',
            'type' => 'Text',
            'options' => array(
                'label' => 'Type number of JIRA ticket to find',
            ),
            'attributes' => array(
                'class' => 'jiraticket form-control'
            ),
        ));
        
        $this->add(array(
            'name' => 'startdate',
            'type' => 'Text',
            'options' => array(
                'label' => 'Start date',
            ),
            'attributes' => array(
                'class' => 'startdate form-control'
            ),
        ));
       
        $this->add(array(
            'name' => 'enddate',
            'type' => 'Text',
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
    }
 }

