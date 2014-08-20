<?php

namespace Codereview\Model;

class CodereviewEntity
{
    public $id;
    public $creationdate;
    public $changeset;
    public $jiraticket;
    public $authorcomments;
    public $reviewercomments;
    public $stateid;
    public $authorid;
    public $reviewerid;

    public function getId() {
        return $this->id;
    }

    public function getCreationdate() {
        return $this->creationdate;
    }

    public function getChangeset() {
        return $this->changeset;
    }

    public function getJiraticket() {
        return $this->jiraticket;
    }

    public function getAuthorcomments() {
        return $this->authorcomments;
    }

    public function getReviewercomments() {
        return $this->reviewercomments;
    }

    public function getStateid() {
        return $this->stateid;
    }

    public function getAuthorid() {
        return $this->authorid;
    }

    public function getReviewerid() {
        return $this->reviewerid;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCreationdate($creationdate) {
        $this->creationdate = $creationdate;
    }

    public function setChangeset($changeset) {
        $this->changeset = $changeset;
    }

    public function setJiraticket($jiraticket) {
        $this->jiraticket = $jiraticket;
    }

    public function setAuthorcomments($authorcomments) {
        $this->authorcomments = $authorcomments;
    }

    public function setReviewercomments($reviewercomments) {
        $this->reviewercomments = $reviewercomments;
    }

    public function setStateid($stateid) {
        $this->stateid = $stateid;
    }

    public function setAuthorid($authorid) {
        $this->authorid = $authorid;
    }

    public function setReviewerid($reviewerid) {
        $this->reviewerid = $reviewerid;
    }


}
