<script>
    $(".baoming").on('click',function (e) {
        $.post('/api/baoming',{'tid' : $(this).attr('data-tid')},function(result){
            alert(result);
//            if(result==='报名成功'){
//                $('.modal').hide();
//            }
        },'html')
    });
</script>