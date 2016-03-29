<?php
namespace Entity;

class Choix {
    //atributs
    protected $id;
    protected $libelle;
    protected $id_question;
    
    function getId() {
        return $this->id;
    }

    function getLibelle() {
        return $this->libelle;
    }

    function getId_question() {
        return $this->id_question;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    function setId_question($id_question) {
        $this->id_question = $id_question;
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
