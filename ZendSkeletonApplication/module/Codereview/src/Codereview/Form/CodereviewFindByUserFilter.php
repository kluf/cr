<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CodereviewFilter
 *
 * @author vklyuf
 */

namespace Codereview\Form;

use Zend\InputFilter\InputFilter;

class CodereviewFindByUserFilter extends InputFilter{
    
    public function __construct(){
        
         $this->add(array(
             'name'     => 'authorid',
             'required' => true,
             'filters'  => array(
                 array('name' => 'Int'),
             ),
         ));
         
         $this->add(array(
             'name'     => 'enddate',
             'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
             ),
             'validators' => array(
                 array(
                     'name'    => 'StringLength',
                     'options' => array(
                         'encoding' => 'UTF-8',
                         'min'      => 10,
                         'max'      => 10,
                     ),
                 ),
             ),
         ));
        
        $this->add(array(
             'name'     => 'startdate',
             'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
             ),
             'validators' => array(
                 array(
                     'name'    => 'StringLength',
                     'options' => array(
                         'encoding' => 'UTF-8',
                         'min'      => 10,
                         'max'      => 10,
                     ),
                 ),
             ),
         ));
         
    }
}

?>
