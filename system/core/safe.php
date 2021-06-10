<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 安全模块
// +-----------------------

class Safe {
    
    static private $ins = null;
    private $rule = null;
    
    private function __construct() {
        $tag = 'script|noscript|iframe|frame|style|html|body|title|link|meta|object';
        $length = strlen($tag);
        $_tag = '';
        for($i=0;$i<$length;$i++){
            $_tag .= $tag{$i}.'\s?';
        }
        $this->rule = array(
            "/<(\/?)($_tag|\\?|%)([^>]*?)>/isU", //过滤标签
            "/(onabort|onchange|onblur|onclick|ondblclick|onerror|onfocus|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onreset|onresize|onselect|onsubmit|onunload)/isU", //匹配标签内on事件
        );
    }
    
    //XSS攻击过滤规则
    public function clear_xss($str) {
        return htmlspecialchars(preg_replace($this->rule, "", $str));
    }
    
    //递归过滤数组
    public function clear_xss_array($array) {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->clear_xss_array($value);
            }
        } else {
            $array = $this->clear_xss($array);
        }
        return $array;
    }
    
    static public function get_instance(){
        if(!self::$ins instanceof self){
            self::$ins = new self;
        }
        return self::$ins;
    } 

}
