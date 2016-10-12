<?php

require('Models.php');
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
class Availability extends Models{
    
    protected $connection;
	
	
    public function __construct()
    {
        
        
    }
	
	public function setDb($connection)
    {
        
        $this->connection = $connection;
        
    }
    public function loaduserBySid(){
        
        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $sid = mysqli_real_escape_string($mysqli,$_SESSION['sid']);
        $sql_string = "SELECT * FROM fa_users WHERE user_sid = '".$sid."'";
        $query = mysqli_query($mysqli,$sql_string);
	$result = mysqli_fetch_array($query);	
	return $result;
    }
    
     public function deleteStatus($floor,$type){
        
        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        $floor = mysqli_real_escape_string($mysqli,$floor);
        $type = mysqli_real_escape_string($mysqli,$type);
        
        $sql_string = "DELETE FROM fa_apartments WHERE ap_floor='".$floor."' AND ap_type = '".$type."'";
        $query = mysqli_query($mysqli,$sql_string);
	
    }
    public function insertStatus($floor,$type,$status){
        
        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        $floor = mysqli_real_escape_string($mysqli,$floor);
        $type = mysqli_real_escape_string($mysqli,$type);
        $status = mysqli_real_escape_string($mysqli,$status);
        
        $sql_string = "INSERT INTO fa_apartments (ap_floor,ap_type,ap_status) VALUES('".$floor."','".$type."','".$status."')";
        $query = mysqli_query($mysqli,$sql_string);
	
    }
     public function getStatus($floor,$type){
        
        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        $floor = mysqli_real_escape_string($mysqli,$floor);
        $type = mysqli_real_escape_string($mysqli,$type);
        
        $sql_string = "SELECT * FROM fa_apartments WHERE ap_floor='".$floor."' AND ap_type = '".$type."'";
        $query = mysqli_query($mysqli,$sql_string);
        $result = mysqli_fetch_array($query);	
	return $result;
	
    }
    
    
}
