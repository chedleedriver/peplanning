<?php

class Application_Form_FeedbackForm extends Table_Form
{

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
        //decorators...
       //validators
       $this->setName('feedbackform');
       $this->setMethod('post');
       
       $how_heard=$this->createElement('radio', 'how_heard_feedback',array('label'=>'How did you hear about PEplanning?'));
       $how_heard->addmultiOptions(array(
            'email' => 'Email',
            'search' => 'Internet Search',
            'recommend' => 'Recommendation',
            'other' => 'Other'))
            ->setOrder(1)
            ->setSeparator('  ');
       $this->addElement($how_heard);    
       
       $other_detail =  $this->createElement('textarea', 'other_feedback',array('label' => '' ));
       $other_detail->addFilters(array('StringTrim'))
           ->setValue('If other please specify')
           ->setOrder(2)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="If other please specify")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="If other please specify";' 
               ));
       $this->addElement($other_detail);
       
       $subscribed=$this->createElement('radio', 'subscribed_feedback', array('label'=>'Have you subscribed to PEplanning?'));
       $subscribed->addmultiOptions(array(
            'yes' => 'Yes',
            'no' => 'No',
            ))
            ->setOrder(3)
            ->setSeparator('  ');
       $this->addElement($subscribed);
       
       $no_sub =  $this->createElement('textarea', 'no_sub_feedback',array('label' => ''  ));
       $no_sub->addFilters(array('StringTrim'))
           ->setValue('If no could you tell us why?')
           ->setOrder(4)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="If no could you tell us why?")this.value="";', 
               'onblur'=>'if(this.value=="")this.value="If no could you tell us why?";' 
               ));
       $this->addElement($no_sub);
       
       $details =  $this->createElement('textarea', 'details_feedback',array('label' => ''  ));
       $details->addFilters(array('StringTrim'))
           ->setValue('Are there any changes we could make to our service that might improve our service?')
           ->setOrder(5)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="Are there any changes we could make to our service that might improve our service?")this.value="";',
               'onblur'=>'if(this.value=="")this.value="Are there any changes we could make to our service that might improve our service?";'
               ));
       $this->addElement($details);
       
       $comments =  $this->createElement('textarea', 'comments_feedback',array('label' => ''  ));
       $comments->addFilters(array('StringTrim'))
           ->setValue('Are there any additional comments you would like to make at this time?')
           ->setOrder(6)
           ->setRequired(true)
           ->setOptions(array(
               'onfocus'=>'if(this.value=="Are there any additional comments you would like to make at this time?")this.value="";',
               'onblur'=>'if(this.value=="")this.value="Are there any additional comments you would like to make at this time?";'
               ));
       $this->addElement($comments);
       
       
    }

}