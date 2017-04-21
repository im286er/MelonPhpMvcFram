
<?php
//数据库与smarty模板引擎的配置
	$config = array(
		'viewconfig' => array(
			'left_delimiter' => '{','right_delimiter' => '}',  'template_dir' => 'tpl',  'compile_dir' => 'data/template_c'),
		'dbconfig' => array(
			'hostname'=>'localhost','username'=>'root', 'password' => '' , 'dbcharset' => 'utf8','hostport'=>'3306','dsn'=>'mysql:host=localhost;dbname=imooc')
	);
?>