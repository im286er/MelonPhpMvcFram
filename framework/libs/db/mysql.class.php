<?php 
header('content-type:text/html;charset=utf-8');
date_default_timezone_set('PRC');

class mysql{
	public static $config=array();//配置数组
	public static $link=null;//连接标志
	public static $pconnect=false;//连接是否成功
	public static $dbVersion=null;//数据库版本
	public static $connected=false;//
	public static $PDOStatement=null;//
	public static $queryStr=null;//保存上次执行的语句
	public static $error=null;//保存错误信息
	public static $lastInsertId=null;//上一次插入操作的id
	public static $numRows=0;//
    
    public static $iniCachDir = "cach/";//默认缓存文件夹
        

	public function __construct(){
		
	}
	
	/**
	 * 连接数据库
	 * 
	 */
	public static function connect($dbConfig=''){
	    if(!class_exists("PDO")){
	        self::throw_exception('无法使用pdo');
	    }
	    /*
	    if(!is_array($dbConfig)){
	        $dbConfig=array(
	            'hostname'=>DB_HOST,
	            'username'=>DB_USER,
	            'password'=>DB_PWD,
	            'database'=>DB_NAME,
	            'hostport'=>DB_PORT,
	            'dbms'=>DB_TYPE,
	            'dsn'=>DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME
	        );
	    }
	    */
	    self::$config=$dbConfig;

	    //if(empty(self::$config['hostname']))self::throw_exception('主机名错误');
	    
	    if(empty(self::$config['params']))self::$config['params']=array();
	    if(!isset(self::$link)){
	        $configs=self::$config;
	        if(self::$pconnect){
	            //设置参数
	            $configs['params'][constant("PDO::ATTR_PERSISTENT")]=true;
	        }
	        try{
	            self::$link=new PDO($configs['dsn'],$configs['username'],$configs['password'],$configs['params']);
	        }catch(PDOException $e){
	            self::throw_exception($e->getMessage());
	        }
	        if(!self::$link){
	            self::throw_exception('PDO连接异常');
	            return false;
	        }
	        self::$link->exec('SET NAMES '.$configs['dbcharset']);
	        self::$dbVersion=self::$link->getAttribute(constant("PDO::ATTR_SERVER_VERSION"));
	        self::$connected=true;
	        unset($configs);
	    }
	}
	
	public static function getNum($sql){

	}  
	/**
	 * 执行sql语句，得到所有结果
	 * @param string $sql
	 * @return unknown
	 */
	public static function getAll($sql=null,$fileName=null,$overTime=3600,$fileDir='cach/'){
            if(isset($fileName)){
                $fileName=  md5($sql);
                $res = self::readCach($fileName,$overTime,$fileDir);
                if($res){return $res;}
            }
            self::connect();
            if($sql!=null){
                    self::query($sql);
            }
            $result=self::$PDOStatement->fetchAll(constant("PDO::FETCH_ASSOC"));
            if(isset($fileName))self::addFindCach($result, $fileName);
            return $result;
	}
	/**
	 * 执行sql语句  得到一条结果
	 * @param string $sql
	 * @return mixed
	 */
	public static function getRow($sql=null){
        if(isset($fileName)){
            $res = self::readCach($fileName,$overTime,$fileDir);
            if($res){return $res;}
        }
        self::connect();
		if($sql!=null){
			self::query($sql);
		}
		$result=self::$PDOStatement->fetch(constant("PDO::FETCH_ASSOC"));
                if(isset($fileName))self::addFindCach($result, $fileName);
		return $result;
	}
	/**
	 * 根据id查找
	 * @param string $tabName
	 * @param int $priId
	 * @param string $fields
	 * @return mixed
	 */
	public static function findById($tabName,$priId,$fields='*',$fileName=null,$overTime=3600,$fileDir='cach/'){           
            $sql='SELECT %s FROM %s WHERE id=%d';
            
            $sql = sprintf($sql,self::parseFields($fields),$tabName,$priId);
            if(isset($fileName)){
                $fileName = md5($sql);
                $res = self::readCach($fileName,$overTime,$fileDir);
                if($res){return $res;}
            }        
            $result = self::getRow($sql);
            if(isset($fileName))self::addFindCach($result, $fileName);
            return $result;
	}
	public static function findByUserName($tabName,$username,$fields='*',$fileName=null,$overTime=3600,$fileDir='cach/'){           
            $sql='SELECT %s FROM %s WHERE username=%d';       
            $sql = sprintf($sql,self::parseFields($fields),$tabName,$username);
            if(isset($fileName)){
                $fileName = md5($sql);
                $res = self::readCach($fileName,$overTime,$fileDir);
                if($res){return $res;}
            }        
            $result = self::getRow($sql);
            if(isset($fileName))self::addFindCach($result, $fileName);
            return $result;
	}
	 
