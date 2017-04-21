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
}