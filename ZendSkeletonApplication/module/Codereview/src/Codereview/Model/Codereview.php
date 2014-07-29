<?php

 namespace Codereview\Model;

 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 
 class Codereview
 {
     public $id;
     public $uldap;
     public $creationdate;
     public $changeset;
     public $jiraticket;
     public $authorcomments;
     public $reviewercomments;
     public $stateid;
     public $authorid;
     public $reviewerid;
     protected $inputFilter;
     public $state; 
     public $author;
     public $reviewer;

     public function exchangeArray($data)
     {
         $this->id = (!empty($data['id'])) ? $data['id'] : null;
         $this->creationdate = (!empty($data['creationdate'])) ? $data['creationdate'] : null;
         $this->changeset = (!empty($data['changeset'])) ? $data['changeset'] : null;
         $this->jiraticket = (!empty($data['jiraticket'])) ? $data['jiraticket'] : null;
         $this->authorcomments = (!empty($data['authorcomments'])) ? $data['authorcomments'] : null;
         $this->reviewercomments = (!empty($data['reviewercomments'])) ? $data['reviewercomments'] : null;
         $this->stateid = (!empty($data['stateid'])) ? $data['stateid'] : null;
         $this->authorid = (!empty($data['authorid'])) ? $data['authorid'] : null;
         $this->reviewerid = (!empty($data['reviewerid'])) ? $data['reviewerid'] : null;
         $this->name = (!empty($data['name'])) ? $data['name'] : null;
         $this->ldap = (!empty($data['ldap'])) ? $data['ldap'] : null;
         $this->Authorsldap = (!empty($data['Authorsldap'])) ? $data['Authorsldap'] : null;
         $this->uldap = (!empty($data['uldap'])) ? $data['uldap'] : null;
         $this->states = (!empty($data['states'])) ? $data['states'] : null;
     }
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }
     
    public function getArrayCopy()
     {
         return get_object_vars($this);
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
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

             $inputFilter->add(array(
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
             
             $inputFilter->add(array(
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
             
             $inputFilter->add(array(
                 'name'     => 'authorcomments',
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
             
             $inputFilter->add(array(
                 'name'     => 'reviewercomments',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'stateid',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
            
             $inputFilter->add(array(
                 'name'     => 'states',
                 'required' => true,
             ));
             
             $inputFilter->add(array(
                 'name'     => 'authorid',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'reviewerid',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
             
             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }
