<?php
	class newsModel{

		public $_table = 'news';

		function findAll_orderby_dateline($curPage,$size){
			$sql = 'select * from '.$this->_table.' order by fdate desc limit '.($curPage-1)*$size.','.$size;
			return DB::getAll($sql);
		}

		function findOne_by_id($id){
			return DB::findById($this->_table,$id);
		}

		function del_by_id($id){
			return DB::delete($this->_table, 'id='.$id);
		}

		function count(){
			$sql = 'select * from '.$this->_table;
			return count(DB::getAll($sql));
		}

		function insert($data){
			return DB::insert($this->_table, $data);
		}

		function update($data,$id){
			return DB::update($data,$this->_table,'id="'.$id.'"');
		}

	}
?>