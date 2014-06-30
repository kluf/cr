<?php

namespace Usergroups\Model;

use Zend\Db\TableGateway\TableGateway;

class UsergroupsTable
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

    public function getUsergroups($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveUsergroups(Usergroups $usergroups)
    {
        $data = array(            
            'name' => $usergroups->name
        );

        $id = (int) $usergroups->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUsergroups($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Usergroups id does not exist');
            }
        }
    }

    public function deleteUsergroups($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}