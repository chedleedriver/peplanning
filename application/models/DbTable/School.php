<?php

class Application_Model_DbTable_School extends Zend_Db_Table_Abstract
{

    protected $_name = 'school';
    
    public function checkSchool($school_name)
    {
        $select = $this->select();
        $select->from($this->_name,'school')
               ->where('school=?',$school_name);
        if($this->fetchRow($select)) return 1;
        else return 0;

    }

    
    public function createSchool($values,$licence)
    {
        $add_school=$this->createRow();
        $add_school->school=$values['school_payment'];
        $add_school->address1=$values['school_address_payment_1'];
        $add_school->address2=$values['school_address_payment_2'];
        $add_school->address3=$values['school_address_payment_3'];
        $add_school->postcode=$values['postcode_payment'];
        $add_school->email=$values['email_payment'];
        $add_school->contact=$values['name_payment'];
        $add_school->licence=$licence;
        $add_school->approved='N';
        if($values['service_payment']=='peteacher') {
          $add_school->classnum=1;
          $add_school->total_cost='60';
        }
        else {
          $add_school->classnum=$values['service_classes'];
          if($values['service_classes']<=5) $add_school->total_cost='60';
          elseif($values['service_classes']<=5) $add_school->total_cost='100';
          elseif($values['service_classes']<=12) $add_school->total_cost='175';
          else $add_school->total_cost='225';
        }
        $add_school->subfrom=date("d-m-Y");
        $add_school->subto=date("d-m-Y",strtotime('+1 year'));
        return $add_school->save();
        
    }
	public function admincreateSchool($values)
    {
        $add_school=$this->createRow();
        $add_school->school=$values['schoolXschooledit'];
        $add_school->address1=$values['address1Xschooledit'];
        $add_school->address2=$values['address2Xschooledit'];
        $add_school->address3=$values['address3Xschooledit'];
        $add_school->postcode=$values['postcodeXschooledit'];
        $add_school->email=$values['emailXschooledit'];
        $add_school->contact=$values['contactXschooledit'];
		$add_school->telephone=$values['telephoneXschooledit'];
        $add_school->licence=$values['licenceXschooledit'];;
        $add_school->approved=$values['approvedXschooledit'];
        $add_school->classnum=$values['classnumXschooledit'];
        $add_school->total_cost=$values['total_costXschooledit'];
		$date_from = explode("-",$values['subfromXschooledit']);
		$add_school->subfrom=mktime(0,0,0,$date_from[1],$date_from[0], $date_from[2]);
		$date_to = explode("-",$values['subtoXschooledit']);
		$add_school->subto=mktime(0,0,0,$date_to[1],$date_to[0], $date_to[2]);
        $add_school->save();
		return $this->getAdapter()->lastInsertId();
        
    }
	public function signupcreateSchool($values)
    {
        $add_school=$this->createRow();
		$add_school->school=$values['school_signup_school_name'];
		$add_school->address1=$values['school_signup_school_address_1'];
		$add_school->address2=$values['school_signup_school_address_2'];
		$add_school->postcode=$values['school_signup_school_postcode'];
		$add_school->contact=$values['school_signup_contact_name'];
		$add_school->email=$values['school_signup_contact_email'];
		$add_school->classnum=$values['school_signup_num_accounts'];
		$date_from = explode("-",$values['school_signup_school_startdate']);
		$start_date=mktime(0,0,0,$date_from[1],$date_from[0], $date_from[2]);
		$renew_date=strtotime('+ 1 year',$start_date);
		$add_school->subfrom=$start_date;
		$add_school->subto=$renew_date;
		$add_school->save();
		return $this->getAdapter()->lastInsertId();
        
    }
	public function getSchoolList($sort_by,$direction,$where)
	{
		$select = $this->select();
        $select->from($this->_name,array('id','school','telephone','contact','email','total_cost','classnum','postcode','subfrom','subto','licence','approved'))
			   ->where('school LIKE ?',$where)
			   ->orwhere('address1 LIKE ?',$where)
			   ->orwhere('address2 LIKE ?',$where)
			   ->orwhere('address3 LIKE ?',$where)
			   ->orwhere('email LIKE ?',$where)
			   ->orwhere('postcode LIKE ?',$where)
			   ->orwhere('contact LIKE ?',$where)
               ->order("$sort_by $direction");
        return $this->fetchAll($select);
	}
	public function getAdminSchoolDetails($school_id)
    {
        $select = $this->select();
        $select->from($this->_name,array('id','school','address1','address2','address3','telephone','contact','email','total_cost','classnum','postcode','subfrom','subto','licence','approved'))
               ->where('id=?',$school_id);
        return $this->fetchRow($select);
    }
	public function updateSchool($updateField,$updateContent,$updateWhereLeft,$updateWhereRight)
    {
        $data = array(
            $updateField => $updateContent
            );
        $where[] = $updateWhereLeft."='".$updateWhereRight."'";
        if($update = $this->update($data,$where)) return 1;
        else return 0;
    }
	public function deleteSchool($s_id)
    {
		$where[] = "id = $s_id";
        return $this->delete($where);
    }
}

