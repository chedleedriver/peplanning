<?php

class Application_Form_PaymentForm extends Pay_Table_Form
{

    public function init()
    {
       
       
    }
    public function setvars($user_details)  
    {  
        //set the variable  
        $this->my_details['name'] = $user_details['name'];
        $this->my_details['school'] = $user_details['school'];
        $this->my_details['email'] = $user_details['email'];
        $this->my_details['role'] = $user_details['what'];
    } 
    public function startform()
    {
        //decorators...
       //validators
       $this->setName('paymentform');
       $this->setMethod('post');
       
       $service_pay=$this->createElement('radio', 'service_payment',array('label'=>'Which service do you want to pay for?'));
       $service_pay->addmultiOptions(array(
            'peschool' => 'PEschool',
            'peteacher' => 'PEteacher'))
            ->setSeparator('  ')
               ->setValue("peschool");
       $this->addElement($service_pay);
       $service_pay_msg =  $this->createElement('text', 'service_payment_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($service_pay_msg);
       $name =  $this->createElement('text', 'name_payment',array('label' => '', 'class'=>'styled_input'  ));
       $name->addFilters(array('StringTrim'))
           ->setValue('name')
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="name")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="name";' 
               ));
       $name->removeDecorator('Label');
       $this->addElement($name);
       $name_msg =  $this->createElement('text', 'name_payment_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($name_msg);
       $email =  $this->createElement('text', 'email_payment',array('label' => '', 'class'=>'styled_input'  ));
       $email->addFilters(array('StringTrim'))
           ->setValue('email')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="email";' 
               ));
       $this->addElement($email);
       $email_msg =  $this->createElement('text', 'email_payment_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($email_msg);
       $email_confirm =  $this->createElement('text', 'email_confirm_payment',array('label' => '', 'class'=>'styled_input'  ));
       $email_confirm->addFilters(array('StringTrim'))
           ->setRequired(true)
           ->setValue('confirm email')
           ->setOptions(array(
               'onfocus'=>'if(this.value=="confirm email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="confirm email";',
               'onKeyPress'=>'return disableCtrlKeyCombination(event);',
               'onKeyDown'=>'return disableCtrlKeyCombination(event);',
               'oncontextmenu'=>'return false;'
               ));
       $this->addElement($email_confirm);
       $email_confirm_msg =  $this->createElement('text', 'email_confirm_payment_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($email_confirm_msg);
       $school_name =  $this->createElement('text', 'school_payment',array('label' => '', 'class'=>'styled_input'  ));
       $school_name->addFilters(array('StringTrim'))
           ->setValue('school')
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school";' 
               ));
       $this->addElement($school_name);
       $school_name_msg =  $this->createElement('text', 'school_payment_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($school_name_msg);
       $school_address_1 =  $this->createElement('text', 'school_address_payment_1',array('label' => '', 'class'=>'styled_input'  ));
       $school_address_1->addFilters(array('StringTrim'))
           ->setValue('school address')
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school address")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school address";' 
               ));
       $this->addElement($school_address_1);
       $school_address_1_msg =  $this->createElement('text', 'school_address_1_payment_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($school_address_1_msg);
       $school_address_2 =  $this->createElement('text', 'school_address_payment_2',array('label' => '', 'class'=>'styled_input'  ));
       $school_address_2->addFilters(array('StringTrim'))
           ->setValue('school address')
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school address")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school address";' 
               ));
       $this->addElement($school_address_2);
       $school_address_2_msg =  $this->createElement('text', 'school_address_2_payment_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($school_address_2_msg);
       $school_address_3 =  $this->createElement('text', 'school_address_payment_3',array('label' => '', 'class'=>'styled_input'  ));
       $school_address_3->addFilters(array('StringTrim'))
           ->setValue('school address')
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school address")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school address";' 
               ));
       $this->addElement($school_address_3);
       $school_address_3_msg =  $this->createElement('text', 'school_address_3_payment_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($school_address_3_msg);
       $school_postcode =  $this->createElement('text', 'postcode_payment',array('label' => ''  ));
       $school_postcode->addFilters(array('StringTrim'))
           ->setValue('postcode')
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="postcode")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="postcode";' 
               ));
       $this->addElement($school_postcode);
       $school_postcode_msg =  $this->createElement('text', 'postcode_payment_msg',array('class' => 'error'  ))
               ->setAttrib('readonly', 'readonly')
               ->setAttrib('style', 'display: none');
       $this->addElement($school_postcode_msg);
    }
}

