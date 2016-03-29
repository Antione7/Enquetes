<?php

namespace Manager;

class EnqueteManager {
    //attribut
    protected $pdo;
    
    public function __construct() {
        $dbManager = new DbManager();
        $this->pdo = $dbManager->getConnection();
    }

    public function insert($enquete) {
        $query="insert into enquete (titre, "
                . "description, "
                . "id_utilisateur)"
                . "values("
                . ":titre,"
                . ":description, "
                . ":id_utilisateur)";
        
        $titre = $enquete->getTitre();
        $description = $enquete->getDescription();
        $id_utilisateur = $enquete->getId_utilisateur();
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':titre',$titre,\PDO::PARAM_STR);
        $stmt->bindParam(':description',$description,\PDO::PARAM_STR);
        $stmt->bindParam(':id_utilisateur',$id_utilisateur,\PDO::PARAM_INT);
        $stmt->execute();
        
        $enquete->setId($this->pdo->lastInsertId());
    }

    public function selectAllByUserId($id) {
        $query = "SELECT * FROM enquete WHERE id_utilisateur = :id_utilisateur";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur',$id,\PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $tab = array();
        
        foreach($result as $row){
            $enquete = new \Entity\Enquete();
            $enquete->hydrate($row);
            $tab[] = $enquete;
        }
        
        return $tab;        
    }

    public function selectOneById($id) {
        $query = "SELECT * FROM enquete WHERE id=:id";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id',$id,\PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function update($enquete){
        
        $query="UPDATE enquete SET titre=:titre, description=:description WHERE id=:id";

        $titre = $enquete->getTitre();
        $description = $enquete->getDescription();
        $id = $enquete->getId();


        $stmt=$this->pdo->prepare($query);
        $stmt->bindParam(':titre',$titre, \PDO::PARAM_STR);
        $stmt->bindParam(':description',$description, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
    }

    public function deleteById($id){
        $query="DELETE FROM enquete WHERE id = :id";
        

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id',$id,\PDO::PARAM_INT);
        $stmt->execute();
    }
    
}
