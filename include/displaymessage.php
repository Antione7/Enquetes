<?php

$sessionManager = new Manager\SessionManager();

$message ="";

if($sessionManager->errorMessage!=""){
    $message = '<div class="alert alert-danger error_info_message">'.$sessionManager->errorMessage.'</div>';
    $sessionManager->errorMessage = null;
}

if($sessionManager->infoMessage!=""){
    $message = '<div class="alert alert-success error_info_message">'.$sessionManager->infoMessage.'</div>';
    $sessionManager->infoMessage = null;
}

