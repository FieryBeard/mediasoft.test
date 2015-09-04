<?php
/**
*
* InsertBuilder class
*
* Examples:
* $db->insert('user', array('name'=>'Ivan', 'age'=>'20'));
*
*/
	
class InsertBuilder{
	
	private $insert;
	private $insert_arr = array();
	
	function __construct($table, $data){
		
		
		$this->insert = 'INSERT INTO '.trim($table);
	    $values = $names = '';
	
	    foreach($data as $key=>$val){
	        $names .= $key.', ';
	        if(strtolower($val)=='null'){
		        
		       $values .= 'NULL,'; 
		       
	        }elseif(strtolower($val) == 'now()'){
		        
		        $values .= 'NOW(),';
		        
	        }else{
		        
	        	$values .= '?,';
	        	$this->insert_arr[] = addslashes($val);
		        
	        }
	    }
	
	    $this->insert .= '('. rtrim($names, ', ') .') VALUES ('. rtrim($values, ',') .')';
		
	}
	
     /**
     * Get a SQL-request string.
     *
     * @return string
     */
	function getQuery(){
		return $this->insert.';';
	}	
	
     /**
     * Get a SQL-request values.
     *
     * @return array
     */
	function getQueryParams(){
		return $this->insert_arr;
	}
	
}

?>
