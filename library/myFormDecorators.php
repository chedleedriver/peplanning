<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of myFormDecorators
 *
 * @author steve
 */
class Decorative_Form extends Zend_Form {
    public $decorators = array (); // your decorator definition, keyed by Zend_Form* class; array () uses Zend defaults
 
    public function __construct($options = null) {
        // plugin form and element decorators
        if (is_array($options) && isset($options['decorators'])) {
            if (is_array($options['decorators'])) {
                $this->decorators = $options['decorators'];
                unset($options['decorators']);
            }
        }
 
        // build the form
        parent::__construct($options);
    }
    public function addElement($element, $name = null, $options = null) {
        // ask the parent to do the work to add the element
        parent::addElement($element, $name, $options);
 
        // now if we did not set a decorator on the element, add our default
        if (null === $options || (is_array($options) && ! isset($options['decorators']))) {
            if (! $element instanceof Zend_Form_Element) {
                $element = $this->getElement($name);
            }
            foreach ($this->decorators as $class => $decorators) {
                if ($element instanceof $class) {
                    $element->setDecorators($decorators);
                    return $this;
                }
            }
        }
 
        return $this;
    }
    public function loadDefaultDecorators() {
        // if we have a form decorator plugged-in, use it
        if (isset($this->decorators['Zend_Form'])) {
            $this->setDecorators($this->decorators['Zend_Form']);
 
        // otherwise, do the Zend default
        } else {
            parent::loadDefaultDecorators();
        }
    }
}
class Accessible_Form extends Decorative_Form {
    public $decorators = array (
                             'Zend_Form_Element_Submit' => array (
                                 'ViewHelper',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'button')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
                             ),
                             'Zend_Form_Element_Captcha' => array (
                                 'Label',
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'li'))
                             ),
                             'Zend_Form_Element_Checkbox' => array (
                                 'Label',
                                 'ViewHelper',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'checkbox')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
                             ),
                             'Zend_Form_Element_Radio' => array (
                                 'Label',
                                 'ViewHelper',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'radio')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
                             ),
                             'Zend_Form_Element' => array (
                                 'ViewHelper',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'element')),
                                 'Label',
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
                             ),
                             'Zend_Form' => array (
                                 'FormErrors',
                                 'FormElements',
                                 array ('HtmlTag', array ('tag' => 'ul')),
                                 'Form'
                             ),
                         );
 
}
 
// decorates with <table> and <tr><td>Label</td><td>Input</td></tr>
class Table_Form extends Decorative_Form {
    public $decorators = array (           
                             'Zend_Form_Element_Radio' => array (
                                 'Label',
                                 'ViewHelper',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'td', 'class' => 'radio')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'tr')),
                             ),
                            'Zend_Form_Element_Textarea' => array (
                                 'ViewHelper',
                                 'Errors',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'td', 'class' => 'element', 'colspan' => '6')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'tr')),
                             ),
                            'Zend_Form_Element' => array (
                                 'ViewHelper',
                                 'Errors',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'td', 'class' => 'element')),
                                 array ('Label', array ('tag' => 'td')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'tr')),
                             ),
                             
                             'Zend_Form' => array (
                                 'FormErrors',
                                 'FormElements',
                                 array ('HtmlTag', array ('tag' => 'table', 'cellpadding' => '4')),
                                 'Form'
                             ),
                         );
}
class Sub_Table_Form extends Decorative_Form {
    public $decorators = array (           
                             'Zend_Form_Element_Radio' => array (
                                 'Errors',
                                 'ViewHelper',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'td', 'class' => 'radio')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'tr')),
                             ),
                            'Zend_Form_Element_Textarea' => array (
                                 'ViewHelper',
                                 'Errors',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'td', 'class' => 'element', 'colspan' => '6')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'tr')),
                             ),
                            'Zend_Form_Element_Select' => array (
                                 'Label',
                                 'ViewHelper',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'select')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'div')),
                             ),
                            'Zend_Form_Element' => array (
                                 'ViewHelper',
                                 'Errors',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'td', 'class' => 'element')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'tr')),
                             ),
                             
                             'Zend_Form' => array (
                                 'FormErrors',
                                 'FormElements',
                                 array ('HtmlTag', array ('tag' => 'table', 'cellpadding' => '1')),
                                 'Form'
                             ),
                         );
}
class Pay_Table_Form extends Decorative_Form {
    public $decorators = array (           
                             'Zend_Form_Element_Radio' => array (
                                 'Label',
                                 'ViewHelper',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'td', 'class' => 'radio')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'tr')),
                             ),
                            'Zend_Form_Element_Textarea' => array (
                                 'ViewHelper',
                                 'Errors',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'td', 'class' => 'element', 'colspan' => '6')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'tr')),
                             ),
                            'Zend_Form_Element' => array (
                                 'ViewHelper',
                                 'Errors',
                                 array (array ('data' => 'HtmlTag'), array ('tag' => 'td', 'class' => 'element')),
                                 array (array ('row' => 'HtmlTag'), array ('tag' => 'tr')),
                             ),
                             
                             'Zend_Form' => array (
                                 'FormErrors',
                                 'FormElements',
                                 array ('HtmlTag', array ('tag' => 'table', 'cellpadding' => '4')),
                                 'Form'
                             ),
                         );
}
?>
