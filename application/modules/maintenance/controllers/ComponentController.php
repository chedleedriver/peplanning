<?php

class Maintenance_ComponentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function equipmentAction()
    {
        $equipment_form = new Maintenance_Form_Component();
        $request = $this->getRequest();
        if($request->isPost()) {
            if($equipment_form->isValid($request->getPost())) {
                $form_values=$request->getPost();
                if($form_values['combobox']==0) {
                    $insert_items = new Maintenance_Model_DbTable_Equipment;
                    $data = array('description' => $form_values['new_item']);
                    $insert_items->insert ($data);
                }
                else {
                    $update_items = new Maintenance_Model_DbTable_Equipment;
                    $data = array('description' => $form_values['new_item']);
                    $where = "id = ".$form_values['combobox'];
                    $update_items->update ($data,$where);
                }
            }
        }
        $list_items = new Maintenance_Model_DbTable_Equipment;
        $equipment_form->getElement('combobox')->addMultiOption(0, '');
        $items = $list_items->fetchAll(null,'description');
            foreach ($items as $item) :
                $equipment_form->getElement('combobox')->addMultiOption($item->id, $item->description);
            endforeach;
        $this->view->form = $equipment_form;
    }

    public function ictAction()
    {
        // action body
    }

    public function keywordsAction()
    {
        // action body
    }

    public function numeracyAction()
    {
        // action body
    }

    public function riskAssessmentAction()
    {
        // action body
    }

    public function citizenshipAction()
    {
        // action body
    }

    public function strandAction()
    {
        // action body
    }

    public function objectiveAction()
    {
        // action body
    }

    public function lessonPartAction()
    {
        // action body
    }

    public function themeAction()
    {
        // action body
    }

    public function levelAction()
    {
        // action body
    }

    public function genreAction()
    {
        // action body
    }

    public function evaluationAction()
    {
        // action body
    }


}



























