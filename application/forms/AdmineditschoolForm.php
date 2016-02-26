<?php

class Application_Form_AdmineditschoolForm extends Zend_Form
{
    private $my_details;
    
    public function init()
    {
        
    }
    public function setvars($school_details)  
    {  
        //set the variable 
		$this->my_details['id'] = $school_details['id'];
        $this->my_details['school'] = $school_details['school'];
		$this->my_details['contact'] = $school_details['contact'];
		$this->my_details['school'] = $school_details['school'];
        $this->my_details['address1'] = $school_details['address1'];
		$this->my_details['address2'] = $school_details['address2'];
		$this->my_details['address3'] = $school_details['address3'];
		$this->my_details['postcode'] = $school_details['postcode'];
		$this->my_details['email'] = $school_details['email'];
		$this->my_details['total_cost'] = $school_details['total_cost'];
		$this->my_details['telephone'] = $school_details['telephone'];
        $this->my_details['classnum'] = $school_details['classnum'];
		$this->my_details['subfrom'] = $school_details['subfrom'];
		$this->my_details['subto'] = $school_details['subto'];
		$this->my_details['approved'] = $school_details['approved'];
    }  
    public function startform()
    {
       $this->setName('admineditschoolform');
       $this->setMethod('post');
	   $id =  $this->createElement('text', 'idXschooledit',array('label' => 'School id number (Auto-Generated)', 'class'=>'styled_input', 'readonly' => 'true'  ));
	   $id->getDecorator('label')->setOption('placement', 'append');
       $id->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['id'] ? $this->my_details['id'] : 'id' ))
           ->setOrder(1)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="id")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="id";hideLabel(this);' 
               ));
       $school =  $this->createElement('text', 'schoolXschooledit',array('label' => 'Enter the School Name', 'class'=>'styled_input'  ));
	   $school->getDecorator('label')->setOption('placement', 'append');
       $school->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['school'] ? $this->my_details['school'] : 'school'))
           ->setOrder(2)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="school")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="school";hideLabel(this);' 
               ));
	   $contact =  $this->createElement('text', 'contactXschooledit',array('label' => 'Enter the name of the school contact', 'class'=>'styled_input'  ));
	   $contact->getDecorator('label')->setOption('placement', 'append');
       $contact->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['contact'] ? $this->my_details['contact'] : 'contact'))
           ->setOrder(3)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="contact")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="contact";hideLabel(this);' 
               ));
	   $address1 =  $this->createElement('text', 'address1Xschooledit',array('label' => 'Enter the School Address', 'class'=>'styled_input'  ));
	   $address1->getDecorator('label')->setOption('placement', 'append');
       $address1->addFilters(array('StringTrim'))
	   	   ->setValue(($this->my_details['address1'] ? $this->my_details['address1'] : 'address1'))
	   	   ->setOrder(4)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="address1")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="address1";hideLabel(this);' 
               ));	
	   $address2 =  $this->createElement('text', 'address2Xschooledit',array('label' => 'Enter the School Address', 'class'=>'styled_input'  ));
	   $address2->getDecorator('label')->setOption('placement', 'append');
       $address2->addFilters(array('StringTrim'))
	   	   ->setValue(($this->my_details['address2'] ? $this->my_details['address2'] : 'address2'))
	   	   ->setOrder(5)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="address2")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="address2";hideLabel(this);' 
               ));	
	   $address3 =  $this->createElement('text', 'address3Xschooledit',array('label' => 'Enter the School Address', 'class'=>'styled_input'  ));
	   $address3->getDecorator('label')->setOption('placement', 'append');
       $address3->addFilters(array('StringTrim'))
	   	   ->setValue(($this->my_details['address3'] ? $this->my_details['address3'] : 'address3'))
	   	   ->setOrder(6)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="address3")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="address3";hideLabel(this);' 
               ));	
       $postcode =  $this->createElement('text', 'postcodeXschooledit',array('label' => 'Enter the School Postcode', 'class'=>'styled_input'  ));
	   $postcode->getDecorator('label')->setOption('placement', 'append');
       $postcode->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['postcode'] ? $this->my_details['postcode'] : 'postcode'))
           ->setOrder(7)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="postcode")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="postcode";hideLabel(this);' 
               ));
	   $email =  $this->createElement('text', 'emailXschooledit',array('label' => 'Enter the School Email Address (office or contact)', 'class'=>'styled_input'  ));
	   $email->getDecorator('label')->setOption('placement', 'append');
       $email->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['email'] ? $this->my_details['email'] : 'email'))
           ->setOrder(8)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="email")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="email";hideLabel(this);' 
               ));
	   $telephone =  $this->createElement('text', 'telephoneXschooledit',array('label' => 'Enter the School Telephone Number', 'class'=>'styled_input'  ));
	   $telephone->getDecorator('label')->setOption('placement', 'append');
       $telephone->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['telephone'] ? $this->my_details['telephone'] : 'telephone'))
           ->setOrder(9)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="telephone")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="telephone";hideLabel(this);' 
               ));	
	   $total_cost =  $this->createElement('text', 'total_costXschooledit',array('label' => 'Enter the School Subscription cost', 'class'=>'styled_input'  ));
	   $total_cost->getDecorator('label')->setOption('placement', 'append');
       $total_cost->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['total_cost'] ? $this->my_details['total_cost'] : 'total_cost'))
           ->setOrder(10)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="total_cost")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="total_cost";hideLabel(this);' 
               ));
       
	   $classnum =  $this->createElement('text', 'classnumXschooledit',array('label' => 'Enter the Number of Classes at the School', 'class'=>'styled_input'  ));
	   $classnum->getDecorator('label')->setOption('placement', 'append');
       $classnum->addFilters(array('StringTrim'))
           ->setValue(($this->my_details['classnum'] ? $this->my_details['classnum'] : 'classnum'))
           ->setOrder(11)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="classnum")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="classnum";hideLabel(this);' 
               ));
	   
	   $subfrom =  $this->createElement('text', 'subfromXschooledit',array('label' => 'Enter the Startdate for the Subscription (dd-mm-yyyy)', 'class'=>'styled_input'));
	   $subfrom->getDecorator('label')->setOption('placement', 'append');
       $subfrom->addFilters(array('StringTrim'))
           ->setValue((date("d-m-Y",$this->my_details['subfrom']) ? date("d-m-Y",$this->my_details['subfrom']) : 'subfrom'))
           ->setOrder(12)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="subfrom")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="subfrom";hideLabel(this);' 
               ));
	   $subto =  $this->createElement('text', 'subtoXschooledit',array('label' => 'Enter the Startdate for the Subscription (dd-mm-yyyy)', 'class'=>'styled_input'));
	   $subto->getDecorator('label')->setOption('placement', 'append');
       $subto->addFilters(array('StringTrim'))
           ->setValue((date("d-m-Y",$this->my_details['subto']) ? date("d-m-Y",$this->my_details['subto']) : 'subto'))
           ->setOrder(13)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="subto")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="subto";hideLabel(this);' 
               ));
       $approved =  $this->createElement('text', 'approvedXschooledit',array('label' => 'Enter Y to approve this school subscription. This will send user emails', 'class'=>'styled_input'  ));
	   $approved->getDecorator('label')->setOption('placement', 'append');
       $approved->addFilters(array('StringTrim'))
           ->setValue($this->my_details['approved'] ? $this->my_details['approved'] : 'approved')
           ->setOrder(14)
           ->setRequired(false)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="approved")this.value="";showLabel(this);', 
               'onblur'=>'if(this.value=="")this.value="approved";hideLabel(this);' 
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

