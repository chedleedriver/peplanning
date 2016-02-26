<?php

class Application_Form_TrialForm extends Zend_Form
{

    public function init()
    {
       //validators
       $roleNotEmpty=new Zend_Validate_NotEmpty();
       $roleNotEmpty->setMessage('You must select a role');
       
       $passwordNotEmpty=new Zend_Validate_NotEmpty();
       $passwordNotEmpty->setMessage('password cannot be blank');
       
       $fieldNotEmpty=new Zend_Validate_InArray(
               array(
                   'name_trial' => 'name',
                   'telephone_trial' => 'telephone',
                   'school_trial' => 'school',
                   'school_postcode_trial' => 'school postcode',
                   ));
       $fieldNotEmpty->setMessage('Field must be completed');
       
       $isEmail=new Zend_Validate_EmailAddress();
       $isEmail->setMessages(array(
        Zend_Validate_EmailAddress::INVALID => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_FORMAT => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_HOSTNAME => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_LOCAL_PART => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_MX_RECORD => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_SEGMENT => 'Please enter in a valid email address'
    ));
       
       $email_not_taken = new Zend_Validate_Db_NoRecordExists(
               array(
                   'table'=>'users',
                   'field'=>'email'
               )
            );
       $email_not_taken->setMessage('That email address is already in use');
       
       $isTheSame= new Zend_Validate_Identical();
       $isTheSame->setMessage('The email addresses do not match');
       
       $tooShort = new Zend_Validate_StringLength();
       $tooShort->setMessage('The password length must be between 8 and 40');
       
       $this->setName('Trial');
       $this->setMethod('post');
      
       $name =  $this->createElement('text', 'name_trial',array('label' => ''  ));
       $name->addFilters(array('StringTrim'))
           ->setValue('name')
           ->setOrder(1)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="name")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="name";' 
               ));
       $name_msg =  $this->createElement('text', 'name_trial_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');;
       
       $email =  $this->createElement('text', 'email_trial',array('label' => ''  ));
       $email->addFilters(array('StringTrim'))
           ->setOrder(2)
           ->setValue('email')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="email";' 
               ));
       $email_msg =  $this->createElement('text', 'email_trial_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       
       $email_confirm =  $this->createElement('text', 'email_confirm_trial',array('label' => ''  ));
       $email_confirm->addFilters(array('StringTrim'))
           ->setRequired(true)
           ->setOrder(3)
           ->setValue('confirm email')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="confirm email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="confirm email";',
               'onKeyPress'=>'return disableCtrlKeyCombination(event);',
               'onKeyDown'=>'return disableCtrlKeyCombination(event);',
               'oncontextmenu'=>'return false;'
               ));
       $email_confirm_msg =  $this->createElement('text', 'email_confirm_trial_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       
       $telephone =  $this->createElement('text', 'telephone_trial',array('label' => ''  ));
       $telephone->addFilters(array('StringTrim'))
           ->setValue('telephone')
           ->setOrder(4)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="telephone")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="telephone";' 
               ));
       $telephone_msg =  $this->createElement('text', 'telephone_trial_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       
       $school_name =  $this->createElement('text', 'school_trial',array('label' => ''  ));
       $school_name->addFilters(array('StringTrim'))
           ->setValue('school')
           ->setOrder(5)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school";' 
               ));
       $school_name_msg =  $this->createElement('text', 'school_trial_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       
       $school_postcode =  $this->createElement('text', 'postcode_trial',array('label' => ''  ));
       $school_postcode->addFilters(array('StringTrim'))
           ->setValue('postcode')
           ->setOrder(6)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="postcode")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="postcode";' 
               ));
       $school_postcode_msg =  $this->createElement('text', 'postcode_trial_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       
       /**$password =  $this->createElement('password','password_reg',array('label' => ''  ));
       $password ->addValidator($tooShort, false,array(5,50))
           ->setRequired(true)
           ->setOrder(4)
           ->addValidator($passwordNotEmpty,false)
               ->setOptions(array(
               'onblur'=>'passwordBlur("register");',
               'style'=>'display:none'
               ));
       $password_clear =  $this->createElement('text','password_reg_clear',array('label' => ''  ));
       $password_clear ->setValue('password')
               ->setOrder(5)
               ->setOptions(array(
               'onfocus'=>'passwordFocus("register");'
               ));  
       $password_msg =  $this->createElement('text', 'password_reg_msg',array('class' => 'error'  ));**/
       $roles = new Application_Model_DbTable_Roles();
       $roles_list = $roles->getRolesList();
       $roles_array = $roles_list->toArray();
       //$role = $this->createElement('text', 'role',array('label' => 'role'  ));
       //$role->setValue("$roles_list");
       $role = $this->createElement('select','role_trial',array('label' => '', 'class'=>'styled-select'));
       $role->addMultiOptions( $roles_array)
            ->setOrder(7)
            ->addValidator($roleNotEmpty,false);
       $role->addFilters(array('StringTrim'))
               ->setOptions(array(
                  'onchange'=>'updateSelect("role_trial","select_trial");'
               ));

       $role_msg =  $this->createElement('text', 'role_trial_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');

       $select_overlay = $this->createElement('text', 'select_trial', array('class' => 'select_overlay', 'value'=>'role'))
               ->setAttrib('readonly', 'readonly');
       
       $this->addElements(array(
                   $name,
                   $name_msg,
                   $email,
                   $email_msg,
                   $email_confirm,
                   $email_confirm_msg,
                   $telephone,
                   $telephone_msg,
                   $school_name,
                   $school_name_msg,
                   $school_postcode,
                   $school_postcode_msg,
                   $role,
                   $role_msg,
                   $select_overlay
                   //$submit,
                   ));
    }

}

