<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsergroupsMapper
 *
 * @author vklyuf
 */
namespace Usergroups\Model;

 use Zend\Db\Adapter\Adapter;
 use Usergroups\Model\UsergroupsEntity;
 use Zend\Stdlib\Hydrator\ClassMethods;
 use Zend\Db\Sql\Sql;
 use Zend\Db\Sql\Select;
 use Zend\Db\ResultSet\HydratingResultSet;

class UsergroupsMapper {
    protected $tableName = 'usergroups';
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

        $entityPrototype = new UsergroupsEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }

   public function saveUsergroups(UsergroupsEntity $usergroups)
   {

       $hydrator = new ClassMethods();
       $data = $hydrator->extract($usergroups);
       if ($usergroups->getId()) {
           // update action
           $action = $this->sql->update();
           $action->set($data);
           $action->where(array('id' => $usergroups->getId()));
       } else {
           // insert action
           $action = $this->sql->insert();
           unset($data['id']);
           $action->values($data);
       }
       $statement = $this->sql->prepareStatementForSqlObject($action);
       $result = $statement->execute();

       if (!$usergroups->getId()) {
           $usergroups->setId($result->getGeneratedValue());
       }
       return $result;

   }

    public function getUsergroups($id)
   {
       $select = $this->sql->select();
       $select->where(array('id' => $id));

       $statement = $this->sql->prepareStatementForSqlObject($select);
       $result = $statement->execute()->current();
       if (!$result) {
           return null;
       }

       $hydrator = new ClassMethods();
       $usergroups = new UsergroupsEntity();
       $hydrator->hydrate($result, $usergroups);

       return $usergroups;
   }

   public function deleteUsergroups($id)
   {
       $delete = $this->sql->delete();
       $delete->where(array('id' => $id));

       $statement = $this->sql->prepareStatementForSqlObject($delete);
       return $statement->execute();
   }
}
