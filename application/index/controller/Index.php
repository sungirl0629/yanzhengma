<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function do_index()
    {


//        $file=request()->file('files');

//        $dir= ROOT_PATH."public/Uploads";
//        if(is_dir($dir)){
//            echo "已存在正在上传文件...";
//            $files=$file->move($dir);
//        }else{
//            mkdir($dir);
//            $files=$file->move($dir);
//        }
        $data = input('post.');
        $code = $data['code'];
        unset($data['code']);

        if (captcha_check($code)) {
            $info=db('member')->insert($data);
            if ($info) {
                $result = [
                    'msg' => '添加成功', 'status' => 1

                ];
                return json($result);
            } else {
                $result = [
                    'msg' => '添加失败', 'status' => 2
                ];
                return json($result);
            }
        } else {
            $result = [
                'msg' => '验证码错误', 'status' => 3
            ];
            return json($result);
        }
    }
    public function userlist()
    {

//        echo "<pre>";
//        print_r($info);exit;
        $page=input('get.page')?input('get.page'):1;
        $num=db('users')->count();
        $tiao=5;
        $pages=ceil($num/$tiao);
        if($page==$pages)
        {
            $xia=$page;
        }else{
            $xia=$page+1;
        }if($page==1) {
            $shang=$page;
    }else {
            $shang=$page-1;
    }
        $info=db('users')->page($page,$tiao)->select();
        $this->assign('page',$page);
        $this->assign('pages',$pages);
        $this->assign('shang',$shang);
        $this->assign('xia',$xia);
        $this->assign('info',$info);
        return $this->fetch('userlist');
    }

}
