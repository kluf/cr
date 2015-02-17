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

class CodereviewFilter extends InputFilter{
    public function __construct(){
        
        $this->add(array(
             'name'     => 'id',
             'required' => true,
             'filters'  => array(
                 array('name' => 'Int'),
             ),
         ));
        
         $this->add(array(
             'name'     => 'creationdate',
             'required' => true,
             'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
             ),
             'validators' => array(
                 array(
                     'name'    => 'StringLength',
                     'options' => array(
                         'encoding' => 'UTF-8',
                         'min'      => 1,
                         'max'      => 100,
                     ),
                 ),
             ),
         ));
         $this->add(array(
             'name'     => 'changeset',
             'required' => true,
             'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
             ),
             'validators' => array(
                 array(
                     'name'    => 'StringLength',
                     'options' => array(
                         'encoding' => 'UTF-8',
                         'min'      => 1,
                         'max'      => 100,
                     ),
                 ),
             ),
         ));

         $this->add(array(
             'name'     => 'jiraticket',
             'required' => true,
             'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
             ),
             'validators' => array(
                 array(
                     'name'    => 'StringLength',
                     'options' => array(
                         'encoding' => 'UTF-8',
                         'min'      => 1,
                         'max'      => 100,
                     ),
                 ),
             ),
         ));

         $this->add(array(
             'name'     => 'authorcomments',
             'required' => false,
             'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
             ),
             'validators' => array(
                 array(
                     'name'    => 'StringLength',
                     'options' => array(
                         'encoding' => 'UTF-8',
                         'min'      => 1,
                         'max'      => 100,
                     ),
                 ),
             ),
         ));

         $this->add(array(
             'name'     => 'reviewercomments',
             'required' => false,
             'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
             ),
         ));

         $this->add(array(
             'name'     => 'stateid',
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
                        \Zend\Validator\InArray::NOT_IN_ARRAY => 'Please select state !'
                            ),
                        ),
                    ),
            ), 
         ));

         $this->add(array(
             'name'     => 'authorid',
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
                        \Zend\Validator\InArray::NOT_IN_ARRAY => 'Please select your ldap as author\'s !'
                            ),
                        ),
                    ),
            ), 
         ));

         $this->add(array(
             'name'     => 'reviewerid',
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
                        \Zend\Validator\InArray::NOT_IN_ARRAY => 'Please select reviewer who will check your code !'
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
