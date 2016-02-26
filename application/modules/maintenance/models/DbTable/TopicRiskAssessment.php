<?php

class Maintenance_Model_DbTable_TopicRiskAssessment extends Zend_Db_Table_Abstract
{

    protected $_name = 'topic_risk_assessment';
    protected $_primary = 'topic_id';
    protected $_referenceMap    = array(
        'topic' => array(
            'columns'           => array('topic_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_Topic',
            'refColumns'        => array('id')
        ),
        'risk_assessment' => array(
            'columns'           => array('risk_assessment_id'),
            'refTableClass'     => 'Maintenance_Model_DbTable_RiskAssessment',
            'refColumns'        => array('id')
        )
);

}

