<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 文件上传
// +-----------------------

class Upload{
    
    //上传文件的最大大小(字节)
    protected $maxsize;
    //文件上传的允许扩展名
    protected $allow_ext;
    //默认上传路径
    protected $default_upload_dir='upload';
    //错误列表
    protected $error_list = array(
        1 => '文件大小超过最大上传文件大小限制',
        2 => '超过表单设置的上限',
        3 => '文件上传不完整',
        4 => '文件没有被上传',
        5 => '文件大小超过限制',
        6 => '找不到临时文件夹',
        7 => '文件写入失败',
        -1 => '文件格式不合法',
        -2 => '移动文件失败',
        -3 => '尝试创建上传目录失败,请检查目录权限是否可写'
    );
    //错误信息
    protected $error = array();
    //格式化处理过的文件信息数组
    protected $files;
    //上传的文件结果数组
    protected $result = array();
    
    /**
     * 初始化
     */
    public function __construct($maxsize=2000000,$allow_ext='gif|jpg|png|rar|zip|7z|gz|txt'){
        if(!is_numeric($maxsize) || true===strpos($maxsize,'.') || $maxsize<=0){
            trigger_error('文件上传参数设置有误',E_USER_ERROR);
        }
        $this->maxsize = $maxsize;
        if(!is_string($allow_ext)){
            trigger_error('允许扩展名错误,参数接收一个字符串',E_USER_ERROR);
        }
        $allow_ext = trim($allow_ext,'|');
        $preg = '/^([\w]+|\|?)+$/';
        if(!preg_match($preg, $allow_ext)){
            trigger_error('允许的扩展名错误;多个扩展名以"|"符号分隔,不包含"."号;',E_USER_ERROR);
        }
        
        $this->allow_ext = $allow_ext;
        $this->fotmat_files($_FILES);
        
    }
        
    
    /**
     * 文件上传主要方法
     * @param string $upload_dir 文件上传的路径 (相对于update路径)
     * @return int 返回成功上传文件的个数;
     */
    public function up($upload_dir='',$fname=''){
	$upload_dir = iconv('utf-8', 'gbk', $upload_dir);
        $fname = iconv('utf-8', 'gbk', $fname);
        $status = array();
        $upload_count = 0;
        if(!is_string($upload_dir) || !is_string($fname)){
            trigger_error('文件上传路径需要一个字符串',E_USER_WARNING);
            return $upload_count;
        }
        
        //找到最终要移动的目录
        $upload_dir = rtrim(rtrim($this->default_upload_dir,'/\\').'/'.trim($upload_dir,'/\\'),'/\\');
        //如果文件夹不存在,尝试创建一个
        if(!is_dir($upload_dir)){
            if(mkdir($upload_dir,0777,true)===false){
                $this->add_error(-3);
                return 0;
            }
        }

        foreach($this->files as $key=>$file){
            //检测文件网络传输是否成功
            if($file['error']>0){
                $this->add_error($file['error'],$file);
                continue;
            }
            //检测是否超过网站大小限制
            if($file['size']>$this->maxsize){
                $this->add_error(5,$file);
                continue;
            }
            //检测是否二次提交导致的文件未上传大小为0
            if($file['size']<=0){
                $this->add_error(4,$file);
                continue;
            }
            //检测是否是允许的文件格式
            $allow_ext = explode('|', $this->allow_ext);
            if(($pos = strrpos($file['name'],'.')) !== false){
                $ext = substr($file['name'],$pos);
            }else{
                $ext = null;
            }
            if(!is_null($ext) && !in_array(ltrim($ext,'.'),$allow_ext)){
                $this->add_error(-1,$file);
                continue;
            }
            
            //如果不指定文件名,则获取到一个随机用户名,文件存在则重试
            if(empty($fname)){
                do{
                    $filename = $this->get_filename($ext);
                }while (is_file($upload_dir.'/'.$filename));
            }else{
                $filename = $fname.$ext;
            }
            //移动上传缓存文件到指定目录
            $result = move_uploaded_file($file['tmp_name'], $upload_dir.'/'.$filename);

            if($result===false){
                $this->add_error(-2,$file);
                continue;
            }else{
                //上传成功,记录路径
                $this->result[$key] = $upload_dir.'/'.$filename;
                $upload_count++;
            }
        }
        return $upload_count;
    }
    
    
    /**
     * 获取上传的文件信息
     */
    public function result(){
        return $this->result;
    }
    
    
    /**
     * 获得文件数组
     */
    public function files(){
        return $this->files;
    }
    
    
    /**
     * 获得错误信息数组
     */
    public function error($json=false){
        if($json){
            return json_encode($this->error);
        }
        return $this->error;
    }
    
    
    /**
     * 获取一个日期型文件名
     * @param string $ext 文件扩展名
     */
    protected function get_filename($ext){
        $ext = trim($ext,'.');
        $date = date('YmdHis');
        return !empty($ext) ? $date.rand(10000,99999).'.'.$ext : $date.rand(10000,99999);
    }
    
    
    /**
     * 添加一条错误信息
     * @param int $code 错误代码
     * @param array $file 文件上传信息数组
     */
    protected function add_error($code,$file=null){
        $error = array(
            'code' => $code,
            'msg' => $this->error_list[$code]
        );
        if(is_array($file)){
            $error['type'] = $file['type'];
            $error['name'] = $file['name'];
            $error['size'] = $file['size'];
        }
        array_push($this->error, $error);
    }
    
    
    /**
     * 格式化文件信息
     */
    protected function fotmat_files($files){
        if(empty($files)){
            $this->files = array();
            return;
        }
        foreach($files as $key => $value){
            //如果是一个文件信息
            if(is_numeric($value['error'])){
                $this->files[$key] = $value;
            }
            //如果是一个数组
            if(is_array($value['error'])){
                foreach($value as $attr => $list){
                    foreach($list as $k => $v){
                        $this->files[$key.'_'.$k][$attr] = $v;
                    }
                }
            }
        }
    }
    
}