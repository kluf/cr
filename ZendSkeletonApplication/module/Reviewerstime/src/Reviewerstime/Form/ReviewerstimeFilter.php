<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReviewerstimeFilter
 *
 * @author vklyuf
 */

namespace Reviewerstime\Form;

use Zend\InputFilter\InputFilter;

class ReviewerstimeFilter extends InputFilter{
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
            ));
            
            $this->add(array(
             'name' => 'completed',
             'required' => false,
            ));
    }
}

?>
