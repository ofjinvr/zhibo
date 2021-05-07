<?php //if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 数据自动验证类
// +-----------------------

class Valid{
    //验证规则
    protected $rule;
    //错误信息
    protected $error;
    //处理的数据
    protected $data;
    /**
     * 初始化自动验证类
     */
    public function __construct() {
        $this->rule = array();
        $this->error = array();
    }
    
    
    /**
     * 验证格式是否正确,如果错误则添加一条错误信息数据
     * @param array 需要验证的数据数组
     * @return bool 验证是否通过
     */
    public function run($data){
        $this->error = array();
        $this->data = $data;
        //遍历规则列表
        foreach ($this->rule as $rules){
            //解析验证规则信息
            $field = $rules['field'];
            $law_array = $rules['law'];
            $msg = $rules['message'];

            //如果字段不存在并且没有设置required规则,则认为字段不存在则不验证
            if(!in_array('required',$law_array) && empty($this->data[$field])){
                continue;
            }
            $field_value = isset($this->data[$field]) ? $this->data[$field] : null;
            //将规则和值进行对比验证
            if($this->valid_rows($field_value,$law_array)!==true){
                $this->add_error($field, $msg);
            }
        }
        //检测验证是否通过
        if(!empty($this->error)){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }
    
    
    /**
     * 应用某一规则进行字段验证
     * @param mixed $value 字段名称的值
     * @param string $law_array 验证的规则数组
     * @return bool
     */
    protected function valid_rows($value,$law_array){
        //遍历并解析规则,验证值
        foreach($law_array as $law){
            //解析规则方法名和方法参数
            $param = strstr($law,'[');
            $law = str_replace($param,'', $law);
            $param = trim($param,'[]');
            //如果本类有验证规则的方法,则进行验证;如果没有则提示
            if(method_exists($this,$law)){
                //区分是否有参数进行规则验证
                if($param===''){
                    if($this->$law($value) !== true): return false; endif;
                }else{
                    if($this->$law($value,$param) !== true): return false; endif;
                }
            }else{
                trigger_error('使用了一个未定义的验证规则 '.$law,E_USER_WARNING);
                return false;
            }
        }
        return true;
    }
    
    
    /**
     * 设置验证规则,字符串
     * @param string $rule 验证规则; 规则格式: 数据名称,提示信息,规则1|规则2|...
     */
    public function set_rule($rule){
        //设置一条规则
        if(!is_string($rule)){
            trigger_error('验证规则参数有误,需要一个字符串');
            return false;
        }
        $rule_array = explode(',',$rule);
        if(count($rule_array)!==3){
            trigger_error('验证规则有误'.$rule);
            return false;
        }
        $law = array(
            'field' => $rule_array[0],
            'message' => $rule_array[1],
            'law' => explode('|',trim($rule_array[2],'|'))
        );
        array_push($this->rule,$law);
    }
    
    
    /**
     * 设置验证规则,数组
     * @param array $rules 验证规则; 规则格式:多个字符串验证规则元素组成的数组
     */
    public function set_rule_array($rules){
        //数组形式设置多条规则
        if(!is_array($rules)){
            trigger_error('验证规则参数有误,需要一个数组');
            return false;
        }
        foreach ($rules as $rule){
            $this->set_rule($rule);
        }

    }
    
    
    /**
     * 清空验证规则
     */
    public function clear_rule(){
        $this->rule = array();
    }
    
    
    /**
     * 添加错误信息
     * @return array
     */
    protected function add_error($field,$msg){
        $info = array(
            'field' => $field,
            'msg' => $msg
        );
        array_push($this->error,$info);
    }
    
    
    /**
     * 获取错误信息
     * @return array
     */
    public function get_error(){
        return $this->error;
    }

    
    /**
     * 验证规则方法-开始
     * 
     * @param mixed $value 验证项的值
     * @param mixed $param 可选,如果是有参数的验证规则,那么验证规则的参数在第二项
     */
    
    //验证是否为空
    public function required($value){
        if(is_null($value) or $value===''){
            return false;
        }
        return true;
    }
    
    //验证是否为数组
    public function isarray($value){
        if(!is_array($value)){
            return false;
        }
        return true;
    }
    
    //验证最小值判断
    public function min($value,$param){
        if(!is_numeric($value) || !is_numeric($param)){
            return false;
        }
        if($value<$param){
            return false;
        }
        return true;
    }
    
    //验证最大值判断
    public function max($value,$param){
        if(!is_numeric($value) || !is_numeric($param)){
            return false;
        }
        if($value>$param){
            return false;
        }
        return true;
    }
    
    //验证最小长度判断
    public function min_length($value,$param){
        $length = 0;
        $param = intval($param);
        if(!is_null($value) && $value!==''){
            $length = $this->multi_strlen($value);
        }
        if($length<$param){
            return false;
        }
        return true;
    }
    
    //验证最大长度判断
    public function max_length($value,$param){
        $length = 0;
        $param = intval($param);
        if(!is_null($value) && $value!==''){
            $length = $this->multi_strlen($value);
        }
        if($length>$param){
            return false;
        }
        return true;
    }
    
    //验证长度相符
    public function length($value,$param){
        $length = 0;
        $param = intval($param);
        if(!is_null($value) && $value!==''){
            $length = $this->multi_strlen($value);
        }
        if($param!==$length){
            return false;
        }
        return true;
    }
    
    //验证是否邮箱判断
    public function email($value){
        $preg_email = '/^[\w]+@[\w]+\.[\w]+$/i';
        if(preg_match($preg_email, $value)===1){
            return true;
        }else{
            return false;
        }
    }
    
    //验证是否为数字
    public function numeric($value){
        if(!is_numeric($value)){
            return false;
        }
        return true;
    }
    
    //验证是否为自然数
    public function natint($value){
        if(!$this->numeric($value) || (strpos($value,'.')!==false) || $value<0){
            return false;
        }
        return true;
    }
    
    //验证是否为手机号码(号段更新 2015/2/4)
    public function mobile($var){
        if(preg_match('/^1[3578][\d]{9}$/',$var)){
            return true;
        }
        return false;
    }
    
    //验证是否为电话号码
    public function telphone($var){
        if(preg_match('/^[0-9\-]+$/',$var)){
            return true;
        }
        return false;
    }
    
    //验证是否在某些枚举的值内,枚举以-号分隔
    public function in($value,$param){
        if(strpos($param,'-') === false){
            return $value==$param;
        }
        $enum = explode('-', trim($param,'-'));
        if(in_array($value,$enum) === false){
            return false;
        }
        return true;
    }
    
    //验证IP格式正确性
    public function ip($value){
        if($value !== trim($value) or strpos($value,'.')===false){
            return false;
        }
        $ip_array = explode('.',$value);
        if(count($ip_array) !== 4){
            return false;
        }
        foreach ($ip_array as $number){
            if($number !== trim($number) or $number !== ltrim($number,'0')){
                return false;
            }
            if(!is_numeric($number) or $number>255 or $number<0 or $number!=intval($number)){
                return false;
            }
        }
        return true;
    }
    
    //验证和某字段值是否相等
    public function equal($value,$param){
        if($value !== $this->data[$param]){
            return false;
        }
        return true;
    }
    
    //验证是否为标准日期格式 yyyy-mm-dd
    public function date($value){
        $ary = array();
        if(preg_match('/^[\d]{4}-([\d]{1,2})-([\d]{1,2})$/',$value,$ary) !== 1){
            return false;
        }
        $month = (int)$ary[1];
        $day = (int)$ary[2];
        if($month===0 || $month>12){return false;}
        if($day===0 || $day>31){return false;}
        return true;
    }
    
    //验证是否为标准时间格式 hh:ii:ss
    public function time($value){
        $ary = array();
        if(preg_match('/^([\d]{1,2})\:([\d]{1,2})\:([\d]{1,2})$/',$value,$ary) !== 1){
            return false;
        }
        $hour = (int)$ary[1];
        $minute = (int)$ary[2];
        $second = (int)$ary[3];
        if($hour>23){return false;}
        if($minute>59){return false;}
        if($second>59){return false;}
        return true;
    }
    
    //验证是否为标准日期时间格式 yyyy-mm-dd hh:ii:ss 
    public function datetime($value){
        $ary = array();
        if(preg_match('/^([\d]{4}-[\d]{1,2}-[\d]{1,2}) ([\d]{1,2}\:[\d]{1,2}\:[\d]{1,2})$/',$value,$ary) !== 1){
            return false;
        }
        if($this->date($ary[1])===true && $this->time($ary[2])===true){
            return true;
        }
        return false;
    }
    
    //验证是否在某表中唯一(如验证用户名是否已注册)
    public function unique($value,$param){
        if(!class_exists('Db')){
            trigger_error("缺少'Db'对象,验证方法unique()访问数据库失败",E_USER_ERROR);
        }
        $db = Db::get_instance();
        $table_info = explode('.',$param);
        $amount = $db->select('count(*) as amount')
                ->from($table_info[0])
                ->where($table_info[1].'=\''.$value.'\'')
                ->query()->row()->amount;
        if($amount !== '0'){
            return false;
        }
        return true;
    }
    
    /**
     * 验证规则方法-结束
     */
    
    private function multi_strlen($string){
        //mb函数库
        if(is_callable('mb_strlen')){
            return mb_strlen($string,'utf-8');
        }
        //mb函数库未开启
        $byte = strlen($string);
        $count = 0;
        for($i=0;$i<$byte;$i++){
            $bin = decbin(ord($string{$i}));
            //不足8位补0
            if(strlen($bin)<8){
                $bin = str_repeat('0',8-strlen($bin)).$bin;
            }
            if(substr($bin,0,2)!=='10'){
                $count++;
            }
        }
        return $count;
    }

}
