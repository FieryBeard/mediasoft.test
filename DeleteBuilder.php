<?php
/**
*
* DeleteBuilder class
*
* Examples:
* $db->delete('user');
*
*/

class DeleteBuilder extends WhereBuilder{
	
	private $delete;
	
	function __construct($table){
		
	    $this->delete = 'DELETE FROM '.trim($table);
		
		return $this;
		
	}
	
	/**
	 * Get a SQL-request string.
	 *
	 * @return string
	 */
	function getQuery(){
		return $this->delete.$this->where.';';
	}	
	
	/**
	 * Get a SQL-request values.
	 *
	 * @return array
	 */
	function getQueryParams(){
		return $this->where_arr;
	}
	
}
	
?>