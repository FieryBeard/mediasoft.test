<?php
/**
*
* QueryBuilder class
*
* Connection:
* $db = new QueryBuilder(); 		// with default settings
*
* $conf = array(
* 	'type'		=> 'mysql',			// pgsql, mssql, sqlite
* 	'host'      => 'localhost',
* 	'user'      => 'root',
* 	'pass'      => 'pass',
* 	'db'        => 'test'
* );
*
* $db = new QueryBuilder($conf);	// with some of the default settings overwritten
*
*/

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
			return false;
			 
		}
		
	}
	
	/**
     * Builds a SELECT SQL-request.
     *
     * Examples:
     * $db->select();
     * $db->select('id');
     * $db->select('id,name');
     * $db->select(array('id','name'));
     *
     * @param mixed $columns
     * @return SelectBuilder
     */
	function select($columns='*'){
		
		$this->action = new SelectBuilder($columns);
		
		return $this->action;
		
	}
	
	/**
     * Builds a INSERT INTO SQL-request.
     *
     * Examples:
     * $db->insert('user', array('name'=>'Ivan', 'age'=>'20'));
     *
     * @param string $table
     * @param array $data
     * @return InsertBuilder
     */
	function insert($table, $data){
		
		$this->action = new InsertBuilder($table, $data);
		
		return $this->action;
		
	}
	
	/**
     * Builds a UPDATE SQL-request.
     *
     * Examples:
     * $db->update('user', array('name'=>'Ivan', 'age'=>'20'));
     *
     * @param string $table
     * @param array $data
     * @return UpdateBuilder
     */
	function update($table, $data){
		
		$this->action = new UpdateBuilder($table, $data);
		
		return $this->action;
		
	}
		
	/**
     * Builds a DELETE SQL-request.
     *
     * Examples:
     * $db->delete('user');
     *
     * @param string $table
     * @return DeleteBuilder
     */
	function delete($table){
		
		$this->action = new DeleteBuilder($table);
		
		return $this->action;
		
	}
	
	/**
     * Execute a SQL-request.
     *
     * Examples:
     * $db->save();
     * $db->save(PDO::FETCH_NUM));
     *
     * @param string $mode
     * @return array/FALSE
     */
	function save($mode=PDO::FETCH_ASSOC){
		
		try{
			
			$stmt = $this->connection->prepare($this->action->getQuery());
			$stmt->setFetchMode($mode);
			$stmt->execute($this->action->getQueryParams());
			
			return $stmt->fetchAll();
	
		}catch(PDOException $e){
			
			echo 'Error: '.$e->getMessage();  
			return false;
			
		}
		
	}
}



?>