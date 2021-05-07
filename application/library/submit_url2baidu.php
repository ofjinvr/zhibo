<?php
/**
 * 提交网址到baidu以供百度快速收录
 * Anthor Zhangzhi 2015.11.24
 */
class Submit_url2baidu {
    
    public $apiurl = 'http://data.zz.baidu.com/urls';
    public $baidu_token = null;
    public $site = null;
    public $original = null;
    
    
    /**
     * 
     * @param string $token baidu站长token
     * @param string $site 网站site
     * @param string $original 是否原创提交
     */
    public function __construct($token=null,$site=null,$original=null){
        if(!function_exists('curl_init')){
            throw new Exception('CURL扩展未开启');
        }
        $this->baidu_token = $token;
        $this->original = $original;
        $this->site = preg_replace('/http(s?):\/\//i','',$site);
        
    }
    
    
    public function submit($urls=null){
        if(!is_array($urls) and !is_string($urls)){
            throw new Exception('URL参数错误,必须为一个数组或者字符串');
        }
        if(is_array($urls)){
            $urls = implode(PHP_EOL,$urls);
        }
        return $this->curl_submit($urls);
    }
    
    
    protected function curl_submit($urls){
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $this->apiurl."?site=$this->site&token=$this->baidu_token&type=$this->original",
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS =>  $urls,
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain')
        );
        curl_setopt_array($ch, $options);
        $json = curl_exec($ch);
        curl_close($ch);
        return json_decode($json,true);
    }

}