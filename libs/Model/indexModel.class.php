<?php
	class indexModel{

		public $_table = 'news';

		function findAll(){
			$sql = 'select * from '.$this->_table;
			return DB::getAll($sql);
		}

		
	}
?>