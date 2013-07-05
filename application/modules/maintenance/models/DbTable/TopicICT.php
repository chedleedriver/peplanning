<?php

class Maintenance_Model_DbTable_TopicICT extends Zend_Db_Table_Abstract
{

    protected $_name = 'topic_ICT';
    protected $_primary = 'topic_id';
    protected $_referenceMap    = array(
        'topic' => array(
            'columns'           => array('topic_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Topic',
            'refColumns'        => array('id')
        ),
        'ICT' => array(
            'columns'           => array('ICT_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Ict',
            'refColumns'        => array('id')
        )
);

}

