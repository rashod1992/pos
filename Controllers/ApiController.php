<?php
require('MainController.php');
include_once('./Helpers/PHPMailer_5.2.4/class.phpmailer.php');
class LoginController extends MainController{
    
    
    public  function isValidSite($site_key){
        
        $api = new Api;
        $info = $api->isValidSite($site_key);
        return $info;
        
    }
    
    
}

