<?php

class Application_Model_DbTable_SetPlanLessons extends Zend_Db_Table_Abstract
{

    protected $_name = 'set_plan_lessons';
    protected $_primary = 'set_plan_id';
    
    public function checkSetPlan($topic_id,$level,$num_lessons)
    {
        $set_plan_select = "(select distinct(set_plan_id) from set_plans where topic_id=$topic_id and num_lessons=$num_lessons and level=$level)";
        $select = $this->select();
	$select->from($this->_name)
		->where('set_plan_id = ?',new Zend_Db_Expr($set_plan_select));
	return $this->fetchAll($select);
        //return $select;
        }//->from(array($this->_name),array('id','content_id','description','name','location','type'))

}

