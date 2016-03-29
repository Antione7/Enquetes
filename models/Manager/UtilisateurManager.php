<?php

namespace Manager;

class UtilisateurManager {
    //attribut
    protected $pdo;
    
    public function __construct(){
        $dbManager = new DbManager();
        $this->pdo = $dbManager->getConnection();
        
    }
    
    public function insert($utilisateur){
        
            $query = "insert into utilisateur (email, password) "
                    . "values (:email, :password)";

            $email=$utilisateur->getEmail();
            $password=password_hash($utilisateur->getPassword(), PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':email',$email , \PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
            $stmt->execute();
            
            $utilisateur->setId($this->pdo->lastInsertId());
        
    }
    
    public function emailExist($email){
        if(!isset($email) || $email==""){
            return false;
        }
        
        $query = "select * from utilisateur where email = :email";
        $stmt=$this->pdo->prepare($query);
        $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount()>0){
            return true;
        }
        
        return false;
                
    }
    
    public function authentification($email, $password){
        
        //On s'assure que les paramètres email et password sont là
        if(!isset($email) || $email=="" || !isset($password) || $password==""){
            
            return false;
            
        }
        
        //On prépare et on exécute la requête de récupération de l'utilisateur
        $query ="select * from utilisateur where email=:email";
        $stmt=$this->pdo->prepare($query);
        $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount()!=1){
            
            return false;
            
        } else {
            
            //on récupere la ligne de l'utilisateur concerné
            $result = $stmt->fetch();
            
            if(password_verify($password, $result['password'])){

            //tout est ok
            //on monte en session l'id_utilisateur, nom, prenom, email et on retourne true
            $sessionManager = new SessionManager();
            $sessionManager->id_utilisateur = $result['id'];
            $sessionManager->email = $result['email'];
            $sessionManager->Z45THYIOPOK67 = true;

            return true;
                
            } else {
                return false;
            };
        }
    }

    public function selectOneById($id){
        $query = "SELECT * FROM utilisateur WHERE id=:id";

        $stmt=$this->pdo->prepare($query);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function update($utilisateur){
        
        $query="UPDATE utilisateur SET email=:email, password=:password WHERE id=:id";

        $email = $utilisateur->getEmail();
        $password = password_hash($utilisateur->getPassword(), PASSWORD_DEFAULT);
        $id = $utilisateur->getId();


        $stmt=$this->pdo->prepare($query);
        $stmt->bindParam(':email',$email, \PDO::PARAM_STR);
        $stmt->bindParam(':password',$password, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
    }
}
