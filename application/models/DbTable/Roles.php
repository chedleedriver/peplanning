<?php

class Application_Model_DbTable_Roles extends Zend_Db_Table_Abstract
{

    protected $_name = 'school_roles';
    
    public function getRolesList()
    {
        $select = $this->select()
                ->from($this->_name,
                        array('key'=>'id','value'=>'school_role'))
                ->order('id');
        return $this->fetchAll($select);
    }
    

}

