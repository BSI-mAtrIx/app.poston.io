<script>

    $(document).ready(function () {

        $(document).ready(function () {
            $("#location_list_ul").trigger('change');
        });

        $(document).on('change', '#location_list_ul', function (event) {
            event.preventDefault();
            console.log(1);

            var waiting_div_content = '<div class="text-center waiting"><i class="bx bx-spin bx-loader blue text-center"></i></div>';
            $("#middle_column").html(waiting_div_content);

            $('#right_column .waiting').show();
            $('#right_column .main_card').hide();

            /* add active class */
            //$(".location_list_item").removeClass('active');
            //$(this).addClass('active');

            var location_table_id = $('#location_list_ul').val();

            $.ajax({
                url: '<?php echo base_url('gmb/get_location_details'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {location_table_id: location_table_id},
                success: function (response) {
                    $("#middle_column").html(response.middle_column_content);
                    $('#right_column .waiting').hide();
                    $('#right_column .main_card').show();
                    $('#review_reply_settings').click();
                    $(".location_insight").attr('href', response.location_insight_url);
                }
            });

        });

        $(document).on('click', '.iframed', function (e) {
            e.preventDefault();
            $(".middle_col_item").removeClass('active');
            $(this).parent().parent().addClass('active');
            var iframe_url = $(this).attr('href');
            var iframe_height = $(this).attr('iframe-height');
            $("#right_column_content iframe").attr('src', iframe_url).show();
            $("#right_column_bottom_content").hide();
            $("#right_column_content iframe").attr('height', iframe_height);
            $("#right_column .main_card").show();
            $('#right_column .waiting').hide();

            var title = '';
            if ($(this).hasClass('dropdown-item')) title = $(this).html();
            else {
                title = $(this).parents('.card-condensed').children('.card-icon').html();
                title += $(this).parents('.card-condensed').children('.card-body').children('h4').html();
            }
            $("#right_column_title").html(title);

        });

        $(document).on('click', '.new_review_url', function (e) {
            e.preventDefault();
            var waiting_div_content = '<div class="text-center waiting"><i class="bx bx-spin bx-loader blue text-center"></i></div>';
            $("#new_review_url_content").html(waiting_div_content);
            $("#new_review_url_modal").modal();
            $.ajax({
                url: '<?php echo base_url('gmb/get_new_review_url'); ?>',
                type: 'POST',
                success: function (response) {
                    $("#new_review_url_content").html(response);
                }
            });

        });

    });

</script>