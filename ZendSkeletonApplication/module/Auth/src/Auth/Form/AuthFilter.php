<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthFilter
 *
 * @author vklyuf
 */

namespace Auth\Form;

use Zend\InputFilter\InputFilter;

class AuthFilter extends InputFilter{
    public function __construct() {
            $this->add(array(
                'name'     => 'ldap',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
            $this->add(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
            $this->add(array(
             'name' => 'completed',
             'required' => false,
            ));
    }
}

?>
