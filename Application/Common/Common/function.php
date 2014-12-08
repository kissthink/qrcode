<?php
/*
qrcode_content  内容
qrcode_logo logo   可以是网络图片
qrcode_type  类型
*/
function qrcode($qrcode_file,$qrcode_content,$qrcode_logo='',$qrcode_width=100,$qrcode_height=100,$qrcode_type='auto')
{

    import('@.Org.QRcode');//import 为Thinkphp内置，使用其它框架请换成： include_once  
    $qrcode_path = SITE_DIR.$qrcode_file;

        $size = round($qrcode_width/25);//QRcode size计算
        if($size<=0) $size =1;
        if(!$qrcode_type or $qrcode_type = 'auto')
        {
            
            if(is_url($qrcode_content))
            {
                $qrcode_type = 'url';
            }else if(is_mobile($qrcode_content) or is_tel($qrcode_content))
            {
                $qrcode_type = 'tel';
            }else
            {
                $qrcode_type = 'text';
            }
            
        }
        if(!in_array($qrcode_type,array('url','tel','text'))) 
            $qrcode_type = 'text';

        if($qrcode_type=='url')
        {
            $qrcode_content = htmlspecialchars_decode($qrcode_content);
            \QRcode::png($qrcode_content, $qrcode_path, 'L',$size, 2);//'url:'. //加上后 微信中不能打开
        }else if($qrcode_type=='tel')
        {
            \QRcode::png($qrcode_content, $qrcode_path, 'L',$size, 2);//'tel:'.
        }else// if($qrcode_type=='text')
        {
            \QRcode::png($qrcode_content, $qrcode_path, 'L',$size, 2);
        }
        if($qrcode_logo)
        {
            //$qrcode_logo  处理网络图片

            $logo = file_get_contents($qrcode_logo);//SITE_DIR.'Uploads/logo.png';//准备好的logo图片
            if ($logo !== FALSE) { 
                 $QR = imagecreatefromstring(file_get_contents($qrcode_path)); 
                 $logo = imagecreatefromstring($logo); 
                 $QR_width = $qrcode_width;//imagesx($QR);//二维码图片宽度 
                 $QR_height = $qrcode_height;//imagesy($QR);//二维码图片高度 
                 $logo_width = imagesx($logo);//logo图片宽度 
                 $logo_height = imagesy($logo);//logo图片高度 
                 $logo_qr_width = $QR_width / 5; 
                 $scale = $logo_width/$logo_qr_width; 
                 $logo_qr_height = $logo_height/$scale; 
                 $from_width = ($QR_width - $logo_qr_width) / 2; 
                 //重新组合图片并调整大小 
                 imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, 
                 $logo_qr_height, $logo_width, $logo_height); 
            } 
            //输出图片 
            imagepng($QR, $qrcode_path);
        }
    return true;

}


//创建多级目录
function mkdirs($dirname, $ismkindex=1) {
    $mkdir = false;
    
    if(is_dir($dirname))
        return true;

    $arr = explode('/',$dirname);
    $dirname= '';
    foreach($arr as $val)
    {
        $dirname .=  $dot .$val;
        $dot= '/';
        if(!is_dir($dirname)) {
            if(@mkdir($dirname, 0777)) {
                if($ismkindex) {
                    @fclose(@fopen($dirname.'/index.html', 'w'));
                }
                $mkdir = true;
            }
        } else {
            $mkdir = true;
        }
    }

    return $mkdir;
}


/*
* 网址检测
*/
function is_url($str)
{
    $chars = "/(http[s]?|ftp):\/\/[^\/\.]+?\..+\w?$/i";
    if (strpos($str, '.') !== false)
    {
        if (preg_match($chars, $str))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
/** 不含 86
 * 电话手机号码
 * 13 - 123456789 开头
 * 15 - 1235689
 * 18 - 015689
 */ 
function is_mobile($str)     
{     
    if(strlen($str) == 11) 
    {
        return preg_match("/13[123456789]{1}\d{8}|15[01235689]{1}\d{8}|18[015689]{1}\d{8}/",$str); 
    }
    return false;     
}  
/*固定电话
可为0451-12345678 045112345678 04511234567
*/
function is_tel($str)
{
    return preg_match("/^(0?(([1-9]\d)|([3-9]\d{2}))-?)?\d{7,8}$/",$str); 
}


/*邮箱地址*/
function is_email($str)
{

    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($str, '@') !== false && strpos($str, '.') !== false)
    {
        if (preg_match($chars, $str))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
