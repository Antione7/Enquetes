<?php

namespace Manager;

class TypeReponseManager {
    //attibuts 
    protected $pdo;
    
    public function __construct() {
        $dbManager = new DbManager();
        $this->pdo = $dbManager->getConnection();
    }
    
    public function selectOneByName($name){
        $query = "SELECT * FROM type_reponse WHERE name=:name";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name',$name,\PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;

    }    

    public function selectOneById($id){
        $query = "SELECT * FROM type_reponse WHERE id=:id";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id',$id,\PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;

    }

}
