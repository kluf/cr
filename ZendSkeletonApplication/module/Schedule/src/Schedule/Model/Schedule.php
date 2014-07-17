<?php

namespace Schedule\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


 class Schedule
 {
    public $id;
    public $Reviewer;
    public $DateTimeBegin;
    public $DateTimeEnd;
    public $ldap;


    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->Reviewer = (!empty($data['Reviewer'])) ? $data['Reviewer'] : null;
        $this->DateTimeBegin  = (!empty($data['DateTimeBegin'])) ? $data['DateTimeBegin'] : null;
        $this->DateTimeEnd  = (!empty($data['DateTimeEnd'])) ? $data['DateTimeEnd'] : null;
        $this->ldap  = (!empty($data['ldap'])) ? $data['ldap'] : null;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
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
                'name'     => 'Reviewer',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int')
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'DateTimeBegin',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
            
            $inputFilter->add(array(
                'name'     => 'DateTimeEnd',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    
    public function getArrayCopy()
    {
    return get_object_vars($this);
    }

 }