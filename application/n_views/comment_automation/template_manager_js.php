<?php
include(FCPATH . 'application/n_views/include/upload_js.php');
?>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

    });

    $(document).ready(function () {

        var areWeUsingScroll = false;
        //todo: areWeUsingScroll

        var base_url = "<?php echo base_url(); ?>";

        // datatable section started
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": base_url + 'comment_automation/autoreply_template_manager_data',
                    "type": 'POST',
                    "dataSrc": function (json) {
                        //$(".table-responsive").niceScroll();
                        //todo: niceScroll
                        return json.data;
                    }
                },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: '',
                    className: 'text-center',
                    sortable: false
                },
                {
                    targets: [4],
                    "render": function (data, type, row, meta) {
                        var id = row[1];
                        var edit_str = "<?php echo $this->lang->line('Edit');?>";
                        var delete_str = "<?php echo $this->lang->line('Delete');?>";
                        var str = "";
                        str = "&nbsp;<a class='text-center edit_reply_info btn btn-circle btn-outline-warning' href='#' title='" + edit_str + "' table_id='" + id + "'>" + '<i class="bx bx-edit"></i>' + "</a>";
                        str = str + "&nbsp;<a href='#' class='text-center delete_reply_info btn btn-circle btn-outline-danger' title='" + delete_str + "' table_id=" + id + " '>" + '<i class="bx bx-trash"></i>' + "</a>";

                        return str;
                    }
                }
            ]
        });
        // End of datatable section


        var content_counter = 1;
        var edit_content_counter = 1;

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });


        $(document).on('click', '.delete_reply_info', function (e) {
            e.preventDefault();
            var doDelete = "<?php echo $this->lang->line('are you sure that you want to delete this record?'); ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: doDelete,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('comment_automation/delete_template')?>",
                            data: {table_id: table_id},
                            success: function (response) {
                                if (response == "successfull") {
                                    iziToast.success({
                                        title: '',
                                        message: '<?php echo $this->lang->line("Template has been deleted successfully."); ?>',
                                        position: 'bottomRight'
                                    });
                                    table.draw();
                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: '<?php echo $this->lang->line("Something went wrong, please try again."); ?>',
                                        position: 'bottomRight'
                                    });
                                }
                            }
                        });
                    }
                });

        });


        $(document).on('click', '.enable_page_response', function (event) {
            event.preventDefault();

            var page_table_id = $(this).attr('page_table_id');
            var post_id = $(this).attr('page_id');

            $("#auto_reply_page_id").val(page_table_id);
            $("#auto_reply_post_id").val(post_id);
            $("#manual_enable").val('no');

            $(".message").val('').click();
            $(".filter_word").val('');
            $("#auto_campaign_name").val(get_current_datetime());
            $("#comment_reply_enabled").prop("checked", true);
            $("#delete_offensive_comment_hide").prop("checked", true);
            $("#multiple_reply").prop("checked", false);
            $("#auto_like_comment").prop("checked", false);
            $("#hide_comment_after_comment_reply").prop("checked", false);

            $("#generic").prop("checked", false);
            $("#filter").prop("checked", false);
            $("#generic_message_div").hide();
            $("#filter_message_div").hide();


            for (var i = 2; i <= 20; i++) {
                $("#filter_div_" + i).hide();
            }
            content_counter = 1;
            $("#content_counter").val(content_counter);
            $("#add_more_button").show();

            $("#response_status").html('');

            $("#auto_reply_message_modal").addClass("modal");
            $("#auto_reply_message_modal").modal();

        });


        $(document).on('click', '.edit_enable_page_response', function (event) {
            event.preventDefault();

            var page_table_id = $(this).attr('page_table_id');
            var post_id = $(this).attr('page_id');

            $("#auto_reply_page_id").val(page_table_id);
            $("#auto_reply_post_id").val(post_id);
            $("#manual_enable").val('no');
            $(".message").val('');
            $(".filter_word").val('');
            for (var i = 2; i <= 20; i++) {
                $("#filter_div_" + i).hide();
            }
            content_counter = 1;
            $("#content_counter").val(content_counter);
            $("#add_more_button").show();

            $("#response_status").html('');

            $("#edit_auto_reply_message_modal").addClass("modal");
            $("#edit_auto_reply_message_modal").modal();

        });


        $("#content_counter").val(content_counter);

        $(document).on('click', '#add_more_button', function () {
            content_counter++;
            if (content_counter == 20)
                $("#add_more_button").hide();
            $("#content_counter").val(content_counter);

            $("#filter_div_" + content_counter).show();

            /** Load Emoji For Filter Word when click on add more button **/


            $("#comment_reply_msg_" + content_counter).emojioneArea({
                <?php if ($rtl_on) {
                    echo "dir: 'rtl',";
                } ?>
                autocomplete: false,
                pickerPosition: "bottom"
            });

        });


        $(document).on('change', 'input[name=message_type]', function () {
            if ($("input[name=message_type]:checked").val() == "generic") {
                $("#generic_message_div").show();
                $("#filter_message_div").hide();

                $("#generic_message").emojioneArea({
                    <?php if ($rtl_on) {
                        echo "dir: 'rtl',";
                    } ?>
                    autocomplete: false,
                    pickerPosition: "bottom"
                });


            } else {
                $("#generic_message_div").hide();
                $("#filter_message_div").show();

                /*** Load Emoji When Filter word click , by defualt first textarea are loaded & No match found field****/

                $("#comment_reply_msg_1, #nofilter_word_found_text").emojioneArea({
                    <?php if ($rtl_on) {
                        echo "dir: 'rtl',";
                    } ?>
                    autocomplete: false,
                    pickerPosition: "bottom"
                });


            }
        });


        $(document).on('click', '.lead_first_name', function () {

            var textAreaTxt = $(this).parent().next().next().next().children('.emojionearea-editor').html();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);


            var txtToAdd = " #LEAD_USER_FIRST_NAME# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().children('.emojionearea-editor').click();

        });

        $(document).on('click', '.lead_last_name', function () {

            var textAreaTxt = $(this).parent().next().next().next().next().children('.emojionearea-editor').html();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);


            var txtToAdd = " #LEAD_USER_LAST_NAME# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().next().children('.emojionearea-editor').click();


        });

        $(document).on('click', '.lead_tag_name', function () {

            var textAreaTxt = $(this).parent().next().next().next().next().next().children('.emojionearea-editor').html();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);


            var txtToAdd = " #TAG_USER# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().next().next().children('.emojionearea-editor').click();


        });


        $(document).on('click', '#save_button', function () {
            var post_id = $("#auto_reply_post_id").val();
            var reply_type = $("input[name=message_type]:checked").val();
            var Youdidntselectanyoption = "<?php echo $Youdidntselectanyoption; ?>";
            var Youdidntprovideallinformation = "<?php echo $Youdidntprovideallinformation; ?>";
            if (typeof (reply_type) === 'undefined') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', Youdidntselectanyoption, 'warning');
                return false;
            }
            var auto_campaign_name = $("#auto_campaign_name").val().trim();
            if (reply_type == 'generic') {
                if (auto_campaign_name == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', Youdidntprovideallinformation, 'warning');
                    return false;
                }
            } else {
                if (auto_campaign_name == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', Youdidntprovideallinformation, 'warning');
                    return false;
                }
            }

            $(this).addClass('btn-progress');

            var queryString = new FormData($("#auto_reply_info_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "comment_automation/autoreply_template_submit",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == "1") {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                            table.draw();
                            $("#auto_reply_message_modal").modal('hide');
                        });
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }

            });

        });


        $(document).on('click', '#modal_close', function () {
            $("#auto_reply_message_modal").modal("hide");
            table.draw();
        });

        $(document).on('click', '#edit_modal_close', function () {
            $("#edit_auto_reply_message_modal").modal("hide");
            table.draw();
        });


        $(document).on('click', '.edit_reply_info', function (event) {

            event.preventDefault();

            var emoji_load_div_list = "";


            $("#manual_edit_reply_by_post").removeClass('modal');
            $("#edit_auto_reply_message_modal").addClass("modal");
            $("#edit_response_status").html("");


            var table_id = $(this).attr('table_id');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>comment_automation/templatemanager_reply_info",
                data: {table_id: table_id},
                dataType: 'JSON',
                success: function (response) {
                    $("#table_id").val(response.table_id);
                    $("#edit_auto_reply_post_id").val(response.edit_auto_reply_post_id);
                    $("#edit_auto_campaign_name").val(response.edit_auto_campaign_name);

                    $("#edit_page_ids").html(response.page_list);
                    $('#edit_page_ids').select2('destroy');
                    $('#edit_page_ids').select2({width: '100%'});
                    var selected_page_id = $("#edit_page_ids").val();
                    $("#dynamic_page_id").val(selected_page_id);


                    $('#edit_private_message_offensive_words').select2('destroy');
                    $("#edit_private_message_offensive_words").html(response.postbacks).val(response.private_message_offensive_words).select2({width: "100%"});

                    $('#edit_generic_message_private').select2('destroy');
                    $("#edit_generic_message_private").html(response.postbacks).select2({width: "100%"});
                    $("#edit_nofilter_word_found_text_private").html(response.postbacks);
                    for (var j = 1; j <= 20; j++) {
                        $("#edit_filter_div_" + j).hide();
                        $("#edit_filter_message_" + j).html(response.postbacks);
                    }

                    if (response.trigger_matching_type == 'exact')
                        $("#edit_trigger_keyword_exact").attr('checked', 'checked');
                    else
                        $("#edit_trigger_keyword_string").attr('checked', 'checked');

                    // comment hide and delete section
                    if (response.is_delete_offensive == 'hide') {
                        $("#edit_delete_offensive_comment_hide").attr('checked', 'checked');
                    } else {
                        $("#edit_delete_offensive_comment_delete").attr('checked', 'checked');
                    }
                    $("#edit_delete_offensive_comment_keyword").val(response.offensive_words);


                    //$("#edit_private_message_offensive_words").val(response.private_message_offensive_words).click();

                    /** make the emoji loads div id in a string for selection . This is the first add. **/
                    // emoji_load_div_list=emoji_load_div_list;

                    if (response.hide_comment_after_comment_reply == 'no')
                        $("#edit_hide_comment_after_comment_reply").removeAttr('checked', 'checked');
                    else
                        $("#edit_hide_comment_after_comment_reply").attr('checked', 'checked');
                    // comment hide and delete section

                    $("#edit_" + response.reply_type).prop('checked', true);
                    // added by mostofa on 27-04-2017
                    if (response.comment_reply_enabled == 'no')
                        $("#edit_comment_reply_enabled").removeAttr('checked', 'checked');
                    else
                        $("#edit_comment_reply_enabled").attr('checked', 'checked');

                    if (response.multiple_reply == 'no')
                        $("#edit_multiple_reply").removeAttr('checked', 'checked');
                    else
                        $("#edit_multiple_reply").attr('checked', 'checked');

                    if (response.auto_like_comment == 'no')
                        $("#edit_auto_like_comment").removeAttr('checked', 'checked');
                    else
                        $("#edit_auto_like_comment").attr('checked', 'checked');

                    var inner_content = '<i class="bx bx-time"></i> Remove';

                    if (response.reply_type == 'generic') {
                        $("#edit_generic_message_div").show();
                        $("#edit_filter_message_div").hide();
                        var i = 1;
                        edit_content_counter = i;
                        var auto_reply_text_array_json = JSON.stringify(response.auto_reply_text);
                        auto_reply_text_array = JSON.parse(auto_reply_text_array_json, 'true');
                        $("#edit_generic_message").val(auto_reply_text_array[0]['comment_reply']).trigger('change');
                        $("#edit_generic_message_private").val(auto_reply_text_array[0]['private_reply']).trigger('change');

                        /** Add generic reply textarea id into the emoji load div list***/
                        if (emoji_load_div_list == '')
                            emoji_load_div_list = emoji_load_div_list + "#edit_generic_message";
                        else
                            emoji_load_div_list = emoji_load_div_list + ", #edit_generic_message";


                        // comment hide and delete section

                        $("#edit_generic_image_for_comment_reply_display").attr('src', auto_reply_text_array[0]['image_link']).show();
                        if (auto_reply_text_array[0]['image_link'] == "") {
                            $("#edit_generic_image_for_comment_reply_display").prev('span').removeClass('remove_media').html('');
                            $("#edit_generic_image_for_comment_reply_display").hide();
                        } else
                            $("#edit_generic_image_for_comment_reply_display").prev('span').addClass('remove_media').html(inner_content);


                        var vidreplace = '<source src="' + auto_reply_text_array[0]['video_link'] + '" id="edit_generic_video_comment_reply_display" type="video/mp4">';
                        $("#edit_generic_video_comment_reply_display").parent().html(vidreplace).show();

                        if (auto_reply_text_array[0]['video_link'] == '') {
                            $("#edit_generic_video_comment_reply_display").parent().prev('span').removeClass('remove_media').html('');
                            $("#edit_generic_video_comment_reply_display").parent().hide();
                        } else
                            $("#edit_generic_video_comment_reply_display").parent().prev('span').addClass('remove_media').html(inner_content);


                        $("#edit_generic_image_for_comment_reply").val(auto_reply_text_array[0]['image_link']);
                        $("#edit_generic_video_comment_reply").val(auto_reply_text_array[0]['video_link']);
                        // comment hide and delete section
                    } else {
                        var edit_nofilter_word_found_text = JSON.stringify(response.edit_nofilter_word_found_text);
                        edit_nofilter_word_found_text = JSON.parse(edit_nofilter_word_found_text, 'true');
                        $("#edit_nofilter_word_found_text").val(edit_nofilter_word_found_text[0]['comment_reply']).click();
                        $("#edit_nofilter_word_found_text_private").val(edit_nofilter_word_found_text[0]['private_reply']).click();

                        /**Add no match found textarea into emoji load div list***/
                        if (emoji_load_div_list == '')
                            emoji_load_div_list = emoji_load_div_list + "#edit_nofilter_word_found_text";
                        else
                            emoji_load_div_list = emoji_load_div_list + ", #edit_nofilter_word_found_text";


                        // comment hide and delete section

                        $("#edit_nofilter_image_upload_reply_display").attr('src', edit_nofilter_word_found_text[0]['image_link']).show();
                        if (edit_nofilter_word_found_text[0]['image_link'] == "") {
                            $("#edit_nofilter_image_upload_reply_display").prev('span').removeClass('remove_media').html('');
                            $("#edit_nofilter_image_upload_reply_display").hide();
                        } else
                            $("#edit_nofilter_image_upload_reply_display").prev('span').addClass('remove_media').html(inner_content);


                        var vidreplace = '<source src="' + edit_nofilter_word_found_text[0]['video_link'] + '" id="edit_nofilter_video_upload_reply_display" type="video/mp4">';
                        $("#edit_nofilter_video_upload_reply_display").parent().html(vidreplace).show();

                        if (edit_nofilter_word_found_text[0]['video_link'] == '') {
                            $("#edit_nofilter_video_upload_reply_display").parent().prev('span').removeClass('remove_media').html('');
                            $("#edit_nofilter_video_upload_reply_display").parent().hide();
                        } else
                            $("#edit_nofilter_video_upload_reply_display").parent().prev('span').addClass('remove_media').html(inner_content);


                        $("#edit_nofilter_image_upload_reply").val(edit_nofilter_word_found_text[0]['image_link']);
                        $("#edit_nofilter_video_upload_reply").val(edit_nofilter_word_found_text[0]['video_link']);
                        // comment hide and delete section

                        $("#edit_filter_message_div").show();
                        $("#edit_generic_message_div").hide();
                        var auto_reply_text_array = JSON.stringify(response.auto_reply_text);
                        auto_reply_text_array = JSON.parse(auto_reply_text_array, 'true');

                        for (var i = 0; i < auto_reply_text_array.length; i++) {
                            var j = i + 1;
                            $("#edit_filter_div_" + j).show();
                            $("#edit_filter_word_" + j).val(auto_reply_text_array[i]['filter_word']);
                            var unscape_reply_text = auto_reply_text_array[i]['reply_text'];
                            $("#edit_filter_message_" + j).val(unscape_reply_text).click();
                            // added by mostofa 25-04-2017
                            var unscape_comment_reply_text = auto_reply_text_array[i]['comment_reply_text'];
                            $("#edit_comment_reply_msg_" + j).val(unscape_comment_reply_text).click();

                            if (emoji_load_div_list == '')
                                emoji_load_div_list = emoji_load_div_list + "#edit_comment_reply_msg_" + j;
                            else
                                emoji_load_div_list = emoji_load_div_list + ", #edit_comment_reply_msg_" + j;


                            // comment hide and delete section

                            $("#edit_filter_image_upload_reply_display_" + j).attr('src', auto_reply_text_array[i]['image_link']).show();
                            if (auto_reply_text_array[i]['image_link'] == "") {
                                $("#edit_filter_image_upload_reply_display_" + j).prev('span').removeClass('remove_media').html('');
                                $("#edit_filter_image_upload_reply_display_" + j).hide();
                            } else
                                $("#edit_filter_image_upload_reply_display_" + j).prev('span').addClass('remove_media').html(inner_content);


                            var vidreplace = '<source src="' + auto_reply_text_array[i]['video_link'] + '" id="edit_filter_video_upload_reply_display' + j + '" type="video/mp4">';
                            $("#edit_filter_video_upload_reply_display" + j).parent().html(vidreplace).show();
                            if (auto_reply_text_array[i]['video_link'] == '') {
                                $("#edit_filter_video_upload_reply_display" + j).parent().prev('span').removeClass('remove_media').html('');
                                $("#edit_filter_video_upload_reply_display" + j).parent().hide();
                            } else
                                $("#edit_filter_video_upload_reply_display" + j).parent().prev('span').addClass('remove_media').html(inner_content);

                            $("#edit_filter_image_upload_reply_" + j).val(auto_reply_text_array[i]['image_link']);
                            $("#edit_filter_video_upload_reply_" + j).val(auto_reply_text_array[i]['video_link']);
                            // comment hide and delete section
                        }

                        edit_content_counter = i + 1;
                        $("#edit_content_counter").val(edit_content_counter);
                    }
                    $("#edit_auto_reply_message_modal").modal();
                },

            });

            setTimeout(function () {

                $(emoji_load_div_list).emojioneArea({
                    <?php if ($rtl_on) {
                        echo "dir: 'rtl',";
                    } ?>
                    autocomplete: false,
                    pickerPosition: "bottom"
                });
            }, 2000);

            setTimeout(function () {

                $(".previewLoader").hide();

            }, 2000);


        });


        $(document).on('click', '#edit_add_more_button', function () {
            if (edit_content_counter == 21)
                $("#edit_add_more_button").hide();
            $("#edit_content_counter").val(edit_content_counter);

            $("#edit_filter_div_" + edit_content_counter).show();

            /** Load Emoji For Filter Word when click on add more button during Edit**/

            $("#edit_comment_reply_msg_" + edit_content_counter).emojioneArea({
                <?php if ($rtl_on) {
                    echo "dir: 'rtl',";
                } ?>
                autocomplete: false,
                pickerPosition: "bottom"
            });


            edit_content_counter++;

        });


        $(document).on('click', '#edit_save_button', function () {
            var post_id = $("#edit_auto_reply_post_id").val();
            var edit_auto_campaign_name = $("#edit_auto_campaign_name").val();
            var reply_type = $("input[name=edit_message_type]:checked").val();
            var Youdidntselectanyoption = "<?php echo $Youdidntselectanyoption; ?>";
            var Youdidntprovideallinformation = "<?php echo $Youdidntprovideallinformation; ?>";
            if (typeof (reply_type) === 'undefined') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', Youdidntselectanyoption, 'warning');
                return false;
            }
            if (reply_type == 'generic') {
                if (edit_auto_campaign_name == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', Youdidntprovideallinformation, 'warning');
                    return false;
                }
            } else {
                if (edit_auto_campaign_name == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', Youdidntprovideallinformation, 'warning');
                    return false;
                }
            }

            $(this).addClass('btn-progress');

            var queryString = new FormData($("#edit_auto_reply_info_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "comment_automation/update_templatemanager_info",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == "1") {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                            table.draw();
                            $("#edit_auto_reply_message_modal").modal('hide');
                        });
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }

            });

        });


        $(document).on('change', 'input[name=edit_message_type]', function () {
            if ($("input[name=edit_message_type]:checked").val() == "generic") {
                $("#edit_generic_message_div").show();
                $("#edit_filter_message_div").hide();

            } else {
                $("#edit_generic_message_div").hide();
                $("#edit_filter_message_div").show();

                /*** Load Emoji When Filter word click during Edit , by defualt first textarea are loaded & No match found field****/

                $("#edit_comment_reply_msg_1, #edit_nofilter_word_found_text").emojioneArea({
                    <?php if ($rtl_on) {
                        echo "dir: 'rtl',";
                    } ?>
                    autocomplete: false,
                    pickerPosition: "bottom"
                });
            }
        });


        $(document).on('click', '.cancel_button', function () {
            $("#auto_reply_message_modal").modal('hide');
            $("#edit_auto_reply_message_modal").modal('hide');
        });

        $(document).on('click', '.remove_media', function () {
            $(this).parent().prev('input').val('');
            $(this).parent().hide();
        });


    });
