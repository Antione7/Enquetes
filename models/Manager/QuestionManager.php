<?php

namespace Manager;

class QuestionManager {
    //attribut
    protected $pdo;
    
    public function __construct() {
        $dbManager = new DbManager();
        $this->pdo = $dbManager->getConnection();
    }

    public function insert($tab_question) {

        foreach ($tab_question as $question) {

            $query="INSERT INTO question (libelle, "
                    . "id_enquete, "
                    . "id_type_reponse)"
                    . "values("
                    . ":libelle,"
                    . ":id_enquete, "
                    . ":id_type_reponse)";

            $libelle = $question->getLibelle();
            $id_enquete = $question->getId_enquete();
            $id_type_reponse = $question->getId_type_reponse();

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':libelle',$libelle,\PDO::PARAM_STR);
            $stmt->bindParam(':id_enquete',$id_enquete,\PDO::PARAM_INT);
            $stmt->bindParam(':id_type_reponse',$id_type_reponse,\PDO::PARAM_INT);
            $stmt->execute();
            
            $question->setId($this->pdo->lastInsertId());
        }
    }

    public function selectAllByEnqueteId($id){
        $query = "SELECT * FROM question WHERE id_enquete = :id_enquete";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_enquete',$id,\PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $tab = array();
        
        foreach($result as $row){
            $question = new \Entity\Question();
            $question->hydrate($row);
            $tab[] = $question;
        }
        
        return $tab;   
    }

    public function deleteByEnqueteId($id_enquete){
        $query="DELETE FROM question WHERE id_enquete = :id_enquete";
            

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_enquete',$id_enquete,\PDO::PARAM_INT);
            $stmt->execute();
    }

    
}
