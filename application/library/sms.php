<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Sms{
    
    private $api_mt = 'http://sdk2.zucp.net:8060/webservice.asmx/mt?'; //单一发送接口
    private $sn = 'SDK-BBX-010-24549';  //SN码
    private $pwd = '805c-e7A';          //密码
    private $tf = '297501';             //特服号
    private $ext = array();
    private $rrid = '';
    
    
    public function __construct() {
        $this->ext = array('default'=>'【淘丁】','1'=>'【企加教育】','2'=>'【企加网】');
    }
    
    
    /**
     * 发送一条短信
     * @param number $mobile 手机号码,可以发送10000以下手机群发,英文逗号分隔
     * @param text $content 短信内容
     * @param mixed $ext 1,2对应不同短信签名,$ext默认为空,签名为【淘丁】
     * @param time stime 定时发送
     */
    public function mt($mobile,$content,$ext='',$stime=''){
        $this->rrid = strval(rand(1000,9999));
        $ext = strval($ext);
        if(!empty($ext) && !empty($this->ext[$ext])){
            $sign = $this->ext[$ext];
        }else{
            $sign = $this->ext['default'];
            $ext = '';
        }
        $api_data = array(
            'sn' => $this->sn,
            'pwd' => strtoupper(md5($this->sn.$this->pwd)),
            'mobile' => $mobile,
            'content' => iconv('UTF-8','GBK',$content.$sign),
            'ext' => $ext,
            'stime' => $stime,
            'rrid' => $this->rrid
        );
        $curl = curl_init();
        $opts = array(
            CURLOPT_URL => $this->api_mt.http_build_query($api_data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        );
        curl_setopt_array($curl, $opts);
        $trunsfer = trim(strip_tags(curl_exec($curl)));
        if($trunsfer!==$this->rrid){
            return false;
        }
        return true;
    }

}