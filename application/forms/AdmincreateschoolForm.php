<?php

class Application_Form_AdmincreateschoolForm extends Zend_Form
{
    public function init()
    {
        
    }
    public function startform()
    {
       $this->setName('admincreateschoolform');
       $this->setMethod('post');
	   $school =  $this->createElement('text', 'schoolXschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $school->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['school'] ? $this->my_details['school'] : 'school'))
           ->setOrder(2)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="school";' 
               ));
	   $contact =  $this->createElement('text', 'contactXschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $contact->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['contact'] ? $this->my_details['contact'] : 'contact'))
           ->setOrder(3)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="contact")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="contact";' 
               ));
	   $address1 =  $this->createElement('text', 'address1Xschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $address1->addFilters(array('StringTrim'))
	       ->setValue('address1')
	   	   ->setOrder(4)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="address1")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="address1";' 
               ));	
	   $address2 =  $this->createElement('text', 'address2Xschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $address2->addFilters(array('StringTrim'))
	       ->setValue('address2')
	   	   ->setOrder(5)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="address2")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="address2";' 
               ));	
	   $address3 =  $this->createElement('text', 'address3Xschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $address3->addFilters(array('StringTrim'))
	       ->setValue('address3')
	   	   ->setOrder(6)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="address3")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="address3";' 
               ));	
       $postcode =  $this->createElement('text', 'postcodeXschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $postcode->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['postcode'] ? $this->my_details['postcode'] : 'postcode'))
           ->setOrder(7)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="postcode")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="postcode";' 
               ));
	   $email =  $this->createElement('text', 'emailXschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $email->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['email'] ? $this->my_details['email'] : 'email'))
           ->setOrder(8)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="email")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="email";' 
               ));
	   $telephone =  $this->createElement('text', 'telephoneXschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $telephone->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['telephone'] ? $this->my_details['telephone'] : 'telephone'))
           ->setOrder(9)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="telephone")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="telephone";' 
               ));	
	   $total_cost =  $this->createElement('text', 'total_costXschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $total_cost->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['total_cost'] ? $this->my_details['total_cost'] : 'total_cost'))
           ->setOrder(10)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="total_cost")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="total_cost";' 
               ));
       
	   $classnum =  $this->createElement('text', 'classnumXschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $classnum->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['classnum'] ? $this->my_details['classnum'] : 'classnum'))
           ->setOrder(11)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="classnum")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="classnum";' 
               ));
	   
	   $subfrom =  $this->createElement('text', 'subfromXschooledit',array('label' => '', 'class'=>'styled_input'   ));
       $subfrom->addFilters(array('StringTrim'))
           ->setValue(('subfrom'))
           ->setOrder(12)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="subfrom")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="subfrom";' 
               ));
	   $subto =  $this->createElement('text', 'subtoXschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $subto->addFilters(array('StringTrim'))
           ->setValue(('subto'))
           ->setOrder(13)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="subto")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="subto";' 
               ));
       $approved =  $this->createElement('text', 'approvedXschooledit',array('label' => '', 'class'=>'styled_input'  ));
       $approved->addFilters(array('StringTrim'))
           ->setValue('approved')
           ->setOrder(14)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="approved")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="approved";' 
               ));
       
       $this->addElements(array(
                   $id,
				   $school,
				   $contact,
                   $address1,
				   $address2,
				   $address3,
                   $postcode,
				   $email,
				   $telephone,
				   $total_cost,
                   $classnum,
				   $subfrom,
				   $subto,
				   $approved
                   ));
    }

}

