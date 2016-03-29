<?php
namespace Entity;


class Question {
    //attributs
    protected $id;
    protected $libelle;
    protected $id_enquete;
    protected $id_type_reponse;
    
    function getId() {
        return $this->id;
    }

    function getLibelle() {
        return $this->libelle;
    }

    function getId_enquete() {
        return $this->id_enquete;
    }

    function getId_type_reponse() {
        return $this->id_type_reponse;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    function setId_enquete($id_enquete) {
        $this->id_enquete = $id_enquete;
    }

    function setId_type_reponse($id_type_reponse) {
        $this->id_type_reponse = $id_type_reponse;
    }

    public function hydrate($data){
        
        foreach($data as $key=>$value){
            
            $method = "set".ucfirst($key);
            
            if(method_exists($this, $method)){
                $this->$method($value);
            }
            
        }
    }
}
