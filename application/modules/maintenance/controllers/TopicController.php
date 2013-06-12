<?php

class Maintenance_TopicController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $topics = new Maintenance_Model_DbTable_Topic();
        $this->view->topics = $topics->fetchAll();
    }

    public function themeAction()
    {
    }

    public function equipmentAction()
    {
        $this->view->mode = 'topic';
        $_GET['topic'] = (isset($_GET['topic']) ? $_GET['topic'] : 'not_set');
        if($_GET['topic']!='not_set') {
            $topic_id = $_GET['topic'];
            $_GET['action'] = (isset($_GET['action']) ? $_GET['action'] : 'nothing');
            $topics = new Maintenance_Model_DbTable_Topic();
            switch( $_GET['action']){
                case 'get':
                    $topicRow = $topics->find($topic_id);
                    $topic = $topicRow->current();
                    $this->view->items = $topic->findMaintenance_Model_DbTable_EquipmentViaMaintenance_Model_DbTable_TopicEquipment();
                    break;
                case 'nothing':
                    $this->view->noaction = true;
                case 'everything':
                    $this->view->items = $topic_equipment->fetchAll();
            } //end of swtich
        } 
        else {
            $this->view->notopic = true;
        }
    }
    public function ictAction()
    {
        $this->view->mode = 'topic';
        $_GET['topic'] = (isset($_GET['topic']) ? $_GET['topic'] : 'not_set');
        if($_GET['topic']!='not_set') {
            $topic_id = $_GET['topic'];
            $_GET['action'] = (isset($_GET['action']) ? $_GET['action'] : 'nothing');
            $topics = new Maintenance_Model_DbTable_Topic();
            switch( $_GET['action']){
                case 'get':
                    $topicRow = $topics->find($topic_id);
                    $topic = $topicRow->current();
                    $this->view->items = $topic->findMaintenance_Model_DbTable_IctViaMaintenance_Model_DbTable_TopicICT();
                    break;
                case 'nothing':
                    $this->view->noaction = true;
                case 'everything':
                    $this->view->items = $topic_ict->fetchAll();
            } //end of swtich
        } 
        else {
            $this->view->notopic = true;
        }
    }

    public function keywordsAction()
    {
        $this->view->mode = 'topic';
        $_GET['topic'] = (isset($_GET['topic']) ? $_GET['topic'] : 'not_set');
        if($_GET['topic']!='not_set') {
            $topic_id = $_GET['topic'];
            $_GET['action'] = (isset($_GET['action']) ? $_GET['action'] : 'nothing');
            $topics = new Maintenance_Model_DbTable_Topic();
            switch( $_GET['action']){
                case 'get':
                    $topicRow = $topics->find($topic_id);
                    $topic = $topicRow->current();
                    $this->view->items = $topic->findMaintenance_Model_DbTable_KeywordsViaMaintenance_Model_DbTable_TopicKeywords();
                    break;
                case 'nothing':
                    $this->view->noaction = true;
                case 'everything':
                    $this->view->items = $topic_items->fetchAll();
            } //end of swtich
        } 
        else {
            $this->view->notopic = true;
        }
    }

    public function numeracyAction()
    {
        $this->view->mode = 'topic';
        $_GET['topic'] = (isset($_GET['topic']) ? $_GET['topic'] : 'not_set');
        if($_GET['topic']!='not_set') {
            $topic_id = $_GET['topic'];
            $_GET['action'] = (isset($_GET['action']) ? $_GET['action'] : 'nothing');
            $topics = new Maintenance_Model_DbTable_Topic();
            switch( $_GET['action']){
                case 'get':
                    $topicRow = $topics->find($topic_id);
                    $topic = $topicRow->current();
                    $this->view->items = $topic->findMaintenance_Model_DbTable_CitizenshipViaMaintenance_Model_DbTable_TopicCitizenship();
                    break;
                case 'nothing':
                    $this->view->noaction = true;
                case 'everything':
                    $this->view->items = $topic_items->fetchAll();
            } //end of swtich
        } 
        else {
            $this->view->notopic = true;
        }
    }
    public function riskassessmentAction()
    {
        $this->view->mode = 'topic';
        $_GET['topic'] = (isset($_GET['topic']) ? $_GET['topic'] : 'not_set');
        if($_GET['topic']!='not_set') {
            $topic_id = $_GET['topic'];
            $_GET['action'] = (isset($_GET['action']) ? $_GET['action'] : 'nothing');
            $topics = new Maintenance_Model_DbTable_Topic();
            switch( $_GET['action']){
                case 'get':
                    $topicRow = $topics->find($topic_id);
                    $topic = $topicRow->current();
                    $this->view->items = $topic->findMaintenance_Model_DbTable_RiskAssessmentViaMaintenance_Model_DbTable_TopicRiskAssessment();
                    break;
                case 'nothing':
                    $this->view->noaction = true;
                case 'everything':
                    $this->view->items = $topic_items->fetchAll();
            } //end of swtich
        } 
        else {
            $this->view->notopic = true;
        }
    }

    public function citizenshipAction()
    {
        $this->view->mode = 'topic';
        $_GET['topic'] = (isset($_GET['topic']) ? $_GET['topic'] : 'not_set');
        if($_GET['topic']!='not_set') {
            $topic_id = $_GET['topic'];
            $_GET['action'] = (isset($_GET['action']) ? $_GET['action'] : 'nothing');
            $topics = new Maintenance_Model_DbTable_Topic();
            switch( $_GET['action']){
                case 'get':
                    $topicRow = $topics->find($topic_id);
                    $topic = $topicRow->current();
                    $this->view->equipment = $topic->findMaintenance_Model_DbTable_CitizenshipViaMaintenance_Model_DbTable_TopicCitizenship();
                    break;
                case 'nothing':
                    $this->view->noaction = true;
                case 'everything':
                    $this->view->equipment = $topic_items->fetchAll();
            } //end of swtich
        } 
        else {
            $this->view->notopic = true;
        }
    }

    public function lessonpartAction()
    {
        $this->view->mode = 'topic';
        $_GET['topic'] = (isset($_GET['topic']) ? $_GET['topic'] : 'not_set');
        if($_GET['topic']!='not_set') {
            $topic_id = $_GET['topic'];
            $_GET['action'] = (isset($_GET['action']) ? $_GET['action'] : 'nothing');
            $topics = new Maintenance_Model_DbTable_Topic();
            switch( $_GET['action']){
                case 'get':
                    $topicRow = $topics->find($topic_id);
                    $topic = $topicRow->current();
                    $this->view->items = $topic->findMaintenance_Model_DbTable_LessonPartViaMaintenance_Model_DbTable_TopicLessonPart();
                    break;
                case 'nothing':
                    $this->view->noaction = true;
                case 'everything':
                    $this->view->items = $topic_items->fetchAll();
            } //end of swtich
        } 
        else {
            $this->view->notopic = true;
        }
    }


}

















