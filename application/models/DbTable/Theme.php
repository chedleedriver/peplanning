<?php

class Application_Model_DbTable_Theme extends Zend_Db_Table_Abstract
{

    protected $_name = 'theme';
    
    public function getLessonTheme($topic_id,$level_id,$theme_id)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('topic_theme'),array('theme_notes'=>'notes'))
                ->join(array('th' => 'theme'),'th.id = topic_theme.theme_id')
                ->join(array('l' => 'level'),'l.id = topic_theme.level')
                ->where('topic_theme.topic_id=?',$topic_id)
                ->where('topic_theme.level=?',$level_id)
                ->where('topic_theme.theme_id=?',$theme_id);
        return $this->fetchAll($select);
    }

}

