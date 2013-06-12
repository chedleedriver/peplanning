<?php

class Application_Form_ContactForm extends Zend_Form
{

    public function init()
    {
       //validators
       $nameNotEmpty=new Zend_Validate_NotEmpty();
       $nameNotEmpty->setMessage('Please enter your name');
       
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
       
       $this->setName('contact');
       $this->setMethod('post');
      
       $name =  $this->createElement('text', 'name_contact',array('label' => ''  ));
       $name->addFilters(array('StringTrim'))
           ->setValue('name')
           ->setOrder(1)
           ->setRequired(true)
           ->addValidator($nameNotEmpty,false)
               ->setOptions(array(
               'onfocus'=>'if(this.value=="name")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="name";' 
               ));
       $name_msg =  $this->createElement('text', 'name_contact_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       
       $email =  $this->createElement('text', 'email_contact',array('label' => ''  ));
       $email->addFilters(array('StringTrim'))
           ->addValidator($isEmail,true)
           ->setOrder(2)
           ->setValue('email address')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="email address")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="email address";' 
               ));
       $email_msg =  $this->createElement('text', 'email_contact_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       
       
       $details =  $this->createElement('textarea', 'details_contact',array('label' => '','cols'=>'30','rows'=>'6'  ));
       $details->addFilters(array('StringTrim'))
           ->setValue('How can we help?')
           ->setOrder(5)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="How can we help?")this.value="";',
               'onblur'=>'if(this.value=="")this.value="How can we help?";'
               ));
       $details_msg =  $this->createElement('text', 'details_contact_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly');
       
       $nature = $this->createElement('select','nature_contact',array('label' => '', 'class'=>'styled-select'));
       $nature->addFilters(array('StringTrim'))
               ->setOptions(array(
                  'onchange'=>'updateSelect("nature_contact","select_git");'
               ));
       $nature->addMultiOptions( array(
        'type' => 'What can we help you with?',
        'question' => 'General Enquiry',
        'price' => 'Pricing Enquiry',
        'trial' => 'Trial Request',
        'other' => 'Not Listed',
        ))
        ->setOrder(4);
       
       $select_overlay = $this->createElement('text', 'select_git', array('class' => 'select_overlay', 'value'=>'What can we help you with?'))
               ->setAttrib('readonly', 'readonly');
       
       $this->addElements(array(
                   $name,
                   $name_msg,
                   $email,
                   $email_msg,
                   $select_overlay,
                   $nature,
                   $details                   
                   //$submit,
                   ));
    }

}