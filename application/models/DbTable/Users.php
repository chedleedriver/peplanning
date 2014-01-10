<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    
    public function activateUser($email_address,$key)
    {
        $data = array(
            'activation' => null
        );
        $where[] = "email='".$email_address."'";
        $where[] = "activation='".$key."'";
        if ($activate = $this->update($data, $where)) return 1;
        else return 0;
    }
    public function activatedUser($check_value,$check_field)
    {
        $where1 = $check_field.'=?';
        $select = $this->select();
        $select->from($this->_name,'id')
                ->where($where1,$check_value)
                ->where('activation is NULL');
        $activate = $this->fetchAll($select);
        return sizeof($activate);
        
    }
    public function payingUser($check_value,$check_field)
    {
        $where1 = $check_field.'=?';
        $select = $this->select();
        $select->from($this->_name,'id')
                ->where($where1,$check_value)
                ->where('user_level>=5');
        $paying = $this->fetchAll($select);
        return sizeof($paying);
        
    }
    public function updateUser($updateField,$updateContent,$updateWhereLeft,$updateWhereRight)
    {
        $data = array(
            $updateField => $updateContent
            );
        $where[] = $updateWhereLeft."='".$updateWhereRight."'";
        if($update = $this->update($data,$where)) return 1;
        else return 0;
    }
    public function getPassword($my_username,$column)
    {
        $column = $column."=?";
        $select = $this->select();
        $select->from($this->_name,'password')
               ->where($column,$my_username)
               ->limit(1);
        return $this->fetchAll($select);
    }
    public function getPasswordForChange($my_id)
    {
        $select = $this->select();
        $select->from($this->_name,'password')
               ->where('id=?',$my_id);
        return $this->fetchRow($select);
    }
    public function getUserDetails($my_id)
    {
        $select = $this->select();
        $select->from($this->_name,array('name','school','postcode','what'))
               ->where('id=?',$my_id);
        return $this->fetchRow($select);
    }
    public function getLoginDetails($my_id)
    {
        $select = $this->select();
        $select->from($this->_name,array('timestamp','num_logins'))
               ->where('id=?',$my_id);
        return $this->fetchRow($select);
    }
    public function alreadyRegistered($email)
    {
        $select = $this->select();
        $select->from($this->_name,'email')
               ->where('email=?',$email);
        if($this->fetchRow($select)) return 1;
        else return 0;
    }
    public function checkForLink($username)
    {
        $select = $this->select();
        $select->from($this->_name,'username')
               ->where('username=?',$username);
        if($this->fetchRow($select)) return 1;
        else return 0;
    }
    public function checkUnifyUser($username)
    {
        $select = $this->select();
        $select->from($this->_name,'userid')
               ->where('userid=?',$username);
        if($this->fetchRow($select)) return 1;
        else return 0;
    }
    public function getUnifyPassword($username)
    {
        $select = $this->select();
        $select->from($this->_name,'password')
               ->where('userid=?',$username);
        return $this->fetchRow($select);
    }
    
    public function getTrialUserDetails()
    {
        $select = $this->select();
        $select->from($this->_name,array('id','name','email','subscribed','num_logins'))
               ->where('userlevel=?',4)
               ->where('subscribed is not NULL');
        return $this->fetchAll($select);
    }
    public function createUnifyUser($username,$name,$school,$email,$password)
    {
        $add_user=$this->createRow();
        $add_user->name=$name;
        $add_user->username=$username;
        $add_user->email=$email;
        $add_user->password=$password;
        $add_user->what='Unify';
        $add_user->userlevel='4';
        $add_user->userid=$username;
        $add_user->school=$school;
        $add_user->timestamp=time();
        $add_user->subscribed=time();
        $add_user->num_logins=0;
        return $add_user->save();
        
    }
}

