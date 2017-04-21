<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/3
 * Time: 17:02
 */

	class userModel{

        public $_table = 'user';
        function findOne_by_username($username){
            return DB::findByUsername($this->_table,$username);
        }
        function findAll(){
            $sql = "select * from ".$this->_table;
            return DB::getAll($sql);
        }
        function deleteById($id){
            return DB::delete($this->_table, 'id='.$id);
        }

        function update($data,$id){
            return DB::update($data,$this->_table,'id="'.$id.'"');
        }


    }
