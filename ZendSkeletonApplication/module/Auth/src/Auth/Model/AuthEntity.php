<?php

namespace Auth\Model;

class AuthEntity
 {
    private $ldap;
    private $password;
    
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