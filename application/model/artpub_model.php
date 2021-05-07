<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Artpub_model extends Fetch{
    
    private $u = 'td_puber';
    private $a = 'td_puber_article';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //检测是否可以登陆，如果登陆成功返回puber_id,失败则返回false
    public function checkLogin($username,$password){
        if(empty($username) or empty($password)){
            return false;
        }
        $sql = "SELECT * FROM $this->u WHERE puber_name='$username' and puber_pwd='$password'";
        $result = $this->db->query($sql)->row();
        if(empty($result)){
            return false;
        }
        return $result;
    }
    
    //统计 $offset是周数 本周是0 上周是1 上上周是2 以此类推
    public function get_counts($puber_id,$offset=0){
        $puber_id = intval($puber_id);
        $offset = intval($offset);
        $time_point = time() - (3600*24*7*abs($offset));
        $begin_timestamp = mktime(0,0,0,date('m',$time_point),date('d',$time_point),date('Y',$time_point)) - (date('w')-1)*3600*24;
        $end_timestamp = mktime(23,59,59,date('m',$time_point),date('d',$time_point),date('Y',$time_point)) + (7-date('w'))*3600*24;
        $begin = date('Y-m-d H:i:s',$begin_timestamp);
        $end = date('Y-m-d H:i:s',$end_timestamp);
        $sql = "select count(*) as n from $this->a where puber_id='$puber_id' and reltime between '$begin' and '$end'";
        $sql_0 = "select count(*) as n from $this->a where puber_id='$puber_id' and status='0' and reltime between '$begin' and '$end'";
        $sql_1 = "select count(*) as n from $this->a where puber_id='$puber_id' and status='1' and reltime between '$begin' and '$end'";
        $sql_2 = "select count(*) as n from $this->a where puber_id='$puber_id' and status='2' and reltime between '$begin' and '$end'";
        $data['totle'] = $this->db->query($sql)->row()->n;
        $data['status_0'] = $this->db->query($sql_0)->row()->n;
        $data['status_1'] = $this->db->query($sql_1)->row()->n;
        $data['status_2'] = $this->db->query($sql_2)->row()->n;
        return $data;
    }
    
    
}