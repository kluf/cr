<?php

namespace State\Form;

use Zend\InputFilter\InputFilter;

class StateFilter extends InputFilter{
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
