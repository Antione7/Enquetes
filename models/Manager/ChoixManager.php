<?php

namespace Manager;

class ChoixManager {
    //attribut
    protected $pdo;
    
    public function __construct() {
        $dbManager = new DbManager();
        $this->pdo = $dbManager->getConnection();
    }

    public function insert($tab_choix) {

        foreach ($tab_choix as $choix) {
            $query="INSERT INTO choix (libelle, "
                    . "id_question)"
                    . "values("
                    . ":libelle,"
                    . ":id_question)";
            
            $libelle = $choix->getLibelle() ;
            $id_question = $choix->getId_question();

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':libelle',$libelle,\PDO::PARAM_STR);
            $stmt->bindParam(':id_question',$id_question,\PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function selectAllByQuestionId($id){
        $query = "SELECT * FROM choix WHERE id_question = :id_question";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_question',$id,\PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $tab = array();
        
        foreach($result as $row){
            $choix = new \Entity\Choix();
            $choix->hydrate($row);
            $tab[] = $choix;
        }
        
        return $tab; 
    }

    public function deleteByQuestionId($id_question){
        $query="DELETE FROM choix WHERE id_question = :id_question";
            

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_question',$id_question,\PDO::PARAM_INT);
            $stmt->execute();
    }
}
