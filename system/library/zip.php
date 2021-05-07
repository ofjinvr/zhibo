<?php 
//if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | Zip压缩类
// +-----------------------

/**
 * 注意:由于本类库采用轻量级,仅返回二进制数据,并不进行磁盘的读写操作
 *      所以无法支持大文件打包,支持的最大数据为PHP内存限额(理论数据,排除其他内存份额)
 */

class Zip{
    
    /**
     * 压缩时使用属性
     */
    protected $now;             //当前时间数组
    protected $dir;             //压缩目录
    protected $zipdata;         //压缩的数据
    protected $offset;          //文件偏移量
    protected $file_amount;     //文件数量
    protected $entries;         //条目总数
    
    /**
     * 解压时使用属性
     */
    protected $zip_handle;              //解压文件时存放的ZIP文件句柄
    protected $endinfo;                 //文件尾部信息数组
    protected $dirinfo;                 //文件中央目录信息数组
    protected $zip_filesize;            //文件的大小
    protected $dirname;                 //解压到某个目录

    public function __construct(){
        $this->cleardata();     //重置初始化变量
        $this->now = getdate();
    }
    
    
    /**
     * 添加目录
     * @param string $filepath 压入Zip文件的目录路径
     */
    public function dappend($dir){
        $dir = trim($this->crepeat($dir),'/\\');
        if(empty($dir)){
            throw new Exception('ZIP文件路径有误,意外的路径格式');
        }
        $dir .= '/';
        $modtime = $this->get_modtime();
        $this->dappend_pack($dir,$modtime);
        return $this;
    }
    
    
    /**
     * 添加文件
     * @param string $filepath 压入Zip文件的数据路径
     * @param string $file_contents 文件内容
     */
    public function fappend($filepath,$contents=null){
        $filepath = trim($this->crepeat($filepath),'/\\');
        if(empty($filepath)){
            throw new Exception('ZIP文件路径有误,意外的路径格式');
        }
        
        //第一个参数为数组,则使用批量添加
        if(is_array($filepath)){
            foreach($filepath as $data){
                if(!empty($data[0]) && isset($data[1])){
                    $modtime = $this->get_modtime();
                    $this->fappend_pack($data[0],$data[1],$modtime);
                }else{
                    throw new Exception('批量打包ZIP文件参数有误,意外的数组格式');
                }
            }
        }
        //如果是字符串,则第二个参数为内容
        if(is_string($filepath)){
            $modtime = $this->get_modtime();
            $this->fappend_pack($filepath,$contents,$modtime);
        }
        return $this;
    }
    
    
    /**
     * 添加整个目录中的文件到压缩包内
     * @param string $dir 目录地址
     * baidu,''   baidu,11/    baidu,11/ext
     */
    public function append_dir($path,$hier_path=''){
        if(!is_dir($path) || !is_readable($path)){
            throw new Exception('目录不存在或没有可读权限');
        }
        $path = rtrim($this->crepeat($path),'/\\');
        $hier_path = trim($this->crepeat($hier_path),'/\\');
        if(empty($hier_path)){
            $hpath = $path;
        }else{
            $hpath = $path.'/'.$hier_path;
        }
        //读取目录
        $dir = opendir($hpath);
        while(($result = readdir($dir)) !== false){
            if($result==='.' || $result==='..'){
                continue;
            }
            $filename = $hpath.'/'.$result;
            if(is_file($filename)){
                if(!empty($hier_path)){
                    $this->fappend($hier_path.'/'.$result,file_get_contents($filename));
                }else{
                    $this->fappend($result,file_get_contents($filename));
                }
            }
            if(is_dir($filename)){
                $this->append_dir($path,$hier_path.'/'.$result);
            }
        }

        return $this;
    }
    
    
    /**
     * 返回zip文件的二进制数据
     * @param string $note zip压缩文件的注释
     * @return bin zip文件的二进制数据
     */
    public function getbin($note=''){
        if ($this->entries == 0){
            return false;
        }
        if(!is_string($note)){
            throw new Exception('zip文件注释参数需要一个字符串');
        }else{
            $note = iconv('utf-8','gbk',$note);
        }
        
        $zipdata = $this->zipdata;
        $zipdata .= $this->dir."\x50\x4b\x05\x06\x00\x00\x00\x00";       //加载目录信息 和 结尾签名
        $zipdata .= pack('v', $this->entries);                           //zip文件总条目
        $zipdata .= pack('v', $this->entries);                           //总条目
        $zipdata .= pack('V', strlen($this->dir));                       //目录大小
        $zipdata .= pack('V', strlen($this->zipdata));                   //目录相对数据的偏移量
        $zipdata .= pack('v',strlen($note));                             //注释长度
        $zipdata .= $note;                                               //注释
        return $zipdata;
    }
    
    
    /**
     * 将压缩包写入一个文件
     * @param string $filename 写入的文件路径
     * @return bool
     */
    public function wfile($filename,$note=''){
        if(!is_string($filename)){
            throw new Exception('存档Zip文件参数需要一个字符串');
        }
        $dir = dirname($filename);
        if(!is_dir($dir) && is_writable(dirname($dir))){
            mkdir($dir,0666,true);
        }
        
        $filename = $this->crepeat($filename);
        $file = fopen($filename,'w');
        if(flock($file,LOCK_EX)){
            fwrite($file,$this->getbin($note));
            flock($file,LOCK_UN);
            fclose($file);
        }
    }
    
    
    /**
     * 解压一个Zip包
     * @param string $dirname 解压至某个目录名称,如果目录不存在则自动创建
     * @param string $zpath 压缩包文件路径
     * @return array
     */
    public function unzip($dirname,$zpath){
        //关闭时限以免超时
        set_time_limit(0);
        $zpath = iconv('utf-8','gbk',$zpath);
        $dirname = iconv('utf-8','gbk',$dirname);
        
        if(!is_string($dirname)){
            throw new Exception('解压Zip包路径参数错误');
        }
        if(!is_readable($zpath)){
            throw new Exception('解压Zip包不可读或不存在');
        }
        if(!is_writable(dirname($dirname))){
            throw new Exception('解压目录不可写');
        }
        //如果解压目录不存在则创建一个
        $this->dirname = trim($this->crepeat($dirname),'/\\');
        if(!is_dir($this->dirname)){
            mkdir($this->dirname,0666,true);
        }
        //打开压缩包
        $this->zip_filesize = filesize($zpath);
        $this->zip_handle = fopen($zpath, 'rb');
        flock($this->zip_handle,LOCK_SH);
        
        $this->uncoding_end_flag(); //解析ZIP包的尾部信息
        $this->uncoding_centerdir_flag(); //解析ZIP中部DIR信息
        $this->uncoding_data_flag(); //解析ZIP中的数据信息,并把这些数据解压到硬盘中
        
        flock($this->zip_handle,LOCK_UN);
        fclose($this->zip_handle);
        //恢复系统设置时间
        set_time_limit(Config::PHP_TIME_OUT);
        $this->cleardata();
        return true;
    }
    
    
    /**
     * 解析ZIP包尾部标识,提取尾部信息数组
     * @return void
     */
    protected function uncoding_end_flag(){
        //用来存放结尾标记的索引位置
        $endpos = null;
        //每次最大读取8192个字节长度,查找尾部标记
        if($this->zip_filesize < 0x2000){
            $jump_block = $this->zip_filesize;
        }else{
            $jump_block = 0x2000;
        }
        for($seek=$this->zip_filesize-$jump_block;$seek>=0;$seek-=$jump_block){
            fseek($this->zip_handle, $seek);
            $block_bin = fread($this->zip_handle,$jump_block+4); //+4 防止2048断点处的flag无法匹配
            if(($pos=strpos($block_bin,"\x50\x4B\x05\x06"))!==false){
                //如果找到尾部标记,则将指针指在尾部标识后的位置
                $endpos = $seek+$pos;
                fseek($this->zip_handle,$endpos+4);
                break;
            }
        }
        //找不到结尾标记,则抛出异常
        if(is_null($endpos)){
            throw new Exception('找不到压缩包结尾标记,解压失败');
        }
        //读取并解析尾部的信息
        $endinfo_bin = fread($this->zip_handle,18);
        $this->endinfo = unpack('vdisk_id/vdisk_dirid/vcentdir_count/vdir_count/Vdir_size/Vdir_offset/vcomment_size',$endinfo_bin);
        if($this->endinfo['comment_size']>0){
            $this->endinfo['comment'] = fread($this->zip_handle,$this->endinfo['comment_size']);
        }
        
    }
    
    
    /**
     * 解析ZIP中部DIR信息
     * @return void
     */
    protected function uncoding_centerdir_flag(){
        //将指针放在中央目录起始处准备解析目录结构
        fseek($this->zip_handle,$this->endinfo['dir_offset']);
        
        $cur = 0;               //游标
        $dir_flag = 0x504b0102; //中央目录标识
        $end_flag = 0x504b0506; //尾部标识
        //解析中央目录和结尾文件信息,创建信息数组
        //每次读取一个字节,将游标右进左出堆栈查找标识
        while (!feof($this->zip_handle)){
            $char = fread($this->zip_handle,1);
            $cur = $cur<<8 | ord($char);
            
            //如果是尾部标识,跳出循环
            if($cur===$end_flag){
                break;
            }
            
            //如果是中央目录标识,解析出文件信息表
            if($cur===$dir_flag){
                $pos = ftell($this->zip_handle);
                $bininfo = fread($this->zip_handle,42);
                //解析出临时数组
                $tempinfo = unpack('vcompressed_version/vuncompressed_version/vis_descriptor/vcompress_method/vmtime/vmdate/Vcrc32/Vcompressed_size/Vsize/vfilename_len/vextra_len/vcomment_len/vdisk_start_id/vinner_property/Vouter_property/Vdata_offset',$bininfo);
                $tempinfo['filename'] = fread($this->zip_handle,$tempinfo['filename_len']);
                array_push($this->dirinfo, $tempinfo);
            }
        }
        unset($tempinfo);
    }
    
    
    
