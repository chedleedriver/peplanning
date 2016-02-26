<?php

class Application_Form_UnsetplanForm extends Zend_Form
{

    public function init()
    {
       //validators
       $nameNotEmpty=new Zend_Validate_NotEmpty();
       $nameNotEmpty->setMessage('You must enter a Title');
       
       $this->setName('createunit');
       $this->setMethod('post');
       $note = new Application_Form_Element_Note('intro',array('value' => 'With your personal lesson planning service you can create your own plans, complete the four steps to get started.<br /><br />'));
       $level = $this->createElement('select','own_sel_level',array('label' => '','onchange'=>'updateSelect("own_sel_level","ownplan_level_overlay");','class' => 'styled-select'));
       $level->addMultiOptions( array(99 => 'Select Year','0.0' => 'Foundation','1.0' => 'Year 1','2.0' => 'Year 2','2.5' => 'Year 3','3.0' => 'Year 4','3.5' => 'Year 5','4.0' => 'Year 6'))
             ->setOrder(1);

       $ownplan_level_overlay = $this->createElement('text', 'ownplan_level_overlay', array('class' => 'hidechrome', 'value'=>'Select year'))
               ->setAttrib('readonly', 'readonly');


       $topic = $this->createElement('select','own_sel_topic',array('class' => 'styled-select'));
       $topic->addMultiOptions( array(0 => 'Select year'))
             ->setOrder(2);
       $topic->addFilters(array('StringTrim'))
               ->setOptions(array(
                  'onchange'=>'updateSelect("own_sel_topic","ownplan_topic_overlay");'
               ));

       $ownplan_topic_overlay = $this->createElement('text', 'ownplan_topic_overlay', array('class' => 'hidechrome', 'value'=>'Select activity'))
               ->setAttrib('readonly', 'readonly');
       
       $num_lessons = $this->createElement('select','own_sel_num_lessons',array('class' => 'styled-select'));
       $num_lessons->addMultiOptions( array(0 => 'Select number of lessons',1 => '1',2 => '2',3 => '3',4 => '4',5 => '5',6 => '6',7 => '7',8 => '8',9 => '9',10 => '10',11 => '11',12 => '12'))
             ->setOrder(3);
       $num_lessons->addFilters(array('StringTrim'))
               ->setOptions(array(
                  'onchange'=>'updateSelect("own_sel_num_lessons","ownplan_numlessons_overlay");'
               ));

       $ownplan_numlessons_overlay = $this->createElement('text', 'ownplan_numlessons_overlay', array('class' => 'hidechrome', 'value'=>'Select number of lessons'))
               ->setAttrib('readonly', 'readonly');
       
       $plan_type = $this->createElement('text', 'plan_type',array('style' => 'display:none'));
       $plan_type->setValue('unsetplan')
               ->setOrder(4);       
       
       $this->addElements(array(
                   $note,
                   $level,
                   $ownplan_level_overlay,
                   $topic,
                   $ownplan_topic_overlay,
                   $num_lessons,
                   $ownplan_numlessons_overlay,
                   $plan_type                   
                   ));
    }


}

