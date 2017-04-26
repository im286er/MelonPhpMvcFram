<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/3
 * Time: 16:57
 */

class userController
{

    public $auth;

    public function __construct()
    {
        session_start();
        if (!(isset($_SESSION['auth'])) && (PC::$method != 'login')) {
            $this->showmessage('请登录后在操作！', 'admin.php?controller=admin&method=login');
        } else {
            $this->auth = isset($_SESSION['auth']) ? $_SESSION['auth'] : array();
        }
    }

    public function adminList(){
        //$size=2;
        //$curPage = isset($_GET['page'])?$_GET['page']:1;
        //$data = $this->getnewslist($curPage,$size);
        $data = $this->getAdminList();
        //$pageList = $this->getPageList("newsList","news",$curPage,$size);

        VIEW::assign(array('data'=>$data));
        //VIEW::assign(array('page'=>$pageList));
        VIEW::display('admin/adminList.html');
    }

    private function getAdminList(){
        $adminobj = M('user');
        return $adminobj->findAll();
    }

    public function adminDel(){
        $adminObj = M('user');
        if(isset($_GET['id'])){
            $flag = $adminObj->delById($_GET['id']);
            if($flag){
                $this->showmessage("删除成功","admin.php?controller=user&method=adminList");
            }else {
                $this->showmessage("删除失败", "admin.php?controller=user&method=adminList");
            }

        }
        $this->showmessage("参数错误", "admin.php?controller=user&method=adminList");

    }
    public function addAdminPage(){
        VIEW::display('admin/addAdmin.html');
    }

    public function addAdmin(){
        if(isset($_POST)){
            extract($_POST);
            $userObj = M('user');
            $data = array(
                'username'=>$title,
                'password'=>md5($password)
            );
            if($id!=''){
                $userObj->update($data,$id);
                $this->showmessage('修改成功！', 'admin.php?controller=user&method=adminList');
            }else{
                $userObj->insert($data);
                $this->showmessage('添加成功！', 'admin.php?controller=user&method=adminList');
            }
        }
    }
    public function editAdmin(){
        if(isset($_GET)){
            extract($_GET);


            $data = array(
                'username'=>$username,
                'id'=>$id
            );
            VIEW::assign(array('data'=>$data));
            VIEW::display('admin/addAdmin.html');
        }
    }


    private function showmessage($info, $url){
        echo "<script>alert('$info');window.location.href='$url'</script>";
        exit;
    }
}