$(document).ready(function($){
    SITE.showSub();
});

SITE={
    showSub:function(){
        $('.tablinks ').click(function () {
            var data = $(this).attr('data');
            $('.blog-box').removeClass('active');
            $('.blog-box'+data).addClass('active');
        });
    },
}