<?php

namespace Backup\Model;

use Zend\Db\TableGateway\TableGateway;

class BackupTable
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

    public function getBackup($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveBackup(Backup $backup)
    {
        $data = array(            
            'Reviewer' => $backup->Reviewer,
            'DateTimeBegin' => $backup->DateTimeBegin,
            'DateTimeEnd' => $backup->DateTimeEnd
        );

        $id = (int) $backup->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getBackup($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Backup id does not exist');
            }
        }
    }

    public function deleteBackup($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}