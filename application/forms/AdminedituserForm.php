<?php

class Application_Form_AdminedituserForm extends Zend_Form
{
    private $my_details;
    
    public function init()
    {
        
    }
    public function setvars($user_details)  
    {  
        //set the variable 
		$this->my_details['id'] = $user_details['id'];
        $this->my_details['name'] = $user_details['name'];
		$this->my_details['username'] = $user_details['username'];
		$this->my_details['password'] = $user_details['password'];
        $this->my_details['school'] = $user_details['school'];
        $this->my_details['postcode'] = $user_details['postcode'];
		$this->my_details['school_id'] = $user_details['school_id'];
		$this->my_details['userlevel'] = $user_details['userlevel'];
		$this->my_details['email'] = $user_details['email'];
		$this->my_details['last_login'] = $user_details['timestamp'];
		$this->my_details['telephone'] = $user_details['telephone'];
        $this->my_details['what'] = $user_details['what'];
		$this->my_details['num_logins'] = $user_details['num_logins'];
		$this->my_details['subscribed'] = $user_details['subscribed'];
		
    }  
    public function startform()
    {
       $this->setName('adminedituserform');
       $this->setMethod('post');
	   $id =  $this->createElement('text', 'idXadminedit',array('label' => '', 'class'=>'styled_input', 'readonly' => 'true'  ));
       $id->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['id'] ? $this->my_details['id'] : 'id' ))
           ->setOrder(1)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="id")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="id";' 
               ));
       $name =  $this->createElement('text', 'nameXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $name->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['name'] ? $this->my_details['name'] : 'name'))
           ->setOrder(2)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="name")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="name";' 
               ));
	   $username =  $this->createElement('text', 'usernameXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $username->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['username'] ? $this->my_details['username'] : 'username'))
           ->setOrder(3)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="username")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="username";' 
               ));
	   $password =  $this->createElement('text', 'passwordXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $password->addFilters(array('StringTrim'))
	   	   ->setValue('password')
           ->setOrder(4)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="password")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="password";' 
               ));	
       $school =  $this->createElement('text', 'schoolXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $school->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['school'] ? $this->my_details['school'] : 'school'))
           ->setOrder(5)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school";' 
               ));
       $school_postcode =  $this->createElement('text', 'postcodeXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $school_postcode->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['postcode'] ? $this->my_details['postcode'] : 'postcode'))
           ->setOrder(6)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="postcode")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="postcode";' 
               ));
	   $school_id =  $this->createElement('text', 'school_idXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $school_id->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['school_id'] ? $this->my_details['school_id'] : 'school_id'))
           ->setOrder(7)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school_id")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school_id";' 
               ));
	   $userlevel =  $this->createElement('text', 'userlevelXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $userlevel->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['userlevel'] ? $this->my_details['userlevel'] : 'userlevel'))
           ->setOrder(8)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="userlevel")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="userlevel";' 
               ));
	   $email =  $this->createElement('text', 'emailXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $email->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['email'] ? $this->my_details['email'] : 'email'))
           ->setOrder(9)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="email";' 
               ));
	   $last_login =  $this->createElement('text', 'timestampXadminedit',array('label' => '', 'class'=>'styled_input',  'readonly' => 'true'   ));
       $last_login->addFilters(array('StringTrim'))
           ->setValue((date("F dS, Y H:i",$this->my_details['last_login']) ? date("F dS, Y H:i",$this->my_details['last_login']) : 'last_login'))
           ->setOrder(10)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="last_login")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="last_login";' 
               ));
	   $telephone =  $this->createElement('text', 'telephoneXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $telephone->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['telephone'] ? $this->my_details['telephone'] : 'telephone'))
           ->setOrder(11)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="telephone")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="telephone";' 
               ));	
       /**$roles = new Application_Model_DbTable_Roles();
       $roles_list = $roles->getRolesList();
       $roles_array = $roles_list->toArray();
       $role = $this->createElement('select','popup_edituser_role',array('label' => ''));
       $role->addMultiOptions( $roles_array)
            ->setValue(($this->my_details['role'] ? $this->my_details['role'] : 'role'))
           ->setOrder(4);**/
	   $role =  $this->createElement('text', 'whatXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $role->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['what'] ? $this->my_details['what'] : 'what'))
           ->setOrder(12)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="what")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="what";' 
               ));
	   $num_logins =  $this->createElement('text', 'num_loginsXadminedit',array('label' => '', 'class'=>'styled_input' ));
       $num_logins->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['num_logins'] ? $this->my_details['num_logins'] : 'num_logins'))
           ->setOrder(13)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="num_logins")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="num_logins";' 
               ));
	   $subscribed =  $this->createElement('text', 'subscribedXadminedit',array('label' => '', 'class'=>'styled_input'  ));
       $subscribed->addFilters(array('StringTrim'))
           ->setValue((date("d-m-Y",$this->my_details['subscribed']) ? date("d-m-Y",$this->my_details['subscribed']) : 'subscribed'))
           ->setOrder(14)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="subscribed")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="subscribed";' 
               ));
       
       $this->addElements(array(
                   $id,
				   $name,
				   $username,
				   $password,
                   $school,
                   $school_postcode,
				   $school_id,
				   $userlevel,
				   $email,
				   $last_login,
                   $telephone,
				   $role,
				   $num_logins,
				   $subscribed
                   ));
    }


}

