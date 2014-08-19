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
//         $select->order(array('completed ASC', 'created ASC'));

        $schedule = $this->sql->prepareSchedulementForSqlObject($select);
        $results = $schedule->execute();

        $entityPrototype = new ScheduleEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
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
       }
       $statement = $this->sql->prepareStatementForSqlObject($action);
       $result = $statement->execute();

       if (!$schedule->getId()) {
           $schedule->setId($result->getGeneratedValue());
       }
       return $result;
   }
   
    public function fetchScheduleWithUsers()
    {
    $select = new Select();
    $select->from('schedule')
               ->columns(array('id', 'reviewer', 'traineebackupid', 'replacementreviewerid', 'originalreviewerid', 'designreviewerid', 'designtraineereviewerid', 'datetimebegin', 'datetimeend'))
               ->join('users', 'schedule.reviewer = users.id', array('uid' =>'id', 'reviewer_ldap' => 'ldap', 'traineebackupid_ldap' => 'ldap', 'replacementreviewerid_ldap' => 'ldap',
                   'originalreviewerid_ldap' => 'ldap', 'designreviewerid_ldap' => 'ldap', 'designtraineereviewerid_ldap' => 'ldap', 'datetimebegin_ldap' => 'ldap'));
       $statement = $this->sql->prepareStatementForSqlObject($select);
       $results = $statement->execute();
       return $results;
    }
   
    public function getSchedule($id)
   {
//       echo $id;exit;
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

?>
