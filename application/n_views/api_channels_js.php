<script>

    $(document).ready(function () {

        var user_type = '<?php echo $user_type;  ?>';
        var is_mobile = '<?php echo $this->session->userdata("is_mobile");  ?>';
        if (user_type == "Admin") {
            $('.social_media_tag .action_tag').off('click');
            $('.social_media_tag .action_tag').css('cursor', 'pointer');
            $('.social_media_tag .action_tag').removeAttr('target href');
        }

        if (is_mobile == '1') {
            $('.social_media_tag .wizard-icons').css('display', 'block');
        }

        $(".social_media_tag").on({
            mouseenter: function () {
                var div = $(this).attr('div_count');
                var div_show = $('.actions' + div);
                $(div_show).show();
            },
            mouseleave: function () {
                var div = $(this).attr('div_count');
                var div_show = $('.actions' + div);
                $(div_show).hide();
            }
        });

        $(document).on('click', '.list-group-item', function (event) {
            event.preventDefault();
            $(".list-group-item").removeClass('active');
            $(this).addClass('active');
            var data_href = $(this).attr("href");
            $('html, body').animate({
                scrollTop: ($(data_href).offset().top)
            }, 1000);
        });
    });
</script>