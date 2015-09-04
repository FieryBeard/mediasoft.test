<?php
require_once("WhereBuilder.php");
require_once("SelectBuilder.php");
require_once("InsertBuilder.php");
require_once("UpdateBuilder.php");
require_once("DeleteBuilder.php");


class QueryBuilder{
	
	private $connection;
	private $action;
	
	private $defaults = array(
		'type'		=> 'mysql',
		'host'      => 'localhost',
		'user'      => 'root',
		'pass'      => '',
		'db'        => 'test'
	);
	
	function __construct($config){
		
		$config = array_merge($this->defaults,$config);
		
		try{
			
			switch ($config['type']){
				case 'sqlite':
					$this->connection = new PDO("sqlite:".$config['db'].".db");
					break;
				default:
					$this->connection = new PDO($config['type'].":host=".$config['host'].";dbname=".$config['db'], $config['user'], $config['pass']); 
					break;
			}
			
			
		}catch(PDOException $e){  
			
			echo 'Error: '.$e->getMessage(); 
			exit;
			 
		}
		
	}
	
	function select($columns='*'){
		
		$this->action = new SelectBuilder($columns);
		
		return $this->action;
		
	}
	
	function insert($table, $data){
		
		$this->action = new InsertBuilder($table, $data);
		
		return $this->action;
		
	}
	
	function update($table, $data){
		
		$this->action = new UpdateBuilder($table, $data);
		
		return $this->action;
		
	}
		
	function delete($table){
		
		$this->action = new DeleteBuilder($table);
		
		return $this->action;
		
	}
	
	function save($mode=PDO::FETCH_ASSOC){
		
		try{
			
			$stmt = $this->connection->prepare($this->action->getQuery());
			$stmt->setFetchMode($mode);
			$stmt->execute($this->action->getQueryParams());
			
			return $stmt->fetchAll();
	
		}catch(PDOException $e){
			
			echo 'Error: '.$e->getMessage();  
			exit;
			
		}
		
	}
}



?>