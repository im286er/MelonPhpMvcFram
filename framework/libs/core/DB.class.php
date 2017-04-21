<?php

class DB {

	public static $db;

	public static function init($dbtype, $config) {
		self::$db = new $dbtype;
		self::$db->connect($config);
	}

	public static function query($sql){
		return self::$db->query($sql);
	}

	public static function getAll($sql){	
		return self::$db->getAll($sql);
	}
	public static function findResult($sql, $row = 0, $filed = 0){
		$num = self::$db->getAll($sql);
		return $num;
	}

	public static function findById($tableName,$prid,$fields='*'){		
		return self::$db->findById($tableName,$prid,$fields='*');
	}
	public static function findByUsername($tableName,$username,$fields='*'){
		
		return self::$db->findByUsername($tableName,$username,$fields='*');
	}

	public static function insert($arr,$table){
		return self::$db->add($table,$arr);
	}

	public static function update($data,$table,$where=null,$order=null,$limit=0){
		return self::$db->update($data,$table,$where,$order,$limit);
	}

	public static function delete($table,$where=null,$order=null,$limit=0){
		return self::$db->delete($table,$where,$order,$limit);
	}

}

?>