<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Seo extends Fetch{
    
    protected $actb = 'td_category';
    protected $atb = 'td_article';
    protected $sctb = 'td_service_cate';
    protected $stb = 'td_service';
    protected $logtb = 'td_pushurl_log';
    protected $city;
    
    
    public function __construct() {
        parent::__construct();
        //检查是否登录
        $this->load->func('check_manager_logined');
        check_manager_logined();
        
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('varcheck');
        $this->load->model('public_model');
        $this->load->library('request');
        $this->request->set_user_opts([
            CURLOPT_HTTPHEADER => [
                'Cache-Control: No-Cache',
                'Connection: close'
            ]
        ]);
        $this->city = $this->public_model->get('td_city');
        array_unshift($this->city,['city_id'=>'0','city_name'=>'全国','city_site'=>'www.taoding.cn']);
    }
    
    
//    public function test(){
//        foreach($this->city as $city){
//            $cid_ary = $this->public_model->get($this->sctb,'scid,url_word');
//            $this->load->model('recursion_model',[
//                'table' => $this->sctb,
//                'idname' => 'scid',
//                'pidname' => 'pscid'
//            ]);
//            foreach($cid_ary as $row){
//                $in = array_column($this->recursion_model->descendant($row['scid']),'scid');
//                array_unshift($in,$row['scid']);
//                $in = "'".implode("','",$in)."'";
//                $id_count = $this->public_model->get_count($this->stb,"scid in ($in) and city_id='{$city['city_id']}'");
//                $page_count = ceil($id_count/15); //每页15个，算一共多少页
//                for($i=1;$i<=$page_count;$i++){
//                    $xml1[$i===1?"http://{$city['city_site']}/service/lists/{$row['scid']}":"http://{$city['city_site']}/service/lists/{$row['scid']}?page=$i"] = $i===1?"http://{$city['city_site']}/service/{$row['url_word']}/":"http://{$city['city_site']}/service/{$row['url_word']}/?page=$i";
//                }
//            }
//            //查询服务详情页
//            $id_ary = $this->public_model->get("$this->stb left join $this->sctb on $this->stb.scid=$this->sctb.scid",'sid,url_word',"city_id='{$city['city_id']}'");
//            foreach($id_ary as $row){
//                $xml1["http://{$city['city_site']}/service/content/{$row['sid']}"] = "http://{$city['city_site']}/service/{$row['url_word']}/{$row['sid']}.html";
//            }
//        }
//        foreach ($xml1 as $k=> $row){
//            echo "$k $row\n";
//        }
//    }
    
    
    
    public function sitemap($act=null){
        check_manager_rights(__METHOD__);
        //sitemap/xa.taoding.cn.xml
        if($act==='action'){
            set_time_limit(0);
            if(!is_dir(LOCAL_ROOT.'sitemap')){
                mkdir(LOCAL_ROOT.'sitemap',0755);
            }
            $now = date('Y-m-d');
            foreach($this->city as $city){
                //初始化当前城市的文件名和文件内容
                $filename = LOCAL_ROOT.'sitemap/'. substr($city['city_site'],0,strpos($city['city_site'],'.')).'.xml';
                $content = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<urlset>'.PHP_EOL.'#REPLACE#'.PHP_EOL.'</urlset>';
                $xml = [];
                //首页/城市首页
                $xml[] = "<url>"
                        ."<loc>http://{$city['city_site']}</loc>"
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>daily</changefreq>"
                        ."<priority>1.0</priority>"
                        ."</url>";
                //查询服务栏目页
                $cid_ary = $this->public_model->get($this->sctb,'scid,url_word');
                $this->load->model('recursion_model',[
                    'table' => $this->sctb,
                    'idname' => 'scid',
                    'pidname' => 'pscid'
                ]);
                foreach($cid_ary as $row){
                    $xml[] = "<url>"
                        ."<loc>http://{$city['city_site']}/faq/c_{$row['scid']}.html</loc>"
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>weekly</changefreq>"
                        ."<priority>0.8</priority>"
                        ."</url>";
                    $in = array_column($this->recursion_model->descendant($row['scid']),'scid');
                    array_unshift($in,$row['scid']);
                    $in = "'".implode("','",$in)."'";
                    $id_count = $this->public_model->get_count($this->stb,"scid in ($in) and city_id='{$city['city_id']}'");
                    $page_count = ceil($id_count/15); //每页15个，算一共多少页
                    for($i=1;$i<=$page_count;$i++){
                        $xml[] = "<url>"
                        .($i===1?"<loc>http://{$city['city_site']}/service/{$row['url_word']}/</loc>":"<loc>http://{$city['city_site']}/service/{$row['url_word']}/?page=$i</loc>")
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>weekly</changefreq>"
                        ."<priority>0.8</priority>"
                        ."</url>";
                    }
                }
                //查询服务详情页
                $id_ary = $this->public_model->get("$this->stb left join $this->sctb on $this->stb.scid=$this->sctb.scid",'sid,url_word',"city_id='{$city['city_id']}'");
                foreach($id_ary as $row){
                    $xml[] = "<url>"
                        ."<loc>http://{$city['city_site']}/service/{$row['url_word']}/{$row['sid']}.html</loc>"
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>monthly</changefreq>"
                        ."<priority>0.6</priority>"
                        ."</url>";
                    $xml[] = "<url>"
                        ."<loc>http://{$city['city_site']}/faq/s_{$row['sid']}.html</loc>"
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>monthly</changefreq>"
                        ."<priority>0.6</priority>"
                        ."</url>";    
                }
                
                //查询文章栏目页
                $cid_ary = $this->public_model->get($this->actb,'cid,url_word');
                foreach($cid_ary as $cate){
                    $id_count = $this->public_model->get_count($this->atb,"cid='{$cate['cid']}' and city_id='{$city['city_id']}'");
                    $page_count = ceil($id_count/10); //每页10个
                    for($i=1;$i<=$page_count;$i++){
                        $xml[] = "<url>"
                        .($i===1?"<loc>http://{$city['city_site']}/{$cate['url_word']}.html</loc>":"<loc>http://{$city['city_site']}/{$cate['url_word']}.html?page=$i</loc>")
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>weekly</changefreq>"
                        ."<priority>0.8</priority>"
                        ."</url>";
                    }
                }
                //查询文章详情页
                $id_ary = $this->public_model->get("$this->atb left join $this->actb on $this->actb.cid=$this->atb.cid",'aid,url_word',"city_id='{$city['city_id']}'");
                foreach($id_ary as $art){
                    $xml[] = "<url>"
                        ."<loc>http://{$city['city_site']}/{$art['url_word']}/{$art['aid']}.html</loc>"
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>monthly</changefreq>"
                        ."<priority>0.6</priority>"
                        ."</url>";
                }
                //查询TAG标签页面
                $id_ary = $this->public_model->get("td_words",'id',"city_id='{$city['city_id']}'");
                foreach($id_ary as $id){
                    $xml[] = "<url>"
                        ."<loc>http://{$city['city_site']}/tag/{$id['id']}.html</loc>"
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>monthly</changefreq>"
                        ."<priority>0.6</priority>"
                        ."</url>";
                }
                //查询FAQ页面
                $id_ary = $this->public_model->get("td_service_question left join td_service on td_service.sid=td_service_question.sid",'sqid',"city_id='{$city['city_id']}'");
                foreach($id_ary as $id){
                    $xml[] = "<url>"
                        ."<loc>http://{$city['city_site']}/faq/{$id['sqid']}.html</loc>"
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>monthly</changefreq>"
                        ."<priority>0.6</priority>"
                        ."</url>";
                }
                //其他页
                $other = [
                    'faq/',
                    'tag/',
                    'index/brief',
                    'index/contact',
                    'index/join',
                    'index/complaint',
                    'index/network',
                    'index/collaborate',
                    'index/matter',
                    'index/serve',
                    'xinhu/zcgs',
                    'xinhu/dljz',
                    'xinhu/dbzz',
                    'xinhu/cqzc',
                    'xinhu/szhy'
                ];
                foreach($other as $path){
                    $xml[] = "<url>"
                        ."<loc>http://{$city['city_site']}/$path</loc>"
                        ."<lastmod>$now</lastmod>"
                        ."<changefreq>monthly</changefreq>"
                        ."<priority>0.6</priority>"
                        ."</url>";
                }
                $content = str_replace('#REPLACE#', implode(PHP_EOL,$xml), $content);
                file_put_contents($filename, $content);
            }
            skip_true('操作完成');
        }
        $this->load->view('manage/seo_create_sitemap');
    }
    
    
    public function push_url($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            set_time_limit(0);
            $post = $this->input->post(null,true);
            if(empty($post['push_var']) or !in_array($post['push_var'],['1','2'])){
                skip_false('参数有误');
            }
            $api_params['token'] = '8atbaNF9ocifQQ7n';
            $api_params['type'] = !empty($post['original']) ? 'original' : '';
            foreach($this->city as $city){
                if($city['city_id']===$post['city_id']){
                    $api_params['site'] = $city['city_site'];
                    break;
                }
            }
            $this->load->library('submit_url2baidu',$api_params['token'],$api_params['site'],$api_params['type']);
            $urls = [];
            //所有链接
            if($post['push_var']==='1'){
                $urls = $this->get_urls($city);
            }
            //自定义
            if($post['push_var']==='2'){
                $urls = array_filter(explode(PHP_EOL,$post['curlist']),function($row){
                    return !empty(trim($row)) ? true : false;
                });
            }
            $result = $this->submit_url2baidu->submit($urls);
            if(!empty($result['error']) and !empty($result['message'])){
                foreach($urls as $url){
                    $this->setLogs($url,strtoupper($result['message']));
                }
                skip_false("推送失败:{$result['message']} 【错误码:{$result['error']}】");
            }

            $not_same_site_count = 0;
            $not_valid_count = 0;
            if(!empty($result['not_same_site'])){
                foreach($result['not_same_site'] as $row){
                    $this->setLogs($row,'NOT_SAME_SITE');
                }
                $urls = array_diff($urls,$result['not_same_site']);
                $not_same_site_count = count($result['not_same_site']);
            }
            if(!empty($result['not_valid'])){
                foreach($result['not_valid'] as $row){
                    $this->setLogs($row,'NOT_VALID');
                }
                $urls = array_diff($urls,$result['not_valid']);
                $not_valid_count = count($result['not_valid']);
            }
            foreach($urls as $url){
                $this->setLogs($url,'SUCCESS');
            }
            skip_true("推送成功了{$result['success']}条URL; 当日剩余量{$result['remain']}条; 不在同一域名被拒绝{$not_same_site_count}条; 未经验证被拒绝的域名{$not_valid_count}条");
        }
        $data['city'] = $this->city;
        $this->load->library('paging',30,$this->public_model->get_count($this->logtb));
        $data['page'] = $this->paging->info();
        $data['list'] = $this->public_model->get($this->logtb,'*',null,'push_date desc',$data['page']['cursor']);
        $this->load->view('manage/seo_push_url',$data);
    }
    
    
    protected function setLogs($url,$status){
        return $this->public_model->add($this->logtb,[
            'url' => $url,
            'push_status' => $status
        ]);
    }
    
    
    //获取网站所有链接URL 传入一个城市信息数组
    protected function get_urls(array $city){
        //首页
        $urls[] = "http://{$city['city_site']}";
        //服务栏目带分页
        $cid_ary = $this->public_model->get($this->sctb,'scid,url_word');
        $this->load->model('recursion_model',[
            'table' => $this->sctb,
            'idname' => 'scid',
            'pidname' => 'pscid'
        ]);
        foreach($cid_ary as $row){
            $in = array_column($this->recursion_model->descendant($row['scid']),'scid');
            array_unshift($in,$row['scid']);
            $in = "'".implode("','",$in)."'";
            $id_count = $this->public_model->get_count($this->stb,"scid in ($in) and city_id='{$city['city_id']}'");
            $page_count = ceil($id_count/15); //每页15个，算一共多少页
            for($i=1;$i<=$page_count;$i++){
                $urls[] = $i===1?"http://{$city['city_site']}/service/{$row['url_word']}/":"http://{$city['city_site']}/service/{$row['url_word']}/?page=$i";
            }
        }
        //服务详情页
        $id_ary = $this->public_model->get("$this->stb left join $this->sctb on $this->sctb.scid=$this->stb.scid",'sid,url_word',"city_id='{$city['city_id']}'");
        foreach($id_ary as $row){
            $urls[] = "http://{$city['city_site']}/service/{$row['url_word']}/{$row['sid']}.html";
        }
        //查询文章栏目页
        $cid_ary = $this->public_model->get($this->actb,'cid,url_word');
        foreach($cid_ary as $cate){
            $id_count = $this->public_model->get_count($this->atb,"cid='{$cate['cid']}' and city_id='{$city['city_id']}'");
            $page_count = ceil($id_count/10); //每页10个
            for($i=1;$i<=$page_count;$i++){
                $urls[] = $i===1?"http://{$city['city_site']}/{$cate['url_word']}.html":"http://{$city['city_site']}/{$cate['url_word']}.html?page=$i";
            }
        }
        //查询文章详情页
        $id_ary = $this->public_model->get("$this->atb left join $this->actb on $this->actb.cid=$this->atb.cid",'aid,url_word',"city_id='{$city['city_id']}'");
        foreach($id_ary as $art){
            $urls[] = "http://{$city['city_site']}/{$art['url_word']}/{$art['aid']}.html";
        }
        //其他页
        $other = [
            'index/brief',
            'index/contact',
            'index/join',
            'index/complaint',
            'index/network',
            'index/collaborate',
            'index/matter',
            'index/serve',
            'xinhu/zcgs',
            'xinhu/dljz',
            'xinhu/dbzz',
            'xinhu/cqzc',
            'xinhu/szhy'
        ];
        foreach($other as $path){
            $urls[] = "http://{$city['city_site']}/$path";
        }
        return $urls;
    }
    
    
    public function thirdjs(){
        check_manager_rights(__METHOD__);
        $this->load->library('paging',15,$this->public_model->get_count('td_thirdjs'));
        $data['page'] = $this->paging->html();
        $data['pageinfo'] = $this->paging->info(4);
        $data['list'] = $this->public_model->get('td_thirdjs left join td_city on td_city.city_id=td_thirdjs.city_id','*',null,'jsid desc',$data['pageinfo']['cursor']);
        
        $this->load->view('manage/thirdjs_list',$data);
    }
    
    
    public function add_thirdjs($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $post = $this->input->post();
            $post['code'] = addslashes(base64_decode($post['code']));
            if($this->public_model->add('td_thirdjs',$post)===false){
                skip_false('系统繁忙,请稍候重试');
            }
            skip_true('成功保存一段JS');
        }
        $data['citys'] = $this->public_model->get('td_city');
        $this->load->view('manage/thirdjs_add',$data);
    }
    
    
    public function edit_thirdjs($jsid=null,$act=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($jsid) or !$this->public_model->in_table('td_thirdjs','jsid',$jsid)){
            skip_false('JS不存在');
        }
        if($act==='action'){
            $post = $this->input->post();
            $post['code'] = addslashes(base64_decode($post['code']));
            if($this->public_model->edit('td_thirdjs',$post,"jsid='$jsid'")===false){
                skip_false('系统繁忙,请稍候重试');
            }
            skip_true('成功保存');
        }
        $data = $this->public_model->one('td_thirdjs','*',"jsid='$jsid'");
        $data['citys'] = $this->public_model->get('td_city');
        //print_r($data);
        $this->load->view('manage/thirdjs_edit',$data);
    }
    
    
    public function del_thirdjs($jsid=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($jsid) or !$this->public_model->in_table('td_thirdjs','jsid',$jsid)){
            skip_false('JS不存在');
        }
        $this->public_model->delete('td_thirdjs',"jsid='$jsid'");
        skip_true('已删除');
    }
}