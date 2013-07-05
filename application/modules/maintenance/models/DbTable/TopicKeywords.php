<?php

class Maintenance_Model_DbTable_TopicKeywords extends Zend_Db_Table_Abstract
{

    protected $_name = 'topic_keywords';
    protected $_primary = 'topic_id';
    protected $_referenceMap    = array(
        'topic' => array(
            'columns'           => array('topic_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Topic',
            'refColumns'        => array('id')
        ),
        'keywords' => array(
            'columns'           => array('keywords_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Keywords',
            'refColumns'        => array('id')
        )
);

}

