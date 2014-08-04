<?php

namespace Schedule\Model;

class ScheduleEntity {
    public $id;
    public $reviewer;
    public $datetimebegin;
    public $datetimeend;
//    public $ldap;
    public function getId() {
        return $this->id;
    }

    public function getReviewer() {
        return $this->reviewer;
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
        $this->reviewer = $Reviewer;
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
