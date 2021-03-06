<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ScheduleMapper
 *
 * @author vklyuf
 */
namespace Schedule\Model;

use Zend\Db\Adapter\Adapter;
use Schedule\Model\ScheduleEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class ScheduleMapper {

    protected $tableName = 'schedule';
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
        $schedule = $this->sql->prepareStatementForSqlObject($select);
        $results = $schedule->execute();
        $entityPrototype = new ScheduleEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }

    public function fetchScheduleWithUsers()
    {
    $select = new Select();
    $select->from(array('S' => 'schedule'))
               ->columns(array('id', 'reviewer', 'traineebackupid', 'replacementreviewerid', 'originalreviewerid', 'designreviewerid', 'designtraineereviewerid', 'timereference', 'dateofschedule'))
               ->join(array('U' => 'users'), 'S.reviewer = U.id', array('uid' =>'id', 'reviewer_ldap' => 'ldap'), 'left')
                ->join(array('U0' => 'users'), 'S.traineebackupid = U0.id', array('traineebackupid_ldap' => 'ldap'), 'left')
                ->join(array('U1' => 'users'), 'S.replacementreviewerid = U1.id', array('replacementreviewerid_ldap' => 'ldap'), 'left')
                ->join(array('U2' => 'users'), 'S.originalreviewerid = U2.id', array('originalreviewerid_ldap' => 'ldap'), 'left')
                ->join(array('U3' => 'users'), 'S.designreviewerid = U3.id', array('designreviewerid_ldap' => 'ldap'), 'left')
                ->join(array('U4' => 'users'), 'S.designtraineereviewerid = U4.id', array('designtraineereviewerid_ldap' => 'ldap'), 'left')
                ->join(array('RT' => 'reviewerstime'), 'S.timereference = RT.id', array('timeref' => 'timeperioud'), 'left');
       $statement = $this->sql->prepareStatementForSqlObject($select);
       $results = $statement->execute();
       return $results;
    }
    
    public function fetchScheduleDates()
    {
    $select = new Select();
    $select->distinct()
            ->from(array('S' => 'schedule'))
        ->columns(array('dateofschedule'));
       $statement = $this->sql->prepareStatementForSqlObject($select);
       $results = $statement->execute();
       return $results;
    }
    
    public function saveSchedule(ScheduleEntity $schedule)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($schedule);
        if ($schedule->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $schedule->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
            echo $action;exit;
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if (!$schedule->getId()) {
            $schedule->setId($result->getGeneratedValue());
        }
        return $result;
    }
   
       public function saveScheduleAPI($data)
    {
        $data = json_decode($data, true);
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
        return $result->getGeneratedValue();
   }
   
    public function fetchScheduleForCurrentDay()
    {
    $currentDate = date('Y-m-d');
    $select = new Select();
    $select->from(array('S' => 'schedule'))
               ->columns(array('id', 'reviewer', 'traineebackupid', 'replacementreviewerid', 'originalreviewerid', 'designreviewerid', 'designtraineereviewerid', 'timereference', 'dateofschedule'))
               ->join(array('U' => 'users'), 'S.reviewer = U.id', array('uid' =>'id', 'reviewer_ldap' => 'ldap'), 'left')
                ->join(array('U0' => 'users'), 'S.traineebackupid = U0.id', array('traineebackupid_ldap' => 'ldap'), 'left')
                ->join(array('U1' => 'users'), 'S.replacementreviewerid = U1.id', array('replacementreviewerid_ldap' => 'ldap'), 'left')
                ->join(array('U2' => 'users'), 'S.originalreviewerid = U2.id', array('originalreviewerid_ldap' => 'ldap'), 'left')
                ->join(array('U3' => 'users'), 'S.designreviewerid = U3.id', array('designreviewerid_ldap' => 'ldap'), 'left')
                ->join(array('U4' => 'users'), 'S.designtraineereviewerid = U4.id', array('designtraineereviewerid_ldap' => 'ldap'), 'left')
                ->join(array('RT' => 'reviewerstime'), 'S.timereference = RT.id', array('timeref' => 'timeperioud'), 'left')
                ->where("dateofschedule LIKE '%{$currentDate}%'");
       $statement = $this->sql->prepareStatementForSqlObject($select);
       $results = $statement->execute();
       return $results;
    }
   
    public function getSchedule($id)
   {
       $select = $this->sql->select();
       $select->where(array('id' => $id));

       $schedule = $this->sql->prepareStatementForSqlObject($select);
       $result = $schedule->execute()->current();
       if (!$result) {
           return null;
       }
       $hydrator = new ClassMethods();
       $schedule = new ScheduleEntity();
       $hydrator->hydrate($result, $schedule);

       return $schedule;
   }

   public function deleteSchedule($id)
   {
       $delete = $this->sql->delete();
       $delete->where(array('id' => $id));
       $schedule = $this->sql->prepareStatementForSqlObject($delete);
       return $schedule->execute();
   }
}
