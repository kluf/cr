<?php

namespace State\Model;

use Zend\Db\Adapter\Adapter;
use State\Model\StateEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class StateMapper
{
    protected $tableName = 'state';
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

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new StateEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }

   public function saveState(StateEntity $state)
   {

       $hydrator = new ClassMethods();
       $data = $hydrator->extract($state);
       if ($state->getId()) {
           // update action
           $action = $this->sql->update();
           $action->set($data);
           $action->where(array('id' => $state->getId()));
       } else {
           // insert action
           $action = $this->sql->insert();
           unset($data['id']);
           $action->values($data);
       }
       $statement = $this->sql->prepareStatementForSqlObject($action);
       $result = $statement->execute();

       if (!$state->getId()) {
           $state->setId($result->getGeneratedValue());
       }
       return $result;

   }

    public function getState($id)
   {
       $select = $this->sql->select();
       $select->where(array('id' => $id));

       $statement = $this->sql->prepareStatementForSqlObject($select);
       $result = $statement->execute()->current();
       if (!$result) {
           return null;
       }

       $hydrator = new ClassMethods();
       $state = new StateEntity();
       $hydrator->hydrate($result, $state);

       return $state;
   }

   public function deleteState($id)
   {
       $delete = $this->sql->delete();
       $delete->where(array('id' => $id));

       $statement = $this->sql->prepareStatementForSqlObject($delete);
       return $statement->execute();
   }
}