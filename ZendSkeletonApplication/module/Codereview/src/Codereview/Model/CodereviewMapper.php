<?php

namespace Codereview\Model;

use Zend\Db\Adapter\Adapter;
use Codereview\Model\CodereviewEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\HydratingResultSet;

 class CodereviewMapper
 {
    protected $tableName = 'codereview';
    protected $dbAdapter;
    protected $sql;
    
    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll()
    {
        $select = $this->sql->select();
        $codereview = $this->sql->prepareCodereviewmentForSqlObject($select);
        $results = $codereview->execute();
        $entityPrototype = new CodereviewEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }

   public function saveCodereview(CodereviewEntity $codereview)
   {
       $hydrator = new ClassMethods();
       $data = $hydrator->extract($codereview);
       if ($codereview->getId()) {
           // update action
           $action = $this->sql->update();
           $action->set($data);
           $action->where(array('id' => $codereview->getId()));
       } else {
           // insert action
           $action = $this->sql->insert();
           unset($data['id']);
           $action->values($data);
       }
       $statement = $this->sql->prepareStatementForSqlObject($action);
       $result = $statement->execute();

       if (!$codereview->getId()) {
           $codereview->setId($result->getGeneratedValue());
       }
       return $result;
   }
   
    public function saveCodereviewAPI($data)
    {
       $data = json_decode($data, true);
//       echo $data['creationdate'];exit;
//       var_dump($data);exit;
       if (isset($data['id']) && $data['id'] != '') {
           // update action
           $action = $this->sql->update();
           $action->set($data);
           $action->where(array('id' => $data['id']));
       } else {
           // insert action
           $action = $this->sql->insert();
           unset($data['id']);
           $action->values($data);
       }
       $statement = $this->sql->prepareStatementForSqlObject($action);
       $result = $statement->execute();

//       if (!$codereview->getId()) {
//           $codereview->setId($result->getGeneratedValue());
//       }
//        var_dump($result);exit;
        return $result->getGeneratedValue();
   }
   
    public function fetchCodereviewWithUsersAndStates()
    {
    $select = new Select();
    $select->from(array('C' => 'codereview'))
               ->columns(array('id', 'creationdate', 'changeset', 'jiraticket', 'authorcomments', 'reviewercomments', 'stateid', 'authorid', 'reviewerid' ))
               ->join(array('U' => 'users'), 'C.authorid = U.id', array('uid' =>'id', 'author' => 'ldap'))
                ->join(array('U0' => 'users'), 'C.reviewerid = U0.id', array('rid' =>'id', 'reviewer' => 'ldap'))
                ->join(array('S' => 'state'), 'C.stateid = S.id', array('state' => 'name'));
       $statement = $this->sql->prepareStatementForSqlObject($select);
       $results = $statement->execute();
       return $results;
    }
   
    public function fetchCodereviewWithUsersAndStatesForPaginator()
    {
    $select = new Select();
    $select->from(array('C' => 'codereview'))
               ->columns(array('id', 'creationdate', 'changeset', 'jiraticket', 'authorcomments', 'reviewercomments', 'stateid', 'authorid', 'reviewerid' ))
               ->join(array('U' => 'users'), 'C.authorid = U.id', array('uid' =>'id', 'author' => 'ldap'))
                ->join(array('U0' => 'users'), 'C.reviewerid = U0.id', array('rid' =>'id', 'reviewer' => 'ldap'))
                ->join(array('S' => 'state'), 'C.stateid = S.id', array('state' => 'name'))
                ->order('creationdate ASC');
       $statement = $this->sql->prepareStatementForSqlObject($select);
       $results = $statement->execute();
       return $results;
    }
    
    public function getCodereview($id)
   {
       $select = $this->sql->select();
       $select->where(array('id' => $id));

       $codereview = $this->sql->prepareStatementForSqlObject($select);
       $result = $codereview->execute()->current();
       if (!$result) {
           return null;
       }
       $hydrator = new ClassMethods();
       $codereview = new CodereviewEntity();
       $hydrator->hydrate($result, $codereview);

       return $codereview;
   }

    public function getCodereviewApi($id)
   {
       $select = $this->sql->select();
       $select->where(array('id' => $id));

       $codereview = $this->sql->prepareStatementForSqlObject($select);
       $result = $codereview->execute()->current();
       if (!$result) {
           return null;
       }
       $hydrator = new ClassMethods();
       $codereview = new CodereviewEntity();
       $hydrator->hydrate($result, $codereview);

       return $codereview;
   }
   
   public function chooseStartEndDate($select, $startdate, $enddate, $userid) {
    $predicate = new Where();
    if (isset($startdate) && isset($enddate)) {
        $select->where($predicate->between('creationdate', $startdate, $enddate));
    } else if (isset($startdate)) {
        $select->where($predicate->greaterThanOrEqualTo('creationdate', $startdate));
    } else if (isset($enddate)) {
        $select->where($predicate->lessThanOrEqualTo('creationdate', $enddate));
    }
    return $select;
   }
   
    public function getCodereviewByUser($userid, $startdate, $enddate)
    {
    $select = new Select();
    $predicate = new Where();
    $select->from(array('C' => 'codereview'))
               ->columns(array('id', 'creationdate', 'changeset', 'jiraticket', 'authorcomments', 'reviewercomments', 'stateid', 'authorid', 'reviewerid' ))
               ->join(array('U' => 'users'), 'C.authorid = U.id', array('uid' =>'id', 'author' => 'ldap'))
                ->join(array('U0' => 'users'), 'C.reviewerid = U0.id', array('rid' =>'id', 'reviewer' => 'ldap'))
                ->join(array('S' => 'state'), 'C.stateid = S.id', array('state' => 'name'))
                ->where($predicate->equalTo('U.id', $userid));
    $select = $this->chooseStartEndDate($select, $startdate, $enddate, $userid);
//                ->where($predicate->between('creationdate', $startdate, $enddate))
//                ->where($predicate->greaterThanOrEqualTo('creationdate', $startdate))
//                ->where($predicate->lessThanOrEqualTo('creationdate', $enddate))
                $select->order('creationdate ASC')
                ->limit(250);
    $statement = $this->sql->prepareStatementForSqlObject($select);
    $results = $statement->execute();
    return $results;
    }
    
    public function getCodereviewByTicket($ticketNumber)
    {
    $select = new Select();
    $select->from(array('C' => 'codereview'))
               ->columns(array('id', 'creationdate', 'changeset', 'jiraticket', 'authorcomments', 'reviewercomments', 'stateid', 'authorid', 'reviewerid' ))
               ->join(array('U' => 'users'), 'C.authorid = U.id', array('uid' =>'id', 'author' => 'ldap'))
                ->join(array('U0' => 'users'), 'C.reviewerid = U0.id', array('rid' =>'id', 'reviewer' => 'ldap'))
                ->join(array('S' => 'state'), 'C.stateid = S.id', array('state' => 'name'))
                ->where('C.jiraticket LIKE "%'.$ticketNumber.'%"')
                ->limit(250);
    $statement = $this->sql->prepareStatementForSqlObject($select);
    $results = $statement->execute();
    return $results;
    }
   
   public function deleteCodereview($id)
   {
       $delete = $this->sql->delete();
       $delete->where(array('id' => $id));
       $codereview = $this->sql->prepareStatementForSqlObject($delete);
       return $codereview->execute();
   }
   
    public function isDayInWeekend($currentDate) {
        $saturday = 0;
        $sunday = 6;
        return (boolean)$currentDate == $saturday && $currentDate == $sunday;
    }

    public function dateCounter() {
       $daysInWeek = 5;
       date_default_timezone_set('Europe/Helsinki');
       $currentDate = date("w");
       $currentDateTextual = date('l');
       $daysLeftToWeekend = 0;
       if ($this->isDayInWeekend($currentDate)) {
           $daysLeftToWeekend = ' thus now is Weekend, so none';
       }
       elseif ($currentDate < $daysInWeek) {
           $daysLeftToWeekend = $daysInWeek - $currentDate;
       }
       $message = "Today is ".$currentDateTextual." ".$daysLeftToWeekend." days left to weekend";
       return $message;
    }
}