<?php

class Maintenance_Model_DbTable_TopicEquipment extends Zend_Db_Table_Abstract
{

    protected $_name = 'topic_equipment';
    protected $_primary = 'topic_id';
    protected $_referenceMap    = array(
        'topic' => array(
            'columns'           => array('topic_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Topic',
            'refColumns'        => array('id')
        ),
        'equipment' => array(
            'columns'           => array('equipment_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Equipment',
            'refColumns'        => array('id')
        )
);

}