	/**
	 * 基础查找
	 * @param unknown $tables 表名
	 * @param string $where 查找条件
	 * @param string $fields 查找范围，可以是数组也可以是字符串
	 * @param string $group 分组规则
	 * @param string $having 与group搭配的筛选条件
	 * @param string $order 排序规则
	 * @param string $limit 查找条数，可以是一个或两个参数
	 * @return Ambigous <unknown, unknown, multitype:>
	 */
	public static function find($tables,$where=null,$fields='*',$fileName=null,$overTime=10,$fileDir=null,$group=null,$having=null,$order=null,$limit=null){
             
	    $sql='SELECT '.self::parseFields($fields).' FROM '.$tables
		.self::parseWhere($where)
		.self::parseGroup($group)
		.self::parseHaving($having)
		.self::parseOrder($order)
		.self::parseLimit($limit);
            
                $fileDir=isset($fileDir)?$fileDir:self::$iniCachDir;
                if(isset($fileName)){
                    $fileName = md5($sql);
                    $res = self::readCach($fileName,$overTime,$fileDir);
                    if($res){return $res;}
                }	   
		$dataAll=self::getAll($sql);
		if(isset($fileName))self::addFindCach($dataAll, $fileName);
		return count($dataAll)==1?$dataAll[0]:$dataAll;
	}
	
	/**
	 * 添加数据
	 * @param array $data
	 * @param string $table
	 * @return Ambigous <boolean, unknown, number>
	 */
	public static function add($data,$table){
		$keys=array_keys($data);
		array_walk($keys,array('mysql','addSpecialChar'));
		$fieldsStr=join(',',$keys);
		$values="'".join("','",array_values($data))."'";
		$sql="INSERT {$table}({$fieldsStr}) VALUES({$values})";
		return self::execute($sql);
	} 
	
	/**
	 * 更新数据
	 * @param array $data
	 * @param string $table
	 * @param string $where
	 * @param string $order
	 * @param string $limit
	 * @return Ambigous <boolean, unknown, number>
	 */
	public static function update($data,$table,$where=null,$order=null,$limit=0){
                $sets = '';
		foreach($data as $key=>$val){
			$sets.=$key."='".$val."',";
		}
		$sets=rtrim($sets,',');
		$sql="UPDATE {$table} SET {$sets} ".self::parseWhere($where).self::parseOrder($order).self::parseLimit($limit);
		
		return self::execute($sql);
	}
	/**
	 * 删除数据
	 * @param string $table
	 * @param string $where
	 * @param string $order
	 * @param number $limit
	 * @return Ambigous <boolean, unknown, number>
	 */
	public static function delete($table,$where=null,$order=null,$limit=0){
            self::connect();
		$sql="DELETE FROM {$table} ".self::parseWhere($where).self::parseOrder($order).self::parseLimit($limit);
		return self::execute($sql);
	}
	/**
	 * 获取上次执行的sql
	 * @return boolean|Ambigous <string, string>
	 */
	public static function getLastSql(){
		$link=self::$link;
		if(!$link)return false;
		return self::$queryStr;
	}
	/**
	 * 获得上一次插入数据的id
	 * @return boolean|string
	 */
	public static function getLastInsertId(){
		$link=self::$link;
		if(!$link)return false;
		return self::$lastInsertId;
	}
	/**
	 * 获取数据库版本
	 * @return boolean|mixed
	 */
	public static function getDbVerion(){
		$link=self::$link;
		if(!$link)return false;
		return self::$dbVersion;
	}
	/**
	 * 获取所有表
	 * @return multitype:mixed 
	 */
	public static function showTables(){
		$tables=array();
		if(self::query("SHOW TABLES")){
			$result=self::getAll();
			foreach($result as $key=>$val){
				$tables[$key]=current($val);
			}
		}
		return $tables;
	}
	/**
	 * 格式化筛选条件，防止注入，如果有多个条件以and分开
	 * @param unknown $where
	 * @return string
	 */
	public static function parseWhere($where){
		$whereStr='';
		if(is_string($where)&&!empty($where)){
			$whereStr=$where;
		}
		return empty($whereStr)?'':' WHERE '.$whereStr;
	}
	/**
	 * 格式化分组条件可以是数组或者字符串
	 * @param unknown $group
	 * @return string
	 */
	public static function parseGroup($group){
		$groupStr='';
		if(is_array($group)){
			$groupStr.=' GROUP BY '.implode(',',$group);
		}elseif(is_string($group)&&!empty($group)){
			$groupStr.=' GROUP BY '.$group;
		}
		return empty($groupStr)?'':$groupStr;
	}
	/**
	 * 格式化having条件，只能是字符串
	 * @param unknown $having
	 * @return string
	 */
	public static function parseHaving($having){
		$havingStr='';
		if(is_string($having)&&!empty($having)){
			$havingStr.=' HAVING '.$having;
		}
		return $havingStr;
	}
	/**
	 * 格式化排序方式 
	 * @param string $order desc|asc
	 * @return string
	 */
	public static function parseOrder($order){
		$orderStr='';
		if(is_array($order)){
			$orderStr.=' ORDER BY '.join(',',$order);
		}elseif(is_string($order)&&!empty($order)){
			$orderStr.=' ORDER BY '.$order;
		}
		return $orderStr;
	}
	/**
	 * 格式化查找数量，可以是数组或者字符串
	 * limit 3
	 * limit 0,3
	 * @param unknown $limit
	 * @return unknown
	 */
	public static function parseLimit($limit){
		$limitStr='';
		if(is_array($limit)){
			if(count($limit)>1){
				$limitStr.=' LIMIT '.$limit[0].','.$limit[1];
			}else{
				$limitStr.=' LIMIT '.$limit[0];
			}
		}elseif(is_string($limit)&&!empty($limit)){
			$limitStr.=' LIMIT '.$limit;
		}
		return $limitStr;
	}
	/**
	 * 格式化查找范围，默认是* 可以是数组或者字符串
	 * @param unknown $fields
	 * @return string
	 */
	public static function parseFields($fields){
		if(is_array($fields)){
			array_walk($fields,array('mysql','addSpecialChar'));
			$fieldsStr=implode(',',$fields);
		}elseif(is_string($fields)&&!empty($fields)){
			if(strpos($fields,'`')===false){
				$fields=explode(',',$fields);
				array_walk($fields,array('mysql','addSpecialChar'));
				$fieldsStr=implode(',',$fields);
			}else{
				$fieldsStr=$fields;
			}
		}else{
			$fieldsStr='*';
		}
		return $fieldsStr;
	}
	/**
	 * 对数值添加`符号
	 * @param unknown $value
	 * @return string
	 */
	public static function addSpecialChar(&$value){
		if($value==='*'||strpos($value,'.')!==false||strpos($value,'`')!==false){
			
		}elseif(strpos($value,'`')===false){
			$value='`'.trim($value).'`';
		}
		return $value;
	}
	/**
	 * 增删改
	 * @param string $sql
	 * @return boolean|unknown
	 */
	public static function execute($sql=null){
        self::connect();
		$link=self::$link;
		if(!$link) return false;
		self::$queryStr=$sql;
		if(!empty(self::$PDOStatement))self::free();
		$result=$link->exec(self::$queryStr);
		self::haveErrorThrowException();
		if($result){
			self::$lastInsertId=$link->lastInsertId();
			self::$numRows=$result;
			return self::$numRows;
		}else{
			return false;
		}
	}
	
