<?php

namespace Schedule\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ScheduleTable
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
    
    public function fetchScheduleWithUsers()
    {   
        $select = new Select();
        $select->from('schedule')
                ->columns(array('id', 'Reviewer', 'DateTimeBegin', 'DateTimeEnd'))
                ->join('users',
                        'schedule.reviewer = users.id', array('idd' => 'id', 'ldap'));
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }
    
    public function getSchedule($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveSchedule(Schedule $schedule)
    {
        $data = array(            
            'Reviewer' => $schedule->Reviewer,
            'DateTimeBegin' => $schedule->DateTimeBegin,
            'DateTimeEnd' => $schedule->DateTimeEnd
        );

        $id = (int) $schedule->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getSchedule($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Schedule id does not exist');
            }
        }
    }

    public function deleteSchedule($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}