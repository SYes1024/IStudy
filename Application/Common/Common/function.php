<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/2
 * Time: 14:23
 */

/**
 * @param $to
 * @param $title
 * @param $content
 * @return bool
 * 邮件发送函数
 */
function sendMail($to, $title, $content)
{
    Vendor('PHPMailer.PHPMailerAutoload');
    $mail = new PHPMailer(); //实例化
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
    $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
    $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to,"尊敬的客户");
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject = $title; //邮件主题
    $mail->Body = $content; //邮件内容
    $mail->AltBody = strip_tags($content); //邮件正文不支持HTML的备用显示
    return($mail->Send());
}

/**
 * @param $type
 * @param $rootpath
 * @param $savepath
 * @param int $size
 * @return mixed
 * 上传函数
 */
function upload($type, $rootpath, $savepath, $size=5242880)
{
    if($type == 'img')
        $result = imgUp($rootpath, $savepath, $size);
    elseif($type == 'video')
        $result = videoUp($rootpath, $savepath, $size);
    return $result;
}

/**
 * @param $rootpath
 * @param $savepath
 * @param int $size
 * @return mixed
 * 图片上传函数
 */
function imgUp($rootpath, $savepath, $size=5242880)
{
    $sub_name = array('date', 'Y/m-d');

    $config = array(
        "rootPath" => './Upload/'.$rootpath.'/',
        "savePath" => $savepath.'/',
        "maxSize" =>  $size, // 单位B,5MB
        'saveName' => array('uniqid',''),//命名规则，不重复
        "exts" => explode(",", 'gif,png,jpg,jpeg,bmp'),//类型，图片格式
        "subName" => $sub_name,//子文件夹保存规则
    );

    $root = $config['rootPath'];//上传根目录
    $root = str_replace('.','',$root);//去除前面的‘.’
    $website = UPLOAD_URL;//网站域名
    $http = "http://";//http协议
    $upload = new \Think\Upload($config);
    $info = $upload->upload();
    if(!$info) {// 上传错误提示错误信息
        $result['code'] = false;
        $result['fileinfo'] = $upload->getError();
    }else{  // 上传成功

        foreach($info as $k => $v){
            $image = new \Think\Image();
            $image->open("./".$root.$v['rootPath'].$v['savepath'].$v['savename']);
            $image->thumb(355, 265)->save("./".$root.$v['rootPath'].$v['savepath'].$v['savename']);//压缩或拉伸

            $return_result[$k]['absolute_path'] = $http.$website.__ROOT__.$root.$v['rootPath'].$v['savepath'].$v['savename'];//图片绝对地址，http://www.sy123.com/Upload/shop/brand/2016/10-29/58144dd75b852.jpg
            $return_result[$k]['Relative_path'] = __ROOT__.$root.$v['rootPath'].$v['savepath'].$v['savename'];//图片绝对地址,/Upload/shop/brand/2016/10-29/58144dd75b852.jpg
            $return_result[$k]['filename'] = $v['savename'];//文件保存名称
            $return_result[$k]['size'] = $v['size'];//文件大小
        }
        $result['code'] = true;
        $result['fileinfo'] = $return_result;
    }

    $upload_result = $result;

    if($upload_result['code']){
        foreach($upload_result['fileinfo'] as $k => $v){
            $initPrev[$k] = $v['Relative_path'];
            $initPreConf[$k] = array(
                'caption' => $v['filename'],
                'size' => $v['size'],
                'width' => '213px',
                'url' => __APP__.'/Home/Course/imgDel',
                'key' => $v['Relative_path']
            );
        }
        $return_data = array(
            'initialPreview' => $initPrev,
            'initialPreviewConfig' => $initPreConf,
            'append' => true,
        );
    }else{
        $return_data['state'] = false;
        $return_data['msg'] = $upload_result['fileinfo'];
    }
    return $return_data;
}

function del($fileName)
{
    $fileName2 = str_replace(__ROOT__.'/Upload','./Upload',$fileName);//地址:./Upload/...

    return unlink($fileName2);
}

/**
 * @param $arr
 * @return array
 * 将数组分组
 */
function groupArr($arr)
{
    for($i=0;$i<ceil(count($arr)/4);$i++)  //四个四个一组
        {
            $return[] = array_slice($arr, $i * 4 ,4);
        }
    return $return;
}

function videoUp($rootpath, $savepath, $size=52428800)
{
    $sub_name = array('date', 'Y/m-d');

    $config = array(
        "rootPath" => './Upload/'.$rootpath.'/',
        "savePath" => $savepath.'/',
        "maxSize" =>  $size, // 单位B,50MB
        'saveName' => array('uniqid',''),//命名规则，不重复
        "exts" => explode(",", 'mp4'),//类型，图片格式
        "subName" => $sub_name,//子文件夹保存规则
    );

    $root = $config['rootPath'];//上传根目录
    $root = str_replace('.','',$root);//去除前面的‘.’
    $website = UPLOAD_URL;//网站域名
    $http = "http://";//http协议
    $upload = new \Think\Upload($config);
    $info = $upload->upload();
    if(!$info) {// 上传错误提示错误信息
        $result['code'] = false;
        $result['fileinfo'] = $upload->getError();
    }else{  // 上传成功

        foreach($info as $k => $v){

            $return_result[$k]['absolute_path'] = $http.$website.__ROOT__.$root.$v['rootPath'].$v['savepath'].$v['savename'];//图片绝对地址，http://www.sy123.com/Upload/shop/brand/2016/10-29/58144dd75b852.jpg
            $return_result[$k]['Relative_path'] = __ROOT__.$root.$v['rootPath'].$v['savepath'].$v['savename'];//图片绝对地址,/Upload/shop/brand/2016/10-29/58144dd75b852.jpg
            $return_result[$k]['filename'] = $v['savename'];//文件保存名称
            $return_result[$k]['size'] = $v['size'];//文件大小
        }
        $result['code'] = true;
        $result['fileinfo'] = $return_result;
    }

    $upload_result = $result;

    if($upload_result['code']){
        foreach($upload_result['fileinfo'] as $k => $v){
            $initPrev[$k] = $v['Relative_path'];
            $initPreConf[$k] = array(
                'type'=>'video',
                'filetype'=>'video/mp4',
                'caption' => $v['filename'],
                'size' => $v['size'],
                'width' => '213px',
                'url' => __APP__.'/Home/Video/delete',
                'key' => $v['Relative_path']
            );
        }
        $return_data = array(
            'initialPreview' => $initPrev,
            'initialPreviewConfig' => $initPreConf,
            'append' => true,
        );
    }else{
        $return_data['state'] = false;
        $return_data['msg'] = $upload_result['fileinfo'];
    }
    return $return_data;
}