<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class QrController extends HomeController {
    public function index(){
	    
        $hash = trim($_GET['hash']);
        $map = array(
            'hash'=>$hash,
        );
        $one = D('qrcode')->where($map)->find();
        $this->assign('one',$one);
        $this->display();
    }
    
    
}