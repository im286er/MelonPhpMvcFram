<?php
	class adminModel{
		public $_table = 'admin';
		function findOne_by_username($username){

			return DB::findByUsername($this->_table,$username);
		}
	}
?>