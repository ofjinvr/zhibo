<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//网站数据管理

class Database extends Fetch{
    
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('check_manager_logined');
        check_manager_logined();
        $this->load->library('files');
    }
    
    
    //查看设置
    public function index($action=null,$base64=null){
        check_manager_rights(__METHOD__);
        //下载备份文件操作
        if($action==='download' && !empty($base64)){
            $filename = base64_decode($base64);
            if(file_exists($filename)){
                header('Location:'.site_url($filename));
            }else{
                skip_false('没有找到指定文件');
            }
            return;
        }
        
        //删除备份文件操作
        if($action==='delete' && !empty($base64)){
            $filename = base64_decode($base64);
            if($filename==='clear'){
                $this->files->delete('backup');
                skip_true('已清空所有备份文件');
            }
            if(file_exists($filename)){
                $this->files->delete($filename);
                skip_true('备份文件已删除');
            }else{
                skip_false('没有找到指定文件');
            }
            return;
        }
        
        $backup = $this->files->all_files('backup','gz');
        //载入数据分页类
        $this->load->library('paging',15,count($backup));
        $page_info = $this->paging->info();
        $data['list'] = array_slice($backup,$page_info['begin'],$page_info['amount']);
        $data['page'] = $this->paging->html();
        $this->load->view('manage/data_index',$data);
    }
    
    
    //数据库备份
    public function backup(){
        check_manager_rights(__METHOD__);
        if($this->input->post('submit')==='开始备份'){
            $backup_sql = '';
            $this->load->database();
            //查询所有的表
            $tables = array();
            $result = $this->db->query('show tables')->all_array('Tables_in_test');
            foreach($result as $table){
                array_push($tables,$table['Tables_in_'.Config::DB_NAME]);
            }
            //遍历所有表
            foreach($tables as $tablename){
                //清除存在的表
                $backup_sql .= 'DROP TABLE IF EXISTS `'.$tablename."`;\n";
                //获得建表语句
                $result = $this->db->query('show create table '.$tablename)->row_array();
                $backup_sql .= $result['Create Table'].";\n";
                //插入数据语句
                $result = $this->db->query('select * from '.$tablename)->all_array();
                foreach ($result as $row){
                    $columns='`';
                    $values='\'';
                    foreach($row as $key => $value){
                        $columns .= $key.'`,`';
                        $values .= $value.'\',\'';
                    }
                    $columns = substr($columns,0,strrpos($columns,','));
                    $values = substr($values,0,strrpos($values,','));
                    $backup_sql .= 'INSERT INTO '.$tablename.'('.$columns.') VALUES('.$values.");\n";
                }
            }
            $filename = 'backup/bak'.date('YmdHis-').md5(microtime(true)).'.gz';
            $zp = gzopen($filename,'w');
            gzwrite($zp, $backup_sql);
            gzclose($zp);
            skip_true('备份完成');
            return;
        }
        $this->load->view('manage/data_backup');
    }
    
    
    //数据库还原
    public function restore(){
        check_manager_rights(__METHOD__);
        $bakfile = $this->input->post('bakfile',true);
        if(!empty($bakfile)){
            $filename = 'backup/'.base64_decode($bakfile);
            if(is_readable($filename)){
                $content = '';
                $zp = gzopen($filename,'r');
                while (!gzeof($zp)){
                    $content .= gzread($zp,8192);
                }
                gzclose($zp);
                $sql_array = explode(';',$content);
                array_pop($sql_array);
                $this->load->database();
                foreach ($sql_array as $sql){
                    $this->db->exec($sql);
                }
                skip_true('数据库已还原');
            }else{
                skip_false('备份不存在或没有读取权限');
            }
            return;
        }
        $data['baklist'] = $this->files->all_files('backup','gz');
        $this->load->view('manage/data_restore',$data);
        
    }
    
}