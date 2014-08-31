<?php

namespace Reviewerstime\Model;

 use Zend\Db\Adapter\Adapter;
 use Reviewerstime\Model\ReviewerstimeEntity;
 use Zend\Stdlib\Hydrator\ClassMethods;
 use Zend\Db\Sql\Sql;
 use Zend\Db\Sql\Select;
 use Zend\Db\ResultSet\HydratingResultSet;

class ReviewerstimeMapper
{
    protected $tableName = 'reviewerstime';
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
    $select = new Select();
    $select->from('reviewerstime')
               ->columns(array('id', 'timeperioud'));
       $statement = $this->sql->prepareStatementForSqlObject($select);
       $results = $statement->execute();
       return $results;
    }
    
    public function fetchReviewerstimeForSelect($checkedOption = 0)
    {
        $result = $this->fetchAll();
        $selectData = array();
        foreach ($result as $res) {
            $selectData[$res['id']] = $res['timeperioud'];
            if ($res['id'] == $checkedOption) {
                $selectData[$res['id']] = array('value' => $res['id'], 'label' => $res['timeperioud'], 'checked' => true);
            }
        }
        return $selectData;
    }

    public function fetchReviewerstimeWithGroups()
    {
    $select = new Select();
    $select->from('reviewerstime')
               ->columns(array('id', 'ldap', 'groupid', 'email'))
               ->join('usergroups',
                       'reviewerstime.groupid = usergroups.id', array('idd' => 'id', 'name'));
       $statement = $this->sql->prepareStatementForSqlObject($select);
       $results = $statement->execute();
       return $results;
    }
    
   public function saveReviewerstime(ReviewerstimeEntity $reviewerstime)
   {

       $hydrator = new ClassMethods();
       $data = $hydrator->extract($reviewerstime);
       if ($reviewerstime->getId()) {
           // update action
           $action = $this->sql->update();
           $action->set($data);
           $action->where(array('id' => $reviewerstime->getId()));
       } else {
           // insert action
           $action = $this->sql->insert();
           unset($data['id']);
           $action->values($data);
       }
       $statement = $this->sql->prepareStatementForSqlObject($action);
       $result = $statement->execute();

       if (!$reviewerstime->getId()) {
           $reviewerstime->setId($result->getGeneratedValue());
       }
       return $result;

   }

    public function getReviewerstime($id)
   {
        $select = $this->sql->select();
        $select->where(array('id' => $id));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }

        $hydrator = new ClassMethods();
        $reviewerstime = new ReviewerstimeEntity();
        $hydrator->hydrate($result, $reviewerstime);
        return $reviewerstime;

              
   }

   public function deleteReviewerstime($id)
   {
       $delete = $this->sql->delete();
       $delete->where(array('id' => $id));

       $statement = $this->sql->prepareStatementForSqlObject($delete);
       return $statement->execute();
   }
}