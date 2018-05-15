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
    elseif ($type == 'excel')
        $result = excelUp($rootpath, $savepath, $size);
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

/**
 * @param $rootpath
 * @param $savepath
 * @param int $size
 * @return array
 * 视频上传
 */
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

/**
 * 导入excel文件
 * @param  string $file excel文件路径
 * @return array        excel文件内容数组
 */
function import_excel($file){
    // 判断文件是什么格式
    $type = pathinfo($file);
    $type = strtolower($type["extension"]);
    if($type === 'xls'){
        $type = 'Excel5';
    }elseif ($type === 'csv'){
        $type = 'csv';
    }elseif ($type === 'xlsx'){
        $type = 'Excel2007';
    }
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    // 判断使用哪种格式
    $objReader = PHPExcel_IOFactory::createReader($type);
    $objPHPExcel = $objReader->load($file);
    $sheet = $objPHPExcel->getSheet(0);
    // 取得总行数
    $highestRow = $sheet->getHighestRow();
    // 取得总列数
    $highestColumn = $sheet->getHighestColumn();
    //循环读取excel文件,读取一条,插入一条
    $data=array();
    //从第一行开始读取数据
    for($j=1;$j<=$highestRow;$j++){
        $data[$j]['title']=$objPHPExcel->getActiveSheet()->getCell("A$j")->getValue();
        $data[$j]['A']=$objPHPExcel->getActiveSheet()->getCell("B$j")->getValue();
        $data[$j]['B']=$objPHPExcel->getActiveSheet()->getCell("C$j")->getValue();
        $data[$j]['C']=$objPHPExcel->getActiveSheet()->getCell("D$j")->getValue();
        $data[$j]['D']=$objPHPExcel->getActiveSheet()->getCell("E$j")->getValue();
        $data[$j]['answer']=$objPHPExcel->getActiveSheet()->getCell("F$j")->getValue();
        $data[$j]['keywords']=$objPHPExcel->getActiveSheet()->getCell("G$j")->getValue();
    }
    array_splice($data,0,1);
    return $data;
}

/**
 * @param $rootpath
 * @param $savepath
 * @param int $size
 * @return array
 * 上传excel
 */
function excelUp($rootpath, $savepath, $size=5242880)
{
    $sub_name = array('date', 'Y/m-d');

    $config = array(
        "rootPath" => './Upload/'.$rootpath.'/',
        "savePath" => $savepath.'/',
        "maxSize" =>  $size, // 单位B,5MB
        'saveName' => array('uniqid',''),//命名规则，不重复
        "exts" => explode(",", 'xls,xlsx,csv'),//类型，图片格式
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
            $relative_path = '..'.__ROOT__.$root.$v['rootPath'].$v['savepath'].$v['savename'];//图片绝对地址,/Upload/shop/brand/2016/10-29/58144dd75b852.jpg
        }
        $result['code'] = true;
        $result['fileinfo'] = $relative_path;
    }

    return $result;
}

/**
 * @param $arr
 * @return mixed
 * 取出二维数组重复值
 */
function array_unique_fd($arr)
{
    $temp = array();
    foreach($arr as $k => $v){
        if(in_array_case($v['id'], $temp)){
            unset($arr[$k]);
        }else{
            $temp[] = $v['id'];
        }
    }
    array_values($arr);

    return $arr;
}