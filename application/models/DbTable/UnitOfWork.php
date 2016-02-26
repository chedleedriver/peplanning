<?php

class Application_Model_DbTable_UnitOfWork extends Zend_Db_Table_Abstract
{

    protected $_name = 'unit_of_work';
    
    public function CreateUnit($teacher_id,$topic_id,$topic,$level,$title,$num_lessons,$plan_type)
    {
        $new_unit=$this->insert(array('description'=>$title,'topic_id'=>$topic_id,'level_id'=>$level,'teacher_id'=>$teacher_id,'num_lessons'=>$num_lessons));
        return $new_unit;
    }
    public function deleteGuestUnits()
    {
        $where[] = "teacher_id >= '9000001'";
        $delete_unit=$this->delete($where);
    }
	public function getGuestUnits()
	{
		$select = $this->select();
        $select->from($this->_name,'id')
               ->where('teacher_id >=?','9000001');
        return $this->fetchAll($select);
	}
    public function getOwner($unit_id)
    {
        $select = $this->select();
        $select->from($this->_name,'teacher_id')
               ->where('id=?',$unit_id);
        return $this->fetchAll($select);
    }
    public function getUnitdetails($unit_id)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
               ->from($this->_name,array('description','level_id'))
               ->join('topic','topic.id = unit_of_work.topic_id', 'name')
               ->join('users','users.id = unit_of_work.teacher_id',array('name','school')) 
               ->where('unit_of_work.id=?',$unit_id);
        return $this->fetchRow($select);
    }

}

