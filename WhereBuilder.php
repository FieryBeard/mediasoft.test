<?php

class WhereBuilder{
	
	protected $where;
	protected $where_arr = array();
	
	function where($col, $op, $val, $t='AND'){

		$t = strtoupper(trim($t));
		$t = ($t == 'AND' || $t == 'OR')?$t:'AND';
		
		$op = strtoupper($op);
		$allowed = array(
					'=',
					'!=',
					'>',
					'<',
					'<>',
					'>=',
					'<=',
					'IS NOT NULL',
					'IS NULL',
					'LIKE',
					'NOT LIKE');
					
		if(!in_array($op, $allowed)){
			return $this;
		}
		
		$val = addslashes(trim($val));
		
		$this->where .= (strlen($this->where) > 0)?' '.$t.' ':' WHERE ';
		$this->where .= '('.$col.' '.$op.' ?)';
		array_push($this->where_arr, $val);
		
		return $this;
		
	}
	
	function between($col, $from, $to, $t='AND'){
		
		$t = strtoupper(trim($t));
		$t = ($t == 'AND' || $t == 'OR')?$t:'AND';
		
		$from = addslashes(trim($from));
		$to = addslashes(trim($to));
		
		$this->where .= (strlen($this->where) > 0)?' '.$t.' ':' WHERE ';
		$this->where .= '('.$col.' BETWEEN ? AND ?)';
		array_push($this->where_arr, $from, $to);
		
		return $this;
		
	}
	
	function in($col, $val, $t='AND'){
		
		$t = strtoupper(trim($t));
		$t = ($t == 'AND' || $t == 'OR')?$t:'AND';
		
		if(is_array($val)){
			
			$value = '(';
			
			foreach($val as $key=>$v){
				$v = addslashes(trim($v));
				$value .= '?,';
				$this->where_arr[] = $v;
			}
			
			$value{strlen($value)-1} = ')';
			
		}else{
			
			$val = explode(',', $val);
			$this->in($col, $val, $t);
			
			return $this;
			
		}
		
		$this->where .= (strlen($this->where) > 0)?' '.$t.' ':' WHERE ';
		$this->where .= "($col IN $value)";
		
		return $this;
		
	}
	
	function not_in($col, $val, $t='AND'){
		
		$t = strtoupper(trim($t));
		$t = ($t == 'AND' || $t == 'OR')?$t:'AND';
		
		if(is_array($val)){
			
			$value = '(';
			
			foreach($val as $key=>$v){
				$v = addslashes(trim($v));
				$value .= '?,';
				$this->where_arr[] = $v;
			}
			
			$value{strlen($value)-1} = ')';
			
		}else{
			
			$val = explode(',', $val);
			$this->not_in($col, $val, $t);
			return $this;
			
		}
		
		$this->where .= (strlen($this->where) > 0)?' '.$t.' ':' WHERE ';
		$this->where .= "($col NOT IN $value)";
		
		return $this;
		
	}

}
	
?>