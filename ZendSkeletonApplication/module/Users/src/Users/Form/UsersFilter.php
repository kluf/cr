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

class UsersFilter extends InputFilter{
    public function __construct() {
            $this->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $this->add(array(
                'name'     => 'ldap',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
            $this->add(array(
                'name'     => 'email',
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
                'name'     => 'groupid',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
                'validators' => array(
                    array(
                        'name' => 'InArray',
                        'options' => array(
                        'haystack' => array(1,9999),
                        'messages' => array(
                            \Zend\Validator\InArray::NOT_IN_ARRAY => 'Please choose group to which user belongs to !'
                                ),
                            ),
                        ),
                ), 
            ));
            
            $this->add(array(
             'name' => 'completed',
             'required' => false,
            ));
    }
}

?>
