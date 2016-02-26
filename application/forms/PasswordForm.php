<?php

class Application_Form_PasswordForm extends Zend_Form
{

    public function init()
    {
       $this->setName('passwordform');
       $this->setMethod('post');
      
       $password =  $this->createElement('password','password_change',array('label' => '', 'class'=>'styled_input'  ));
       $password ->setRequired(true)
           ->addValidator('StringLength', false,array(5,50))
           ->setValue('password')
               ->setOrder(1)
               ->setOptions(array(
               'onblur'=>'passwordBlur("change");',
               'style'=>'display:none'
               ));
       $password_clear =  $this->createElement('text','password_clear_change',array('label' => '', 'class'=>'styled_input'  ));
       $password_clear ->setValue('password')
               ->setOrder(2)
               ->setOptions(array(
               'onfocus'=>'passwordFocus("change");'
               ));   
       
       $new_password =  $this->createElement('password','new_password_change',array('label' => '', 'class'=>'styled_input'  ));
       $new_password ->setRequired(true)
           ->addValidator('StringLength', false,array(5,50))
           ->setValue('new password')
               ->setOrder(3)
               ->setOptions(array(
               'onblur'=>'passwordBlur("change_new");',
               'style'=>'display:none'
               ));
       $new_password_clear =  $this->createElement('text','new_password_clear_change',array('label' => '', 'class'=>'styled_input'  ));
       $new_password_clear ->setValue('new password')
               ->setOrder(4)
               ->setOptions(array(
               'onfocus'=>'passwordFocus("change_new");'
               ));
       
       $confirm_password =  $this->createElement('password','confirm_password_change',array('label' => '', 'class'=>'styled_input'  ));
       $confirm_password ->setRequired(true)
           ->addValidator('StringLength', false,array(5,50))
           ->setValue('confirm password')
               ->setOrder(5)
               ->setOptions(array(
               'onblur'=>'passwordBlur("change_confirm");',
               'style'=>'display:none'
               ));
       $confirm_password_clear =  $this->createElement('text','confirm_password_clear_change',array('label' => '', 'class'=>'styled_input'  ));
       $confirm_password_clear ->setValue('confirm password')
               ->setOrder(6)
               ->setOptions(array(
               'onfocus'=>'passwordFocus("change_confirm");'
               ));
       
       $submit =  $this->createElement('submit','save',array('label' => ''));
       $submit->setRequired(false)
           ->setIgnore(true);

          
       $this->addElements(array(
                   $password,
                   $password_clear,
                   $new_password,
                   $new_password_clear,
                   $confirm_password,
                   $confirm_password_clear,
                   //$submit,
                    
                   ));
    }


}

