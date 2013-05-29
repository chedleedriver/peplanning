<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
/**
* init jquery view helper, enable jquery, jqueryui, jquery ui css
*/

    protected function _initJquery() {

    $this->bootstrap('view');
    $view = $this->getResource('view'); //get the view object

    //add the jquery view helper path into your project
    $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");

    //jquery lib includes here (default loads from google CDN)
    $view->jQuery()->enable()//enable jquery ; ->setCdnSsl(true) if need to load from ssl location
     ->setVersion('1.7')//jQuery version, automatically 1.5 = 1.5.latest
     ->setUiVersion('1.8')//jQuery UI version, automatically 1.8 = 1.8.latest
     ->uiEnable()
     ->setCdnSsl(true);//enable ui

}
    protected function _initSession()
    {
        if(!Zend_Auth::getInstance()->hasIdentity())  
            { $options = $this->getOptions();
              $sessionOptions = array(
                'gc_probability'    =>    $options['resources']['session']['gc_probability'],
                'gc_divisor'        =>    $options['resources']['session']['gc_divisor'],
                'gc_maxlifetime'    =>    $options['resources']['session']['gc_maxlifetime']
            );
 
            $idleTimeout = $options['resources']['session']['idle_timeout'];
 
            Zend_Session::setOptions($sessionOptions);
            $mysession = new Zend_Session_Namespace('mysession');
            
            if(isset($mysession->timeout_idle) && $mysession->timeout_idle < time()) {
                //Zend_Session::destroy();
                //Zend_Session::regenerateId();
                //exit();
                //echo '<meta http-equiv="refresh" content="0;url=" />';
                // If they have been idle for too long then the session gets reset this should clear the blank page bug
                Zend_Session::namespaceUnset('mysession');
            }
 
            $mysession->timeout_idle = time() + $idleTimeout;         
         
               if(!$mysession->id){
               $mysession->userlevel = '0';
               $mysession->id=mt_rand(9000001,9999998);
                //$mysession->id = '9999999';
               $mysession->username = 'guest@peplanning.org.uk';
               }
                  
            }
/*        try {
            // Autoload simplesamlphp classes.
            if(!file_exists("/var/simplesamlphp/lib/_autoload.php")) {
            throw(new Exception("simpleSAMLphp lib loader file does not exist: ".
            "/var/simplesamlphp/lib/_autoload.php"));
            }
 
            include_once("/var/simplesamlphp/lib/_autoload.php");
            $as = new SimpleSAML_Auth_Simple('rm');
 
            // Take the user to IdP and authenticate.
            $as->requireAuth();
            $valid_saml_session = $as->isAuthenticated();
 
            } catch (Exception $e) {
            // SimpleSAMLphp is not configured correctly.
            throw(new Exception("SSO authentication failed: ". $e->getMessage()));
            return;
            }
 
        if (!$valid_saml_session) {
            // Not valid session. Redirect a user to Identity Provider
            try {
                $as = new SimpleSAML_Auth_Simple('rm');
                $as->requireAuth();
                } catch (Exception $e) {
                // SimpleSAMLphp is not configured correctly.
                throw(new Exception("SSO authentication failed: ". $e->getMessage()));
            return;
                }
            }
 
        // At this point, the user is authenticated by the Identity Provider, and has access
        // to the attributes received with SAML assertion.
        $attributes = $as->getAttributes();
 
        // The print_r response of $as->getAttributes() look something like this:
        //Array (
        //      [first_name] => Array ( [0] => John )
        //      [last_name] => Array ( [0] => Doe )
        //      [email] => Array ( [0] => john.doe@webtrafficexchange.com )
        //)
         
        $firstname = $attributes['first_name'][0];
        $lastName = $attributes['last_name'][0];
        $email = $attributes['email'][0];
*/    }
    
    protected function _initView()
    {
    // Initialize view
    $view = new Zend_View();
    $view->doctype('HTML4_STRICT');
    $view->setEncoding('UTF-8');//per , htmlentities($str, ENT_QUOTES, "UTF-8");

    $view->headTitle('PE Planning');


    // Add it to the ViewRenderer
    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
    $viewRenderer->setView($view);
    // Return it, so that it can be stored by the bootstrap
    return $view;
    }   
    protected function _initAutoload()
    {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
        'namespace' => '', 
        'basePath' => APPLICATION_PATH));
        return $moduleLoader;

    }
    protected function _initForm()
    {
        include_once('myFormDecorators.php');
    }
    
}

