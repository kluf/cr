<?php

namespace Schedule\Model;

class ScheduleEntity {
    public $id;
    public $reviewer;
    public $traineebackupid;
    public $replacementreviewerid;
    public $originalreviewerid;
    public $designreviewerid;
    public $designtraineereviewerid;
    public $dateofschedule;
    public $timereference;
    public function getId() {
        return $this->id;
    }

    public function getReviewer() {
        return $this->reviewer;
    }

    public function getTraineebackupid() {
        return $this->traineebackupid;
    }

    public function getReplacementreviewerid() {
        return $this->replacementreviewerid;
    }

    public function getOriginalreviewerid() {
        return $this->originalreviewerid;
    }

    public function getDesignreviewerid() {
        return $this->designreviewerid;
    }

    public function getDesigntraineereviewerid() {
        return $this->designtraineereviewerid;
    }

    public function getDateofschedule() {
        return $this->dateofschedule;
    }

    public function getTimereference() {
        return $this->timereference;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setReviewer($reviewer) {
        $this->reviewer = $reviewer;
    }

    public function setTraineebackupid($traineebackupid) {
        $this->traineebackupid = $traineebackupid;
    }

    public function setReplacementreviewerid($replacementreviewerid) {
        $this->replacementreviewerid = $replacementreviewerid;
    }

    public function setOriginalreviewerid($originalreviewerid) {
        $this->originalreviewerid = $originalreviewerid;
    }

    public function setDesignreviewerid($designreviewerid) {
        $this->designreviewerid = $designreviewerid;
    }

    public function setDesigntraineereviewerid($designtraineereviewerid) {
        $this->designtraineereviewerid = $designtraineereviewerid;
    }

    public function setDateofschedule($dateofschedule) {
        $this->dateofschedule = $dateofschedule;
    }

    public function setTimereference($timereference) {
        $this->timereference = $timereference;
    }

}
