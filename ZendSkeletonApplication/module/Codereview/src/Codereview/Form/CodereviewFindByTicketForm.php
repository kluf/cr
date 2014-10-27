<?php
namespace Codereview\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class CodereviewFindByTicketForm extends Form
{
    public function __construct($name = null)
    {

        // we want to ignore the name passed
        parent::__construct('codereview');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new CodereviewFindByTicketFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'jiraticket',
            'type' => 'Text',
            'options' => array(
                'label' => 'Type number of JIRA ticket to find',
            ),
        ));
       
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Find',
                'id' => 'submitbutton',
            ),
        ));
    }
 }

