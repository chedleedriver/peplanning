<?php

class Maintenance_Model_DbTable_TopicNumeracy extends Zend_Db_Table_Abstract
{

    protected $_name = 'topic_numeracy';
    protected $_primary = 'topic_id';
    protected $_referenceMap    = array(
        'topic' => array(
            'columns'           => array('topic_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Topic',
            'refColumns'        => array('id')
        ),
        'numeracy' => array(
            'columns'           => array('numeracy_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Numeracy',
            'refColumns'        => array('id')
        )
);

}

