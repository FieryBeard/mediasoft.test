<?php
/**
*
* SelectBuilder class
*
* Examples:
* $db->select()
*	->from('user')
*	->orderby('age')
*	->groupby(array('name','age'))
*	->limit(5);
*	->offset(0,3);
*
*/
	
class SelectBuilder extends WhereBuilder{
	
	private $select;
	private $from;
	private $orderby;
	private $groupby;
	private $limit;
	
	function __construct($columns){
		
		if(is_array($columns)){
			$columns = implode(',', $columns);
		}
		
		$this->select = 'SELECT '.trim($columns);
		
		return $this;
		
	}
	
     /**
     * Generate a FROM part of SELECT SQL-request.
     *
     * Examples:
     * $db->select()->from('user');
     *
     * @param string $table
     * @return SelectBuilder
     */
	function from($table){
		
		$this->from = ' FROM '.trim($table);
		
		return $this;
		
	}
		
     /**
     * Generate a ORDER BY part of SELECT SQL-request.
     *
     * Examples:
     * $db->select()->orderby('user');
     * $db->select()->orderby(array('name','age'));
     * $db->select()->orderby('user', 'DESC');
     *
     * @param mixed $col
     * @param string $sort
     * @return SelectBuilder
     */
	function orderby($col, $sort='ASC'){
		
		$sort = strtoupper(trim($sort));
		$sort = ($sort == 'ASC' || $sort == 'DESC')?$sort:'ASC';
		
		$this->orderby .= (strlen($this->orderby) > 0)?', ':' ORDER BY ';
		
		if(is_array($col)){
			$col = implode(' '.$sort.', ', $col);
		}
		
		$this->orderby .= $col.' '.$sort;
		
		return $this;
		
	}
	
     /**
     * Generate a GROUP BY part of SELECT SQL-request.
     *
     * Examples:
     * $db->select()->groupby('user');
     * $db->select()->groupby(array('name','age'));
     *
     * @param mixed $col
     * @return SelectBuilder
     */
	function groupby($col){
		
		$this->groupby .= (strlen($this->groupby) > 0)?', ':' GROUP BY ';
		
		if(is_array($col)){
			$col = implode(', ', $col);
		}
		
		$this->groupby .= trim($col);
		
		return $this;
		
	}
	
     /**
     * Generate a LIMIT part of SELECT SQL-request.
     *
     * Examples:
     * $db->select()->limit(10);
     *
     * @param int $rows
     * @return SelectBuilder
     */
	function limit($rows){
		
		$rows = (int)$rows;
		
		$this->limit = ' LIMIT '.$rows;
		
		return $this;
		
	}
	
     /**
     * Generate a LIMIT part of SELECT SQL-request with offset option.
     *
     * Examples:
     * $db->select()->offset(10,20);
     *
     * @param int $offset
     * @param int $rows
     * @return SelectBuilder
     */
	function offset($offset, $rows){
		
		$offset = (int)$offset;
		$rows = (int)$rows;
		
		$this->limit = ' LIMIT '.$offset.','.$rows;
		
		return $this;
		
	}
	
     /**
     * Get a SQL-request string.
     *
     * @return string
     */
	function getQuery(){
		return $this->select.$this->from.$this->where.$this->orderby.$this->groupby.$this->limit.';';
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
