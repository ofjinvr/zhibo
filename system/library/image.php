<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 图像处理类
// +-----------------------

class Image{
    
    //强制使用透明 
    //如果需要把jpg格式的文件强制作为透明水印 可以使用这个模式
    //否则不要使用这个模式,水印本身支持GIF和PNG的原始透明度
    protected $transparent_use = false;
    
    //水印透明度设置 仅针对强制透明有效 透明度由低到高 0-100
    protected $transparent = 70;
    
    //水印位置
    //|-----------------|
    //|  1  |  2  |  3  |
    //|-----------------|
    //|  4  |  5  |  6  |
    //|-----------------|
    //|  7  |  8  |  9  |
    //|-----------------|
    protected $fixed = 9;
    
    //TTF文字相关配置
    protected $ttfpath = 'resource/fonts/msyh.ttf';
    protected $fontsize = 10;
    
    public function __construct() {
        if(!function_exists('imagecreate')){
            trigger_error('Image_manage初始化错误,缺少GD库支持!',E_USER_ERROR);
        }
    }
    
    /**
     * 设置属性
     * @param string $name 属性名称
     * @param mixed $value 属性值
     * @return boolean 赋值是否成功
     */
    public function set_attribute($name,$value){
        switch($name){
            case 'transparent_use':
                if(is_bool($value)){
                    $this->transparent_use = $value;
                    return true;
                }else{
                    trigger_error('属性'.$name.'的值有误,必须是布尔型数据');
                    return false;
                }
            case 'transparent':
                if(is_numeric($value) && false===strpos($value,'.') && $value>=0 && $value<=100){
                    $this->transparent = $value;
                    return true;
                }else{
                    trigger_error('属性'.$name.'的值有误,必须是0-100之间的整数');
                    return false;
                }
            case 'ttfpath':
                if(is_file($value)){
                    $this->transparent = $value;
                    return true;
                }else{
                    trigger_error('属性'.$name.'的值有误,找不到文件');
                    return false;
                }
            case 'fontsize':
                if(is_numeric($value) && false===strpos($value,'.') && $value>0){
                    $this->fontsize = $value;
                    return true;
                }else{
                    trigger_error('属性'.$name.'的值有误,必须是整数');
                    return false;
                }
            case 'fixed':
                if(is_numeric($value) && $value>=1 && $value<=9 && false===strpos($value,'.')){
                    $this->fixed = $value;
                    return true;
                }else{
                    trigger_error('属性'.$name.'的值有误,必须是在1-9之间的整数');
                    return false;
                }
            default :
                trigger_error('没有找到属性'.$name);
                return false;
        }
    }
    
    
    /**
     * 根据最长边限制压缩图片
     * @param src_image_file 原图的路径
     * @param int $max_border 最长边限制
     * @param output_filepath 输出图片路径 默认覆盖原图
     */
    public function compress($src_image_file,$max_border,$output_filepath=null){
        if(!is_string($src_image_file) || empty($src_image_file) || !is_numeric($max_border) || $max_border<=0){
            trigger_error('参数有误');
            return false;
        }
        //检测文件是否存在
        if(!is_file($src_image_file)){
            trigger_error('要处理的图像不存在');
            return false;
        }
        //检测图片信息
        $image_info = getimagesize($src_image_file);
        $mime = explode('/',$image_info['mime']);
        if($mime[0]!=='image'){
            trigger_error('文件类型错误');
            return false;
        }
        $src_width = $image_info[0];
        $src_height = $image_info[1];
        $max_border = intval($max_border);
        //对缩放的大小进行等比例计算
        $thumb_width = $src_width;
        $thumb_height = $src_height;
        $ratio = $thumb_height/$thumb_width;
        while($thumb_width>$max_border or $thumb_height>$max_border){
            $thumb_width-=1;
            $thumb_height-= $ratio;
        }
        $thumb_height = round($thumb_height);
        //缩放
        $create_srcimage = 'imagecreatefrom'.$mime[1];
        if(!is_callable($create_srcimage)){
            return false;
        }
        $src_image = $create_srcimage($src_image_file);
        $thumb_image = imagecreatetruecolor($thumb_width, $thumb_height);
        imagecopyresampled($thumb_image, $src_image,0,0,0,0,$thumb_width, $thumb_height, $src_width, $src_height);
        $output = 'image'.$mime[1];
        if(!is_callable($output)){
            return false;
        }
        if(empty($output_filepath)){
            $output_filepath=$src_image_file;
        }
        return $output($thumb_image,$output_filepath);
    }
  
    
    /**
     * @param string $src_image_file 原图的路径
     * @param int $width 缩略图的宽度
     * @param int $height 缩略图的高度
     * @param string $des_path 生成缩略图的存放目录
     * @param string $filename 文件名 为空则自动生成一个文件名
     */
    public function thumb($src_image_file,$width,$height,$thumb_dir=null,$filename=null){
        //检测参数是否合法
        if(!is_string($src_image_file) || !is_numeric($width) || !is_numeric($height)){
            trigger_error('参数有误');
            return false;
        }
        $width = intval($width);
        $height = intval($height);
        //检测文件是否存在
        if(!is_file($src_image_file)){
            trigger_error('要处理的图像不存在');
            return false;
        }
        //检测是否图像类型和大小
        $image_info = getimagesize($src_image_file);
        $mime = explode('/',$image_info['mime']);
        if($mime[0]!=='image'){
            trigger_error('文件类型错误');
            return false;
        }
        $src_width = $image_info[0];
        $src_height = $image_info[1];
        //根据图像类型创建画布
        $image_type = $mime[1];
        $create_callable  = 'imagecreatefrom'.$image_type;
        if(is_callable($create_callable)){
            //原图像画布
            $src_image = $create_callable($src_image_file);
            //生成图像画布
            $thumb_image = imagecreatetruecolor($width, $height);
            //背景色填充
            $background_color = imagecolorallocate($thumb_image,250,250,250);
            imagefill($thumb_image,0,0,$background_color);
        }else{
            trigger_error('无法创建图像资源');
            return false;
        }
        //对缩略图的大小进行等比例计算
        $thumb_width = $src_width;
        $thumb_height = $src_height;
        $ratio = $thumb_height/$thumb_width;
        while($thumb_width>$width or $thumb_height>$height){
            $thumb_width-=1;
            $thumb_height-= $ratio;
        }
        $thumb_height = round($thumb_height);
        //计算缩略图居中
        $padding_left = ($width-$thumb_width)/2;
        $padding_top  = ($height-$thumb_height)/2;
        //进行缩放
        imagecopyresampled($thumb_image, $src_image,$padding_left,$padding_top, 0, 0, $thumb_width, $thumb_height, $src_width, $src_height);
        //生成缩略图
        $thumb_callable = 'image'.$image_type;
        if(is_callable($thumb_callable)){
            if(is_null($thumb_dir)){
                $thumb_file = dirname($src_image_file).'/'.$this->get_thumb_filename($image_type);
            }else{
                if(!is_dir($thumb_dir)){
                    mkdir($thumb_dir,0666,true);
                }
                $thumb_dir = rtrim($thumb_dir,'/');
                if(!is_string($filename)){
                    do{
                        $thumb_file = $thumb_dir.'/'.$this->get_thumb_filename($image_type);
                    }while(is_file($thumb_dir));
                }else{
                    $thumb_file = $thumb_dir.'/'.$filename;
                }
            }
            $thumb_callable($thumb_image,$thumb_file);
            return $thumb_file;
        }else{
            trigger_error('无法生成图像');
            return false;
        }
        imagedestroy($src_image);
        imagedestroy($thumb_image);
    }
    
    
    /**
     * 给图片添加文字水印
     * @param string $image_file 原图片的路径
     * @param string $text 水印要添加的文字
     * @param int $fixed 水印添加的位置,默认左下
     */
    public function water_mark_text($image_file,$text,$fixed = null){
        //检测参数是否合法
        if(!is_string($image_file) || !is_string($text)){
            trigger_error('参数有误');
            return false;
        }
        //检测文件是否存在
        if(!is_file($image_file)){
            trigger_error('要处理的图像不存在');
            return false;
        }
        //文件类型检测
        $image_info = getimagesize($image_file);
        $mime = explode('/',$image_info['mime']);
        if($mime[0]!=='image'){
            trigger_error('文件类型错误');
            return false;
        }
        //检测水印位置是否设置,如未设置使用默认设置
        if($fixed === null){
            $fixed = $this->fixed;
        }
        //根据图像类型创建画布
        $image_type = $mime[1];
        $create_callable = 'imagecreatefrom'.$image_type;
        if(is_callable($create_callable)){
            $image = $create_callable($image_file);
            $image_color = imagecolorallocate($image, 255, 255, 255);
            $shadow_color = imagecolorallocate($image,33,33,33);
        }else{
            trigger_error('无法创建图像资源');
            return false;
        }
        
        //画布的宽度和高度
        $image_width = imagesx($image);
        $image_height = imagesy($image);
        //文字区域的宽度和高度
        $ttf_box = imagettfbbox($this->fontsize, 0, $this->ttfpath, $text);
        $ttf_width = $ttf_box[2]-$ttf_box[0];
        $ttf_height = $ttf_box[1]-$ttf_box[7];
        //根据配置计算文字书写的坐标位置
        $position = $this->get_position($ttf_width,$ttf_height,$image_width,$image_height,$fixed);
        //写文字
        imagettftext($image,$this->fontsize, 0, $position['x']+1,$position['y']+1, $shadow_color, $this->ttfpath, $text);
        imagettftext($image,$this->fontsize, 0, $position['x'],$position['y'], $image_color, $this->ttfpath, $text);
        
        $image_print = 'image'.$image_type;
        if(is_callable($image_print)){
            $image_print($image,$image_file);
        }else{
            trigger_error('无法生成图片');
            return false;
        }
        imagedestroy($image);
    }
    
    
    /**
     * 添加图片水印
     * @param string $image_file 要处理的图片路径
     * @param string $mark_image_file 水印图片路径
     * @param int $fixed 水印添加的位置,默认左下
     */
    public function water_mark_image($image_file,$mark_image_file,$fixed = null){
        //检测参数是否合法
        if(!is_string($image_file) || !is_string($mark_image_file)){
            trigger_error('参数有误');
            return false;
        }
        //检测文件是否存在
        if(!is_file($image_file)){
            trigger_error('要处理的图像不存在');
            return false;
        }
        //检测水印文件存在
        if(!is_file($mark_image_file)){
            trigger_error('水印图片不存在');
            return false;
        }
        //检测水印位置是否设置,如未设置使用默认设置
        if($fixed === null){
            $fixed = $this->fixed;
        }
        //文件类型检测
        $image_info = getimagesize($image_file);
        $mark_image_info = getimagesize($mark_image_file);
        $mime = explode('/',$image_info['mime']);
        $mark_mime  = explode('/',$mark_image_info['mime']);
        if($mime[0]!=='image' or $mark_mime[0]!=='image'){
            trigger_error('文件类型错误');
            return false;
        }
        //根据图像类型创建画布
        $image_type = $mime[1];
        $mark_image_type = $mark_mime[1];
        $create_callable = 'imagecreatefrom'.$image_type;
        $create_mark_callable = 'imagecreatefrom'.$mark_image_type;
        if(is_callable($create_callable) && is_callable($create_mark_callable)){
            $image = $create_callable($image_file);
            $mark_image = $create_mark_callable($mark_image_file);
        }else{
            trigger_error('无法创建图像资源');
            return false;
        }
        
        $position = $this->get_position($mark_image_info[0], $mark_image_info[1], $image_info[0], $image_info[1],$fixed,'image');
        if($this->transparent_use === true){
            imagecopymerge($image, $mark_image,$position['x'],$position['y'], 0, 0, $mark_image_info[0], $mark_image_info[1],$this->transparent);
        }else{
            imagecopyresampled($image, $mark_image,$position['x'],$position['y'], 0, 0,$image_info[0],$image_info[1], $mark_image_info[0], $mark_image_info[1]);
        }
        $image_print = 'image'.$image_type;
        if(is_callable($image_print)){
            $image_print($image,$image_file);
        }else{
            trigger_error('无法生成图片');
            return false;
        }
        imagedestroy($image);
        imagedestroy($mark_image);
    }
    
    
    /**
     * 计算水印的位置坐标
     * @param int $width 水印宽度
     * @param int $height 水印高度
     * @param int $image_width 图像宽度
     * @param int $image_height 图像高度
     * @param int $fixed 水印位置,从1-9代表从左上到右下
     * @param string $type 用来区分TTF文字和图片格式,兼容文字以左下角为原点的问题
     * @return array
     */
    protected function get_position($width,$height,$image_width,$image_height,$fixed,$type='text'){
        $position = array();
        $padding = 5;
        switch($fixed){
            case 1:
                $position['x']=$padding;
                if($type==='text'){
                    $position['y']=$height+$padding;
                }else{
                    $position['y']=$padding;
                }
                break;
            case 2:
                $position['x']=floor(($image_width-$width)/2);
                if($type==='text'){
                    $position['y']=$height+$padding;
                }else{
                    $position['y']=$padding;
                }
                break;
            case 3:
                $position['x']=$image_width-$width-$padding;
                if($type==='text'){
                    $position['y']=$height+$padding;
                }else{
                    $position['y']=$padding;
                }
                break;
            case 4:
                $position['x']=$padding;
                $position['y']=floor(($image_height-$height)/2);
                break;
            case 5:
                $position['x']=floor(($image_width-$width)/2);
                $position['y']=floor(($image_height-$height)/2);
                break;
            case 6:
                $position['x']=$image_width-$width-$padding;
                $position['y']=floor(($image_height-$height)/2);
                break;
            case 7:
                $position['x']=$padding;
                $position['y']=$image_height-$height-$padding;
                break;
            case 8:
                $position['x']=floor(($image_width-$width)/2);
                $position['y']=$image_height-$height-$padding;
                break;
            default:
                $position['x']=$image_width-$width-$padding;
                $position['y']=$image_height-$height-$padding;
        }
        return $position;
    }
        
    
    /**
     * 获取一个日期型文件名
     * @param string $ext 文件扩展名
     */
    protected function get_thumb_filename($ext){
        $ext = trim($ext,'.');
        if($ext==='jpeg'){
            $ext = 'jpg';
        }
        $date = date('YmdHis');
        return $date.rand(1000,9999).'.'.$ext;
    }
}