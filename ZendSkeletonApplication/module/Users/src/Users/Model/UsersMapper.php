<?php

namespace Users\Model;

use Zend\Db\Adapter\Adapter;
use Users\Model\UsersEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Crypt\Password\Bcrypt;
 
 
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
        $select = new Select();
        $select->from('users')
                   ->columns(array('id', 'ldap'));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results;
    }

    public function ifUserExists($userLdap) {
        $select = $this->sql->select();
        $select->where(array('ldap' => $userLdap));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return false;
        }
        return true;
    }
    
    public function fetchUserForLoginAction($userLdap="", $pass="")
    {
        if ($userLdap == '' && $pass == '' && !$this->ifUserExists($userLdap)) {
            return false;
        }
        $bcrypt = new Bcrypt();
        $select = new Select();
        $select->from('users')
                ->columns(array('id', 'ldap', 'groupid', 'email', 'password'))
                ->join('usergroups', 'users.groupid = usergroups.id', array('groupname' => 'name'))
                ->where(array('ldap' => $userLdap));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result && !$bcrypt->verify($pass, $result['password'])) {
            return null;
        }
        $result['password'] = '';
//        $hydrator = new ClassMethods();
//        $users = new UsersEntity();
//        $hydrator->hydrate($result, $users);
//        var_dump($users);exit;
        return $result;
//        $this->isUserOwnerOfChangeset(1,1);
    }
    
    public function isUserAdmin($uid)
    {
        if (!$uid) {
            return false;
        }
        $select = new Select();
        $select->from('users')
                            ->columns(array('uid' => 'id', 'ldap', 'groupid'))
                            ->where(array('uid' => $uid))
                            ->join('usergroups',
                                    'users.groupid = usergroups.id', array('name'))
                            ->where(array('usergroups.name' => 'admins'));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
        return $result;
    }
    
    public function isUserReviewer($uid) 
    {
        if (!$uid) {
            return false;
        }
        $select = new Select();
        $select->from('users')
                            ->columns(array('uid' => 'id', 'ldap', 'groupid'))
                            ->where(array('uid' => $uid))
                            ->join('usergroups',
                                    'users.groupid = usergroups.id', array('name'))
                            ->where(array('usergroups.name' => 'reviewers'));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
        return $result;
    }
    
    public function isUserOwnerOfChangeset($userId, $codereviewId) 
    {
        if (!$userId && !$changesetId) {
            return false;
        }
        $select = new Select();
        $select->from('users')
                            ->columns(array('uid' => 'id', 'ldap', 'groupid'))
                            ->join('codereview',
                                    'users.id = codereview.authorid', array('codereviewId' => 'id', 'codeAuthorId' => 'authorid', 'jiraticket'))
                            ->where(array('codereviewId' => $codereviewId, 'codeAuthorId' => $userId));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        return $result;
    }
    
    public function canUserEditChangeset($userId, $changesetId) 
    {
        return ($this->isUserAdmin($userId) || $this->isUserOwnerOfChangeset($userId, $changesetId) || $this->isUserReviewer($userId));
    }
    
    public function fetchUsersForSelect($selectedOption = 0)
    {
        $result = $this->fetchAll();
        $selectData = array();
        foreach ($result as $res) {
            $selectData[$res['id']] = $res['ldap'];
            if ($res['id'] == $selectedOption) {
                $selectData[$res['id']] = array('value' => $res['id'], 'label' => $res['ldap'], 'selected' => true);
            }
        }
        return $selectData;
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
        $bcrypt = new Bcrypt();
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($users);
        $data["password"] = $bcrypt->create($data["password"]);
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