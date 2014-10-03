<?php

namespace Auth\Model;

class AuthEntity
 {
    private $ldap;
    private $password;
    private $groupid;
    
    public function getGroupid() {
        return $this->groupid;
    }

    public function setGroupid($groupid) {
        $this->groupid = $groupid;
    }

    public function getLdap() {
        return $this->ldap;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setLdap($ldap) {
        $this->ldap = $ldap;
    }

    public function setPassword($password) {
        $this->password = $password;
    }


    
 }