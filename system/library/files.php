<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 文件处理类
// +-----------------------

class Files{
    
    public function __construct() {
        ;
    }
    
    /**
     * 列出目录下的所有文件
     * @param string $dir 本类中root目录下的子目录
     * @param bool $filestat 是否获得大部分信息
     * @param string $ext 列出此扩展名的文件,可以用|号分隔
     * @return array 目标路径下的所有文件
     */
    public function all_files($path='', $filestat=false, $exts=null){
        $path = iconv('utf-8','gbk',$path);
        if(!is_dir($path)){
            return false;
        }
        if(is_string($exts)){
            $exts_array = explode('|',$exts);
        }
        $files = array();
        $handle = opendir($path);
        while(($file=readdir($handle))!==false){
            if($file==='.'||$file==='..'){
                continue;
            }
            if(!empty($exts_array)){
                if(!in_array(ltrim(strrchr($file,'.'),'.'),$exts_array)){
                    continue;
                }
            }
            $filename = rtrim($path,'/\\').'/'.$file;
            
            if($filestat===true){
                $fileinfo = stat($filename);
                array_splice($fileinfo,0,13);
                $fileinfo['filename'] = iconv('gbk','utf-8',$filename);
                $fileinfo['filetype'] = filetype($filename);
                array_push($files,$fileinfo);
            }else{
                array_push($files,iconv('gbk','utf-8',$filename));
            }
        }
        closedir($handle);
        return $files;
    }
    
    
    /**
     * 删除某个目录/文件 - 删除之前你要知道你在干什么 :)
     * @param string $dir 相对路径
     */
    public function delete($path){
        $path = iconv('utf-8', 'gbk', $path);
        if(empty($path) || !is_string($path)){
            return false;
        }
        if(is_dir($path)){
            $files = $this->all_files($path);
            foreach ($files as $file){
                $file = iconv('utf-8', 'gbk', $file);
                if(is_dir($file)){
                    if(delete($file)===true){
                        rmdir($file);
                    }else{
                        return false;
                    }
                    continue;
                }
                if(is_file($file)){
                    if(unlink($file)===false){
                        return false;
                    }
                }
            }
            return true;
        }
        if(is_file($path) && unlink($path)===true){
            return true;
        }
        return false;
    }
     
}