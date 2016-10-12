<?PHP
class Db
{
    
    function connectDb($auth_info)
    {
        
        $connection = new mysqli(   $auth_info['DB_HOST'],
                                    $auth_info['DB_USERNAME'], 
                                    $auth_info['DB_PASSWORD'], 
                                    $auth_info['DB_NAME']);
        if(DEBUG_MODE == 1){
            if($connection->connect_errno > 0){
                die('Unable to connect to database [' . $connection->connect_error . ']'); 
            }
        }
        else{
            die('Error Occured!');
        }
        
        return ($connection);
		
        
    }
    
    function executeInsertQuery($connection,$sql_string, $a_bind_params, $a_param_type)
    {
		
   
        /* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
        $a_params = array();

        $param_type = '';
        $n = count($a_param_type);
        for($i = 0; $i < $n; $i++)
        {
            $param_type .= $a_param_type[$i];
        }

        /* with call_user_func_array, array params must be passed by reference */
        $a_params[] = & $param_type;

        for($i = 0; $i < $n; $i++)
        {
            /* with call_user_func_array, array params must be passed by reference */
            $a_params[] = & $a_bind_params[$i];
        }
        
        /* Prepare statement */

        $stmt = $connection->prepare($sql_string);
		
        if($stmt === false) {
            if(DEBUG_MODE == 1){
                trigger_error('Wrong SQL: ' . $sql_string . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
            }
            else{
                die("Error Occured");
            }
        }
		
        /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
        $call = call_user_func_array(array($stmt, 'bind_param'), $a_params);
		
        
        if (!$stmt->execute()) {
			
			
            if(DEBUG_MODE == 1){
				
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            else{
                die("Error Occured");
            }
        }
		
        else{
			
            return mysqli_insert_id($connection);

			
        }
        
    }
    
     function executeUpdateQuery($connection,$sql_string, $a_bind_params, $a_param_type)
     {
        
        /* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
        $a_params = array();

        $param_type = '';
        $n = count($a_param_type);
        for($i = 0; $i < $n; $i++)
        {
            $param_type .= $a_param_type[$i];
        }
        
        $param_array_bind[] = $param_type;

        for($i = 0; $i < $n; $i++)
        {
            $param_array_bind[] = &$a_bind_params[$i];
        }
        
        /* Prepare statement */
        //echo $sql_string;
       // var_dump($param_array_bind);
        $stmt = $connection->prepare($sql_string);
        
        //var_dump($stmt);
        if($stmt === false) {
			
            if(DEBUG_MODE == 1){
                trigger_error('Wrong SQL: ' . $sql_string . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
            }
            else{
                die("Error Occured");
            }
        }
        
        /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
        call_user_func_array(array($stmt, 'bind_param'), $param_array_bind);
        
        if (!$stmt->execute()) {
			
            if(DEBUG_MODE == 1){
               echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            else{
                die("Error Occured");
            }
        }
        else{
			
            return TRUE;
        }
        
    }   
    

    function executeSelectQuery($connection,$sql_string, $a_bind_params, $a_param_type)
    {
        /* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
        $a_params = array();
		if(count($a_bind_params) > 0){
				$param_type = '';
				$n = count($a_param_type);
				for($i = 0; $i < $n; $i++)
				{
					$param_type .= $a_param_type[$i];
				}
		
				/* with call_user_func_array, array params must be passed by reference */
				$a_params[] = & $param_type;
		
				for($i = 0; $i < $n; $i++)
				{
					/* with call_user_func_array, array params must be passed by reference */
					$a_params[] = & $a_bind_params[$i];
				}
		}
        /* Prepare statement */
        $stmt = $connection->prepare($sql_string);

        if($stmt === false) {
            if(DEBUG_MODE == 1){
                trigger_error('Wrong SQL: ' . $sql_string . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
            }
            else{
                die("Error Occured");
            }
        }

          if(count($a_bind_params) > 0){ //Change
                /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
                                                call_user_func_array(array($stmt, 'bind_param'), $a_params);
                                }

        
        if (!$stmt->execute()) {
            if(DEBUG_MODE == 1){
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            else{
                die("Error Occured");
            }
        }
        else{
             /* Fetch result to array */
            $stmt->bind_result($col1);
            $a_data = array();
            while ($stmt->fetch()) {
        		printf("%s %s\n", $col1);
   			 }
            var_dump($a_data);
			exit();
			
            return ($a_data);
        }
        
        
    }
	
	function executeDeleteQuery($connection,$sql_string, $a_bind_params, $a_param_type)
    {
        /* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
        $a_params = array();
		if(count($a_bind_params) > 0){
				$param_type = '';
				$n = count($a_param_type);
				for($i = 0; $i < $n; $i++)
				{
					$param_type .= $a_param_type[$i];
				}
		
				/* with call_user_func_array, array params must be passed by reference */
				$a_params[] = & $param_type;
		
				for($i = 0; $i < $n; $i++)
				{
					/* with call_user_func_array, array params must be passed by reference */
					$a_params[] = & $a_bind_params[$i];
				}
		}
        /* Prepare statement */
		
        $stmt = $connection->prepare($sql_string);

        if($stmt === false) {
            if(DEBUG_MODE == 1){
                trigger_error('Wrong SQL: ' . $sql_string . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
            }
            else{
                die("Error Occured");
            }
        }

          if(count($a_bind_params) > 0){ //Change
                /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
                                                call_user_func_array(array($stmt, 'bind_param'), $a_params);
                                }

        
        if (!$stmt->execute()) {
            if(DEBUG_MODE == 1){
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            else{
                die("Error Occured");
            }
        }
        else{
             /* Fetch result to array */
            $res = $stmt->fetch();
            $a_data = array();
            
            
            return ($a_data);
        }
        
        
    } 
    

    function formatDateMysql($date)
    {
        $date_prep = date("Y/m/d",strtotime($date));
        return($date_prep);

    }
    
    function formatDateDisplay($date)
    {
        $date_prep = date("m/d/Y",strtotime($date));
        return($date_prep);

    }
}
?>