<?php

namespace Manager;

/**
 * Description of SessionManager
 *
 * @author stagiaire
 */
class SessionManager {

    public function __construct(){
        if(!isset($_SESSION)){
            session_start();
        }
    }
    
   public function __set($name, $value) {
       $_SESSION[$name] = $value;
   }
   
   public function __get($name) {
       if(isset($_SESSION[$name])){
            return $_SESSION[$name];
       }
       
       return false;
   }
   
   public function destroy(){
       $_SESSION = array();
       session_destroy();
   }
   
   public function restart(){
       session_start();
   }
   
}