    /**
     * 解析ZIP数据段,并解压数据到目录下
     * @return void
     */
    protected function uncoding_data_flag(){
        //遍历中央目录数组,根据中央目录读取数据区信息
        foreach($this->dirinfo as $dirrow){
            //如果是目录,尝试创建目录
            $filename = $this->dirname.'/'.$dirrow['filename'];
            if($dirrow['outer_property'] === 16 || $dirrow['outer_property']===48){
                if(!is_dir($filename)){
                    mkdir($filename,0666,true);
                }
                continue;
            }
            //如果是文件,事先验证它的目录,如果目录不存在则新建一个
            if(!is_dir(dirname($filename))){
                mkdir(dirname($filename),0666,true);
            }
            
            //window下不支持特殊的文件类型
            if($dirrow['outer_property']!==32 && PHP_OS==="WINNT"){
                continue;
            }
            
            //效验算法支持
            if($dirrow['compress_method']!==8 && $dirrow['compress_method']!==0){
                throw new Exception('不支持的Zip压缩算法');
            }
            //读取数据头,校验文件指针是否在正确的位置
            fseek($this->zip_handle,$dirrow['data_offset'],SEEK_SET);
            $data_sign_check = fread($this->zip_handle,4);
            if($data_sign_check !== "\x50\x4b\x03\x04"){
                throw new Exception('解压数据时出错,数据头校验有误');
            }
            //数据头校验成功时,说明文件指针位置正确,读取剩余的头文件信息
            $datarow = unpack(
                'vmix_version/vis_descriptor/vcompress_method/vmtime/vmdate/Vcrc32/Vcompressed_size/Vsize/vfilename_len/vextra_len',
                fread($this->zip_handle,26)
            );

            //将指针再向后移动文件名长度个字节(跨过文件名读文件内容)
            fseek($this->zip_handle,$datarow['filename_len']+$datarow['extra_len'],SEEK_CUR);
            $seektest = ftell($this->zip_handle);
            
            //非目录的情况,创建GZ文件
            $gz_header_data = pack('va1a1Va1a1', 0x8b1f, Chr($datarow['compress_method']),Chr(0x00), time(), Chr(0x00),0xff);
            if(is_numeric($datarow['compressed_size']) && $datarow['compressed_size']>0){
                $gzdata = fread($this->zip_handle,$datarow['compressed_size']);
            }
            $gz_end_data = pack('VV',$datarow['crc32'],$datarow['size']);
            $data = $gz_header_data.$gzdata.$gz_end_data;
            file_put_contents($filename.'.gz',$data);
            
            //GZ算法打开文件,解压
            if(is_readable($filename.'.gz')){
                $gz = gzopen($filename.'.gz','rb');
                flock($gz,LOCK_SH);
                $content = gzread($gz,$datarow['size']+18);
                file_put_contents($filename, $content);
                flock($gz,LOCK_UN);
                gzclose($gz);
                unlink($filename.'.gz');
            }
        }
    }
    

    
    /**
     * 添加目录封包
     */
    protected function dappend_pack($dir,$time){        
        $this->zipdata .=
            "\x50\x4b\x03\x04\x0a\x00\x00\x00\x00\x00"  //Zip文件头 [格式标识][最低版本][是否有描述字段][压缩方法]
            .pack('v',$time['mod_time'])                //最后修改时间
            .pack('v',$time['mod_date'])                //最后修改日期
            .pack('V',0)                                //效验码
            .pack('V',0)                                //压缩后大小
            .pack('V',0)                                //未压缩的数据大小
            .pack('v',strlen($dir))                     //文件名长度
            .pack('v',0)                                //额外字段长度
            .$dir                                       //路径/文件名
            .pack('V',0)                                //效验码
            .pack('V',0)                                //压缩后大小
            .pack('V',0);                               //未压缩的数据大小
        
        $this->dir .=
            "\x50\x4b\x01\x02\x00\x00\x0a\x00\x00\x00\x00\x00"
            .pack('v',$time['mod_time'])                //最后修改时间
            .pack('v',$time['mod_date'])                //最后修改日期
            .pack('V',0)                                //效验码
            .pack('V',0)                                //压缩后大小
            .pack('V',0)                                //未压缩的数据大小
            .pack('v',strlen($dir))                     //文件名长度
            .pack('v',0)                                //额外字段长度
            .pack('v',0)                                //文件注释长度
            .pack('v',0)                                //磁盘开始号
            .pack('v',0)                                //内部文件属性
            .pack('V',16)                               //扩展文件属性-设置为目录标识bit
            .pack('V',$this->offset)                    //标头偏移量
            .$dir;                                      //目录
        
        //更新偏移量,增加计数
        $this->offset = strlen($this->zipdata);
        $this->entries++;
    }
    
    
    /**
     * 添加文件封包
     */
    protected function fappend_pack($filepath,$content,$time){
        $content_size = strlen($content);                   //压缩前大小
        $gz_content = substr(gzcompress($content),2,-4);  //压缩后数据
        $gz_content_size = strlen($gz_content);             //压缩后大小
        
        $this->zipdata .=
            "\x50\x4b\x03\x04\x0a\x00\x00\x00\x08\x00"  //Zip文件头 [格式标识][最低版本][是否有描述字段][压缩方法]
            .pack('v',$time['mod_time'])                //最后修改时间
            .pack('v',$time['mod_date'])                //最后修改日期
            .pack('V',crc32($content))                  //效验码
            .pack('V',$gz_content_size)                 //压缩后大小
            .pack('V',$content_size)                    //未压缩的数据大小
            .pack('v',strlen($filepath))                //文件名长度
            .pack('v',0)                                //描述字段长度
            .$filepath                                  //路径/文件名
            .$gz_content;                               //压缩的内容
        $this->dir .=
            "\x50\x4b\x01\x02\x00\x00\x0a\x00\x00\x00\x08\x00" //zip文件头 
            .pack('v',$time['mod_time'])                //最后修改时间
            .pack('v',$time['mod_date'])                //最后修改日期
            .pack('V',crc32($content))                  //效验码
            .pack('V',$gz_content_size)                 //压缩后大小
            .pack('V',$content_size)                    //解压后大小
            .pack('v',strlen($filepath))                //文件名长度
            .pack('v',0)                                //额外字段长度
            .pack('v',0)                                //文件注释长度
            .pack('v',0)                                //磁盘开始号
            .pack('v',0)                                //内部文件属性
            .pack('V',32)                               //外部文件属性
            .pack('V',$this->offset)                    //标头偏移量
            .$filepath;                                 //路径/文件名
        
        //更新偏移量,增加计数
        $this->offset = strlen($this->zipdata);
        $this->entries++;
        $this->file_amount++;
    }
        
    
    /**
     * 整理路径,将路径中的多个"/","\"整理成标准路径
     */
    protected function crepeat($path){
        //如果格式公正直接返回
        if(strpos($path,'\\')!==false){
            $path = str_replace('\\','/',$path);
        }
        if(strpos($path,'//')===false){
            return $path;
        }
        while(strpos($path,'//')!==false){
            $path = str_replace('//','/',$path);
        }
        return $path;
    }
    
    /**
     * 获得修改时间
     * @return int bit编码的时间格式
     */
    protected function get_modtime(){
        $time = array();
        $time['mod_date'] = (($this->now['year']-1980) << 9) + ($this->now['mon'] << 5) + $this->now['mday'];
        $time['mod_time'] = ($this->now['hours'] << 11) + ($this->now['minutes'] << 5) + $this->now['seconds']/2;
        return $time;
    }
    
    
    /**
     * 重置运行数据
     */
    protected function cleardata(){
        $this->zipdata = '';
        $this->dir = '';
        $this->entries = 0;
        $this->file_num	= 0;
        $this->offset = 0;
        
        $this->zip_handle = null; 
        $this->endinfo = array();
        $this->dirinfo = array();
        $this->zip_filesize = 0;
        $this->dirname = '';
    }
    
}