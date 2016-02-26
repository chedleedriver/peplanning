<?php

class Application_Form_LoginForm extends Zend_Form
{

    public function init()
    {
       $this->setName('Loginform');
       $this->setMethod('post');
      
       $userName =  $this->createElement('text', 'userName',array('label' => ''  ));
       $userName->addFilters(array('StringTrim'))
           ->addValidator('StringLength', false,array(3,80))
           ->setValue('username or email')
           ->setOrder(1)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="username or email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="username or email";' 
               ));

       $password =  $this->createElement('password','password',array('label' => ''  ));
       $password ->setRequired(true)
           ->addValidator('StringLength', false,array(5,80))
           ->setOrder(2)
           ->setValue('password')
               ->setOptions(array(
               'onblur'=>'passwordBlur("login");',
               'style'=>'display:none'
               ));
       $password_clear =  $this->createElement('text','password_clear',array('label' => ''  ));
       $password_clear ->setValue('password')
               ->setOrder(3)
                ->setOptions(array(
               'onfocus'=>'passwordFocus("login");'
               ));   
       
       $submit =  $this->createElement('submit','save',array('label' => ''));
       $submit->setRequired(false)
           ->setIgnore(true);

          
       $this->addElements(array(
                   $userName,
                   $password,
                   $password_clear,
                   //$submit,
                    
                   ));
    }


}

