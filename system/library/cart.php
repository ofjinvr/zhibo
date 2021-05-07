<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 购物车类
// +-----------------------

class Cart{
    //购物车使用的SESSION键值名称
    protected $session_key;
    
    
    public function __construct($cartkey='cartlist') {
        if(!isset($_SESSION)){
            session_start();
        }
        if(empty($cartkey) || !is_string($cartkey)){
            throw new Exception('购物车初始化键名失败,必须为一个字符串');
        }
        $this->session_key = $cartkey;
        if(empty($_SESSION[$this->session_key]) || !is_array($_SESSION[$this->session_key])){
            $_SESSION[$this->session_key] = array();
        }
    }
    
    
    /**
     * 将一个商品加入购物车
     * @param Array $goods 商品数组
     * 
     * 该数组必须包含以下几个键值:
     * id         商品ID
     * name       商品名称
     * price      商品价格
     * amount     商品数量
     * options    商品属性[可选]
     * 拥有一个保留字作为键值:
     * subtotal  商品小计
     * @return mixed 成功-返回商品绝对id 失败-返回FALSE 
     */
    public function append($goods){
        if(!is_array($goods)){
            trigger_error('购物车商品添加失败,商品数据有误',E_USER_NOTICE);
            return false;
        }
        //去除保留字
        if(isset($goods['subtotal'])){
            unset($goods['subtotal']);
        }
        if($this->goods_check($goods)===false){
            trigger_error('购物车商品添加失败,商品格式有误',E_USER_NOTICE);
            return false;
        }
        if(empty($goods['options']) || !is_array($goods['options'])){
            $goods['options'] = array();
        }
        $absid = $this->absid($goods);
        $goods['subtotal'] = $goods['price'] * $goods['amount'];
        //如果当前添加的商品在购物车中已经存在,则增加相应的商品个数并更新小计数
        if(array_key_exists($absid,$_SESSION[$this->session_key])){
            $_SESSION[$this->session_key][$absid]['amount'] += $goods['amount'];
            $this->count_subtotal($absid);
        }else{
            $_SESSION[$this->session_key][$absid]=$goods;
        }
        return $absid;
    }
    
    
    /**
     * 批量添加到购物车
     * @param array $goods 多商品列表
     * @return int 成功加入到购物车的数量
     */
    public function append_more($container){
        if(!is_array($container)){
            trigger_error('购物车商品添加失败,商品数据有误',E_USER_NOTICE);
            return false;
        }
        foreach($container as $key => $goods){
            if(($absid=$this->append($goods))!==false){
                $suc_amount[$key] = $absid;
            }
        }
        return $suc_amount;
    }
    
    
    /**
     * 根据绝对ID删除商品
     * @param string $absid 商品的绝对ID,可以通过absid()方法获得
     */
    public function remove($absid){
        if(array_key_exists($absid,$_SESSION[$this->session_key])){
            unset($_SESSION[$this->session_key][$absid]);
            return true;
        }
        return false;
    }
    
    
    /**
     * 返回购物车清单
     * @return array 购物车清单
     */
    public function cartlist(){
        $cartlist = $_SESSION[$this->session_key];
        $total_price = 0;
        foreach ($cartlist as $goods){
            $total_price += $goods['subtotal'];
        }
        $cartlist['total_price'] = $total_price;
        return $cartlist;
    }
    
    
    /**
     * 设置商品数量
     * @parse string $absid 绝对ID
     * @parse int $amount 数量
     * @return void
     */
    public function set_amount($absid,$amount){
        if(isset($_SESSION[$this->session_key][$absid]['amount']) && 
                is_numeric($amount) && $amount>0 && strpos($amount,'.')===false){
            $_SESSION[$this->session_key][$absid]['amount'] = $amount;
            $this->count_subtotal($absid);
        }
    }
    
    
    /**
     * 商品数量增一
     * @parse string $absid 绝对ID
     * @return void
     */
    public function inc($absid){
        if(!empty($_SESSION[$this->session_key][$absid]['amount'])){
            $_SESSION[$this->session_key][$absid]['amount'] += 1;
            $this->count_subtotal($absid);
        }
    }
    
    
    /**
     * 商品数量减一
     * @parse string $absid 绝对ID
     * @return void
     */
    public function dec($absid){
        if(!empty($_SESSION[$this->session_key][$absid]['amount'])){
            $_SESSION[$this->session_key][$absid]['amount'] -= 1;
            $this->count_subtotal($absid);
        }
    }
    
    
    /**
     * 清空购物车
     * @return void
     */
    public function clear(){
        $_SESSION[$this->session_key] = array();
    }
    
    
    /**
     * 计算商品的绝对ID
     * @param string $id 商品ID
     * @param string $name 商品名称
     * @param string $price 商品价格
     * @param array $options 商品选项
     */
    public function absid($goods){
        foreach($goods as $key => $value){
            $$key = $value;
        }
        $options = http_build_query($options);
        return md5($id.$name.$price.$options);
    }
    
    
    /**
     * 商品数据格式合法性检测
     * @param array $goods
     * @return bool 商品数据合法性
     */
    public function goods_check($goods){
        //检查数组的有效性
        $check_ary = array('id','name','price','amount');
        foreach($check_ary as $key){
            if(!array_key_exists($key,$goods) || empty($goods[$key])){
                return false;
            }
        }
        return true;
    }
    
    
    /**
     * 计算商品小计
     * @parse string $absid 绝对ID
     * @return void
     */
    protected function count_subtotal($absid){
        $_SESSION[$this->session_key][$absid]['subtotal'] = $_SESSION[$this->session_key][$absid]['price'] * $_SESSION[$this->session_key][$absid]['amount'];
    }
    
}