<?php
namespace Entity;

class Reponse {
    //attributs
    protected $id;
    protected $libelle;
    protected $id_question;
    protected $unique_id;

    
    function getId() {
        return $this->id;
    }

    function getLibelle() {
        return $this->libelle;
    }

    function getId_question() {
        return $this->id_question;
    }

    function getUnique_id() {
        return $this->unique_id;
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

    function setUnique_id($unique_id) {
        $this->unique_id = $unique_id;
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
