<?php

class Application_Model_DbTable_Topic extends Zend_Db_Table_Abstract
{

    protected $_name = 'topic';
    
    public function getTopicList($level,$plan_type)
    {
        if($plan_type=='setplan'){
        $select = $this->select();
        $select->setIntegrityCheck(false)
		->from('topic', '*')
		->join(array('td' => 'topic_description'),'td.topic_id = topic.id', '*')
                ->join(array('g' => 'genre'),'g.id = topic.genre','*')
                ->where('td.topic_level=?',$level)
                ->where('td.topic_description!=?','')
                ->order('g.description');
        return $this->fetchAll($select);
        }
        else {
        $select = $this->select();
        $select->setIntegrityCheck(false)
		->from('topic', '*')
		->join(array('td' => 'topic_description'),'td.topic_id = topic.id', '*')
                ->join(array('g' => 'genre'),'g.id = topic.genre','*')
                ->where('td.topic_level=?',$level)
                ->where('td.topic_description!=?','')
                ->where('status!=?','R')
                ->order('g.description');
        return $this->fetchAll($select);   
        }
     }

}

