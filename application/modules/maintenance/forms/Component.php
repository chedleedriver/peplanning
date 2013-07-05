<?php

class Maintenance_Form_Component extends Zend_Form
{

    public function __construct($option=null)
    {
        parent::__construct($option);
        
        $this->setMethod('post');
        
        $list = new Zend_Form_Element_Select('combobox');
        $list->setRegisterInArrayValidator(false)
             ->setDecorators(array(
               'ViewHelper',
               'Description',
               'Errors',
               array(array('data'=>'HtmlTag'), array('tag' => 'td')),
               array('Label', array('tag' => 'td')),
               array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'openOnly'=>true))
       ));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Create')
               ->setDecorators(array(
               'ViewHelper',
               'Description',
               'Errors', array(array('data'=>'HtmlTag'), array('tag' => 'td',
               'colspan'=>'2','align'=>'center')),
               array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'closeOnly'=>'true'))
       ));

        $this->addElements(array($list, $submit));
        $this->setDecorators(array(
               'FormElements',
               array(array('data'=>'HtmlTag'),array('tag'=>'table')),
               'Form'
       ));
    }


}