	/**
	 * 缓存查询操作的结果
	 * @param $rows 查询结果集
	 * @param $name 文件名
	 * @param $dir 缓存目录，默认为cach/
	 * @return boolean
	 */
	public static function addFindCach($rows,$name,$dir=null){	
            $dir = isset($dir)?$dir:self::$iniCachDir;
	    if (!file_exists($dir)){
	        mkdir ($dir);
	    }
	    try {
            $msg = serialize($rows);   
            $fp = fopen($dir.$name,"w");   
            fputs($fp,$msg);   
            fclose($fp);
	    }catch (Exception $e){
	        return false;
	    }
	    return true;
	}
	/**
	 * 读取缓存文件
	 * @param string $name 检查的文件名
	 * @return boolean|array 如果检查文件名存在且未过期，返回数组，如果不存在或者过期了，返回false
	 */
	public static function readCach($name,$overTime=3600,$dir=null){      
            $dir = isset($dir)?$dir:self::$iniCachDir;            
	    if(!self::checkCach($name,$overTime,$dir)){
	        return false;
	    }            
	    $msg = file_get_contents($dir.$name);
            echo '读取缓存了';
	    $result = unserialize($msg);	   
	    return $result;
	}
	/**
	 * 检测缓存文件是否存在或者过期
	 * @param $name 缓存文件名
	 * @param $overTime 文件过期时间
	 * @param $dir 缓存路径
	 * @return boolean
	 */
	public static function checkCach($name,$overTime=3600,$dir=null){	    
	    $dir = isset($dir)?$dir:self::$iniCachDir;   
	    if(file_exists($dir.$name)){               
	        $mtime=filemtime($dir.$name);
	        if((time()-$mtime)<$overTime){
                    echo '没有超时'.$overTime;
                    return true;
                }
	    }
	    return false;	    
	}
	/**
	 * 清除缓存目录和文件
	 * @param $dirName缓存目录
	 * @return string 
	 */
	public static function clearCach($dirName=null){
            $dir = isset($dir)?$dir:self::$iniCachDir;
            if(is_dir($dirName)){ 
            if ($handle=opendir($dirName)) {      
                while ( false !== ( $item = readdir( $handle ) ) ) {      
                    if ( $item != "." && $item != ".." ) {      
                        if ( is_dir( "$dirName/$item" ) ) {      
                            del_DirAndFile( "$dirName/$item" );      
                        } else {      
                            if( unlink( "$dirName/$item" ) )echo "已删除文件: $dirName/$item<br /> ";      
                        }     
                    }      
                }     
                closedir($handle);                  
            }   
        }
            return '清除缓存成功';
	}
		
