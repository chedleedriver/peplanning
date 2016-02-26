<?php

class Application_Model_DbTable_ActiveGuests extends Zend_Db_Table_Abstract
{

    protected $_name = 'active_guests';
    public function updateUser($updateField,$updateContent,$updateWhereLeft,$updateWhereRight)
    {
        $where[] = $updateWhereLeft."='".$updateWhereRight."'";
        $select = $this->select($where);
        if($this->fetchAll($select)) $this->removeUser($updateWhereLeft,$updateWhereRight);
        $data = array(
            $updateField => $updateContent,
            $updateWhereLeft=> $updateWhereRight
            );
        if($update = $this->insert($data)) return 1;
        else return 0;
    }
    public function removeUser($removeWhereLeft,$removeWhereRight)
    {
        $where[] = $removeWhereLeft."='".$removeWhereRight."'";
        if($update = $this->delete($where)) return 1;
        else return 0;
    }
    public function removeIdleUser()
    {
        $timeout = time()-10*60;
        $where[] = "timestamp < $timeout";
        $this->delete($where);
    }
}

