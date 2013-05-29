<?php


class Application_Model_DbTable_StoredProcedures extends Zend_Db_Table_Abstract 
{
    public function CreatePlan($teacher_id,$topic_id,$topic,$level,$description,$num_lessons,$plan_type)
    {
        if($plan_type=='setplan'){
        $pdo = $this->getAdapter()->prepare("CALL CreateDefaultUnit(:teacher,:topic_id,:topic,:level,:description,:num_lessons,@success)");
                $pdo->bindParam(':teacher',$teacher_id,PDO::PARAM_STR);
                $pdo->bindParam(':topic_id',$topic_id,PDO::PARAM_STR);
                $pdo->bindParam(':topic',$topic,PDO::PARAM_STR);
                $pdo->bindParam(':level',$level,PDO::PARAM_STR);
                $pdo->bindParam(':description',$description,PDO::PARAM_STR);
                $pdo->bindParam(':num_lessons',$num_lessons,PDO::PARAM_STR);
        $pdo->execute();
        return 1;
        }
        elseif($plan_type=='unsetplan'){
        $pdo = $this->getAdapter()->prepare("CALL CreateUnit(:teacher,:topic_id,:topic,:level,:description,:num_lessons,@success)");
                $pdo->bindParam(':teacher',$teacher_id,PDO::PARAM_STR);
                $pdo->bindParam(':topic_id',$topic_id,PDO::PARAM_STR);
                $pdo->bindParam(':topic',$topic,PDO::PARAM_STR);
                $pdo->bindParam(':level',$level,PDO::PARAM_STR);
                $pdo->bindParam(':description',$description,PDO::PARAM_STR);
                $pdo->bindParam(':num_lessons',$num_lessons,PDO::PARAM_STR);
        $pdo->execute(); 
        return 1;
        }
        else return 0;
     }
     public function CreateGuestPlan($teacher_id,$topic_id,$topic,$level,$description,$num_lessons,$plan_type)
    {
        if($plan_type=='setplan'){
        $pdo = $this->getAdapter()->prepare("CALL CreateDefaultGuestUnit(:teacher,:topic_id,:topic,:level,:description,:num_lessons,@success)");
                $pdo->bindParam(':teacher',$teacher_id,PDO::PARAM_STR);
                $pdo->bindParam(':topic_id',$topic_id,PDO::PARAM_STR);
                $pdo->bindParam(':topic',$topic,PDO::PARAM_STR);
                $pdo->bindParam(':level',$level,PDO::PARAM_STR);
                $pdo->bindParam(':description',$description,PDO::PARAM_STR);
                $pdo->bindParam(':num_lessons',$num_lessons,PDO::PARAM_STR);
        $pdo->execute();
        return 1;
        }
    }
}

?>
