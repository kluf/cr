<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsergroupsFilter
 *
 * @author vklyuf
 */

namespace Usergroups\Form;

use Zend\InputFilter\InputFilter;

class UsergroupsFilter extends InputFilter{
    public function __construct() {
        $this->add(array(
             'name' => 'id',
             'required' => true,
             'filters' => array(
                 array('name' => 'Int'),
             ),
         ));
        $this->add(array(
             'name' => 'name',
             'required' => true,
         ));
        $this->add(array(
             'name' => 'completed',
             'required' => false,
         ));
    }
}

?>
