<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>管理中心设置</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">查看设置</h1>
    <div class="center">
        <form action="<?php echo site_url('manage/setting/base/index/action');?>" method="post">
        <table class='input'>
            <tr>
                <td class="key">标题</td>
                <td class="value"><input  type="text" name="title" placeholder="网站标题" class='text' value="<?php echo $title;?>"></td>
            </tr>
            <tr>
                <td class="key">关键字</td>
                <td class="value"><input type="text" name="keyword"  placeholder="SEO相关:keywords" class='text' value="<?php echo $keyword;?>"></td>
            </tr>
            <tr>
                <td class="key">网站描述</td>
                <td class="value"><textarea name="description" placeholder="SEO相关:description"><?php echo $description;?></textarea></td>
            </tr>
            <tr>
                <td class="key">400电话</td>
                <td class="value"><input  type="text" name="tel400" class='text' value="<?php echo $tel400;?>"></td>
            </tr>
            <tr>
                <td class="key">固定电话</td>
                <td class="value"><input  type="text" name="tel" class='text' value="<?php echo $tel;?>"></td>
            </tr>
            <tr>
                <td class="key">移动电话</td>
                <td class="value"><input  type="text" name="mobile" class='text' value="<?php echo $mobile;?>"></td>
            </tr>
            <tr>
                <td class="key">QQ号码</td>
                <td class="value"><input  type="text" name="qq" class='text' value="<?php echo $qq;?>"></td>
            </tr>
            <tr>
                <td class="key">地址</td>
                <td class="value"><input  type="text" name="address" class='text' value="<?php echo $address;?>"></td>
            </tr>
            
            <tr>
                <td class="key">HR邮箱</td>
                <td class="value"><input  type="text" name="hremail" class='text' value="<?php echo $hremail;?>"></td>
            </tr>
            <tr>
                <td class="key">HR电话</td>
                <td class="value"><input  type="text" name="hrtel" class='text' value="<?php echo $hrtel;?>"></td>
            </tr>
<!--			<tr>
                <td class="key">投诉渠道</td>
                <td class="value"><textarea name="complaint"><?php echo $complaint;?></textarea><p class="tips">每个渠道之间用换行（回车）隔开</p></td>
            </tr>-->
            <tr>
                <td class="key"></td>
                <td class="value"><input  type="submit" class='button' value="提交"></td>
            </tr>
        </table>
        </form>
    </div>
</body>
</html>