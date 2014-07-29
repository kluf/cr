<?php

namespace Codereview\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\TableIdentifier;

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
     
    public function fetchFromCodereviewUsersState() 
    {
        $select = new Select();
        $select->from('codereview')
        ->columns(array('id','creationdate','changeset','jiraticket', 'authorcomments', 'reviewercomments', 'stateid', 'authorid', 'reviewerid'))
        ->join('users',
                'codereview.authorid = users.id', array('ldap'))
        ->join('state',
                'codereview.stateid = state.id',array('name'))
        ->join(array('us' => 'users'),
                'codereview.reviewerid = us.id',array('uldap' => 'ldap'));
        $resultSet = $this->tableGateway->selectWith($select);
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
    
    public function getCodereviewForEdit($id)
     {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
//        $select = new Select();
//        $select->from('state')
//                ->columns(array('states' => 'name'));
//        $resultSet = $this->tableGateway->selectWith($select);
//        $row->states = [1,2,3];
        return $row;
    }

        public function saveCodereview(Codereview $codereview)
     {
         $data = array(
            'creationdate' => $codereview->creationdate,
            'changeset' => $codereview->changeset,
            'jiraticket' => $codereview->jiraticket,
            'authorcomments' => $codereview->authorcomments,
            'reviewercomments' => $codereview->reviewercomments,
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