	/**
	释放数据库连接
	 */
	public static function free(){
		self::$PDOStatement=null;
	}
	public static function query($sql=''){
		$link=self::$link;
		if(!$link) return false;	
		if(!empty(self::$PDOStatement))self::free();
		self::$queryStr=$sql;
		self::$PDOStatement=$link->prepare(self::$queryStr);
		$res=self::$PDOStatement->execute();

		self::haveErrorThrowException();
		return $res;
	}
	/**
	 * 自定义异常
	 */
	public static function haveErrorThrowException(){
		$obj=empty(self::$PDOStatement)?self::$link: self::$PDOStatement;
		$arrError=$obj->errorInfo();
		//print_r($arrError);
		if($arrError[0]!='00000'){
			self::$error='SQLSTATE: '.$arrError[0].' <br/>SQL Error: '.$arrError[2].'<br/>Error SQL:'.self::$queryStr;
			self::throw_exception(self::$error);
			return false;
		}
		if(self::$queryStr==''){
			self::throw_exception('语句为空');
			return false;
		}
	}
	/**
	 * 定义抛出异常的样式
	 * @param unknown $errMsg
	 */
	public static function throw_exception($errMsg){
		echo '<div style="width:80%;background-color:#ABCDEF;color:black;font-size:20px;padding:20px 0px;">
				'.$errMsg.'
		</div>';
	}
	/**
	 * 关闭连接
	 */
	public static function close(){
		self::$link=null;
	}
	
}

//$PdoMySQL=new PdoMySQL;
//测试通过id查找
//var_dump($PdoMySQL->findById('user','1','*','byid.txt'));
//var_dump($PdoMySQL);

//获取sql语句所有结果
//$sql='SELECT * FROM user';
//print_r($PdoMySQL->getAll($sql,'testGetAll'));

//测试基础查找方法
// $sql='SELECT * FROM user';
// $PdoMySQL->addFindCach($PdoMySQL->find('user'), 'text.txt');

//测试插入
// $sql='INSERT user(username,password,email,token,token_exptime,regtime)';
// $sql.=" VALUES('imooc1113','imooc1113','imooc1113@imooc.com','abcdefgh','1392348346','12313346')";
// var_dump($PdoMySQL->execute($sql));

//测试删除
// $sql='DELETE FROM user WHERE id<=3';
// var_dump($PdoMySQL->execute($sql));

//测试更新数据
// $sql='UPDATE user SET username="king1234" WHERE id=4';
// var_dump($PdoMySQL->execute($sql));

// $data=array(
// 	 'username'=>'imooc111',
// 	 'password'=>'imooc222',
// 	 'email'=>'imooc333@imooc.com',
// 	 'token'=>'4444',
// 	 'token_exptime'=>'1234444',
// 	 'regtime'=>'12345678'
// );
//var_dump($PdoMySQL->update($data,'user','id<=38',' id DESC','2'));

// 两种设置查找参数方法，字符串和数组
// $tabName='user';
// $priId='4';
 //$fields='username,email';
// $fields=array('username','email','regtime');
// print_r($PdoMySQL->findById($tabName,$priId,$fields,'testById2'));

//print_r($PdoMySQL->findById($tabName, $priId));
//print_r($PdoMySQL->find($tables));
//print_r($PdoMySQL->find($tables,'id>=30'));
// print_r($PdoMySQL->find($tables,'id>=30','username,email'));
//print_r($PdoMySQL->find($tables,'id<=10','*','status'));
//print_r($PdoMySQL->find($tables,'id<=10','*','status','count(*)>=6'));
//print_r($PdoMySQL->find($tables,'id>5','*',null,null,'username desc,id desc'));
//print_r($PdoMySQL->find($tables,null,'*',null,null,null,array(3,5)));

//设置添加数据参数
// $data= array(
// 	 'username'=>'imooc',
// 	 'password'=>'imooc',
// 	 'email'=>'imooc@imooc.com',
// 	 'token'=>'123abc',
// 	 'token_exptime'=>'123123',
// 	 'regtime'=>'123456'
// 	 );
// var_dump($PdoMySQL->add($data,$tables));






