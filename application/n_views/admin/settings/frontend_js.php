<script>
    $("document").ready(function () {
        var val1 = "0";
        var val2 = "0";

        if ($("input[name='display_review_block']").is(':checked')) val1 = '1';
        if ($("input[name='display_video_block']").is(':checked')) val2 = '1';

        // initail situation
        // review block
        if (val1 == '0') {
            $('.allReview').hide();
            $('.review_block').css("min-height", "150px");
        } else {
            $('.review_block').css("min-height", "1266px");
        }

        // video block
        if (val2 == '0') {
            $('.extensions').hide();
            $('.video_block').css("min-height", "150px");
        } else {
            $('.video_block').css("min-height", "1266px");
        }


        $('input[name=display_review_block]').change(function () {
            if ($("input[name='display_review_block']").is(':checked')) {
                $('.allReview').show();
                $('.review_block').css("min-height", "1266px");

            } else {
                $('.allReview').hide();
                $('.review_block').css("min-height", "150px");
            }
        });

        $('input[name=display_video_block]').change(function () {
            if ($("input[name='display_video_block']").is(':checked')) {
                $('.extensions').show();
                $('.video_block').css("min-height", "1266px");
            } else {
                $('.extensions').hide();
                $('.video_block').css("min-height", "150px");
            }
        });
    });
</script>


<script type="text/javascript">
    $('document').ready(function () {
        $(".settings_menu a").click(function () {
            $(".settings_menu a").removeClass("active");
            $(this).addClass("active");
        });
    });
</script>
