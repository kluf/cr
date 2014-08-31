<?php

namespace Reviewerstime\Model;

class ReviewerstimeEntity
 {
    public $id;
    public $timeperioud;
    public function getId() {
        return $this->id;
    }

    public function getTimeperioud() {
        return $this->timeperioud;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTimeperioud($timeperioud) {
        $this->timeperioud = $timeperioud;
    }


 }