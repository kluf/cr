<?php

namespace Users\Model;

class UsersEntity
 {
    public $id;
    public $ldap;
    public $email;
    public $password;
    public $groupid;
    
    public function getId() {
        return $this->id;
    }

    public function getLdap() {
        return $this->ldap;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getGroupid() {
        return $this->groupid;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLdap($ldap) {
        $this->ldap = $ldap;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setGroupid($groupid) {
        $this->groupid = $groupid;
    }


 }