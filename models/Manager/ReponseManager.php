<?php

namespace Manager;

class ReponseManager {
    //attribut
    protected $pdo;
    
    public function __construct() {
        $dbManager = new DbManager();
        $this->pdo = $dbManager->getConnection();
    }

    public function insert($tab_reponse) {

        foreach ($tab_reponse as $reponse) {

            $query="INSERT INTO reponse (libelle, "
                    . "id_question, "
                    . "unique_id)"
                    . "values("
                    . ":libelle,"
                    . ":id_question,"
                    . ":unique_id)";

            $libelle = $reponse->getLibelle();
            $id_question = $reponse->getId_question();
            $unique_id = $reponse->getUnique_id();

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':libelle',$libelle,\PDO::PARAM_STR);
            $stmt->bindParam(':id_question',$id_question,\PDO::PARAM_INT);
            $stmt->bindParam(':unique_id',$unique_id,\PDO::PARAM_STR);
            $stmt->execute();
            
        }
    }

    public function selectAllByQuestionId($id){
        $query = "SELECT * FROM reponse WHERE id_question = :id_question";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_question',$id,\PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $tab = array();
        
        foreach($result as $row){
            $reponse = new \Entity\Reponse();
            $reponse->hydrate($row);
            $tab[] = $reponse;
        }
        
        return $tab;
    }

    public function selectAllByEnqueteId($id){
        $query="SELECT * FROM reponse r LEFT JOIN question q ON q.id = r.id_question WHERE q.id_enquete = :id_enquete";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_enquete',$id,\PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $tab = array();
        
        foreach($result as $row){
            $reponse = new \Entity\Reponse();
            $reponse->hydrate($row);
            $tab[] = $reponse;
        }
        
        return $tab;

    }
    
    public function getAnswerNumberByEnqueteId($id){
        $query="SELECT unique_id, COUNT(unique_id) FROM reponse r LEFT JOIN question q ON q.id = r.id_question WHERE q.id_enquete = :id_enquete GROUP BY unique_id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_enquete',$id,\PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return count($result);
    }
    
    public function deleteByQuestionId($id){
        $query="DELETE FROM reponse WHERE id_question = :id_question";
        

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_question',$id,\PDO::PARAM_INT);
        $stmt->execute();

    }
    
    public function deleteByUniqueId($unique_id){
        $query="DELETE FROM reponse WHERE unique_id = :unique_id";
        

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':unique_id',$unique_id,\PDO::PARAM_INT);
        $stmt->execute();

    }


    public function selectOccurencesLibelleByQuestionId($id){
        $query="SELECT libelle, count(libelle) FROM reponse AS r WHERE id_question = :id_question GROUP BY libelle ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_question',$id,\PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $tab = array();
        
        foreach($result as $row){
            
            $tab[$row['libelle']] = $row['count(libelle)'];
        }
        
        return $tab;
    }
    
}
