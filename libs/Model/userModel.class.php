<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/3
 * Time: 17:02
 */

	class userModel{

        public $_table = 'admin';
        function findOne_by_username($username){
            return DB::findByUsername($this->_table,$username);
        }
        function findAll(){
            $sql = "select * from ".$this->_table;
            return DB::getAll($sql);
        }


        function update($data,$id){
            return DB::update($data,$this->_table,'id="'.$id.'"');
        }

        function delById($id){
            return DB::delete($this->_table,'id="'.$id.'"');
        }

        function insert($data){
            return DB::insert($this->_table, $data);
        }

    }
