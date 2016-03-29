<?php
namespace Entity;

class Enquete {
    //attributs
    protected $id;
    protected $titre;
    protected $description;
    protected $id_utilisateur;

    
    function getId() {
        return $this->id;
    }

    function getTitre() {
        return $this->titre;
    }

    function getDescription() {
        return $this->description;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitre($titre) {
        $this->titre = $titre;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
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
