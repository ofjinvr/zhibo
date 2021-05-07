<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 分页类
// +-----------------------
class Paging{
    //列表总条数
    protected $amount_all;
    //每页条数
    protected $amount;
    //分页标识
    protected $mark;
    //当前页码
    protected $current;
    //过滤掉分页标识的URL
    protected $url;

    
    /**
     * 初始化分页类
     * @param int $amount 每页展示的数据
     * @param int $amount_all 数据总数
     * @param string $mark 分页GET参数标识
     */
    public function __construct($amount,$amount_all,$mark='page') {
        //获得标识
        if(!empty($mark) && is_string($mark)){
            $this->mark=$mark;
        }else{
            trigger_error('无效的分页标识',E_USER_ERROR);
            return false;
        }
        //设置并检测参数
        if(!$this->amount($amount) || !$this->amount_all($amount_all)){
            trigger_error('无效分页参数,分页数量有误',E_USER_ERROR);
            return false;
        }
        //设置当前页
        $this->current = 1;
        if(!empty($_GET[$this->mark])){
            $current = intval($_GET[$this->mark]);
            if(is_numeric($current) && $current>1 && false===strpos($current,'.')){
                $this->current = intval($current);
            }
        }
        //过滤分页标识的URL
        $this->url = $this->routing_url();
    }
    
    
    /**
     * 获得分页信息数组
     * @param int $paging_num 分页数组单侧的展示数量
     * @return array page_all=>总页码 current=>当前页码 amount_all=>总数 paging=>分页数据数组
     */
    public function info($paging_num=5){
        //单侧展示数量验证
        if(!is_numeric($paging_num) || $paging_num<=0 && false!==strpos($paging_num,'.')){
            trigger_error('分页展示数量有误',E_USER_WARNING);
            return false;
        }
        
        $info = array();
        
        //计算总页码
        ($this->amount_all==='0' or $this->amount_all===0) ? $info['page_amount']=1 : $info['page_amount']=ceil($this->amount_all/$this->amount);
        
        //不超过总数的当前页码
        $this->current>$info['page_amount'] ? $info['current']=$info['page_amount'] : $info['current'] =$this->current;
        //数据总数
        $info['amount_all'] = $this->amount_all;
        //首页
        $info['index_page'] = $this->url.$this->mark.'=1';
        //末页
        $info['end_page'] = $this->url.$this->mark.'='.$info['page_amount'];
        //上一页
        $info['prev_page'] = $this->url.$this->mark.'='.((($info['current']-1)!==0)?$info['current']-1:1);
        //下一页
        $info['next_page'] = $this->url.$this->mark.'='.(($info['current']+1<=$info['page_amount'])?$info['current']+1:$info['current']);
        //查询数据库起始点/终止点
        $info['begin'] = ($info['current']-1)*$this->amount;
        $info['amount'] = $this->amount;
        //可用于查询的SQL语句片段
        $info['cursor'] = $info['begin'].','.$info['amount'];
        $info['limit'] = ' limit '.$info['begin'].','.$info['amount'];
        //展示分页数组
        $info['paging'] = $this->get_paging_array($info['current'],$info['page_amount'],$paging_num);
        //所有页码
        for($i=1;$i<=$info['page_amount'];$i++){
            $info['all_page'][$i]=$this->url.$this->mark.'='.$i;
        }
        return $info;
    }
    
    
    /**
     * 生成一个分页的html
     * @param int $paging_num 分页数组单侧的展示数量
     * @param int $style 风格
     */
    public function html($paging_num=5){
        //单侧展示数量验证
        if(!is_numeric($paging_num) || $paging_num<=0 && false!==strpos($paging_num,'.')){
            trigger_error('分页展示数量有误',E_USER_WARNING);
            return false;
        }
        $info = $this->info($paging_num);
        $pagehtml = '<div class="page">';
        $pagehtml .= '<a title="首页" href="'.$info['index_page'].'">首页</a>';
        $pagehtml .= '<a title="上一页" href="'.$info['prev_page'].'">上一页</a>';
        foreach($info['paging'] as $key=>$value){
            if($key !== $info['current']){
                $pagehtml .= '<a title="第'.$key.'页" href="'.$value.'">'.$key.'</a>';
            }else{
                $pagehtml .= '<span title="第'.$key.'页">'.$key.'</span>';
            }
        }
        $pagehtml .= '<a title="下一页" href="'.$info['next_page'].'">下一页</a>';
        $pagehtml .= '<a title="尾页" href="'.$info['end_page'].'">尾页</a>';
        $pagehtml .= '<select onchange="javascript:window.location.href=this.value">';
        foreach($info['all_page'] as $key=>$value){
            if($key !== $info['current']){
                $pagehtml .= '<option title="第'.$key.'页" value="'.$value.'">第'.$key.'页</option>';
            }else{
                $pagehtml .= '<option title="第'.$key.'页" value="'.$value.'" selected>第'.$key.'页</option>';
            }
        }
        $pagehtml .= '</select></div>';
        return $pagehtml;   
    }
    
    
    /**
     * 设置每页数据数量
     * @param int $amount 每页数据数量
     */
    public function amount($amount){
        if(is_numeric($amount) && $amount>0 && false===strpos($amount,'.')){
            $this->amount=$amount;
            return true;
        }
        return false;
    }
    
    
    /**
     * 设置分页数据的总数
     * @param int $amount_all 分页数据的总数
     */
    public function amount_all($amount_all){
        if(is_numeric($amount_all) && $amount_all>=0 && false===strpos($amount_all,'.')){
            $this->amount_all=$amount_all;
            return true;
        }
        return false;
    }
    
    
    /**
     * 获得展示数组
     * @param int $cur 当前页码
     * @param int $all 总页码
     * @param int $num 单侧展示数量
     */
    protected function get_paging_array($cur,$all,$num){
        $pagelist = array();
        for($i=1;$i<=$all;$i++){
            $pagelist[$i] = $i;
        }
        foreach($pagelist as $key=>$value){
            if($value>$cur+$num || $value<$cur-$num){
                unset($pagelist[$key]);
            }else{
                //将合适的页码替换为链接
                $pagelist[$key] = $this->url.$this->mark.'='.($value);
            }
        }
        return $pagelist;
    }
    
    
    /**
     * 解析URL,返回一个不带分页标识的参数
     * @return string
     */
    protected function routing_url(){
        $gets = array();
        $xss_safe = Safe::get_instance();
        $request_uri = explode('?', $xss_safe->clear_xss(urldecode($_SERVER['REQUEST_URI'])));
        if(isset($request_uri[1])){
            parse_str($request_uri[1],$gets);
        }
        $url = '?';
        foreach($gets as $key => $value){
            if($key===$this->mark or !is_string($value)){
                continue;
            }
            $url .= $key.'='.$value.'&';
        }
        return $url;
    }
}