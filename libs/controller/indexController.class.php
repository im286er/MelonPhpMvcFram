<?php
	class indexController{
		function index(){
			$data = $this->getPro();
			VIEW::assign(array('data'=>$data));
			VIEW::display('index.html');
		}

		function getPro(){
			$proList = M('news');
			return $proList->findAll_orderby_dateline();
		}
	}
?>