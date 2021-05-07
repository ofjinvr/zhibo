<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>关于学堂</title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/index.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<?php include 'header.php';?>
<section>
    <div class="sectionMain" style="min-height: 500px;">
        <h1 style="text-align: center;"><?=$info['title']?></h1>
        <br>
        <article>
            <?=$info['content']?>
        </article>
    </div>
    <?php include 'footer.php';?>
</section>
</body>
</html>