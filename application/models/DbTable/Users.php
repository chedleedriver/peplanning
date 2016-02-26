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
	public function getEmail($my_username)
    {
        $select = $this->select();
        $select->from($this->_name,'email')
               ->where("username=?",$my_username)
               ->limit(1);
        return $this->fetchRow($select);
    }
    public function getEmailById($id)
    {
        $select = $this->select();
        $select->from($this->_name,'email')
               ->where("id=?",$id)
               ->limit(1);
        return $this->fetchRow($select);
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
    public function getAdminUserDetails($user_id)
    {
        $select = $this->select();
        $select->from($this->_name,array('id','name','username','password','school','postcode','school_id','userlevel','email','timestamp','telephone','what','num_logins','subscribed'))
               ->where('id=?',$user_id);
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
	public function emailSubscriptionStatus($email)
    {
        $select = $this->select();
        $select->from($this->_name,'newsletter')
               ->where('email=?',$email)
			   ->where('newsletter is not NULL');
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
        $select->from($this->_name,array('id','name','email','subscribed','num_logins','what'))
               ->where('userlevel=?',4)
               ->where('subscribed is not NULL')
			   ->where('newsletter is NULL');
        return $this->fetchAll($select);
    }
    
	public function getPostTrialUserDetails()
    {
        $select = $this->select();
        $select->from($this->_name,array('id','name','email','subscribed','num_logins','what'))
               ->where('userlevel=?',1)
               ->where('subscribed is not NULL')
			   ->where('newsletter is NULL');
        return $this->fetchAll($select);
    }
    public function createUser($values)
	{
        $add_user=$this->createRow();
        $add_user->name=$values['name_admincreate'];
        $add_user->username=$values['username_admincreate'];
        $add_user->email=$values['username_admincreate'];
        $add_user->password=md5($values['password_admincreate']);
		$add_user->postcode=$values['postcode_admincreate'];
        $add_user->how='Admin';
        $add_user->userlevel=$values['userlevel_admincreate'];
        $add_user->school=$values['school_admincreate'];
        $add_user->subscribed=time();
        $add_user->telephone=$values['telephone_admincreate'];
		$add_user->what=$values['what_admincreate'];
		return $add_user->save();
        
    }
	public function admincreateschoolUsers($values)
	{
		$add_user=$this->createRow();
        $add_user->name=$values['nameXschoolusercreate'];
        $add_user->username=$values['usernameXschoolusercreate'];
        $add_user->email=$values['usernameXschoolusercreate'];
        $add_user->password=md5($values['passwordXschoolusercreate']);
		$add_user->postcode=$values['postcodeXschoolusercreate'];
        $add_user->school_id=$values['school_idXschoolusercreate'];
		$add_user->how='Admin';
        $add_user->userlevel=5;
        $add_user->school=$values['schoolXschoolusercreate'];
        $add_user->subscribed=$values['sub_fromXschoolusercreate'];
        $add_user->telephone=$values['telephoneXschoolusercreate'];
		$add_user->what=1;
		return $add_user->save();
	}
	public function signupcreateschoolUsers($values)
	{
		$add_user=$this->createRow();
		$add_user->name=$values['school_user_name'];
        $add_user->username=$values['school_user_email'];
        $add_user->email=$values['school_user_email'];
        $add_user->password=md5($values['school_user_school']);
		$add_user->school_id=$values['school_id'];
		$add_user->school=$values['school_user_school'];
		$date_from = explode("-",$values['school_user_start']);
		$start_date=mktime(0,0,0,$date_from[1],$date_from[0], $date_from[2]);
		$add_user->subscribed=$start_date;
		$add_user->how='Admin';
        $add_user->userlevel=5;
        $add_user->what=1;
		return $add_user->save();	
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
	public function getUserList($ulevel,$sort_by,$direction,$where)
	{
		$select = $this->select();
        $select->from($this->_name,array('id','username','name','userlevel','email','timestamp','school','postcode','subscribed','num_logins','what'))
               ->where('userlevel>=?',$ulevel)
			   ->where('username LIKE ?',$where)
			   ->orwhere('name LIKE ?',$where)
			   ->orwhere('school LIKE ?',$where)
			   ->orwhere('email LIKE ?',$where)
			   ->order("$sort_by $direction");
        return $this->fetchAll($select);
	}
	public function getSchoolUserList($sort_by,$direction,$where)
	{
		$select = $this->select();
        $select->from($this->_name,array('id','username','name','userlevel','email','timestamp','school','postcode','subscribed','num_logins','what'))
               ->where('school_id=?',$where)
			   ->order("$sort_by $direction");
        return $this->fetchAll($select);
	}
	public function getSchoolUserIdList($where)
	{
		$select = $this->select();
        $select->from($this->_name,array('id'))
               ->where('school_id=?',$where);
        return $this->fetchAll($select);
	}
	public function deleteUser($u_id)
    {
		$where[] = "id = $u_id";
        return $this->delete($where);
    }
}

