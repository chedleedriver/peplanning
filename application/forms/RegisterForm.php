<?php

class Application_Form_RegisterForm extends Zend_Form
{

    public function init()
    {
       //validators
       $nameNotEmpty=new Zend_Validate_NotEmpty();
       $nameNotEmpty->setMessage('You must enter a username');
       
       $passwordNotEmpty=new Zend_Validate_NotEmpty();
       $passwordNotEmpty->setMessage('password cannot be blank');
       
       $isEmail=new Zend_Validate_EmailAddress();
       $isEmail->setMessages(array(
        Zend_Validate_EmailAddress::INVALID => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_FORMAT => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_HOSTNAME => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_LOCAL_PART => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_MX_RECORD => 'Please enter in a valid email address',
        Zend_Validate_EmailAddress::INVALID_SEGMENT => 'Please enter in a valid email address'
    ));
       
       //$email_not_taken = new Zend_Validate_Db_NoRecordExists(
       //        array(
       //            'table'=>'users',
       //            'field'=>'email'
       //        )
       //     );
       //$email_not_taken->setMessage('That email address is already in use');
       
       $isTheSame= new Zend_Validate_Identical();
       $isTheSame->setMessage('The email addresses do not match');
       
       $tooShort = new Zend_Validate_StringLength();
       $tooShort->setMessage('The password length must be between 8 and 40');
       
       $this->setName('Register');
       $this->setMethod('post');
      
       $name =  $this->createElement('text', 'name_reg',array('label' => ''  ));
       $name->addFilters(array('StringTrim'))
           ->setValue('name')
           ->setOrder(1)
           ->setRequired(true)
           ->addValidator($nameNotEmpty,false)
               ->setOptions(array(
               'onfocus'=>'if(this.value=="name")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="name";' 
               ));
       $name_msg =  $this->createElement('text', 'name_reg_msg',array('class' => 'error'  ))
          ->setAttrib('readonly', 'readonly');
       $email =  $this->createElement('text', 'email_reg',array('label' => ''  ));
       $email->addFilters(array('StringTrim'))
           ->setOrder(2)
           ->setValue('email')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="email";' 
               ));
       $email_msg =  $this->createElement('text', 'email_reg_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       $email_confirm =  $this->createElement('text', 'email_confirm_reg',array('label' => ''  ));
       $email_confirm->addFilters(array('StringTrim'))
           ->addErrorMessage('The email addresses do not match')
           ->setOrder(3)
           ->setValue('confirm email')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="confirm email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="confirm email";',
               'onKeyPress'=>'return disableCtrlKeyCombination(event);',
               'onKeyDown'=>'return disableCtrlKeyCombination(event);',
               'oncontextmenu'=>'return false;'
               ));
       $email_confirm_msg =  $this->createElement('text', 'email_confirm_reg_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       $password =  $this->createElement('password','password_reg',array('label' => ''  ));
       $password ->addValidator($tooShort, false,array(5,50))
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
       $password_msg =  $this->createElement('text', 'password_reg_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       $roles = new Application_Model_DbTable_Roles();
       $roles_list = $roles->getRolesList();
       $roles_array = $roles_list->toArray();
       //$role = $this->createElement('text', 'role',array('label' => 'role'  ));
       //$role->setValue("$roles_list");

       $role = $this->createElement('select','role_reg',array('label' => '', 'class' => 'styled-select'));
       $role->addMultiOptions( $roles_array)
            ->setOrder(6);
       $role->addFilters(array('StringTrim'))
               ->setOptions(array(
                  'onchange'=>'updateSelect("role_reg","select_reg");'
               ));

       $role_msg =  $this->createElement('text', 'role_reg_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');

       $select_overlay = $this->createElement('text', 'select_reg', array('class' => 'select_overlay', 'value'=>'role'))
               ->setAttrib('readonly', 'readonly');
       
       $this->addElements(array(
                   $name,
                   $name_msg,
                   $email,
                   $email_msg,
                   $email_confirm,
                   $email_confirm_msg,
                   $password,
                   $password_clear,
                   $password_msg,
                   $role,
                   $role_msg,
                   $select_overlay
                   //$submit,
                   ));
    }


}

