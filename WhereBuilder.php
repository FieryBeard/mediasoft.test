<?php
/**
*
* WhereBuilder class
*
* Generate WHERE part of SQL-request.
*
* Examples:
* $db->select()
*	->from('user')
*	->where('age','>',10)
*	->where('age','IS NOT NULL')
*	->where('name','like','%ivan%','or')
*	->in('name',array('Ivan','Petr'))
*	->not_in('age',array(16,20,17), 'OR')
*	->between('age',14,50);
*
*/

class WhereBuilder{
	
	protected $where;
	protected $where_arr = array();
	
	/**
     * Add condition.
     *
     * Examples:
     * $db->...->where('age','=',10);
     * $db->...->where('age','!=',10, 'or');
     * $db->...->where('age','>',10);
     * $db->...->where('age','<',10, 'AND');
     * $db->...->where('age','<>',10);
     * $db->...->where('age','>=',10);
     * $db->...->where('age','<=',10);
     * $db->...->where('age','IS NOT NULL');
     * $db->...->where('age','IS NULL');
     * $db->...->where('name','LIKE','%Ivan_'');
     * $db->...->where('name','NOT LIKE','Ivan');
     *
     * @param string $col
     * @param string $op		// '=', '!=', '>', '<', '<>', '>=', '<=', 'IS NOT NULL', 'IS NULL', 'LIKE', 'NOT LIKE'
     * @param mixed $val
     * @param string $t			// 'AND' or 'OR'
     * @return WhereBuilder
     */
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
	
	/**
	* Add IN condition.
	*
	* Examples:
	* $db->...->in('name','Ivan,Petr');
	* $db->...->in('name',array('Ivan','Petr'));
	* $db->...->in('age',array(16,20,17), 'OR');
	*
	* @param string $col
	* @param mixed $val
	* @param string $t			// 'AND' or 'OR'
	* @return WhereBuilder
	*/
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
	
	/**
	* Add NOT IN condition.
	*
	* Examples:
	* $db->...->not_in('name','Ivan,Petr');
	* $db->...->not_in('name',array('Ivan','Petr'));
	* $db->...->not_in('age',array(16,20,17), 'OR');
	*
	* @param string $col
	* @param mixed $val
	* @param string $t			// 'AND' or 'OR'
	* @return WhereBuilder
	*/
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
	
	/**
	* Add BETWEEN condition.
	*
	* Examples:
	* $db->...->between('age',18,35);
	* $db->...->between('age',18,35,'OR');
	*
	* @param string $col
	* @param int $from
	* @param int $to
	* @param string $t			// 'AND' or 'OR'
	* @return WhereBuilder
	*/
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

}
	
?>