</script>
<script>
    $("document").ready(function () {

        $("#page_ids,.private_reply_postback,#edit_page_ids").select2({width: "100%"});

        $(document).on('change', '#page_ids,#edit_page_ids', function (e) {
            var page_table_ids = $(this).val();
            $("#dynamic_page_id").val(page_table_ids);
            $.ajax({
                type: 'POST',
                url: base_url + "comment_automation/get_private_reply_postbacks",
                data: {page_table_ids: page_table_ids},
                dataType: 'JSON',
                success: function (response) {
                    $(".private_reply_postback").html(response.options);
                }

            });
        });


        $("#filemanager_close").click(function () {
            $("#modal-live-video-library").removeClass('modal');
        });

        var base_url = "<?php echo site_url(); ?>";
        var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
        <?php for($k = 1;$k <= 20;$k++) : ?>
        $("#edit_filter_video_upload_<?php echo $k; ?>").uploadFile({
            url: base_url + "comment_automation/upload_live_video",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:500*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_filter_video_upload_reply_<?php echo $k; ?>").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var file_path = base_url + "upload/video/" + data;
                $("#edit_filter_video_upload_reply_<?php echo $k; ?>").val(file_path);
            }
        });


        $("#edit_filter_image_upload_<?php echo $k; ?>").uploadFile({
            url: base_url + "comment_automation/upload_image_only",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:1*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_filter_image_upload_reply_<?php echo $k; ?>").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#edit_filter_image_upload_reply_<?php echo $k; ?>").val(data_modified);
            }
        });
        <?php endfor; ?>

        <?php for($k = 1;$k <= 20;$k++) : ?>
        $("#filter_video_upload_<?php echo $k; ?>").uploadFile({
            url: base_url + "comment_automation/upload_live_video",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:500*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#filter_video_upload_reply_<?php echo $k; ?>").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var file_path = base_url + "upload/video/" + data;
                $("#filter_video_upload_reply_<?php echo $k; ?>").val(file_path);
            }
        });


        $("#filter_image_upload_<?php echo $k; ?>").uploadFile({
            url: base_url + "comment_automation/upload_image_only",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:1*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#filter_image_upload_reply_<?php echo $k; ?>").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#filter_image_upload_reply_<?php echo $k; ?>").val(data_modified);
            }
        });
        <?php endfor; ?>

        $("#generic_video_upload").uploadFile({
            url: base_url + "comment_automation/upload_live_video",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:500*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#generic_video_comment_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var file_path = base_url + "upload/video/" + data;
                $("#generic_video_comment_reply").val(file_path);
            }
        });


        $("#generic_comment_image").uploadFile({
            url: base_url + "comment_automation/upload_image_only",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:1*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#generic_image_for_comment_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#generic_image_for_comment_reply").val(data_modified);
            }
        });


        $("#nofilter_video_upload").uploadFile({
            url: base_url + "comment_automation/upload_live_video",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:500*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#nofilter_video_upload_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var file_path = base_url + "upload/video/" + data;
                $("#nofilter_video_upload_reply").val(file_path);
            }
        });


        $("#nofilter_image_upload").uploadFile({
            url: base_url + "comment_automation/upload_image_only",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:1*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#nofilter_image_upload_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#nofilter_image_upload_reply").val(data_modified);
            }
        });

        $("#edit_generic_video_upload").uploadFile({
            url: base_url + "comment_automation/upload_live_video",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:500*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_generic_video_comment_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var file_path = base_url + "upload/video/" + data;
                $("#edit_generic_video_comment_reply").val(file_path);
            }
        });


        $("#edit_generic_comment_image").uploadFile({
            url: base_url + "comment_automation/upload_image_only",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:1*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_generic_image_for_comment_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#edit_generic_image_for_comment_reply").val(data_modified);
            }
        });


        $("#edit_nofilter_video_upload").uploadFile({
            url: base_url + "comment_automation/upload_live_video",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:500*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_nofilter_video_upload_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var file_path = base_url + "upload/video/" + data;
                $("#edit_nofilter_video_upload_reply").val(file_path);
            }
        });


        $("#edit_nofilter_image_upload").uploadFile({
            url: base_url + "comment_automation/upload_image_only",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            // maxFileSize:1*1024*1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_nofilter_image_upload_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#edit_nofilter_image_upload_reply").val(data_modified);
            }
        });

    });
