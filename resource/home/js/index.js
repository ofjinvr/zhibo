$(document).ready(function () {
        var index = 0;
        var slideFlag = true;
        var length = $(".roll-news-image img").length;

        function showImg(i) {
            $(".roll-news-image img")
                .eq(i).stop(true, true).fadeIn(800)
                .siblings("img").hide();

            $(".roll-news-index li").removeClass("roll-news-index-hover");
            $(".roll-news-index li").eq(i).addClass("roll-news-index-hover");

            $(".roll-news-title a")
                .eq(i).stop(true, true).fadeIn(800)
                .siblings("a").hide();
        }
        showImg(index);

        $(".roll-news-index li").click(function () {
            index = $(".roll-news-index li").index(this);
            showImg(index);
            slideFlag = false;
        });

        function autoSlide() {
            setInterval(function () {
                if (slideFlag) {
                    showImg((index + 1) % length);
                    index = (index + 1) % length;
                }
                slideFlag = true;
            }, 3000);
        }

        autoSlide();
    //头部导航
    // $('.navTop li').on('mouseover',function (e) {
    //     $('.navTop .active').removeClass('active')
    //     $(this).addClass('active')
    // })
    //detail
    // $('.category1 ul li').on('mouseover',function (e) {
    //     $('.category1 ul li.active').removeClass('active')
    //     $(this).addClass('active')
    // })
    // $('.category2 ul li').on('mouseover',function (e) {
    //     $('.category2 ul li.active').removeClass('active')
    //     $(this).addClass('active')
    // })
    // $('.category3 ul li').on('mouseover',function (e) {
    //     $('.category3 ul li.active').removeClass('active')
    //     $(this).addClass('active')
    // })
});

