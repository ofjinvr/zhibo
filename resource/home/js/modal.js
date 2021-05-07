
 $(".searchButton").on('click',function (e) {
     $('.modal').addClass('activeM')
     if(e.target.innerText == "登陆"){
         $('.accModal').addClass('activeM')
         console.log("登陆")
     }
     else{
         $('.regModal').addClass('activeM')
         console.log("注册")
     }
     // $('.modal').addClass('activeM')
 })
 $('.tRight').on('click',function () {
     $('.modal').removeClass('activeM')
     $('.accModal').removeClass('activeM')
     $('.regModal').removeClass('activeM')
 })