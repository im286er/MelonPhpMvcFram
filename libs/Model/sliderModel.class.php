<?php
	class sliderModel{

		public $child_table = 'sliderimg';
		public $parent_table = 'slider_class';
		function findAllSlider(){
			$sql = 'select * from '.$this->parent_table;
			return DB::getAll($sql);
		}
		function getSliderImgList($id){
			$sql = 'select c.name,c.id,c.text,c.position from '.$this->child_table.' as c where c.classId='.$id.' ORDER BY c.position ASC;';
			return DB::getAll($sql);
		}
		function delClassById($id){
			return DB::delete($this->child_table, 'id='.$id);
		}
		function insertClass($data){
			return DB::insert($this->parent_table, $data);
		}
		function findOneById($id){
			return DB::findById($this->child_table,$id);
		} 
		function delChildById($id){
			return DB::delete($this->child_table, 'id='.$id);
		}
		function insertChild($data){
		    var_dump($data);
			return DB::insert($this->child_table, $data);
		}

		function updateChild($data,$id){
			return DB::update($data,$this->child_table,'id="'.$id.'"');
		}
		function updateParent($data,$id){
			return DB::update($data,$this->parent_table,'id="'.$id.'"');
		}
		function insertParent($data){
			return DB::insert($this->parent_table,$data);
		}
	}
?>