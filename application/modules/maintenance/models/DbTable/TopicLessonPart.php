<?php

class Maintenance_Model_DbTable_TopicLessonPart extends Zend_Db_Table_Abstract
{

    protected $_name = 'topic_lesson_part';
    protected $_primary = 'topic_id';
    protected $_referenceMap    = array(
        'topic' => array(
            'columns'           => array('topic_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Topic',
            'refColumns'        => array('id')
        ),
        'lesson_part' => array(
            'columns'           => array('lesson_part_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_LessonPart',
            'refColumns'        => array('id')
        )
);

}

