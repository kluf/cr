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
            'name' => 'Reviewer',
            'required' => true,
            'filters' => array(
                 array('name' => 'Int'),
             ),
        ));
        $this->add(array(
        'name' => 'traineebackupid',
        'required' => true,
        'filters' => array(
                array('name' => 'Int'),
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
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));
        $this->add(array(
            'name' => 'designtraineereviewerid',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));
        $this->add(array(
            'name' => 'datetimebegin',
            'required' => true,
//            'filters' => array(
//                array('name' => 'Date'),
//            ),
        ));
        $this->add(array(
            'name' => 'datetimeend',
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
