<?php
	
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
	
	function from($table){
		
		$this->from = ' FROM '.trim($table);
		
		return $this;
		
	}
		
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
	
	function groupby($col){
		
		$this->groupby .= (strlen($this->groupby) > 0)?', ':' GROUP BY ';
		
		if(is_array($col)){
			$col = implode(', ', $col);
		}
		
		$this->groupby .= trim($col);
		
		return $this;
		
	}
	
	function limit($rows){
		
		$rows = (int)$rows;
		
		$this->limit = ' LIMIT '.$rows;
		
		return $this;
		
	}
	
	function offset($offset, $rows){
		
		$offset = (int)$offset;
		$rows = (int)$rows;
		
		$this->limit = ' LIMIT '.$offset.','.$rows;
		
		return $this;
		
	}
	
	function getQuery(){
		return $this->select.$this->from.$this->where.$this->orderby.$this->groupby.$this->limit.';';
	}	
	
	function getQueryParams(){
		return $this->where_arr;
	}
	
}

?>