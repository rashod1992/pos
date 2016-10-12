<?php
require('MainController.php');
class AvailabilityController extends MainController{
    
    
    public  function loaduserBySid(){
        
        $api = new Availability;
        $info = $api->loaduserBySid();
        return $info;
        
    }
    public  function updateStatus($floor,$type,$status){
        
        $api = new Availability;
        $info = $api->deleteStatus($floor,$type);
        $info = $api->insertStatus($floor,$type,$status);
        return $info;
        
    }
    public  function getStatus($floor,$type){
        
        $api = new Availability;
        $info = $api->getStatus($floor,$type);
        
        if(count($info)>0){
            
            if($info['ap_status']==1){
                $status = "available";
            }elseif($info['ap_status']==2){
                $status = "sold";
            }elseif($info['ap_status']==3){
                $status = "blocked";
            }elseif($info['ap_status']==4){
                $status = "reserved";
            }else{
               $status = "reserved"; 
            }
            
        }else{
            $status = "available";
            
        }
        
        return $status;
    }
    
    
}

