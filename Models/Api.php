<?php

require('Models.php');
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
class Login extends Models{
    
    protected $connection;
	
	
    public function __construct()
    {
        
        
    }
	
	public function setDb($connection)
    {
        
        $this->connection = $connection;
        
    }
   
    
    public function isValidSite($site_key){
        
        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        
        $site_key = mysqli_real_escape_string($mysqli,$site_key);
        
        
        $sql_string = "SELECT * FROM office_sites WHERE site_key = '".$site_key."'";
        $query = mysqli_query($mysqli,$sql_string);
	$result = mysqli_fetch_array($query);	
	return $result;
    }
    
    
}
