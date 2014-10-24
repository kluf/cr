<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersFilter
 *
 * @author vklyuf
 */

namespace Users\Form;

use Zend\InputFilter\InputFilter;

class UsersResetPassFilter extends InputFilter{
    public function __construct() {
            
            $this->add(array(
                'name'     => 'userid',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));
            
            $this->add(array(
             'name' => 'completed',
             'required' => false,
            ));
    }
}

?>
