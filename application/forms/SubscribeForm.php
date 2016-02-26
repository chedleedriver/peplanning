<?php

class Application_Form_SubscribeForm extends Sub_Table_Form
{

    public function init()
    {
       //validators
       $this->setName('Subscribeform');
       $this->setMethod('post');
      
       $name =  $this->createElement('text', 'name_subscribe',array('label' => '', 'class'=>'styled_input'  ));
       $name->addFilters(array('StringTrim'))
           ->setValue('name')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="name")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="name";' 
               ))
           ->setAttrib('tabindex', 1);
       $this->addElement($name);
       $name_msg =  $this->createElement('text', 'name_subscribe_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('tabindex', -1);
       $this->addElement($name_msg);
       $email =  $this->createElement('text', 'email_subscribe',array('label' => '', 'class'=>'styled_input'  ));
       $email->addFilters(array('StringTrim'))
           ->setValue('email')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="email";' 
               ))
           ->setAttrib('tabindex', 2);;
       $this->addElement($email);
       $email_msg =  $this->createElement('text', 'email_subscribe_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('tabindex', -1);
       $this->addElement($email_msg);
       
       $email_confirm =  $this->createElement('text', 'email_confirm_subscribe',array('label' => '', 'class'=>'styled_input'  ));
       $email_confirm->addFilters(array('StringTrim'))
           ->setValue('confirm email')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="confirm email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="confirm email";',
               'onKeyPress'=>'return disableCtrlKeyCombination(event);',
               'onKeyDown'=>'return disableCtrlKeyCombination(event);',
               'oncontextmenu'=>'return false;'
               ))
           ->setAttrib('tabindex', 3);;
       $this->addElement($email_confirm);
       
       $email_confirm_msg =  $this->createElement('text', 'email_confirm_subscribe_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('tabindex', -1);
       $this->addElement($email_confirm_msg);
       
       $password =  $this->createElement('password','password_subscribe',array('label' => '', 'class'=>'styled_input'  ));
       $password ->setOptions(array(
               'onblur'=>'passwordBlur("subscribe");',
               'style'=>'display:none'
               ));
       $this->addElement($password);
       $password_clear =  $this->createElement('text','password_subscribe_clear',array('label' => '', 'class'=>'styled_input'  ));
       $password_clear ->setValue('password')
               ->setOptions(array(
               'onfocus'=>'passwordFocus("subscribe");'
               ))
           ->setAttrib('tabindex', 4);;  
       $this->addElement($password_clear);
       
       $password_msg =  $this->createElement('text', 'password_subscribe_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('tabindex', -1);
       $this->addElement($password_msg);
       
       $roles = new Application_Model_DbTable_Roles();
       $roles_list = $roles->getRolesList();
       $roles_array = $roles_list->toArray();
       //$role = $this->createElement('text', 'role',array('label' => 'role'  ));
       //$role->setValue("$roles_list");
       $role = $this->createElement('select','role_subscribe',array('label' => '', 'class'=>'styled-select'));
       $role->addMultiOptions( $roles_array);
       $role->addFilters(array('StringTrim'))
               ->setOptions(array(
                  'onchange'=>'updateSelect("role_subscribe","select_subscribe");'
               ))
               ->setAttrib('tabindex', 5);
       $this->addElement($role);
       /**$role=$this->createElement('radio', 'role_subscribe',array('label'=>'Which best describes your role in school?'));
       $role->addmultiOptions(array(
            'teacher' => 'Teacher',
            'teaching assistant' => 'Teaching Assistant',
            'head teacher' => 'Head Teacher',
            'pecoordinator' => 'PE Coordinator'))
            ->setSeparator(' ');
       $this->addElement($role);**/
       $select_overlay = $this->createElement('text', 'select_subscribe', array('class' => 'form_select_overlay', 'value'=>'role' ))
               ->setAttrib('readonly', 'readonly')
           ->setAttrib('tabindex', 6);;
       $this->addElement($select_overlay);
       $role_msg =  $this->createElement('text', 'role_subscribe_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('tabindex', -1);
       $this->addElement($role_msg);
       //echo recaptcha_get_html("6LdQmPESAAAAAGut3CzRGz62cEZ1T4yysnWCftml",NULL,true);
       $recaptcha_msg =  $this->createElement('text', 'recaptcha_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($recaptcha_msg);
    }
}

