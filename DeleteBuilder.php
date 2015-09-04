<?php

class DeleteBuilder extends WhereBuilder{
	
	private $delete;
	
	function __construct($table){
		
	    $this->delete = 'DELETE FROM '.trim($table);
		
		return $this;
		
	}
	
	function getQuery(){
		return $this->delete.$this->where.';';
	}	
	
	function getQueryParams(){
		return $this->where_arr;
	}
	
}
	
?>