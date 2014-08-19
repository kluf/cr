<?php
namespace Schedule\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

 class ScheduleForm extends Form
 {
     public function __construct($name = null, AdapterInterface $dbAdapter, $options = array("selectedReviewer" => 0, "selectedtraineebackupid" => 0,
             "selectedreplacementreviewerid" => 0, "selectedoriginalreviewerid" => 0, "selecteddesignreviewerid" => 0, "selecteddesigntraineereviewerid" => 0))
     {
         $this->adapter =$dbAdapter;
         // we want to ignore the name passed
         parent::__construct('schedule');
         
         $this->setAttribute('method', 'post');
         $this->setInputFilter(new ScheduleFilter());
         $this->setHydrator(new ClassMethods());
         
         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
            'name' => 'Reviewer',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Reviewer',
                    'value_options' => $this->getOptionsForSelect($options["selectedReviewer"], 'users', 'ldap'),
                    'empty_option' => 'Please select reviewer'
            ),
        ));
        $this->add(array(
            'name' => 'traineebackupid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Trainee backup',
                    'value_options' => $this->getOptionsForSelect($options["selectedtraineebackupid"], 'users', 'ldap'),
                    'empty_option' => 'Please select trainee'
            ),
        ));
        $this->add(array(
            'name' => 'replacementreviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Replacement',
                    'value_options' => $this->getOptionsForSelect($options["selectedreplacementreviewerid"], 'users', 'ldap'),
                    'empty_option' => 'Please select who will replace the original'
            ),
        ));
        $this->add(array(
            'name' => 'originalreviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Original',
                    'value_options' => $this->getOptionsForSelect($options["selectedoriginalreviewerid"], 'users', 'ldap'),
                    'empty_option' => 'Please select original who is going to be replaced'
            ),
        ));
        $this->add(array(
            'name' => 'designreviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Design reviewer',
                    'value_options' => $this->getOptionsForSelect($options["selecteddesignreviewerid"], 'users', 'ldap'),
                    'empty_option' => 'Please select design reviewer'
            ),
        ));
        $this->add(array(
            'name' => 'designtraineereviewerid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                    'label' => 'Design reviewer trainee',
                    'value_options' => $this->getOptionsForSelect($options["selecteddesigntraineereviewerid"], 'users', 'ldap'),
                    'empty_option' => 'Please select Design trainee'
            ),
        ));
         $this->add(array(
             'name' => 'datetimebegin',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Begin of schedule',
             ),
         ));
         $this->add(array(
             'name' => 'datetimeend',
             'type' => 'Text',
             'options' => array(
                 'label' => 'End of schedule',
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
                $selectData[$res['id']] = array('value' => $res['id'], 'label' => $res['ldap'], 'selected' => true);
            }
        }
        return $selectData;
    }
 }
