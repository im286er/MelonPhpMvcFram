<?php
	require_once 'libs/function/upload.func.php';
	require_once 'libs/function/image.func.php';
	class adminController{

		public $auth;

		public function __construct(){
			session_start();
			if(!(isset($_SESSION['auth']))&&(PC::$method!='login')){
				$this->showmessage('请登录后在操作！', 'admin.php?controller=admin&method=login');
			}else{
				$this->auth = isset($_SESSION['auth'])?$_SESSION['auth']:array();
			}
		}

		public function index(){
		    /*
			$newsobj = M('news');
			$newsnum = $newsobj->count();
			VIEW::assign(array('newsnum'=>$newsnum));
			VIEW::display('admin/blog-list.html');
		    */
		    $this->newslist();
		}
		public function login(){
			if(!isset($_POST['submit'])){
				VIEW::display('admin/login.html');
			}else{

				$this->checklogin();
			}
		}

        //退出登录
		public function logout(){
			unset($_SESSION['auth']);
				$this->showmessage('退出成功！', 'admin.php?controller=admin&method=login');
		}

		//添加新闻
		public function newsadd(){
			if(!isset($_POST['submit'])){
				$data = $this->getnewsinfo();
				VIEW::assign(array('data'=>$data));
				VIEW::display('admin/newsadd.html');
			}else{
				$this->newssubmit();
			}
		}

		//新闻列表
		public function newslist(){
		    $size=2;
            $curPage = isset($_GET['page'])?$_GET['page']:1;
			$data = $this->getnewslist($curPage,$size);
			$pageList = $this->getPageList("newsList","news",$curPage,$size);
			VIEW::assign(array('data'=>$data));
            VIEW::assign(array('page'=>$pageList));
			VIEW::display('admin/newslist.html');
		}

		//删除新闻
		public function newsdel(){
			if($_GET['id']){
				$this->delnews();
				$this->showmessage('删除新闻成功！', 'admin.php?controller=admin&method=newslist');
			}
		}

		//检查登录情况
		private function checklogin(){
			if(empty($_POST['username'])||empty($_POST['password'])){
				$this->showmessage('登录失败！', 'admin.php?controller=admin&method=login');
			}
			$username = daddslashes($_POST['username']);
			$password = daddslashes($_POST['password']);
			$authobj = M('auth');
			$auth = $authobj->checkauth($username, $password);
			
			if($auth){
				$_SESSION['auth'] = $auth;
				$this->showmessage('登录成功！', 'admin.php?controller=admin&method=index');
			}else{
				$this->showmessage('登录失败！', 'admin.php?controller=admin&method=login');
			}
		}

        //获得新闻详情
		private function getnewsinfo(){
			if(isset($_GET['id'])){
				$id = intval($_GET['id']);
				$newsobj = M('news');
				return $newsobj->findOne_by_id($id);
			}else{
				return array();
			}

		}

		//获得新闻列表
		private function getnewslist($curPage,$size){
			$newsobj = M('news');
			return $newsobj->findAll_orderby_dateline($curPage,$size);
		}

		//删除新闻
		private function delnews(){
			$newsobj = M('news');
			return $newsobj->del_by_id($_GET['id']);
		}

        //提交新闻
		private function newssubmit(){
			extract($_POST);				
			if(empty($title)||empty($editorValue)){
				$this->showmessage('请把新闻标题、内容填写完整再提交！', 'admin.php?controller=admin&method=newsadd');
			}
			$title = daddslashes($title);
			$content = daddslashes($editorValue);
			$author = daddslashes($author);
			$from = daddslashes($url);
			$newsobj = M('news');
			$data = array(
				'title'=>$title,
				'content'=>$content,
				'author'=>$author,
				'url'=>$from
			);
			if($_POST['id']!=''){
				$newsobj ->update($data, intval($_POST['id']));
				$this->showmessage('修改成功！', 'admin.php?controller=admin&method=newslist');
			}else{
				$newsobj ->insert($data);
				$this->showmessage('添加成功！', 'admin.php?controller=admin&method=newslist');
			}
		}

		//展示轮播分类页
		public function sliderClassAddPage(){
			if(isset($_GET['id'])&&isset($_GET['title'])){
				$data = array(
					'title'=>$_GET['title'],
					'id'=>$_GET['id']
				);
				VIEW::assign(array('data'=>$data));		
			}
			VIEW::display('admin/sliderClassAdd.html');
		}

		//新增轮播分类
		public function sliderClassAdd(){
			if(isset($_POST)){
				extract($_POST);
				$sliderObj = M('slider');
				$data = array(
					'class_name'=>$title
				);
				if($id!=''){					
					$sliderObj->updateParent($data,$id);
					$this->showmessage('修改成功！', 'admin.php?controller=admin&method=sliderClassList');
				}else{
					$sliderObj->insertParent($data);
					$this->showmessage('添加成功！', 'admin.php?controller=admin&method=sliderClassList');
				}
			}
		}

		//轮播分类列表
		public function sliderClassList(){
			$data = $this->getSliderClassList();
			VIEW::assign(array('data'=>$data));
			VIEW::display('admin/sliderlist.html');
		}

		//分类轮播内图片列表
		public function sliderImgList(){
			$data = $this->getSliderImgList();
			$id = $_GET['id'];
			VIEW::assign(array('data'=>$data));
			VIEW::assign(array('classId'=>$id));
			VIEW::display('admin/sliderImgList.html');
		}

		//删除轮播分类
		public function delSliderClass(){
			if($_GET['id']){
				$newsobj = M('news');
				if($newsobj->del_by_id($_GET['id'])){
					$this->showmessage('删除新闻成功！', 'admin.php?controller=admin&method=newslist');
				}else{
					$this->showmessage('删除新闻失败！', 'admin.php?controller=admin&method=newslist');
				}
				
			}
		}

		private function getSliderClass(){
			if(isset($_GET['id'])){
				$id = intval($_GET['id']);
				$newsobj = M('news');
				return $newsobj->findOne_by_id($id);
			}else{
				return array();
			}
		}

		//得到轮播图列表
		private function getSliderImgList(){
			if(isset($_GET['id'])){
				$id = intval($_GET['id']);
				$newsobj = M('slider');
				return $newsobj->getSliderImgList($id);
			}else{
				return array();
			}
		}

		//得到轮播分类列表
		private function getSliderClassList(){
			$sliderClassObj = M('slider');
			return $sliderClassObj->findAllSlider();
		}

		//删除轮播图
		public function sliderImgDel(){

			if($_GET['id']&&$_GET['name']){
				$this->delSliImg();
				$flag = $this->delDoc('uploads/'.$_GET['name']);
				$this->showmessage('删除轮播图！', 'admin.php?controller=admin&method=sliderImgList&id='.$_GET['classId']);
			}else{
				$this->showmessage('删除失败！', 'admin.php?controller=admin&method=sliderClassList');
			}
		}

		//删除轮播图片
		private function delSliImg(){
			$newsobj = M('slider');
			return $newsobj->delChildById($_GET['id']);
		}

		//删除文件
		private function delDoc($file){		
			$result = @unlink ($file); 
			if ($result == false) { 
				return true; 
			} else { 
				return false;
			} 
		}

		private function sliderClassSubmit(){
			extract($_POST);				
			if(empty($title)||empty($content)){
				$this->showmessage('请把新闻标题、内容填写完整再提交！', 'admin.php?controller=admin&method=newsadd');
			}
			$title = daddslashes($title);
			$content = daddslashes($content);
			$author = daddslashes($author);
			$from = daddslashes($url);
			$newsobj = M('news');
			$data = array(
				'title'=>$title,
				'content'=>$content,
				'author'=>$author,
				'url'=>$from
			);
			if($_POST['id']!=''){
				$newsobj ->update($data, intval($_POST['id']));
				$this->showmessage('修改成功！', 'admin.php?controller=admin&method=newslist');
			}else{
				$newsobj ->insert($data);
				$this->showmessage('添加成功！', 'admin.php?controller=admin&method=newslist');
			}
		}

		//新增轮播图片
		public function addSliderImg(){
			$arr=$_POST;
			//$arr['pubTime']=time();
			$path="uploads";
			$classPath = 'image/';
			$uploadFiles=uploadFile($path);
			if(is_array($uploadFiles)&&$uploadFiles){
				foreach($uploadFiles as $key=>$uploadFile){
					thumb($path."/".$uploadFile['name'],$classPath."image_50/".$uploadFile['name'],50,50);
					thumb($path."/".$uploadFile['name'],$classPath."image_220/".$uploadFile['name'],220,220);
					thumb($path."/".$uploadFile['name'],$classPath."image_350/".$uploadFile['name'],350,350);
					thumb($path."/".$uploadFile['name'],$classPath."image_800/".$uploadFile['name'],800,800);
				}
				$sliderObj = M('slider');
				$i=0;
				foreach ($arr['text'] as $key => $item) {
					$arr = array(
						'text' => $item,
                        'position' => $arr['position'][$i],
						'name' => $uploadFiles[$i]['name'],
						'classId' => $_POST['classId']
					);
					$sliderObj->insertChild($arr);
					$i++;
				}

				$this->showmessage('添加成功！', 'admin.php?controller=admin&method=sliderClassList');
			
			
			}else{
				foreach($uploadFiles as $uploadFile){
					if(file_exists($classPath."image_800/".$uploadFile['name'])){
						unlink($classPath."image_800/".$uploadFile['name']);
					}
					if(file_exists($classPath."image_50/".$uploadFile['name'])){
						unlink($classPath."image_50/".$uploadFile['name']);
					}
					if(file_exists($classPath."image_220/".$uploadFile['name'])){
						unlink($classPath."image_220/".$uploadFile['name']);
					}
					if(file_exists($classPath."image_350/".$uploadFile['name'])){
						unlink($classPath."image_350/".$uploadFile['name']);
					}
				}			
			}
			
		}

		//生成分页
        /**
         * @param $model 模型名称
         * @param $curNum 当前页数
         * @param int $numSize 每页显示数量
         * @param string $where 筛选条件
         */
        public function getPageList($funcName,$model, $curNum=1, $numSize=2, $where=""){
            $obj = M($model);
            $sum =  ceil($obj->count()/$numSize);
            $pageList = array();
            for ($i=1;$i<=$sum;$i++){
                if($i==$curNum){
                    array_push($pageList,'<span>'.$i.'</span>');
                }else{
                    array_push($pageList,'<a href="admin.php?controller=admin&method='.$funcName.'&page='.$i.'&'.$where.'">'.$i.'</a>');
                }
            }
            return $pageList;
        }
		private function showmessage($info, $url){
			echo "<script>alert('$info');window.location.href='$url'</script>";
			exit;
		}
	}
?>