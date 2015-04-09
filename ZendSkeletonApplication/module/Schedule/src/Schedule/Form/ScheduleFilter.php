<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ScheduleFilter
 *
 * @author vklyuf
 */
namespace Schedule\Form;

use Zend\InputFilter\InputFilter;

class ScheduleFilter extends InputFilter{
    public function __construct()
    {
        $this->add(array(
             'name' => 'id',
             'required' => true,
             'filters' => array(
                 array('name' => 'Int'),
             ),
         ));
        $this->add(array(
            'name' => 'reviewer',
            'required' => true,
            'filters' => array(
                 array('name' => 'Int'),
             ),
             'validators' => array(
                array(
                    'name' => 'InArray',
                    'options' => array(
                    'haystack' => array(1,9999),
                    'messages' => array(
                        \Zend\Validator\InArray::NOT_IN_ARRAY => 'Please select reviewer !'
                            ),
                        ),
                    ),
            ), 
        ));
        $this->add(array(
            'name' => 'traineebackupid',
            'required' => true,
            'filters' => array(
                    array('name' => 'Int'),
                ),
            'validators' => array(
                    array(
                        'name' => 'InArray',
                        'options' => array(
                        'haystack' => array(1,9999),
                        'messages' => array(
                            \Zend\Validator\InArray::NOT_IN_ARRAY => 'Please select backup reviewer !'
                                ),
                            ),
                        ),
                ), 
        ));
        $this->add(array(
            'name' => 'replacementreviewerid',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));
        $this->add(array(
            'name' => 'originalreviewerid',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));
        $this->add(array(
            'name' => 'designreviewerid',
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));
        $this->add(array(
            'name' => 'designtraineereviewerid',
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));
        $this->add(array(
            'name' => 'timereference',
            'required' => true,
//            'filters' => array(
//                array('name' => 'Date'),
//            ),
        ));
        $this->add(array(
            'name' => 'dateofschedule',
            'required' => true,
//            'filters' => array(
//                array('name' => 'Date'),
//            ),
        ));
        $this->add(array(
             'name' => 'completed',
             'required' => false,
         ));
    }
}

?>
