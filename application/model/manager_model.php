<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Manager_model extends Fetch{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * 添加一个管理员
     */
    public function add_manager($data){
        if($this->db->insert('trl_manage',$data)===1){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 获取管理员列表和所属权限组
     */
    public function get_managers_limit($cur){
        return $this->db
                ->select('trl_manage.*,trl_rights.acc_name')
                ->from('trl_manage')
                ->join('trl_rights','trl_rights.id=trl_manage.rid',Mysql::JOIN_LEFT)
                ->limit($cur)
                ->query()->all_array();
    }
    
    /**
     * 获取管理员详细信息
     */
    public function get_managers_info($id){
        return $this->db
                ->select('trl_manage.id,trl_manage.merager_name,trl_manage.status,trl_manage.remark,trl_rights.acc_name,trl_rights.rule')
                ->from('trl_manage')
                ->join('trl_rights','trl_rights.id=trl_manage.rid',Mysql::JOIN_LEFT)
                ->where('trl_manage.id='.$id)
                ->query()->row_array();
    }
    
    /**
     * 获取管理员最基本信息
     */
    public function get_managers_baseinfo($id){
        return $this->db->select()->from('trl_manage')->where('id='.$id)->query()->row_array();
    }
    
    /**
     * 获取管理账户个数
     */
    public function get_manages_count(){
        return $this->db->query('select count(*) as num from trl_manage')->row()->num;
    }
    
    /**
     * 根据用户名称查ID
     */
    public function get_manages_id($name){
        $result = $this->db->query('select id from trl_manage where merager_name=\''.$name.'\'')->row();
        if(!empty($result)){
            return $result->id;
        }
        return false;
    }
    
    /**
     * 更改管理员账户信息
     */
    public function edit_manages($data,$id){
        return $this->db->update('trl_manage',$data,'id='.$id);
    }
    
    /**
     * 删除一个账户
     */
    public function del_manager($id){
        return $this->db->delete('trl_manage','id='.$id);
    }
    
    
    /**
     * 添加一个权限组
     */
    public function add_rights($data){
        if($this->db->insert('trl_rights',$data)===1){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 获取权限组总数
     */
    public function get_rights_count(){
        return $this->db->query('select count(*) as num from trl_rights')->row()->num;
    }
    
    /**
     * 获取权限列表
     */
    public function get_base_rights(){
        return $this->db->query('select id,acc_name from trl_rights')->all_array();
    }
    
    /**
     * 根据limit查询数据
     */
    public function get_rights_limit($limit){
        return $this->db->query('select * from trl_rights '.$limit)->all_array();
    }
    
    /**
     * 根据id查询数据
     */
    public function get_rights_one($id){
        return $this->db->query('select * from trl_rights where id='.$id)->row_array();
    }
    
    /**
     * 更新权限组规则
     */
    public function edit_rights($data,$id){
        return $this->db->update('trl_rights',$data,'id='.$id);
    }
    
    
    /**
     * 删除一个权限规则
     */
    public function del_rights($id){
        return $this->db->delete('trl_rights','id='.$id);
    }
    
    /**
     * 使用某条规则的管理员人数
     */
    public function rule_merages_count($rid){
        return $this->db->query('select count(*) as num from trl_manage where rid='.$rid)->row()->num;
    }
    
    /**
     * 根据用户名查询密码并对比
     */
    public function login_check($n,$p){
        $id = $this->db->query('select id from trl_manage where merager_name=\''.$n.'\' and merager_pwd=\''.$p.'\'')->row();
        if($id===false){
            return false;
        }else{
            return $id->id;
        }
    }
    
    /**
     * 修改密码方法
     */
    public function change_password($id,$pwd){
        return $this->db->exec('update trl_manage set merager_pwd=\''.$pwd.'\' where id='.$id);
    }
    
    /**
     * 获取账户登录日志
     */
    public function login_log_paging($limit){
        $sql = 'select trl_login_log.*,trl_manage.merager_name from trl_login_log left join trl_manage on trl_manage.id=trl_login_log.mid order by id desc limit '.$limit;
        return $this->db->query($sql)->all_array();
    }
    
    
    /**
     * 获取表中的个数
     */
    public function log_count(){
        $sql = 'select count(*) as num from trl_login_log';
        return $this->db->query($sql)->row()->num;
    }
    
    
    public function add_login_log($data){
        if(is_numeric($this->db->insert('trl_login_log',$data))){
            return true;
        }else{
            return false;
        }
    }
}
