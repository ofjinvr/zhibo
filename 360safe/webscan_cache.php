<?php
//�û�Ψһkey
//www : c30cb0f0a8af7ee85973e29b88b58ff1
//xa  : 817f660443c44757f44e4675d5ad7aaf
//cs  : d1d41551c3db6613d22de2e1ffc5f72f
//wh  : 91cee5bceca3bedc4671aa89cdadbad6
//zz  : a05ffcaab19ab459b7a0b64186750d0f
switch($_SERVER['HTTP_HOST']){
    case 'xa.taoding.cn': define('WEBSCAN_U_KEY', '817f660443c44757f44e4675d5ad7aaf'); break;
    case 'zz.taoding.cn': define('WEBSCAN_U_KEY', 'a05ffcaab19ab459b7a0b64186750d0f'); break;
    case 'wh.taoding.cn': define('WEBSCAN_U_KEY', '91cee5bceca3bedc4671aa89cdadbad6'); break;
    case 'cs.taoding.cn': define('WEBSCAN_U_KEY', 'd1d41551c3db6613d22de2e1ffc5f72f'); break;
    default : define('WEBSCAN_U_KEY', 'c30cb0f0a8af7ee85973e29b88b58ff1'); break;
}
//���ݻص�ͳ�Ƶ�ַ
define('WEBSCAN_API_LOG', 'http://safe.webscan.360.cn/papi/log/?key='.WEBSCAN_U_KEY);
//�汾���µ�ַ
define('WEBSCAN_UPDATE_FILE','http://safe.webscan.360.cn/papi/update/?key='.WEBSCAN_U_KEY);
//���ؿ���(1Ϊ������0�ر�)
$webscan_switch=1;
//�ύ��ʽ����(1��������,0�ر�����,post,get,cookie,referreѡ����Ҫ���صķ�ʽ)
$webscan_post=1;
$webscan_get=1;
$webscan_cookie=1;
$webscan_referre=1;
//��̨������,��̨��������������,���"|"����������Ŀ¼����Ĭ������ַ�� admin  /dede/ ����
$webscan_white_directory='manage'; 
//url������,�����Զ������url������,Ĭ���Ƕ�phpcms�ĺ�̨url����
//д��������phpcms ��̨����url index.php?m=admin php168�������ύ����post.php?job=postnew&step=post ,dedecms �ռ�����edit_space_info.php
$webscan_white_url = array('index.php' => 'm=admin','post.php' => 'job=postnew&step=post','edit_space_info.php'=>'');
?>