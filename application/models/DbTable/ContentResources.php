<?php

class Application_Model_DbTable_ContentResources extends Zend_Db_Table_Abstract
{

    protected $_name = 'content_resources';
    
    public function getLessonResources($lesson_id)
    {
        $select = $this->select();
	$select->setIntegrityCheck(false)
                ->from(array($this->_name),array('description','location','type'))
		->joinLeft('lesson_activities','lesson_activities.activity_id = content_resources.content_id')
                ->where('lesson_activities.lesson_id=?',$lesson_id);
	return $this->fetchAll($select);
        }//->from(array($this->_name),array('id','content_id','description','name','location','type'))

}

