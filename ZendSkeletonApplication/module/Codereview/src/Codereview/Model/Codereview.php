<?php

 namespace Codereview\Model;

 class Codereview
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
     }
 }
