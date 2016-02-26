<?php

class Application_Model_DbTable_Lesson extends Zend_Db_Table_Abstract
{

    protected $_name = 'lesson';
    
    public function getUnitLessons($unit_id,$my_id,$my_level)
    {
        $select = $this->select();
	$select->setIntegrityCheck(false)
                ->from(array($this->_name),array('user_id'=>new Zend_Db_Expr($my_id),'user_level'=>new Zend_Db_Expr($my_level),'id','uow_id','lesson_num','theme_id','set_lesson_id'))
		->join(array('th' => 'theme'),'th.id = lesson.theme_id', 'theme')
                ->where('uow_id=?',$unit_id)
                ->order('lesson_num');
	return $this->fetchAll($select);
    }
    
    public function createLesson($unit_id,$lesson_num)
    {
        $newLesson = $this->insert(array('uow_id'=>$unit_id,'lesson_num'=>$lesson_num));
        return $newLesson;
    }
    
    public function getLessonDetails($unit_id,$lesson_num,$key,$table,$column,$join_column)
    {
        $join_table='lesson_'.strtolower($table);
        $join_condition=$table.".".$key.'='.$join_column;
        $order_column=$table.".id";
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array($this->_name),array('id','sen','ta'))
                ->join(array($join_table),'lesson.id=lesson_id')
                ->join(array($table),$join_condition,array($key,$column))
                ->where('lesson.uow_id=?',$unit_id)
                ->where('lesson.lesson_num=?',$lesson_num)
                ->order($order_column);
        return $this->fetchAll($select);
        return $select;
    }
	
	public function getSetLessonId($lesson_id)
	{
		$select = $this->select();
		$select->from($this->_name,'set_lesson_id')
				->where('id=?',$lesson_id);
		return $this->fetchRow($select);
	}
}

