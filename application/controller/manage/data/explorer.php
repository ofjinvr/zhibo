<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//网站数据管理

class Explorer extends Fetch{
    
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('check_manager_logined');
        check_manager_logined();
        $this->load->library('files');
    }
    
    
    //资源管理器-文件上传
    public function upload_files($act=null){
        check_manager_rights(__METHOD__);
        
        if($act===null){
            $get = $this->input->get(null,true);
            $data['setdir'] = !empty($get['plupload_setdir']) ? trim($get['plupload_setdir'],'/\\') : '';
            $data['setdir'] = preg_replace("/[\/\\\]+/",'/',$data['setdir']);
            if(preg_match('/\.{2,}[\/\\\\]|(\.{2,}$)/',$data['setdir'])){
                skip_false('非法的文件目录');
            }
        }
        
        if($act==='action'){
            $post = $this->input->post(null,true);
            $data['setdir'] = !empty($post['plupload_setdir']) ? trim($post['plupload_setdir'],'/\\') : '';
            $data['setdir'] = preg_replace("/[\/\\\]+/",'/',$data['setdir']);
            if(preg_match('/\.{2,}[\/\\\\]|(\.{2,}$)/',$data['setdir'])){
                skip_false('非法的文件目录');
            }
            $this->load->library('upload');
            if($this->upload->up($data['setdir'])){
                $result = $this->upload->result();
                $temp_file_path = $result['plupload_files'];
                $dirname = dirname($temp_file_path);
                
                //如果断点上传则合并文件
                if(isset($post['chunk'])&& isset($post['chunks'])&& $this->is_natint($post['chunk'])&& $this->is_natint($post['chunks'])&& !empty($post['name'])){
                    $post['name'] = iconv('utf-8','gbk',$post['name']);
                    $handle = fopen($dirname.'/'.$post['name'] , 'ab');
                    flock($handle, LOCK_EX);
                    fwrite($handle,  file_get_contents($temp_file_path));
                    flock($handle,LOCK_UN);
                    fclose($handle);
                    unlink($temp_file_path);
                    
                    if((int)$post['chunk'] === $post['chunks']-1){
                        $ext_name = strrchr($dirname.'/'.$post['name'],'.');
                        rename($dirname.'/'.$post['name'], $dirname.'/'.date('YmdHis').rand(10000000,99999999).$ext_name);
                    }
                }
                //返回本次上传状态(包括分片上传的结果)
                echo json_encode(array('error_code' => '0','msg' => '上传完成'));
            }else{
                $err = $this->upload->error();
                echo json_encode(array('error' => '1','msg' => !empty($err) ? $err[0]['msg'] : '文件超出限额,上传失败'));
            }
            return;
        }
        $this->load->view('manage/data_upload_files',$data);
    }
    
    
    //资源管理器-文件浏览
    public function uploaded_files(){
        check_manager_rights(__METHOD__);
        $dir = 'upload/'.trim($this->input->get('dir'),'/\\ ');
        $dir = preg_replace("/[\/\\\]+/",'/',$dir);
        if(preg_match('/\.{2,}[\/\\\\]|(\.{2,}$)/',$dir)){
            skip_false('非法操作');
        }
        $page = $this->input->get('page');
        $page = !empty($page) ? $page : 1;
        $amount = 15;
        $flist = $this->files->all_files($dir,true);
        if($flist===false){
            $flist = array();
        }
        usort($flist,array($this,'flist_sort'));
        $this->load->library('paging',$amount,count($flist));
        $data['flist'] = array_slice($flist,($page-1)*$amount,$amount);
        $data['page'] = $this->paging->html();
        $navdir = str_replace('upload/','', $dir);
        $data['nav'] = !empty($navdir) ? explode('/',$navdir) : array();
        $this->load->view('manage/data_uploaded_files',$data);
    }
    
    
    //资源管理器-文件删除
    public function delete_uploaded_file(){
        check_manager_rights(__METHOD__);
        $filepath = 'upload/'.trim($this->input->get('filepath'),'/\\');
        $filepath = preg_replace("/[\/\\\]+/",'/',$filepath);
        if(preg_match('/\.{2,}[\/\\\\]|(\.{2,}$)/',$filepath)){
            skip_false('非法操作');
        }
        if($this->files->delete($filepath)===true){
            if(is_dir($filepath) && rmdir($filepath)){
                skip_true('已删除目录');
            }
            skip_true('已删除文件');
        }
        skip_false('删除失败');
    }
    
    
    //为资源管理器文件排序
    protected function flist_sort($a,$b){
        if($a['filetype']==='dir'){return -1;}
        if($b['filetype']==='dir'){return 1;}
        if($a['ctime']>$b['ctime']){return -1;}
        if($a['ctime']<$b['ctime']){return 1;}
        return 0;
    }
    
    //判断是否为自然数
    protected function is_natint($number){
        if(is_numeric($number) && $number>=0 && strpos($number,'.')===false){
            return true;
        }
        return false;
    }
    
}