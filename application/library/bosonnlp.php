<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Bosonnlp{

    private $curl;
    private $token = 'pEw-Icn0.4529.4lq6UUyxqxUA';

    private $api_splitter = 'http://api.bosonnlp.com/tag/analysis';   //分词接口
    private $api_keyword = 'http://api.bosonnlp.com/keywords/analysis'; //关键词提取接口
    private $api_depict = 'http://api.bosonnlp.com/summary/analysis'; //摘要提取接口


    public function __construct() {
        if(!function_exists('curl_init')){
            throw new Exception('Bosonnlp library need curl extension but it\'s not turned on.');
        }
        $this->curl = curl_init();
    }


    /**
     * 中文分词
     * @param string $text 待处理文本
     * @param string $space_mode 空格保留选项 0-不保留空格 1-去重复空格 2-保留所有空格 3-英文单词间的空格不保留,中文词空格去重复
     * @param string $oov_level 新词枚举级别 0不枚举新词 1-4 枚举新词 从1到4出现新词的可能性依次增大
     * @param string $t2s 繁转简 0关闭 1开启
     * @param string $special_char_conv 1-进行特殊字符转换，将”\n”, “\r”, “\t”分别 转换成”_Enter_”, “_Enter_” , “_Tab_” 0-关闭(默认)
     * @return array
     */
    public function splitter($text,$space_mode='0',$oov_level='3',$t2s='0',$special_char_conv='0'){
        if(empty($text)){return '';}
        $params = array(
            'space_mode' => $space_mode,
            'oov_level' => $oov_level,
            't2s' => $t2s,
            'special_char_conv'=>$special_char_conv
        );
        $api = $this->api_splitter.'?'.http_build_query($params);
        $result = json_decode($this->request($api, $this->text_fotmat($text)));
        if($result instanceof stdClass and !empty($result->status) and !empty($result->message)){
            throw new Exception($result->message,$result->status);
        }
        return $result;
    }


    /**
     * 提取关键词
     * @param type $text 待处理文本
     * @param type $top_k
     * @return string
     */
    public function get_keywords($text,$top_k='100'){
        if(empty($text)){return '';}
        $api = $this->api_keyword."?top_k=$top_k";
        $result = json_decode($this->request($api, $this->text_fotmat($text)));
        if($result instanceof stdClass and !empty($result->status) and !empty($result->message)){
            throw new Exception($result->message,$result->status);
        }
        return $result;
    }


    /**
     * 提取文章摘要
     * @param $text 文章正文
     * @param string $title 文章标题
     * @param string $percentage 最大字数 0~1之间小数表示摘要跟正文的比例  1以上表示摘要的具体字数
     * @param string $not_exceed 严格字数限制 0-字数可能大于限制以确保句子完整, 开启-摘要字数小于等于字数限制
     */
    public function get_depict($text,$title='',$percentage='100',$not_exceed='0'){
        if(empty($text)){return '';}
        $api = $this->api_depict."?percentage=$percentage&not_exceed=$not_exceed";
        $data = array(
            'title' => $title,
            'content' => str_replace('&nbsp;',' ',htmlspecialchars_decode(strip_tags($text)))
        );
        $result = $this->request($api,json_encode($data));
        if($result instanceof stdClass and !empty($result->status) and !empty($result->message)){
            throw new Exception($result->message,$result->status);
        }
        return $result;
    }


    //整理格式化输入文本
    private function text_fotmat($text){
        if(empty($text)){return ''; }
        $text = htmlspecialchars_decode($text);
        $text = str_replace('&nbsp;',' ',$text);
        $text = strtr($text, array('"'=>''));
        return '"'.strip_tags($text).'"';
    }


    //发送一个post请求
    private function request($api,$data=''){
        !empty($data) && is_array($data) && $data = http_build_query($data);
        !empty($data) && is_string($data) && $data = trim($data);
        if(curl_setopt_array($this->curl, array(
                CURLOPT_URL => $api,
                CURLOPT_HTTPHEADER => array(
                    "X-Token:$this->token",
                    'Content-Type: application/json',
                    'Accept:application/json'
                ),
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => '3'
            ))===true){
            $result = curl_exec($this->curl);
            if(curl_errno($this->curl)){
                throw new Exception(curl_error($this->curl));
            }
            return $result;
        }
        return false;
    }

}