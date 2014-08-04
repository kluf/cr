<?php

namespace Users\Model;

 use Zend\Db\Adapter\Adapter;
 use Users\Model\UsersEntity;
 use Zend\Stdlib\Hydrator\ClassMethods;
 use Zend\Db\Sql\Sql;
 use Zend\Db\Sql\Select;
 use Zend\Db\ResultSet\HydratingResultSet;

class UsersMapper
{
    protected $tableName = 'users';
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

        $entityPrototype = new UsersEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }

    public function fetchUsersWithGroups()
    {
    $select = new Select();
    $select->from('users')
               ->columns(array('id', 'ldap', 'groupid', 'email'))
               ->join('usergroups',
                       'users.groupid = usergroups.id', array('idd' => 'id', 'name'));
       $statement = $this->sql->prepareStatementForSqlObject($select);
       $results = $statement->execute();
       return $results;
    }
    
   public function saveUsers(UsersEntity $users)
   {

       $hydrator = new ClassMethods();
       $data = $hydrator->extract($users);
       if ($users->getId()) {
           // update action
           $action = $this->sql->update();
           $action->set($data);
           $action->where(array('id' => $users->getId()));
       } else {
           // insert action
           $action = $this->sql->insert();
           unset($data['id']);
           $action->values($data);
       }
       $statement = $this->sql->prepareStatementForSqlObject($action);
       $result = $statement->execute();

       if (!$users->getId()) {
           $users->setId($result->getGeneratedValue());
       }
       return $result;

   }

    public function getUsers($id)
   {
        $select = $this->sql->select();
        $select->where(array('id' => $id));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }

        $hydrator = new ClassMethods();
        $users = new UsersEntity();
        $hydrator->hydrate($result, $users);
        return $users;

              
   }

   public function deleteUsers($id)
   {
       $delete = $this->sql->delete();
       $delete->where(array('id' => $id));

       $statement = $this->sql->prepareStatementForSqlObject($delete);
       return $statement->execute();
   }
}