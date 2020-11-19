$(document).ready(function($){
    SITE.dmtop();
});

SITE={
    dmtop:function () {
        if ($('.dmtop').length > 0){
            $(window).scroll(function(){
                var e = $(window).scrollTop();
                if (e > 300){
                    $('.dmtop').css({bottom: "25px"});
                }
                else{
                    $('.dmtop').css({bottom: "-100px"});
                }
            });
            $('.dmtop').click(function () {
                $('body,html').animate({
                    scrollTop: "0px"
                },800)
                return false
            })
        }
    }
}