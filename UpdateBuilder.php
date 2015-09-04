<?php
/**
*
* UpdateBuilder class
*
* Examples:
* $db->update('user', array('name'=>'Ivan', 'age'=>'20'));
*
*/

class UpdateBuilder extends WhereBuilder{
	
	private $update;
	private $set;
	private $set_arr = array();
	
	function __construct($table, $data){
			
		$this->update = 'UPDATE '.trim($table);
		
	    $this->set = ' SET ';
	
	    foreach($data as $key=>$val){
		    
	        if(strtolower($val)=='null'){
		        
		       $this->set .= $key.'=NULL,'; 
		       
	        }elseif(strtolower($val) == 'now()'){
		        
		        $this->set .= $key.'=NOW(),';
		        
	        }else{
		        
	        	$this->set .= $key.'=?,';
	        	$this->set_arr[] = addslashes($val);
		        
	        }
	    }
	
	    $this->set = rtrim($this->set, ',');
		
	}
	
     /**
     * Get a SQL-request string.
     *
     * @return string
     */
	function getQuery(){
		return $this->update.$this->set.$this->where.';';
	}	
	
     /**
     * Get a SQL-request values.
     *
     * @return array
     */
	function getQueryParams(){
		return array_merge($this->set_arr, $this->where_arr);
	}
}
	
?>
