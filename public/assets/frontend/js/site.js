$(document).ready(function($){
    SITE.menuHead();
    SITE.backTop();
    SITE.contact();
    SITE.contactPopup();
    SITE.trainingPopup();
    SITE.btnSendTrainingNote();
    SITE.commentSubmit();
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
    contact: function () {
        $('#submitContact').click(function () {
            var valid = true;
            if ($('#txtName').val() == '') {
                $('#txtName').addClass('error');
                valid = false;
            } else {
                $('#txtName').removeClass('error');
            }
            /*
            //Check mail
            if ($('#txtMail').val() == '') {
                $('#txtMail').addClass('error');
                valid = false;
            } else {
                var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                var mail = $('#txtMail').val();
                if (regex.test(mail)) {
                    $('#txtMail').removeClass('error');
                } else {
                    $('#txtMail').addClass('error');
                    valid = false;
                }
            }
            */

            if (valid == false) {
                return false;
            }
            return valid;
        });
    },
    contactPopup:function(){
        $('.submitContact').click(function(){
            var valid = true;
            if ($('.txtName').val() == '') {
                $('.txtName').addClass('error');
                valid = false;
            } else {
                $('.txtName').removeClass('error');
            }

            if ($('.txtMobile').val() == '') {
                $('.txtMobile').addClass('error');
                valid = false;
            } else {
                var regex = /^[0-9-+]+(\d{9,10})$/;
                var phone = $('.txtMobile').val();
                if (regex.test(phone)) {
                    $('.txtMobile').removeClass('error');
                } else {
                    $('.txtMobile').addClass('error');
                    valid = false;
                }
            }
            /*
            if ($('.txtMail').val() == '') {
                $('.txtMail').addClass('error');
                valid = false;
            } else {
                var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                var mail = $('.txtMail').val();
                if (regex.test(mail)) {
                    $('.txtMail').removeClass('error');
                } else {
                    $('.txtMail').addClass('error');
                    valid = false;
                }
            }
            */

            if (valid == false) {
                return false;
            }
            return valid;
        });
    },
    btnClickSupport:function(){
        $('.box-reg-click-book').click(function(){
            $('.sys-popup-support').modal('show');
        });
    },
    btnClickTraining:function(){
        $('.course-register').click(function(){
            $('.sys-popup-training').modal('show');
        });
    },
    trainingPopup:function(){
        $('.submitTraining').click(function(){
            var valid = true;
            if ($('.txtNameTraining').val() == '') {
                $('.txtNameTraining').addClass('error');
                valid = false;
            } else {
                $('.txtName').removeClass('error');
            }

            if ($('.txtMobileTraining').val() == '') {
                $('.txtMobileTraining').addClass('error');
                valid = false;
            } else {
                var regex = /^[0-9-+]+(\d{9,10})$/;
                var phone = $('.txtMobileTraining').val();
                if (regex.test(phone)) {
                    $('.txtMobileTraining').removeClass('error');
                } else {
                    $('.txtMobileTraining').addClass('error');
                    valid = false;
                }
            }
            /*
            if ($('.txtMailTraining').val() == '') {
                $('.txtMailTraining').addClass('error');
                valid = false;
            } else {
                var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                var mail = $('.txtMailTraining').val();
                if (regex.test(mail)) {
                    $('.txtMailTraining').removeClass('error');
                } else {
                    $('.txtMailTraining').addClass('error');
                    valid = false;
                }
            }
            */

            if (valid == false) {
                return false;
            }
            return valid;
        });
    },
    btnSendTrainingNote:function(){
        $('.btnSendTrainingNote').click(function(){
            var valid = true;
            if ($('.name').val() == '') {
                $('.name').addClass('error');
                valid = false;
            } else {
                $('.name').removeClass('error');
            }
            if ($('.phone').val() == '') {
                $('.phone').addClass('error');
                valid = false;
            } else {
                var regex = /^[0-9-+]+(\d{9,10})$/;
                var phone = $('.phone').val();
                if (regex.test(phone)) {
                    $('.phone').removeClass('error');
                } else {
                    $('.phone').addClass('error');
                    valid = false;
                }
            }

            if (valid == false) {
                return false;
            }
            return valid;
        });
    },
    commentSubmit:function (){
        $('#comment_submit').unbind('click').click(function (){
            var url = BASE_URL + 'binh-luan';
            var comment = $('#comment_details').val();
            var name = $('#comment_name').val();
            var email = $('#comment_email').val();
            var web = $('#comment_web').val();
            var statics_id = $('#statics_id').val();
            var _token = jQuery('input[name="_token"]').val();
            jConfirm('Bạn có muốn đánh giá không [OK]:Đồng ý [Cancel]:Bỏ qua ?', 'Xác nhận', function (r) {
                if (r) {
                    jQuery.ajax({
                        type: "POST",
                        url: url,
                        data: {statics_id: statics_id ,comment : comment , name:name , email:email,web:web, _token: _token},
                        success: function (data) {
                            html.append(data);
                            $('#comment_details').val('');
                            $('#comment_name').val('');
                            $('#comment_email').val('');
                            $('#comment_web').val('');
                        },
                        error: function (data) {
                            alert('khong the bình luận');
                        }
                    })
                }
            })
        })
    }
}