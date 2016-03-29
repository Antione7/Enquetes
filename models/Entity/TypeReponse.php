<?php


namespace Entity;

class TypeReponse {
    //attributs
    protected $id;
    protected $name;
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
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
