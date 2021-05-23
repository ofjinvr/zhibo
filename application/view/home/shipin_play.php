<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$info['title']?></title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/zbym.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
</head>
<body>
<div class="container">
    <div id="play_1" style="width: 100%; height: 100%; background: #000;"></div>
    <script>
        new Clappr.Player({
            source: "<?= $info['stream']?>",
            parentId: "#play_1",
            mute: true,
            autoPlay:true,
            disableVideoTagContextMenu:true
        });
    </script>
</div>
<script>
    $(function(){
        $('#play_1>div').css({
            width:'100%',
            height:'100%'
        })
    })
</script>
</body>
</html>