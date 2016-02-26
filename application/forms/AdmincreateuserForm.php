<?php

class Application_Form_AdmincreateuserForm extends Zend_Form
{
    public function init()
    {
        
    }
    public function startform()
    {
       $this->setName('admincreateuserform');
       $this->setMethod('post');
	   $name =  $this->createElement('text', 'name_admincreate',array('label' => '', 'class'=>'styled_input'  ));
       $name->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['name'] ? $this->my_details['name'] : 'name'))
           ->setOrder(2)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="name")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="name";' 
               ));
	   $username =  $this->createElement('text', 'username_admincreate',array('label' => '', 'class'=>'styled_input'  ));
       $username->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['username'] ? $this->my_details['username'] : 'username'))
           ->setOrder(3)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="username")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="username";' 
               ));
	   $password =  $this->createElement('text', 'password_admincreate',array('label' => '', 'class'=>'styled_input'  ));
       $password->addFilters(array('StringTrim'))
	   	   ->setValue('password')
           ->setOrder(4)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="password")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="password";' 
               ));	
       $school =  $this->createElement('text', 'school_admincreate',array('label' => '', 'class'=>'styled_input'  ));
       $school->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['school'] ? $this->my_details['school'] : 'school'))
           ->setOrder(5)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school";' 
               ));
       $school_postcode =  $this->createElement('text', 'postcode_admincreate',array('label' => '', 'class'=>'styled_input'  ));
       $school_postcode->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['postcode'] ? $this->my_details['postcode'] : 'postcode'))
           ->setOrder(6)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="postcode")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="postcode";' 
               ));
	   $userlevel =  $this->createElement('text', 'userlevel_admincreate',array('label' => '', 'class'=>'styled_input'  ));
       $userlevel->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['userlevel'] ? $this->my_details['userlevel'] : 'userlevel'))
           ->setOrder(7)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="userlevel")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="userlevel";' 
               ));
	   $email =  $this->createElement('text', 'email_admincreate',array('label' => '', 'class'=>'styled_input'  ));
       $email->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['email'] ? $this->my_details['email'] : 'email'))
           ->setOrder(8)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="email";' 
               ));
	   
	   $telephone =  $this->createElement('text', 'telephone_admincreate',array('label' => '', 'class'=>'styled_input'  ));
       $telephone->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['telephone'] ? $this->my_details['telephone'] : 'telephone'))
           ->setOrder(10)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="telephone")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="telephone";' 
               ));	
       /**$roles = new Application_Model_DbTable_Roles();
       $roles_list = $roles->getRolesList();
       $roles_array = $roles_list->toArray();
       $role = $this->createElement('select','popup_createuser_role',array('label' => ''));
       $role->addMultiOptions( $roles_array)
            ->setValue(($this->my_details['role'] ? $this->my_details['role'] : 'role'))
           ->setOrder(4);**/
	   $role =  $this->createElement('text', 'what_admincreate',array('label' => '', 'class'=>'styled_input'  ));
       $role->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['role'] ? $this->my_details['role'] : 'role'))
           ->setOrder(11)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="role")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="role";' 
               ));
	   
       $this->addElements(array(
                   $name,
				   $username,
				   $password,
                   $school,
                   $school_postcode,
				   $userlevel,
				   $telephone,
				   $role
                   ));
    }


}

