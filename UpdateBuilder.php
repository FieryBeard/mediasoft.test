<?php

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
	
	function getQuery(){
		return $this->update.$this->set.$this->where.';';
	}	
	
	function getQueryParams(){
		return array_merge($this->set_arr, $this->where_arr);
	}
}
	
?>