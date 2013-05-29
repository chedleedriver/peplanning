<?php

class Maintenance_Model_DbTable_TopicCitizenship extends Zend_Db_Table_Abstract
{

    protected $_name = 'topic_citizenship';
    protected $_primary = 'topic_id';
    protected $_referenceMap    = array(
        'topic' => array(
            'columns'           => array('topic_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Topic',
            'refColumns'        => array('id')
        ),
        'citizenship' => array(
            'columns'           => array('citizenship_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Citizenship',
            'refColumns'        => array('id')
        )
);

}

