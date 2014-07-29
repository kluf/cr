<?php

namespace Schedule\Model;

class ScheduleEntity {
    public $id;
    public $Reviewer;
    public $datetimebegin;
    public $datetimeend;
//    public $ldap;
    public function getId() {
        return $this->id;
    }

    public function getReviewer() {
        return $this->Reviewer;
    }

    public function getDatetimebegin() {
        return $this->datetimebegin;
    }

    public function getDatetimeend() {
        return $this->datetimeend;
    }

//    public function getLdap() {
//        return $this->ldap;
//    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setReviewer($Reviewer) {
        $this->Reviewer = $Reviewer;
    }

    public function setDatetimebegin($datetimebegin) {
        $this->datetimebegin = $datetimebegin;
    }

    public function setDatetimeend($datetimeend) {
        $this->datetimeend = $datetimeend;
    }

//    public function setLdap($ldap) {
//        $this->ldap = $ldap;
//    }




}
//
//use Zend\InputFilter\InputFilter;
//use Zend\InputFilter\InputFilterAwareInterface;
//use Zend\InputFilter\InputFilterInterface;
//
//
// class Schedule
// {
//    public $id;
//    public $Reviewer;
//    public $DateTimeBegin;
//    public $DateTimeEnd;
//    public $ldap;
//
//
//    public function exchangeArray($data)
//    {
//        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
//        $this->Reviewer = (!empty($data['Reviewer'])) ? $data['Reviewer'] : null;
//        $this->DateTimeBegin  = (!empty($data['DateTimeBegin'])) ? $data['DateTimeBegin'] : null;
//        $this->DateTimeEnd  = (!empty($data['DateTimeEnd'])) ? $data['DateTimeEnd'] : null;
//        $this->ldap  = (!empty($data['ldap'])) ? $data['ldap'] : null;
//    }
//    
//    public function setInputFilter(InputFilterInterface $inputFilter)
//    {
//        throw new \Exception("Not used");
//    }
//
//    public function getInputFilter()
//    {
//        if (!$this->inputFilter) {
//            $inputFilter = new InputFilter();
//
//            $inputFilter->add(array(
//                'name'     => 'id',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'Int'),
//                ),
//            ));
//
//            $inputFilter->add(array(
//                'name'     => 'Reviewer',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'Int')
//                ),
//            ));
//
//            $inputFilter->add(array(
//                'name'     => 'DateTimeBegin',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'StripTags'),
//                    array('name' => 'StringTrim'),
//                ),
//            ));
//            
//            $inputFilter->add(array(
//                'name'     => 'DateTimeEnd',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'StripTags'),
//                    array('name' => 'StringTrim'),
//                ),
//            ));
//
//            $this->inputFilter = $inputFilter;
//        }
//
//        return $this->inputFilter;
//    }
//    
//    public function getArrayCopy()
//    {
//    return get_object_vars($this);
//    }
//
// }