</script>
<script type="text/javascript">
    $("document").ready(function () {
        var base_url = "<?php echo base_url(); ?>";

        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();
            var current_id = $(this).prev().prev().attr('id');
            var current_val = $(this).prev().prev().val();
            var page_id = get_page_id();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $("#add_template_modal").attr("current_id", current_id);
            $("#add_template_modal").attr("current_val", current_val);
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var current_val = $(this).prev().prev().prev().val();
            var current_id = $(this).prev().prev().prev().attr('id');
            console.log(current_id);
            var page_id = get_page_id();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "comment_automation/get_private_reply_postbacks",
                data: {page_table_ids: page_id},
                dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response.options).val(current_val);
                }
            });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_id = $("#add_template_modal").attr("current_id");
            var current_val = $("#add_template_modal").attr("current_val");
            var page_id = get_page_id();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "comment_automation/get_private_reply_postbacks",
                data: {page_table_ids: page_id, is_from_add_button: '1'},
                dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response.options);
                }
            });
        });

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {
            var page_id = get_page_id();
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id;
            $(this).find('iframe').attr('src', iframe_link);
        });
        // getting postback list and making iframe

    });

    function get_page_id() {
        var page_id = $("#dynamic_page_id").val();
        return page_id;
    }
</script>

<?php
if(file_exists(APPPATH.'n_sgp/tools/spintax.php')){
    include(APPPATH.'n_sgp/tools/spintax.php');
}