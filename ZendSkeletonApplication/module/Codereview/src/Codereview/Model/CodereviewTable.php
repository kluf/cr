<?php

namespace Codereview\Model;

 use Zend\Db\TableGateway\TableGateway;

 class CodereviewTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getCodereview($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveCodereview(Codereview $codereview)
     {
         $data = array(
            'creationdate' => $codereview->creationdate,
            'changeset' => $codereview->changeset,
            'jiraticket' => $codereview->jiraticket,
            'authorcomments' => $codereview->authorcomments,
            'reviewercommentsnull' => $codereview->reviewercommentsnull,
            'stateid' => $codereview->stateid,
            'authorid' => $codereview->authorid,
            'reviewerid' => $codereview->reviewerid,
         );

         $id = (int) $codereview->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getCodereview($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Codereview id does not exist');
             }
         }
     }

     public function deleteCodereview($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }

