<?php

class Application_Form_EdituserForm extends Zend_Form
{
    private $my_details;
    
    public function init()
    {
        
    }
    public function setvars($user_details)  
    {  
        //set the variable  
        $this->my_details['name'] = $user_details['name'];
        $this->my_details['school'] = $user_details['school'];
        $this->my_details['postcode'] = $user_details['postcode'];
        $this->my_details['role'] = $user_details['what'];
    }  
    public function startform()
    {
       $this->setName('edituserform');
       $this->setMethod('post');
       $name =  $this->createElement('text', 'name',array('label' => '', 'class'=>'styled_input'  ));
       $name->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['name'] ? $this->my_details['name'] : 'name'))
           ->setOrder(1)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="name")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="name";' 
               ));
       $school =  $this->createElement('text', 'school',array('label' => '', 'class'=>'styled_input'  ));
       $school->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['school'] ? $this->my_details['school'] : 'school'))
           ->setOrder(2)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school";' 
               ));
       $school_postcode =  $this->createElement('text', 'postcode',array('label' => '', 'class'=>'styled_input'  ));
       $school_postcode->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['postcode'] ? $this->my_details['postcode'] : 'postcode'))
           ->setOrder(3)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="postcode")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="postcode";' 
               ));
       $roles = new Application_Model_DbTable_Roles();
       $roles_list = $roles->getRolesList();
       $roles_array = $roles_list->toArray();
       //$role = $this->createElement('text', 'role',array('label' => 'role'  ));
       //$role->setValue("$roles_list");
       $role = $this->createElement('select','popup_edituser_role',array('label' => ''));
       $role->addMultiOptions( $roles_array)
            ->setValue(($this->my_details['role'] ? $this->my_details['role'] : 'role'))
           ->setOrder(4);
       
       $this->addElements(array(
                   $name,
                   $school,
                   $school_postcode,
                   //$role,
                   //$submit,
                   ));
    }


}

