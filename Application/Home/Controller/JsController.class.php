<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class JsController extends HomeController {
    public function index(){
	    

        $qrcode_width = intval($_GET['qw']);
        $qrcode_height = intval($_GET['qh']);
        $qrcode_type = trim($_GET['qt']);
        $qrcode_content = trim($_GET['qc']);
        $qrcode_logo = trim($_GET['ql']);

        
        $hash =  md5($qrcode_content.$qrcode_width.$qrcode_height.$qrcode_type.$qrcode_logo);

        $map = array(
            'hash'=>$hash,
        );
        $one = D('qrcode')->field('file_path')->where($map)->find();
        if($one)
        {
            $qrcode_file = $one['file_path'];
        }else
        {
            $file_dir = 'Uploads/'.date('Y').'/'.date('m').'/'.date('d');
            mkdirs($file_dir);
            $qrcode_file = $file_dir.'/'.$hash.'.png';
        }
        
        
        //$qrcode_content = htmlspecialchars_decode($qrcode_content);

        if(!$one)//新生成 
        {
            qrcode($qrcode_file,$qrcode_content,$qrcode_logo,$qrcode_width,$qrcode_height,$qrcode_type);

            //保存到数据库
            $data = array(
                'hash'=>$hash,
                'width'=>$qrcode_width,
                'height'=>$qrcode_height,
                'logo'=>$qrcode_logo,
                'content'=>$qrcode_content,
                'file_path'=>$qrcode_file,
                'dateline'=>time(),
            );
            D('qrcode')->add($data);
        }


        $qrcode_url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$qrcode_file;
        //qrcode 
        $qrcode_href = 'http://'.$_SERVER['HTTP_HOST'].'/qr.html?hash='.$hash;
        
        $this->assign('qrcode_width',$qrcode_width);
        $this->assign('qrcode_height',$qrcode_height);
        $this->assign('qrcode_url',$qrcode_url);
        $this->assign('qrcode_href',$qrcode_href);
        $this->display();
    }
    
    
}