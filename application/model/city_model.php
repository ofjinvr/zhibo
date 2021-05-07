<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class City_model extends Fetch{
    
    public $ip;
    private $api;
    private $tb = 'td_city';
    private $domain = 'taoding.cn';

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->ip = get_true_ip();
        $this->api = "http://whois.pconline.com.cn/ip.jsp?ip=$this->ip&level=2";
    }

    
    //所有城市列表
    public function whole(){
        return  $this->db->select()->from($this->tb)->query()->all_array();
    }


    //获取当前城市信息
    public function current(){
        $host = $_SERVER['HTTP_HOST'];
        $city_list = $this->whole();
        foreach($city_list as $row){
            if($row['city_site']===$host){
                return $row;
            }
        }
        return null;
    }
    
    
    //根据IP定位城市
    public function getCityByIp(){
        return iconv('GBK','UTF-8',@file_get_contents($this->api));
    }
    
    
    //获取推荐分站
    public function getRecommendCityWeb(){
        $text = $this->getCityByIp();
//        $text='深圳';
        $city_list = $this->whole();
        foreach($city_list as $row){
            if(strpos($text,$row['city_name'])!==false){
                return $row;
            }
        }
    }

}